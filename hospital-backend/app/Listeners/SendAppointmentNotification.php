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

        // In a real scenario, this would call an SMS or WhatsApp API.
        // Example logic:
        if ($status === 'confirmed') {
            \Log::info("SMS/WhatsApp Sent to {$phone}: Your appointment for {$appointment->date->format('Y-m-d')} at {$appointment->time} has been confirmed.");
        } elseif ($status === 'cancelled') {
            \Log::info("SMS/WhatsApp Sent to {$phone}: Your appointment has been cancelled.");
        }
    }
}
