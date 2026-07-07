<?php

namespace App\Listeners;

use App\Events\AppointmentStatusChanged;
use App\Services\NotificationService;

class SendAppointmentNotification
{
    /**
     * Create the event listener.
     *
     * @param  NotificationService  $notificationService
     */
    public function __construct(
        private readonly NotificationService $notificationService
    ) {}

    /**
     * Handle the event.
     *
     * @param  AppointmentStatusChanged  $event
     * @return void
     */
    public function handle(AppointmentStatusChanged $event): void
    {
        $appointment = $event->appointment;
        
        // ONLY send notification when booking is confirmed
        if ($appointment->status !== 'confirmed') {
            return;
        }

        $this->notificationService->sendAppointmentConfirmation($appointment);
    }
}

