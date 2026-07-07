<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    private function createAdmin(): User
    {
        $user = User::create([
            'username' => 'admin_test',
            'password' => bcrypt('password123'),
            'role' => 'Super Admin',
            'name' => 'Admin User',
            'email' => 'admin_test@example.com',
            'phone' => '+1234567890',
            'active' => true,
        ]);
        $user->assignRole('Super Admin');
        return $user;
    }

    public function test_clear_all_notifications_works(): void
    {
        $admin = $this->createAdmin();

        // Create a dummy notification
        Notification::create([
            'type' => 'sms',
            'recipient' => '0555555555',
            'message' => 'Test message',
            'status' => 'sent',
        ]);

        $this->assertEquals(1, Notification::count());

        $response = $this->actingAs($admin)
            ->post(route('admin.notifications.clearAll'));

        $response->assertRedirect();
        $this->assertEquals(0, Notification::count());
    }

    public function test_notifications_only_sent_on_confirmed_obeying_channel_settings(): void
    {
        $settings = \App\Models\Setting::first() ?? new \App\Models\Setting();
        $settings->site_name = 'Test Hospital';
        $settings->notification_channel = 'whatsapp';
        $settings->save();

        // Create a pending appointment
        $appointment = \App\Models\Appointment::create([
            'patient_name' => 'John Doe',
            'phone' => '0555555555',
            'department' => 'أمراض القلب',
            'date' => '2026-07-02',
            'time' => '10:00',
            'status' => 'pending',
        ]);

        // Event listener should not trigger any notifications for pending status
        $this->assertEquals(0, Notification::count());

        // Update to confirmed with 'whatsapp' channel
        $appointment->status = 'confirmed';
        $appointment->save();

        // Should trigger 1 WhatsApp notification and 0 SMS
        $this->assertEquals(1, Notification::where('type', 'whatsapp')->count());
        $this->assertEquals(0, Notification::where('type', 'sms')->count());

        // Clear notifications
        Notification::query()->delete();

        // Switch setting to 'sms'
        $settings->notification_channel = 'sms';
        $settings->save();

        // Update status to pending then back to confirmed to trigger listener
        $appointment->status = 'pending';
        $appointment->save();
        Notification::query()->delete(); // clear any unexpected notifications

        $appointment->status = 'confirmed';
        $appointment->save();

        // Should trigger 1 SMS notification and 0 WhatsApp
        $this->assertEquals(0, Notification::where('type', 'whatsapp')->count());
        $this->assertEquals(1, Notification::where('type', 'sms')->count());
    }

    public function test_notifications_send_via_real_twilio_when_configured_success(): void
    {
        // 1. Configure fake Twilio env variables
        putenv('TWILIO_SID=ACXXXXXX');
        putenv('TWILIO_AUTH_TOKEN=fake_token');
        putenv('TWILIO_SMS_FROM=AlShifa');
        putenv('TWILIO_WHATSAPP_FROM=+14155238886');

        // 2. Fake HTTP requests
        \Illuminate\Support\Facades\Http::fake([
            'https://api.twilio.com/*' => \Illuminate\Support\Facades\Http::response([
                'sid' => 'SMxxxxxx',
                'status' => 'queued'
            ], 201)
        ]);

        // 3. Create a confirmed appointment (this triggers SendAppointmentNotification listener)
        $appointment = \App\Models\Appointment::create([
            'patient_name' => 'Jane Doe',
            'phone' => '+966500000000',
            'department' => 'أمراض القلب',
            'date' => '2026-07-02',
            'time' => '10:00',
            'status' => 'confirmed',
        ]);

        // 4. Verify HTTP requests were made to Twilio
        \Illuminate\Support\Facades\Http::assertSent(function (\Illuminate\Http\Client\Request $request) {
            return str_contains($request->url(), 'api.twilio.com') &&
                   $request['To'] === 'whatsapp:+966500000000' &&
                   $request['From'] === 'whatsapp:+14155238886';
        });

        // 5. Verify database records are updated correctly
        $whatsappNotification = Notification::where('type', 'whatsapp')->first();
        $this->assertNotNull($whatsappNotification);
        $this->assertEquals('delivered', $whatsappNotification->status);
        $this->assertNull($whatsappNotification->error_message);

        // Clean env variables
        putenv('TWILIO_SID');
        putenv('TWILIO_AUTH_TOKEN');
        putenv('TWILIO_SMS_FROM');
        putenv('TWILIO_WHATSAPP_FROM');
    }

    public function test_notifications_send_via_real_twilio_when_configured_failure(): void
    {
        // 1. Configure fake Twilio env variables
        putenv('TWILIO_SID=ACXXXXXX');
        putenv('TWILIO_AUTH_TOKEN=fake_token');
        putenv('TWILIO_SMS_FROM=AlShifa');
        putenv('TWILIO_WHATSAPP_FROM=+14155238886');

        // 2. Fake HTTP requests with failure status
        \Illuminate\Support\Facades\Http::fake([
            'https://api.twilio.com/*' => \Illuminate\Support\Facades\Http::response([
                'code' => 21211,
                'message' => 'The To number is not a valid phone number.'
            ], 400)
        ]);

        // 3. Create a confirmed appointment
        $appointment = \App\Models\Appointment::create([
            'patient_name' => 'Jane Doe',
            'phone' => 'invalid_number',
            'department' => 'أمراض القلب',
            'date' => '2026-07-02',
            'time' => '10:00',
            'status' => 'confirmed',
        ]);

        // 4. Verify database records updated as failed with error message
        $whatsappNotification = Notification::where('type', 'whatsapp')->first();
        $this->assertNotNull($whatsappNotification);
        $this->assertEquals('failed', $whatsappNotification->status);
        $this->assertEquals('The To number is not a valid phone number.', $whatsappNotification->error_message);

        // Clean env variables
        putenv('TWILIO_SID');
        putenv('TWILIO_AUTH_TOKEN');
        putenv('TWILIO_SMS_FROM');
        putenv('TWILIO_WHATSAPP_FROM');
    }
}

