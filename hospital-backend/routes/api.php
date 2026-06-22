<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\InsuranceController;
use App\Http\Controllers\Api\PartnerController;
use App\Http\Controllers\Api\CertificationController;
use App\Http\Controllers\Api\PriceItemController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ActivityLogController;
use App\Http\Controllers\Api\ScreenController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\DashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::post('/auth/login', [AuthController::class, 'login']);

// Public read-only endpoints
Route::get('/departments', [DepartmentController::class, 'index']);
Route::get('/departments/{id}', [DepartmentController::class, 'show']);
Route::get('/doctors', [DoctorController::class, 'index']);
Route::get('/doctors/{id}', [DoctorController::class, 'show']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/packages', [PackageController::class, 'index']);
Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{id}', [NewsController::class, 'show']);
Route::get('/faqs', [FaqController::class, 'index']);
Route::get('/insurances', [InsuranceController::class, 'index']);
Route::get('/partners', [PartnerController::class, 'index']);
Route::get('/certifications', [CertificationController::class, 'index']);
Route::get('/prices', [PriceItemController::class, 'index']);
Route::post('/appointments', [AppointmentController::class, 'store']);
Route::post('/messages', [MessageController::class, 'store']);
Route::get('/settings', [SettingsController::class, 'getPublic']);

/*
|--------------------------------------------------------------------------
| Protected Routes (require auth:sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Users
    Route::apiResource('users', UserController::class)->except(['edit', 'create']);

    // Doctors
    Route::post('/doctors', [DoctorController::class, 'store']);
    Route::put('/doctors/{id}', [DoctorController::class, 'update']);
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy']);

    // Departments
    Route::post('/departments', [DepartmentController::class, 'store']);
    Route::put('/departments/{id}', [DepartmentController::class, 'update']);
    Route::delete('/departments/{id}', [DepartmentController::class, 'destroy']);

    // Appointments
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::get('/appointments/{id}', [AppointmentController::class, 'show']);
    Route::put('/appointments/{id}', [AppointmentController::class, 'update']);
    Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy']);

    // Services
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

    // Packages
    Route::post('/packages', [PackageController::class, 'store']);
    Route::put('/packages/{id}', [PackageController::class, 'update']);
    Route::delete('/packages/{id}', [PackageController::class, 'destroy']);

    // Testimonials
    Route::post('/testimonials', [TestimonialController::class, 'store']);
    Route::put('/testimonials/{id}', [TestimonialController::class, 'update']);
    Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy']);

    // News
    Route::post('/news', [NewsController::class, 'store']);
    Route::put('/news/{id}', [NewsController::class, 'update']);
    Route::delete('/news/{id}', [NewsController::class, 'destroy']);

    // FAQs
    Route::post('/faqs', [FaqController::class, 'store']);
    Route::put('/faqs/{id}', [FaqController::class, 'update']);
    Route::delete('/faqs/{id}', [FaqController::class, 'destroy']);

    // Insurances
    Route::post('/insurances', [InsuranceController::class, 'store']);
    Route::put('/insurances/{id}', [InsuranceController::class, 'update']);
    Route::delete('/insurances/{id}', [InsuranceController::class, 'destroy']);

    // Partners
    Route::post('/partners', [PartnerController::class, 'store']);
    Route::put('/partners/{id}', [PartnerController::class, 'update']);
    Route::delete('/partners/{id}', [PartnerController::class, 'destroy']);

    // Certifications
    Route::post('/certifications', [CertificationController::class, 'store']);
    Route::put('/certifications/{id}', [CertificationController::class, 'update']);
    Route::delete('/certifications/{id}', [CertificationController::class, 'destroy']);

    // Prices
    Route::post('/prices', [PriceItemController::class, 'store']);
    Route::put('/prices/{id}', [PriceItemController::class, 'update']);
    Route::delete('/prices/{id}', [PriceItemController::class, 'destroy']);

    // Messages
    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/messages/{id}', [MessageController::class, 'show']);
    Route::put('/messages/{id}', [MessageController::class, 'update']);
    Route::delete('/messages/{id}', [MessageController::class, 'destroy']);

    // Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index']);

    // Screens
    Route::apiResource('screens', ScreenController::class)->except(['edit', 'create']);

    // Settings
    Route::put('/settings', [SettingsController::class, 'update']);

    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
});
