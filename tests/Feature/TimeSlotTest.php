<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimeSlotTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed database to have standard departments and doctors
        $this->seed();
    }

    public function test_get_available_slots_returns_all_slots_when_no_appointments(): void
    {
        $response = $this->getJson(route('appointments.available-slots', [
            'department' => 'أمراض القلب',
            'doctor' => 'د. أحمد الراشد',
            'date' => date('Y-m-d', strtotime('tomorrow')),
        ]));

        $response->assertStatus(200);
        
        $slots = $response->json();
        $this->assertCount(13, $slots); // Standard 13 slots from 08:00 to 20:00
        $this->assertContains('10:00', $slots);
    }

    public function test_get_available_slots_excludes_booked_time_for_specific_doctor(): void
    {
        $tomorrow = date('Y-m-d', strtotime('tomorrow'));

        // Book 10:00 AM slot for د. أحمد الراشد
        Appointment::create([
            'patient_name' => 'جون دو',
            'phone' => '0555555555',
            'department' => 'أمراض القلب',
            'doctor' => 'د. أحمد الراشد',
            'date' => $tomorrow,
            'time' => '10:00',
            'status' => 'confirmed',
        ]);

        // Request available slots for د. أحمد الراشد
        $response = $this->getJson(route('appointments.available-slots', [
            'department' => 'أمراض القلب',
            'doctor' => 'د. أحمد الراشد',
            'date' => $tomorrow,
        ]));

        $response->assertStatus(200);
        $slots = $response->json();
        
        $this->assertCount(12, $slots); // 13 - 1 = 12
        $this->assertNotContains('10:00', $slots); // 10:00 should be excluded
        $this->assertContains('09:00', $slots);
    }

    public function test_get_available_slots_excludes_booked_time_for_department_when_all_doctors_booked(): void
    {
        $tomorrow = date('Y-m-d', strtotime('tomorrow'));

        // Department 'أمراض القلب' has only one doctor seeded in database ('د. أحمد الراشد')
        // Let's verify by querying active doctors in that department
        $doctors = Doctor::where('department', 'أمراض القلب')->where('active', true)->pluck('name')->toArray();
        
        // Book 10:00 AM slot for the seeded doctor in this department
        foreach ($doctors as $docName) {
            Appointment::create([
                'patient_name' => 'مريض تجريبي',
                'phone' => '0555555555',
                'department' => 'أمراض القلب',
                'doctor' => $docName,
                'date' => $tomorrow,
                'time' => '10:00',
                'status' => 'confirmed',
            ]);
        }

        // Request available slots for the department without specifying a doctor
        $response = $this->getJson(route('appointments.available-slots', [
            'department' => 'أمراض القلب',
            'date' => $tomorrow,
        ]));

        $response->assertStatus(200);
        $slots = $response->json();

        // 10:00 should be excluded because the only doctor (or all doctors) in the department is booked
        $this->assertNotContains('10:00', $slots);
    }
}
