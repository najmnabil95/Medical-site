<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Screen;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Package;
use App\Models\Testimonial;
use App\Models\News;
use App\Models\Faq;
use App\Models\Insurance;
use App\Models\Partner;
use App\Models\Certification;
use App\Models\PriceItem;
use App\Models\Appointment;
use App\Models\Message;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::first() ?? new Setting();
        $screens = Screen::where('enabled', true)->orderBy('order', 'asc')->get();
        $departments = Department::where('active', true)->get();
        $doctors = Doctor::where('active', true)->get();
        $services = Service::where('active', true)->get();
        $packages = Package::where('active', true)->get();
        $testimonials = Testimonial::all();
        $news = News::orderBy('date', 'desc')->get();
        $faqs = Faq::all();
        $insurances = Insurance::where('active', true)->get();
        $partners = Partner::all();
        $certifications = Certification::all();
        $priceItems = PriceItem::where('active', true)->get();

        return view('home', compact(
            'settings',
            'screens',
            'departments',
            'doctors',
            'services',
            'packages',
            'testimonials',
            'news',
            'faqs',
            'insurances',
            'partners',
            'certifications',
            'priceItems'
        ));
    }

    public function storeAppointment(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'department' => 'required|string|max:255',
            'doctor' => 'nullable|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string',
            'type' => 'sometimes|in:normal,offer,consultation',
            'offer_id' => 'nullable',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';
        $appointment = Appointment::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم حجز الموعد بنجاح وسوف نتواصل معك لتأكيده.',
                'appointment' => $appointment
            ], 201);
        }

        return back()->with('success', 'تم حجز الموعد بنجاح وسوف نتواصل معك لتأكيده.');
    }

    public function storeMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $validated['status'] = 'new';
        $message = Message::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال رسالتك بنجاح. شكراً لتواصلك معنا!',
                'message_data' => $message
            ], 201);
        }

        return back()->with('success', 'تم إرسال رسالتك بنجاح. شكراً لتواصلك معنا!');
    }
}
