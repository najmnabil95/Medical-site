<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$appointments = \App\Models\Appointment::all(['id', 'patient_name', 'date', 'status'])->toArray();
print_r($appointments);
