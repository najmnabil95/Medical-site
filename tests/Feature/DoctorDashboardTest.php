<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Appointment;
use Spatie\Permission\Models\Role;

class DoctorDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Role::firstOrCreate(['name' => 'Doctor']);
    }

    public function test_doctor_is_redirected_to_appointments_from_admin_dashboard(): void
    {
        $doctor = User::create([
            'username' => 'doctor.test',
            'password' => bcrypt('password'),
            'role' => 'Doctor',
            'name' => 'د. تيست',
            'email' => 'doctor@test.com',
            'phone' => '0501234567',
            'active' => true,
        ]);
        $doctor->assignRole('Doctor');

        $response = $this->actingAs($doctor)->get('/admin');
        
        $response->assertRedirect(route('doctor.appointments.index'));
    }

    public function test_doctor_can_view_own_appointments(): void
    {
        $doctor = User::create([
            'username' => 'doctor.ahmed',
            'password' => bcrypt('password'),
            'role' => 'Doctor',
            'name' => 'د. أحمد',
            'email' => 'ahmed@test.com',
            'phone' => '0501234568',
            'active' => true,
        ]);
        $doctor->assignRole('Doctor');

        $appt1 = Appointment::create([
            'patient_name' => 'John',
            'phone' => '050',
            'department' => 'Heart',
            'doctor' => 'د. أحمد',
            'date' => now()->format('Y-m-d'),
            'time' => '10:00',
            'status' => 'confirmed',
            'type' => 'normal',
        ]);

        $appt2 = Appointment::create([
            'patient_name' => 'Jane',
            'phone' => '050',
            'department' => 'Heart',
            'doctor' => 'د. محمد', // Different doctor
            'date' => now()->format('Y-m-d'),
            'time' => '11:00',
            'status' => 'confirmed',
            'type' => 'normal',
        ]);

        $response = $this->actingAs($doctor)->get(route('doctor.appointments.index', ['tab' => 'today']));
        
        $response->assertStatus(200);
        $response->assertSee('John');
        $response->assertDontSee('Jane');
    }
}
