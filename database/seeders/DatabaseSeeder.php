<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
use App\Models\Setting;
use App\Models\Screen;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed official roles and permissions first
        $this->call(RolesAndPermissionsSeeder::class);

        $admin = User::create(['username' => 'admin', 'password' => Hash::make('admin123'), 'role' => 'Super Admin', 'name' => 'مدير النظام', 'email' => 'admin@alshifa-hospital.com', 'phone' => '+966 50 123 4567', 'active' => true]);
        $admin->assignRole('Super Admin');

        $doc1 = User::create(['username' => 'ahmed.rashed', 'password' => Hash::make('doctor123'), 'role' => 'Doctor', 'name' => 'د. أحمد الراشد', 'email' => 'ahmed.rashed@alshifa-hospital.com', 'phone' => '+966 50 111 2222', 'active' => true, 'assigned_departments' => ['أمراض القلب']]);
        $doc1->assignRole('Doctor');

        $doc2 = User::create(['username' => 'sara.mansour', 'password' => Hash::make('doctor123'), 'role' => 'Doctor', 'name' => 'د. سارة المنصور', 'email' => 'sara.mansour@alshifa-hospital.com', 'phone' => '+966 50 222 3333', 'active' => true, 'assigned_departments' => ['طب الأطفال']]);
        $doc2->assignRole('Doctor');

        $doc3 = User::create(['username' => 'khalid.omari', 'password' => Hash::make('doctor123'), 'role' => 'Doctor', 'name' => 'د. خالد العمري', 'email' => 'khalid.omari@alshifa-hospital.com', 'phone' => '+966 50 333 4444', 'active' => true, 'assigned_departments' => ['جراحة المخ والأعصاب']]);
        $doc3->assignRole('Doctor');

        $nurse1 = User::create(['username' => 'nurse.fatima', 'password' => Hash::make('nurse123'), 'role' => 'Nurse', 'name' => 'فاطمة الزهراء', 'email' => 'fatima@alshifa-hospital.com', 'phone' => '+966 50 444 5555', 'active' => true, 'assigned_departments' => ['أمراض القلب', 'طب الأطفال'], 'assigned_doctors' => ['د. أحمد الراشد', 'د. سارة المنصور']]);
        $nurse1->assignRole('Nurse');

        $nurse2 = User::create(['username' => 'nurse.mohammed', 'password' => Hash::make('nurse123'), 'role' => 'Nurse', 'name' => 'محمد السعيد', 'email' => 'mohammed@alshifa-hospital.com', 'phone' => '+966 50 555 6666', 'active' => true, 'assigned_departments' => ['جراحة المخ والأعصاب'], 'assigned_doctors' => ['د. خالد العمري']]);
        $nurse2->assignRole('Nurse');

        $reception = User::create(['username' => 'reception.noura', 'password' => Hash::make('reception123'), 'role' => 'Reception', 'name' => 'نورة القحطاني', 'email' => 'noura@alshifa-hospital.com', 'phone' => '+966 50 666 7777', 'active' => true]);
        $reception->assignRole('Reception');

        $accountant = User::create(['username' => 'accountant.fahad', 'password' => Hash::make('accountant123'), 'role' => 'Accountant', 'name' => 'فهد العتيبي', 'email' => 'fahad@alshifa-hospital.com', 'phone' => '+966 50 777 8888', 'active' => true]);
        $accountant->assignRole('Accountant');

        Department::create(['icon' => 'Heart', 'name' => 'أمراض القلب', 'desc' => 'تشخيص وعلاج أمراض القلب والأوعية الدموية بأحدث التقنيات وقسطرة القلب', 'color' => 'from-red-500 to-rose-600', 'active' => true]);
        Department::create(['icon' => 'Brain', 'name' => 'جراحة المخ والأعصاب', 'desc' => 'علاج أمراض الدماغ والجهاز العصبي المركزي والطرفي بدقة متناهية', 'color' => 'from-purple-500 to-violet-600', 'active' => true]);
        Department::create(['icon' => 'Bone', 'name' => 'جراحة العظام', 'desc' => 'علاج الإصابات والكسور وتبديل المفاصل وجراحات العمود الفقري', 'color' => 'from-amber-500 to-orange-600', 'active' => true]);
        Department::create(['icon' => 'Baby', 'name' => 'طب الأطفال', 'desc' => 'رعاية صحية متكاملة للأطفال وحديثي الولادة والخدج بأحدث الحضانات', 'color' => 'from-pink-500 to-rose-600', 'active' => true]);
        Department::create(['icon' => 'Eye', 'name' => 'طب العيون', 'desc' => 'تصحيح النظر بالليزك وعلاج أمراض العيون وزراعة القرنية', 'color' => 'from-cyan-500 to-teal-600', 'active' => true]);
        Department::create(['icon' => 'Stethoscope', 'name' => 'الطب الباطني', 'desc' => 'تشخيص وعلاج أمراض الجهاز الهضمي والكبد والغدد الصماء', 'color' => 'from-blue-500 to-indigo-600', 'active' => true]);

        Doctor::create(['name' => 'د. أحمد الراشد', 'specialty' => 'استشاري جراحة القلب والأوعية الدموية', 'department' => 'أمراض القلب', 'image' => 'https://images.pexels.com/photos/5452224/pexels-photo-5452224.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400', 'rating' => 4.9, 'experience' => '20 سنة', 'patients' => '+5000', 'gradient' => 'from-red-500 to-rose-600', 'active' => true]);
        Doctor::create(['name' => 'د. سارة المنصور', 'specialty' => 'استشارية طب الأطفال وحديثي الولادة', 'department' => 'طب الأطفال', 'image' => 'https://images.pexels.com/photos/33032998/pexels-photo-33032998.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400', 'rating' => 4.8, 'experience' => '15 سنة', 'patients' => '+3500', 'gradient' => 'from-pink-500 to-rose-600', 'active' => true]);
        Doctor::create(['name' => 'د. خالد العمري', 'specialty' => 'استشاري جراحة المخ والأعصاب', 'department' => 'جراحة المخ والأعصاب', 'image' => 'https://images.pexels.com/photos/14438786/pexels-photo-14438786.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400', 'rating' => 4.9, 'experience' => '18 سنة', 'patients' => '+4200', 'gradient' => 'from-purple-500 to-violet-600', 'active' => true]);
        Doctor::create(['name' => 'د. نورة الحربي', 'specialty' => 'استشارية طب العيون وجراحة الليزر', 'department' => 'طب العيون', 'image' => 'https://images.pexels.com/photos/19260195/pexels-photo-19260195.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400', 'rating' => 4.7, 'experience' => '12 سنة', 'patients' => '+2800', 'gradient' => 'from-cyan-500 to-teal-600', 'active' => true]);

        Service::create(['icon' => 'Ambulance', 'title' => 'خدمة الإسعاف', 'desc' => 'سيارات إسعاف مجهزة بأحدث المعدات الطبية للنقل الآمن والسريع', 'color' => 'from-red-500 to-rose-600', 'number' => '01', 'active' => true]);
        Service::create(['icon' => 'Clock', 'title' => 'طوارئ 24/7', 'desc' => 'قسم طوارئ يعمل على مدار الساعة بفريق طبي متخصص ومؤهل', 'color' => 'from-orange-500 to-amber-600', 'number' => '02', 'active' => true]);
        Service::create(['icon' => 'FlaskConical', 'title' => 'مختبرات متقدمة', 'desc' => 'تحاليل طبية شاملة بأحدث الأجهزة ونتائج دقيقة وسريعة', 'color' => 'from-blue-500 to-indigo-600', 'number' => '03', 'active' => true]);
        Service::create(['icon' => 'Scan', 'title' => 'الأشعة والتصوير', 'desc' => 'أجهزة تصوير متطورة تشمل الرنين المغناطيسي والأشعة المقطعية', 'color' => 'from-purple-500 to-violet-600', 'number' => '04', 'active' => true]);

        Package::create(['name' => 'الباقة الأساسية', 'name_en' => 'Basic', 'price' => '500', 'period' => 'سنوياً', 'icon' => '🩺', 'popular' => false, 'gradient' => 'from-gray-600 to-gray-800', 'features' => ['كشف طبي شامل سنوي', 'تحاليل دم أساسية', 'أشعة صدر'], 'active' => true]);
        Package::create(['name' => 'الباقة الذهبية', 'name_en' => 'Gold', 'price' => '1,500', 'period' => 'سنوياً', 'icon' => '👑', 'popular' => true, 'gradient' => 'from-amber-500 to-yellow-600', 'features' => ['كشف طبي شامل مرتين سنوياً', 'تحاليل دم شاملة', 'خصم 25%'], 'active' => true]);
        Package::create(['name' => 'الباقة البلاتينية', 'name_en' => 'Platinum', 'price' => '3,000', 'period' => 'سنوياً', 'icon' => '💎', 'popular' => false, 'gradient' => 'from-violet-600 to-purple-800', 'features' => ['كشف طبي شامل 4 مرات', 'جميع التحاليل', 'خصم 40%'], 'active' => true]);

        Testimonial::create(['name' => 'محمد بن عبدالله', 'role' => 'مريض - جراحة القلب', 'text' => 'تجربة رائعة في مستشفى الشفاء. الفريق الطبي كان محترفاً للغاية.', 'rating' => 5, 'avatar' => 'م', 'color' => 'from-primary-500 to-primary-600']);
        Testimonial::create(['name' => 'فاطمة الزهراء', 'role' => 'مريضة - طب العيون', 'text' => 'أجريت عملية تصحيح النظر بالليزر وكانت النتائج مذهلة.', 'rating' => 5, 'avatar' => 'ف', 'color' => 'from-accent-500 to-accent-600']);
        Testimonial::create(['name' => 'عبدالرحمن السعيد', 'role' => 'مريض - جراحة العظام', 'text' => 'الفريق الطبي في مستشفى الشفاء أعاد لي الثقة وتعافيت بشكل كامل.', 'rating' => 5, 'avatar' => 'ع', 'color' => 'from-purple-500 to-violet-600']);

        News::create(['image' => 'https://images.pexels.com/photos/24193873/pexels-photo-24193873.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=350&w=550', 'category' => 'أخبار المستشفى', 'title' => 'مستشفى الشفاء يحصل على اعتماد JCI الدولي', 'excerpt' => 'حصل المستشفى على تجديد الاعتماد الدولي', 'date' => '2024-01-15', 'author' => 'إدارة المستشفى', 'read_time' => '5 دقائق', 'category_color' => 'bg-primary-100 text-primary-700', 'featured' => true]);
        News::create(['image' => 'https://images.pexels.com/photos/18112241/pexels-photo-18112241.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=350&w=550', 'category' => 'تقنية طبية', 'title' => 'إطلاق أحدث جهاز للتصوير بالرنين المغناطيسي', 'excerpt' => 'دشن المستشفى أحدث جهاز تصوير بالرنين', 'date' => '2024-01-08', 'author' => 'القسم التقني', 'read_time' => '3 دقائق', 'category_color' => 'bg-purple-100 text-purple-700', 'featured' => false]);

        Faq::create(['question' => 'ما هي ساعات عمل المستشفى؟', 'answer' => 'يعمل المستشفى من السبت إلى الخميس من الساعة 8 صباحاً حتى 10 مساءً.']);
        Faq::create(['question' => 'كيف يمكنني حجز موعد مع طبيب؟', 'answer' => 'يمكنك حجز موعد عبر النموذج الإلكتروني أو الاتصال بنا على الرقم 920012345.']);
        Faq::create(['question' => 'هل يقبل المستشفى جميع شركات التأمين؟', 'answer' => 'نتعامل مع أكثر من 25 شركة تأمين طبي معتمدة.']);

        Insurance::create(['name' => 'بوبا العربية', 'abbr' => 'BUPA', 'active' => true]);
        Insurance::create(['name' => 'التعاونية', 'abbr' => 'TAWU', 'active' => true]);
        Insurance::create(['name' => 'ميدغلف', 'abbr' => 'MEDG', 'active' => true]);
        Insurance::create(['name' => 'الراجحي تكافل', 'abbr' => 'RAJH', 'active' => true]);

        Partner::create(['name' => 'JCI', 'sub' => 'الاعتماد الدولي', 'emoji' => '🏆']);
        Partner::create(['name' => 'WHO', 'sub' => 'منظمة الصحة العالمية', 'emoji' => '🌍']);
        Partner::create(['name' => 'CBAHI', 'sub' => 'المجلس المركزي', 'emoji' => '🏛️']);

        Certification::create(['icon' => '🏆', 'name' => 'JCI', 'full_name' => 'الاعتماد الدولي', 'desc' => 'حاصلون على اعتماد الهيئة الدولية', 'year' => '2024', 'color' => 'from-amber-500 to-yellow-600', 'border' => 'border-amber-200', 'bg' => 'bg-amber-50']);
        Certification::create(['icon' => '🌟', 'name' => 'CBAHI', 'full_name' => 'المجلس المركزي', 'desc' => 'اعتماد المجلس المركزي', 'year' => '2024', 'color' => 'from-blue-500 to-indigo-600', 'border' => 'border-blue-200', 'bg' => 'bg-blue-50']);

        PriceItem::create(['service' => 'استشارة عامة', 'category' => 'استشارة', 'price' => 100, 'currency' => 'ر.س', 'duration' => '30 دقيقة', 'active' => true]);
        PriceItem::create(['service' => 'استشارة متخصصة', 'category' => 'استشارة', 'price' => 200, 'currency' => 'ر.س', 'duration' => '30 دقيقة', 'active' => true]);
        PriceItem::create(['service' => 'استشارة استشاري', 'category' => 'استشارة', 'price' => 300, 'currency' => 'ر.س', 'duration' => '45 دقيقة', 'active' => true]);
        PriceItem::create(['service' => 'فحص دم شامل', 'category' => 'تحليل', 'price' => 150, 'currency' => 'ر.س', 'active' => true]);
        PriceItem::create(['service' => 'تحليل سكر تراكمي', 'category' => 'تحليل', 'price' => 80, 'currency' => 'ر.س', 'active' => true]);
        PriceItem::create(['service' => 'أشعة سينية', 'category' => 'أشعة', 'price' => 120, 'currency' => 'ر.س', 'active' => true]);
        PriceItem::create(['service' => 'أشعة مقطعية', 'category' => 'أشعة', 'price' => 800, 'currency' => 'ر.س', 'duration' => '20 دقيقة', 'active' => true]);
        PriceItem::create(['service' => 'رنين مغناطيسي', 'category' => 'أشعة', 'price' => 1500, 'currency' => 'ر.س', 'duration' => '45 دقيقة', 'active' => true]);
        PriceItem::create(['service' => 'عملية جراحية بسيطة', 'category' => 'جراحة', 'price' => 5000, 'currency' => 'ر.س', 'active' => true]);
        PriceItem::create(['service' => 'عملية جراحية معقدة', 'category' => 'جراحة', 'price' => 15000, 'currency' => 'ر.س', 'active' => true]);

        Setting::create([
            'site_name' => 'مستشفى الشفاء',
            'site_name_en' => 'AL-SHIFA INTERNATIONAL HOSPITAL',
            'phone' => '+966 12 345 6789',
            'phone_en' => '920012345',
            'email' => 'info@alshifa-hospital.com',
            'address' => 'طريق الملك فهد',
            'city' => 'الرياض، المملكة العربية السعودية',
            'emergency' => '920012345',
            'whatsapp' => '966123456789',
            'facebook' => '#',
            'twitter' => '#',
            'instagram' => '#',
            'youtube' => '#',
            'linkedin' => '#',
            'snapchat' => '#',
        ]);

        Screen::create(['name' => 'الرئيسية', 'component' => 'Hero', 'enabled' => true, 'order' => 1, 'icon' => '🏠']);
        Screen::create(['name' => 'من نحن', 'component' => 'About', 'enabled' => true, 'order' => 2, 'icon' => '📖']);
        Screen::create(['name' => 'لماذا تختارنا', 'component' => 'WhyChooseUs', 'enabled' => true, 'order' => 3, 'icon' => '⭐']);
        Screen::create(['name' => 'الإحصائيات', 'component' => 'Stats', 'enabled' => true, 'order' => 4, 'icon' => '📊']);
        Screen::create(['name' => 'الأقسام الطبية', 'component' => 'Departments', 'enabled' => true, 'order' => 5, 'icon' => '🏥']);
        Screen::create(['name' => 'الأطباء', 'component' => 'Doctors', 'enabled' => true, 'order' => 6, 'icon' => '👨‍⚕️']);
        Screen::create(['name' => 'الخدمات', 'component' => 'Services', 'enabled' => true, 'order' => 7, 'icon' => '💼']);
        Screen::create(['name' => 'الاستشارات عن بُعد', 'component' => 'Telemedicine', 'enabled' => true, 'order' => 8, 'icon' => '📹']);
        Screen::create(['name' => 'الفيديو التعريفي', 'component' => 'VideoSection', 'enabled' => true, 'order' => 9, 'icon' => '🎬']);
        Screen::create(['name' => 'معرض الصور', 'component' => 'Gallery', 'enabled' => true, 'order' => 10, 'icon' => '🖼️']);
        Screen::create(['name' => 'آراء المرضى', 'component' => 'Testimonials', 'enabled' => true, 'order' => 11, 'icon' => '💬']);
        Screen::create(['name' => 'العروض والخصومات', 'component' => 'Offers', 'enabled' => true, 'order' => 12, 'icon' => '🎁']);
        Screen::create(['name' => 'الباقات المميزة', 'component' => 'PremiumPackages', 'enabled' => true, 'order' => 13, 'icon' => '💎']);
        Screen::create(['name' => 'حاسبة التكلفة', 'component' => 'CostCalculator', 'enabled' => true, 'order' => 14, 'icon' => '🧮']);
        Screen::create(['name' => 'الرعاية المنزلية', 'component' => 'HomeCare', 'enabled' => true, 'order' => 15, 'icon' => '🏠']);
        Screen::create(['name' => 'السياحة العلاجية', 'component' => 'MedicalTourism', 'enabled' => true, 'order' => 16, 'icon' => '✈️']);
        Screen::create(['name' => 'حجز موعد', 'component' => 'Appointment', 'enabled' => true, 'order' => 17, 'icon' => '📅']);
        Screen::create(['name' => 'المسيرة الزمنية', 'component' => 'Timeline', 'enabled' => true, 'order' => 18, 'icon' => '⏳']);
        Screen::create(['name' => 'الشهادات والاعتمادات', 'component' => 'Certifications', 'enabled' => true, 'order' => 19, 'icon' => '🏆']);
        Screen::create(['name' => 'التأمين الطبي', 'component' => 'Insurance', 'enabled' => true, 'order' => 20, 'icon' => '🛡️']);
        Screen::create(['name' => 'تطبيق الجوال', 'component' => 'MobileApp', 'enabled' => true, 'order' => 21, 'icon' => '📱']);
        Screen::create(['name' => 'الأخبار', 'component' => 'News', 'enabled' => true, 'order' => 22, 'icon' => '📰']);
        Screen::create(['name' => 'الأسئلة الشائعة', 'component' => 'FAQ', 'enabled' => true, 'order' => 23, 'icon' => '❓']);
        Screen::create(['name' => 'الشركاء', 'component' => 'Partners', 'enabled' => true, 'order' => 24, 'icon' => '🤝']);
        Screen::create(['name' => 'تواصل معنا', 'component' => 'Contact', 'enabled' => true, 'order' => 25, 'icon' => '📞']);
    }
}
