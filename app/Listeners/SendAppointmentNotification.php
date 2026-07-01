<?php

namespace App\Listeners;

use App\Events\AppointmentStatusChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAppointmentNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppointmentStatusChanged $event): void
    {
        $appointment = $event->appointment;
        $status = $appointment->status;
        
        // ONLY send notification when booking is confirmed
        if ($status !== 'confirmed') {
            return;
        }

        $phone = $appointment->phone;
        $name = $appointment->patient_name;
        $doctor = $appointment->doctor ?? 'الطبيب المختص';
        $department = $appointment->department;
        
        $dateStr = '';
        if ($appointment->date) {
            $dateStr = $appointment->date instanceof \Carbon\Carbon 
                ? $appointment->date->format('Y-m-d') 
                : (is_string($appointment->date) ? $appointment->date : date('Y-m-d', strtotime($appointment->date)));
        }
        $timeStr = $appointment->time;

        $msg = "عزيزي {$name}، يسعدنا إبلاغك بأنه تم تأكيد حجزك لعيادة {$department} مع الدكتور {$doctor} بتاريخ {$dateStr} الساعة {$timeStr}. ننتظر حضورك ونتمنى لك الشفاء العاجل.";

        $settings = \App\Models\Setting::first() ?? new \App\Models\Setting();
        $channel = $settings->notification_channel ?? 'whatsapp';

        // Save simulated SMS notification to DB if channel is sms or both
        if ($channel === 'sms' || $channel === 'both') {
            \App\Models\Notification::create([
                'type' => 'sms',
                'recipient' => $phone,
                'message' => $msg,
                'status' => 'sent',
                'reservation_id' => (string)$appointment->id,
                'patient_name' => $name,
                'sent_at' => now(),
            ]);
        }

        // Save simulated WhatsApp notification to DB if channel is whatsapp or both
        if ($channel === 'whatsapp' || $channel === 'both') {
            \App\Models\Notification::create([
                'type' => 'whatsapp',
                'recipient' => $phone,
                'message' => $msg,
                'status' => 'delivered', // simulated delivery status
                'reservation_id' => (string)$appointment->id,
                'patient_name' => $name,
                'sent_at' => now(),
            ]);
        }

        // Also log for system file logs
        \Log::info("Notification logs generated for Appointment ID: {$appointment->id} via channel: {$channel}");
    }
}
