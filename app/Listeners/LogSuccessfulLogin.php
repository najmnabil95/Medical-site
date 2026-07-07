<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\ActivityLog;

class LogSuccessfulLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        
        ActivityLog::create([
            'action' => 'تم تسجيل الدخول إلى النظام بنجاح',
            'type' => 'login',
            'user' => $user->name,
            'timestamp' => now(),
        ]);
    }
}
