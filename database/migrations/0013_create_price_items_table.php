<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_items', function (Blueprint $table) {
            $table->id();
            $table->string('service');
            $table->string('category');
            $table->decimal('price', 10, 2);
            $table->decimal('price_to', 10, 2)->nullable();
            $table->string('currency')->default('ر.س');
            $table->string('duration')->nullable();
            $table->text('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_items');
    }
};
