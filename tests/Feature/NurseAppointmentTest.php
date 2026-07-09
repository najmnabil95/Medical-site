<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NurseAppointmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles and permissions
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);

        // Setup base data
        Department::create([
            'name' => 'أمراض القلب',
            'icon' => 'Heart',
            'desc' => 'Cardiology',
            'color' => 'red',
            'active' => true,
        ]);

        Department::create([
            'name' => 'طب الأطفال',
            'icon' => 'Baby',
            'desc' => 'Pediatrics',
            'color' => 'pink',
            'active' => true,
        ]);

        Doctor::create([
            'name' => 'د. أحمد الراشد',
            'specialty' => 'Cardiologist',
            'department' => 'أمراض القلب',
            'image' => 'cardio.jpg',
            'rating' => 4.9,
            'experience' => '20 years',
            'patients' => '+5000',
            'gradient' => 'red',
            'active' => true,
        ]);

        Doctor::create([
            'name' => 'د. سارة المنصور',
            'specialty' => 'Pediatrician',
            'department' => 'طب الأطفال',
            'image' => 'ped.jpg',
            'rating' => 4.8,
            'experience' => '15 years',
            'patients' => '+3500',
            'gradient' => 'pink',
            'active' => true,
        ]);
    }

    private function createAdmin(): User
    {
        $admin = User::create([
            'username' => 'admin_test',
            'password' => bcrypt('password123'),
            'role' => 'Super Admin',
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '+123456789',
            'active' => true,
        ]);
        $admin->assignRole('Super Admin');
        return $admin;
    }

    private function createNurse(array $departments = [], array $doctors = []): User
    {
        $nurse = User::create([
            'username' => 'fatima_test',
            'password' => bcrypt('password123'),
            'role' => 'Nurse',
            'name' => 'Fatima',
            'email' => 'fatima@example.com',
            'phone' => '+966501112222',
            'active' => true,
            'assigned_departments' => $departments,
            'assigned_doctors' => $doctors,
        ]);
        $nurse->assignRole('Nurse');
        return $nurse;
    }

    /**
     * Test department-doctor validation when creating a Nurse.
     */
    public function test_nurse_cannot_be_linked_to_doctor_without_linking_to_their_department_first(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        // Attempting to create a Nurse linked to 'د. أحمد الراشد' (Cardiology) but only assigned to 'طب الأطفال' (Pediatrics) department
        $response = $this->post(route('admin.users.store'), [
            'name' => 'Fatima Zahra',
            'username' => 'fatima.zahra',
            'password' => 'password123',
            'role' => 'Nurse',
            'email' => 'fatima.zahra@example.com',
            'phone' => '+966504445555',
            'assigned_departments' => ['طب الأطفال'],
            'assigned_doctors' => ['د. أحمد الراشد'],
            'active' => 1,
        ]);

        $response->assertSessionHasErrors(['assigned_doctors']);
        $this->assertDatabaseMissing('users', ['username' => 'fatima.zahra']);
    }

    /**
     * Test successful Nurse creation when doctor department is assigned.
     */
    public function test_nurse_creation_succeeds_when_properly_linked_to_department_and_doctor(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin);

        $response = $this->post(route('admin.users.store'), [
            'name' => 'Fatima Zahra',
            'username' => 'fatima.zahra',
            'password' => 'password123',
            'role' => 'Nurse',
            'email' => 'fatima.zahra@example.com',
            'phone' => '+966504445555',
            'assigned_departments' => ['أمراض القلب', 'طب الأطفال'],
            'assigned_doctors' => ['د. أحمد الراشد'],
            'active' => 1,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['username' => 'fatima.zahra']);
    }

    /**
     * Test appointment visibility filtered by assigned doctors for Nurse.
     */
    public function test_nurse_only_sees_appointments_for_assigned_doctors(): void
    {
        $nurse = $this->createNurse(['أمراض القلب'], ['د. أحمد الراشد']);

        // Create appointments
        $appt1 = Appointment::create([
            'patient_name' => 'John Doe',
            'phone' => '0501111111',
            'department' => 'أمراض القلب',
            'doctor' => 'د. أحمد الراشد',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '10:00 ص',
            'status' => 'pending',
            'type' => 'consultation',
        ]);

        $appt2 = Appointment::create([
            'patient_name' => 'Jane Smith',
            'phone' => '0502222222',
            'department' => 'طب الأطفال',
            'doctor' => 'د. سارة المنصور',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '11:00 ص',
            'status' => 'pending',
            'type' => 'consultation',
        ]);

        $this->actingAs($nurse);

        $response = $this->get(route('admin.appointments.index'));
        $response->assertStatus(200);

        // Nurse should see John Doe but not Jane Smith
        $response->assertSee('John Doe');
        $response->assertDontSee('Jane Smith');
    }

    /**
     * Test Nurse capability to confirm and cancel bookings for assigned doctor.
     */
    public function test_nurse_can_confirm_and_cancel_bookings_for_assigned_doctor(): void
    {
        $nurse = $this->createNurse(['أمراض القلب'], ['د. أحمد الراشد']);

        $appt = Appointment::create([
            'patient_name' => 'John Doe',
            'phone' => '0501111111',
            'department' => 'أمراض القلب',
            'doctor' => 'د. أحمد الراشد',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '10:00 ص',
            'status' => 'pending',
            'type' => 'consultation',
        ]);

        $this->actingAs($nurse);

        // Confirm booking
        $response1 = $this->put(route('admin.appointments.updateStatus', $appt->id), [
            'status' => 'confirmed',
        ]);
        $response1->assertRedirect();
        $this->assertEquals('confirmed', $appt->fresh()->status);

        // Cancel booking
        $response2 = $this->put(route('admin.appointments.updateStatus', $appt->id), [
            'status' => 'cancelled',
        ]);
        $response2->assertRedirect();
        $this->assertEquals('cancelled', $appt->fresh()->status);
    }

    /**
     * Test Nurse blocked from performing actions on unassigned doctors' bookings.
     */
    public function test_nurse_cannot_manage_bookings_for_unassigned_doctors(): void
    {
        $nurse = $this->createNurse(['أمراض القلب'], ['د. أحمد الراشد']);

        $appt = Appointment::create([
            'patient_name' => 'Jane Smith',
            'phone' => '0502222222',
            'department' => 'طب الأطفال',
            'doctor' => 'د. سارة المنصور',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '11:00 ص',
            'status' => 'pending',
            'type' => 'consultation',
        ]);

        $this->actingAs($nurse);

        // Attempt confirm
        $response1 = $this->put(route('admin.appointments.updateStatus', $appt->id), [
            'status' => 'confirmed',
        ]);
        $response1->assertStatus(403);
        $this->assertEquals('pending', $appt->fresh()->status);

        // Attempt reschedule / update to another doctor or unassigned doctor
        $response2 = $this->put(route('admin.appointments.update', $appt->id), [
            'patient_name' => 'Jane Smith Update',
            'phone' => '0502222222',
            'department' => 'طب الأطفال',
            'doctor' => 'د. سارة المنصور',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '12:00 م',
            'status' => 'confirmed',
            'type' => 'normal',
        ]);
        $response2->assertStatus(403);
    }

    /**
     * Test Nurse cannot delete appointments.
     */
    public function test_nurse_cannot_delete_appointments(): void
    {
        $nurse = $this->createNurse(['أمراض القلب'], ['د. أحمد الراشد']);

        $appt = Appointment::create([
            'patient_name' => 'John Doe',
            'phone' => '0501111111',
            'department' => 'أمراض القلب',
            'doctor' => 'د. أحمد الراشد',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '10:00 ص',
            'status' => 'pending',
            'type' => 'consultation',
        ]);

        $this->actingAs($nurse);

        $response = $this->delete(route('admin.appointments.destroy', $appt->id));
        $response->assertStatus(403);
        $this->assertDatabaseHas('appointments', ['id' => $appt->id]);
    }

    /**
     * Test Nurse cannot change department or doctor of an appointment.
     */
    public function test_nurse_cannot_change_department_or_doctor_of_appointment(): void
    {
        $nurse = $this->createNurse(['أمراض القلب', 'طب الأطفال'], ['د. أحمد الراشد', 'د. سارة المنصور']);

        $appt = Appointment::create([
            'patient_name' => 'John Doe',
            'phone' => '0501111111',
            'department' => 'أمراض القلب',
            'doctor' => 'د. أحمد الراشد',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '10:00 ص',
            'status' => 'pending',
            'type' => 'consultation',
        ]);

        $this->actingAs($nurse);

        // Attempt to update the doctor to another assigned doctor (د. سارة المنصور)
        $response = $this->put(route('admin.appointments.update', $appt->id), [
            'patient_name' => 'John Doe',
            'phone' => '0501111111',
            'department' => 'طب الأطفال',
            'doctor' => 'د. سارة المنصور',
            'date' => now()->addDay()->format('Y-m-d'),
            'time' => '10:00 ص',
            'status' => 'pending',
            'type' => 'consultation',
        ]);

        $response->assertStatus(403);
        // Ensure database didn't change
        $this->assertEquals('د. أحمد الراشد', $appt->fresh()->doctor);
    }
}
