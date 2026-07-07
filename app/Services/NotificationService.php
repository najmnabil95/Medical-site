<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Appointment;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    private ?string $twilioSid;
    private ?string $twilioToken;
    private ?string $smsFrom;
    private ?string $whatsappFrom;

    public function __construct()
    {
        $this->twilioSid = env('TWILIO_SID');
        $this->twilioToken = env('TWILIO_AUTH_TOKEN');
        $this->smsFrom = env('TWILIO_SMS_FROM');
        $this->whatsappFrom = env('TWILIO_WHATSAPP_FROM');
    }

    /**
     * Send appointment confirmation notifications.
     *
     * @param  Appointment  $appointment
     * @return void
     */
    public function sendAppointmentConfirmation(Appointment $appointment): void
    {
        $phone = $appointment->phone;
        $name = $appointment->patient_name;
        $doctor = $appointment->doctor ?? 'الطبيب المختص';
        $department = $appointment->department;

        // Date formatting safety
        $dateStr = '';
        if ($appointment->date) {
            $dateStr = $appointment->date instanceof \Carbon\Carbon 
                ? $appointment->date->format('Y-m-d') 
                : (is_string($appointment->date) ? $appointment->date : date('Y-m-d', strtotime($appointment->date)));
        }
        $timeStr = $appointment->time;

        $msg = "عزيزي {$name}، يسعدنا إبلاغك بأنه تم تأكيد حجزك لعيادة {$department} مع الدكتور {$doctor} بتاريخ {$dateStr} الساعة {$timeStr}. ننتظر حضورك ونتمنى لك الشفاء العاجل.";

        $settings = Setting::getCached();
        $channel = $settings->notification_channel ?? 'whatsapp';

        if ($channel === 'sms' || $channel === 'both') {
            $this->sendSMS($phone, $msg, $appointment->id, $name);
        }

        if ($channel === 'whatsapp' || $channel === 'both') {
            $this->sendWhatsApp($phone, $msg, $appointment->id, $name);
        }
    }

    /**
     * Send SMS notification.
     *
     * @param  string  $to
     * @param  string  $message
     * @param  int|null  $reservationId
     * @param  string|null  $patientName
     * @return void
     */
    public function sendSMS(string $to, string $message, ?int $reservationId = null, ?string $patientName = null): void
    {
        $notification = Notification::create([
            'type' => 'sms',
            'recipient' => $to,
            'message' => $message,
            'status' => 'pending',
            'reservation_id' => (string) $reservationId,
            'patient_name' => $patientName,
            'sent_at' => now(),
        ]);

        if ($this->isTwilioConfigured()) {
            $this->sendViaTwilioSMS($notification);
        } else {
            // Simulation Mode
            $notification->update(['status' => 'sent']);
            Log::info("Simulated SMS sent to {$to}: {$message}");
        }
    }

    /**
     * Send WhatsApp notification.
     *
     * @param  string  $to
     * @param  string  $message
     * @param  int|null  $reservationId
     * @param  string|null  $patientName
     * @return void
     */
    public function sendWhatsApp(string $to, string $message, ?int $reservationId = null, ?string $patientName = null): void
    {
        $notification = Notification::create([
            'type' => 'whatsapp',
            'recipient' => $to,
            'message' => $message,
            'status' => 'pending',
            'reservation_id' => (string) $reservationId,
            'patient_name' => $patientName,
            'sent_at' => now(),
        ]);

        if ($this->isTwilioConfigured()) {
            $this->sendViaTwilioWhatsApp($notification);
        } else {
            // Simulation Mode
            $notification->update(['status' => 'delivered']);
            Log::info("Simulated WhatsApp sent to {$to}: {$message}");
        }
    }

    /**
     * Determine if Twilio credentials are set.
     *
     * @return bool
     */
    private function isTwilioConfigured(): bool
    {
        return !empty($this->twilioSid) && !empty($this->twilioToken);
    }

    /**
     * Deliver SMS using Twilio REST API.
     *
     * @param  Notification  $notification
     * @return void
     */
    private function sendViaTwilioSMS(Notification $notification): void
    {
        try {
            $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->twilioSid}/Messages.json";
            
            $response = Http::asForm()
                ->withBasicAuth($this->twilioSid, $this->twilioToken)
                ->post($url, [
                    'To' => $notification->recipient,
                    'From' => $this->smsFrom ?? 'AlShifa',
                    'Body' => $notification->message,
                ]);

            if ($response->successful()) {
                $notification->update(['status' => 'sent']);
            } else {
                $errorData = $response->json();
                $notification->update([
                    'status' => 'failed',
                    'error_message' => $errorData['message'] ?? 'Twilio API Error',
                ]);
            }
        } catch (\Exception $e) {
            $notification->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Deliver WhatsApp message using Twilio REST API.
     *
     * @param  Notification  $notification
     * @return void
     */
    private function sendViaTwilioWhatsApp(Notification $notification): void
    {
        try {
            $url = "https://api.twilio.com/2010-04-01/Accounts/{$this->twilioSid}/Messages.json";

            // Format numbers to ensure they match Twilio WhatsApp requirements (e.g. whatsapp:+966...)
            $to = $notification->recipient;
            if (!str_starts_with($to, 'whatsapp:')) {
                $to = 'whatsapp:' . $to;
            }

            $from = $this->whatsappFrom ?? '';
            if (!str_starts_with($from, 'whatsapp:') && !empty($from)) {
                $from = 'whatsapp:' . $from;
            }

            $response = Http::asForm()
                ->withBasicAuth($this->twilioSid, $this->twilioToken)
                ->post($url, [
                    'To' => $to,
                    'From' => $from ?: 'whatsapp:+14155238886', // Twilio WhatsApp sandbox number fallback
                    'Body' => $notification->message,
                ]);

            if ($response->successful()) {
                $notification->update(['status' => 'delivered']);
            } else {
                $errorData = $response->json();
                $notification->update([
                    'status' => 'failed',
                    'error_message' => $errorData['message'] ?? 'Twilio API Error',
                ]);
            }
        } catch (\Exception $e) {
            $notification->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
