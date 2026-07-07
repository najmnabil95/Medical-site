<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\ActivityLog;

class LogSuccessfulLogout
{
    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        $user = $event->user;
        
        if ($user) {
            ActivityLog::create([
                'action' => 'تم تسجيل الخروج من النظام بنجاح',
                'type' => 'logout',
                'user' => $user->name,
                'timestamp' => now(),
            ]);
        }
    }
}
