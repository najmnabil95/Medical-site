<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Doctor;
use App\Models\ActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ActivityLogTest extends TestCase
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

    private function createEditor(): User
    {
        $user = User::create([
            'username' => 'editor_test',
            'password' => bcrypt('password123'),
            'role' => 'Editor',
            'name' => 'Editor User',
            'email' => 'editor_test@example.com',
            'phone' => '+1234567891',
            'active' => true,
        ]);
        $user->assignRole('Editor');
        return $user;
    }

    public function test_creating_updating_deleting_model_logs_activity(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        // 1. Test Create
        $doctor = Doctor::create([
            'name' => 'د. محمد علي',
            'specialty' => 'طب الأطفال',
            'department' => 'طب الأطفال',
            'image' => 'https://example.com/doc.jpg',
            'rating' => 4.8,
            'experience' => '10 سنوات',
            'patients' => '500+',
            'gradient' => 'from-blue-500 to-indigo-600',
            'active' => true,
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'type' => 'create',
            'user' => 'Admin User',
            'action' => 'تم إضافة طبيب جديد: د. محمد علي',
        ]);

        // 2. Test Update
        $doctor->update(['specialty' => 'استشاري طب الأطفال']);
        
        $this->assertDatabaseHas('activity_logs', [
            'type' => 'update',
            'user' => 'Admin User',
            'action' => 'تم تعديل بيانات طبيب: د. محمد علي',
        ]);

        // 3. Test Delete
        $doctor->delete();

        $this->assertDatabaseHas('activity_logs', [
            'type' => 'delete',
            'user' => 'Admin User',
            'action' => 'تم حذف طبيب: د. محمد علي',
        ]);
    }

    public function test_login_logout_events_log_activity(): void
    {
        $user = User::create([
            'username' => 'test_user',
            'password' => bcrypt('password123'),
            'role' => 'Super Admin',
            'name' => 'Test User',
            'email' => 'test_user@example.com',
            'phone' => '+1234567890',
            'active' => true,
        ]);
        $user->assignRole('Super Admin');

        // Trigger login event manually since actingAs doesn't dispatch standard HTTP auth events
        event(new \Illuminate\Auth\Events\Login('web', $user, false));

        $this->assertDatabaseHas('activity_logs', [
            'type' => 'login',
            'user' => 'Test User',
            'action' => 'تم تسجيل الدخول إلى النظام بنجاح',
        ]);

        // Trigger logout event manually
        event(new \Illuminate\Auth\Events\Logout('web', $user));

        $this->assertDatabaseHas('activity_logs', [
            'type' => 'logout',
            'user' => 'Test User',
            'action' => 'تم تسجيل الخروج من النظام بنجاح',
        ]);
    }

    public function test_activity_logs_page_only_accessible_to_super_admin(): void
    {
        $editor = $this->createEditor();
        $admin = $this->createAdmin();

        // 1. Editor should be forbidden
        $response = $this->actingAs($editor)->get(route('admin.activity-logs.index'));
        $response->assertStatus(403);

        // 2. Super Admin should be allowed
        $response = $this->actingAs($admin)->get(route('admin.activity-logs.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.activity-logs.index');
    }

    public function test_super_admin_can_clear_all_activity_logs(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        // Create a dummy log entry
        ActivityLog::create([
            'action' => 'عملية تجريبية',
            'type' => 'create',
            'user' => 'System',
        ]);

        $this->assertGreaterThan(0, ActivityLog::count());

        $response = $this->delete(route('admin.activity-logs.clearAll'));
        $response->assertRedirect(route('admin.activity-logs.index'));
        $response->assertSessionHas('success', 'تم مسح سجل النشاطات بالكامل بنجاح.');

        $this->assertEquals(0, ActivityLog::count());
    }
}
