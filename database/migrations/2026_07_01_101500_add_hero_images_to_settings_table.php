<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->longText('hero_image_1')->nullable();
            $table->longText('hero_image_2')->nullable();
            $table->longText('hero_image_3')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['hero_image_1', 'hero_image_2', 'hero_image_3']);
        });
    }
};
