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

        // Perform clear-all request acting as admin
        $response = $this->actingAs($admin)
            ->post(route('admin.notifications.clearAll'));

        $response->assertRedirect();
        $this->assertEquals(0, Notification::count());
    }
}
