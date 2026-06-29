<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicFormSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_message_submission_normalizes_email_and_trims_inputs(): void
    {
        $response = $this->post('/message', [
            'name' => '  أحمد محمد  ',
            'email' => '  Ahmed@Example.COM  ',
            'subject' => '  استفسار عام  ',
            'message' => '  مرحبا  ',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('messages', [
            'name' => 'أحمد محمد',
            'email' => 'ahmed@example.com',
            'subject' => 'استفسار عام',
            'message' => 'مرحبا',
        ]);
    }

    public function test_appointment_submission_trims_user_input_values(): void
    {
        $response = $this->post('/appointment', [
            'patient_name' => '  أحمد محمد  ',
            'phone' => '  0501234567  ',
            'department' => '  القلب  ',
            'doctor' => '  د. علي  ',
            'date' => now()->addDay()->toDateString(),
            'time' => ' 09:30 ',
            'notes' => '  ملاحظة اختبار  ',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('appointments', [
            'patient_name' => 'أحمد محمد',
            'phone' => '0501234567',
            'department' => 'القلب',
            'doctor' => 'د. علي',
            'time' => '09:30',
            'notes' => 'ملاحظة اختبار',
        ]);
    }
}
