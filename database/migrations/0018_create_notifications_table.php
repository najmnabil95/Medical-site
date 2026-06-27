<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['sms', 'whatsapp', 'email', 'internal']);
            $table->string('recipient');
            $table->text('message');
            $table->enum('status', ['pending', 'sent', 'failed', 'delivered'])->default('pending');
            $table->string('reservation_id')->nullable();
            $table->string('patient_name')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
