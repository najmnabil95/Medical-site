<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles and permissions
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    private function createUser(string $username, string $roleName): User
    {
        $user = User::create([
            'username' => $username,
            'password' => bcrypt('password123'),
            'role' => $roleName,
            'name' => 'Test User',
            'email' => $username . '@example.com',
            'phone' => '+1234567890',
            'active' => true,
        ]);
        $user->assignRole($roleName);
        return $user;
    }

    public function test_unauthenticated_requests_are_blocked(): void
    {
        $this->getJson('/api/users')->assertStatus(401);
        $this->putJson('/api/settings', [])->assertStatus(401);
    }

    public function test_users_without_required_role_are_forbidden(): void
    {
        // Create user with 'Doctor' role (which shouldn't access users list or settings)
        $user = $this->createUser('doc.test', 'Doctor');

        Sanctum::actingAs($user, ['Doctor']);

        // Cannot view users list
        $this->getJson('/api/users')->assertStatus(403);
        // Cannot update settings
        $this->putJson('/api/settings', [])->assertStatus(403);
    }

    public function test_authorized_users_can_access_endpoints(): void
    {
        // Create Super Admin user
        $admin = $this->createUser('admin.test', 'Super Admin');

        Sanctum::actingAs($admin, ['Super Admin']);

        // Can view users list
        $this->getJson('/api/users')->assertStatus(200);
    }
}
