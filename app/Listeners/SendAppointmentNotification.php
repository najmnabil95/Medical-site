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

        $msg = '';

        if ($event->oldStatus === null && $status === 'pending') {
            // New booking request from website
            $msg = "مرحباً {$name}، تم استلام طلب حجزك لعيادة {$department} مع الدكتور {$doctor} بتاريخ {$dateStr} الساعة {$timeStr}. طلبك قيد المراجعة وسنتصل بك قريباً لتأكيده.";
        } else {
            switch ($status) {
                case 'confirmed':
                    $msg = "عزيزي {$name}، يسعدنا إبلاغك بأنه تم تأكيد حجزك لعيادة {$department} مع الدكتور {$doctor} بتاريخ {$dateStr} الساعة {$timeStr}. ننتظر حضورك ونتمنى لك الشفاء العاجل.";
                    break;
                case 'cancelled':
                    $msg = "عزيزي {$name}، نود إعلامك بأنه تم إلغاء حجزك لعيادة {$department} مع الدكتور {$doctor} بتاريخ {$dateStr} الساعة {$timeStr}. نتمنى لك دوام الصحة والعافية.";
                    break;
                case 'completed':
                    $msg = "عزيزي {$name}، شكراً لزيارتك لعيادة {$department} مع الدكتور {$doctor}. نتمنى أن نكون قد قدمنا لك الخدمة المرجوة ونسأل الله لك دوام الشفاء.";
                    break;
                case 'pending':
                    $msg = "عزيزي {$name}، تم إعادة حجزك لعيادة {$department} مع الدكتور {$doctor} بتاريخ {$dateStr} الساعة {$timeStr} إلى حالة قيد الانتظار.";
                    break;
            }
        }

        if (empty($msg)) {
            return;
        }

        // Save simulated SMS notification to DB
        \App\Models\Notification::create([
            'type' => 'sms',
            'recipient' => $phone,
            'message' => $msg,
            'status' => 'sent',
            'reservation_id' => (string)$appointment->id,
            'patient_name' => $name,
            'sent_at' => now(),
        ]);

        // Save simulated WhatsApp notification to DB
        \App\Models\Notification::create([
            'type' => 'whatsapp',
            'recipient' => $phone,
            'message' => $msg,
            'status' => 'delivered', // simulated delivery status
            'reservation_id' => (string)$appointment->id,
            'patient_name' => $name,
            'sent_at' => now(),
        ]);

        // Also log for system file logs
        \Log::info("SMS and WhatsApp notification logs generated for Appointment ID: {$appointment->id}");
    }
}
