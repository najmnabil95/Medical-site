<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\InsuranceController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\CertificationController;
use App\Http\Controllers\Admin\PriceItemController;
use App\Http\Controllers\Admin\ScreenController;
use App\Http\Controllers\Admin\ActivityLogController;

// Public site routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/doctors', [HomeController::class, 'doctors'])->name('doctors.index');
Route::get('/available-slots', [HomeController::class, 'getAvailableSlots'])->name('appointments.available-slots');
Route::post('/appointment', [HomeController::class, 'storeAppointment'])->name('appointments.store')->middleware('throttle:5,1');
Route::post('/message', [HomeController::class, 'storeMessage'])->name('messages.store')->middleware('throttle:5,1');

// Web Authentication routes
Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [WebAuthController::class, 'login']);
Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

// Admin Protected Dashboard routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Super Admin and Manager Protected Routes (Users & Screens)
    Route::middleware(['role:Super Admin|Manager'])->group(function () {
        // Users management
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        // Screens management
        Route::get('/screens', [ScreenController::class, 'index'])->name('admin.screens.index');
        Route::post('/screens', [ScreenController::class, 'store'])->name('admin.screens.store');
        Route::put('/screens/{id}', [ScreenController::class, 'update'])->name('admin.screens.update');
        Route::delete('/screens/{id}', [ScreenController::class, 'destroy'])->name('admin.screens.destroy');
        Route::post('/screens/{id}/up', [ScreenController::class, 'moveUp'])->name('admin.screens.up');
        Route::post('/screens/{id}/down', [ScreenController::class, 'moveDown'])->name('admin.screens.down');
    });

    // Super Admin Only Protected Routes (Settings & Logs Management)
    Route::middleware(['role:Super Admin'])->group(function () {
        // Settings management
        Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])->name('admin.settings.update');

        // Activity Logs management
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity-logs.index');
        Route::delete('/activity-logs/clear-all', [ActivityLogController::class, 'clearAll'])->name('admin.activity-logs.clearAll');
    });


    // Manager, Editor, and Super Admin Protected Routes (Content & Medical Admin)
    Route::middleware(['role:Super Admin|Manager|Editor'])->group(function () {
        // Doctors management
        Route::get('/doctors', [DoctorController::class, 'index'])->name('admin.doctors.index');
        Route::post('/doctors', [DoctorController::class, 'store'])->name('admin.doctors.store');
        Route::put('/doctors/{id}', [DoctorController::class, 'update'])->name('admin.doctors.update');
        Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('admin.doctors.destroy');

        // Departments management
        Route::get('/departments', [DepartmentController::class, 'index'])->name('admin.departments.index');
        Route::post('/departments', [DepartmentController::class, 'store'])->name('admin.departments.store');
        Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('admin.departments.update');
        Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('admin.departments.destroy');

        // Services management
        Route::get('/services', [ServiceController::class, 'index'])->name('admin.services.index');
        Route::post('/services', [ServiceController::class, 'store'])->name('admin.services.store');
        Route::put('/services/{id}', [ServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('/services/{id}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');

        // News management
        Route::get('/news', [NewsController::class, 'index'])->name('admin.news.index');
        Route::post('/news', [NewsController::class, 'store'])->name('admin.news.store');
        Route::put('/news/{id}', [NewsController::class, 'update'])->name('admin.news.update');
        Route::delete('/news/{id}', [NewsController::class, 'destroy'])->name('admin.news.destroy');

        // FAQs management
        Route::get('/faqs', [FaqController::class, 'index'])->name('admin.faqs.index');
        Route::post('/faqs', [FaqController::class, 'store'])->name('admin.faqs.store');
        Route::put('/faqs/{id}', [FaqController::class, 'update'])->name('admin.faqs.update');
        Route::delete('/faqs/{id}', [FaqController::class, 'destroy'])->name('admin.faqs.destroy');

        // Testimonials management
        Route::get('/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonials.index');
        Route::post('/testimonials', [TestimonialController::class, 'store'])->name('admin.testimonials.store');
        Route::put('/testimonials/{id}', [TestimonialController::class, 'update'])->name('admin.testimonials.update');
        Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy'])->name('admin.testimonials.destroy');

        // Partners management
        Route::get('/partners', [PartnerController::class, 'index'])->name('admin.partners.index');
        Route::post('/partners', [PartnerController::class, 'store'])->name('admin.partners.store');
        Route::put('/partners/{id}', [PartnerController::class, 'update'])->name('admin.partners.update');
        Route::delete('/partners/{id}', [PartnerController::class, 'destroy'])->name('admin.partners.destroy');

        // Certifications management
        Route::get('/certifications', [CertificationController::class, 'index'])->name('admin.certifications.index');
        Route::post('/certifications', [CertificationController::class, 'store'])->name('admin.certifications.store');
        Route::put('/certifications/{id}', [CertificationController::class, 'update'])->name('admin.certifications.update');
        Route::delete('/certifications/{id}', [CertificationController::class, 'destroy'])->name('admin.certifications.destroy');
    });

    // Manager, Accountant, and Super Admin Protected Routes (Financial Management)
    Route::middleware(['role:Super Admin|Manager|Accountant'])->group(function () {
        // Packages management
        Route::get('/packages', [PackageController::class, 'index'])->name('admin.packages.index');
        Route::post('/packages', [PackageController::class, 'store'])->name('admin.packages.store');
        Route::put('/packages/{id}', [PackageController::class, 'update'])->name('admin.packages.update');
        Route::delete('/packages/{id}', [PackageController::class, 'destroy'])->name('admin.packages.destroy');

        // Insurances management
        Route::get('/insurances', [InsuranceController::class, 'index'])->name('admin.insurances.index');
        Route::post('/insurances', [InsuranceController::class, 'store'])->name('admin.insurances.store');
        Route::put('/insurances/{id}', [InsuranceController::class, 'update'])->name('admin.insurances.update');
        Route::delete('/insurances/{id}', [InsuranceController::class, 'destroy'])->name('admin.insurances.destroy');

        // Prices management
        Route::get('/prices', [PriceItemController::class, 'index'])->name('admin.prices.index');
        Route::post('/prices', [PriceItemController::class, 'store'])->name('admin.prices.store');
        Route::put('/prices/{id}', [PriceItemController::class, 'update'])->name('admin.prices.update');
        Route::delete('/prices/{id}', [PriceItemController::class, 'destroy'])->name('admin.prices.destroy');
    });

    // Manager, Reception, Nurse, and Super Admin Protected Routes (Appointments)
    Route::middleware(['role:Super Admin|Manager|Reception|Nurse'])->group(function () {
        // Appointments management
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('admin.appointments.index');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('admin.appointments.store');
        Route::put('/appointments/{id}', [AppointmentController::class, 'update'])->name('admin.appointments.update');
        Route::put('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])->name('admin.appointments.updateStatus');
        Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('admin.appointments.destroy');
    });

    // Manager, Reception, and Super Admin Protected Routes (Operations Management - Messages & Notifications)
    Route::middleware(['role:Super Admin|Manager|Reception'])->group(function () {
        // Messages management
        Route::get('/messages', [MessageController::class, 'index'])->name('admin.messages.index');
        Route::post('/messages', [MessageController::class, 'store'])->name('admin.messages.store');
        Route::put('/messages/{id}', [MessageController::class, 'update'])->name('admin.messages.update');
        Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('admin.messages.destroy');

        // Notifications logs management
        Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('admin.notifications.index');
        Route::delete('/notifications/{id}', [\App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('admin.notifications.destroy');
        Route::post('/notifications/clear-all', [\App\Http\Controllers\Admin\NotificationController::class, 'clearAll'])->name('admin.notifications.clearAll');
    });
});

// Doctor Protected Dashboard routes
Route::middleware(['auth', 'role:Doctor'])->prefix('doctor')->group(function () {
    Route::get('/appointments', [\App\Http\Controllers\Doctor\AppointmentController::class, 'index'])->name('doctor.appointments.index');
    Route::put('/appointments/{id}/status', [\App\Http\Controllers\Doctor\AppointmentController::class, 'updateStatus'])->name('doctor.appointments.updateStatus');
});
