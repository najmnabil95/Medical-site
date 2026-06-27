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

        $admin = $this->firstOrCreateUser('admin', 'admin123', 'Super Admin', 'مدير النظام', 'admin@alshifa-hospital.com', '+966 50 123 4567');
        $admin->assignRole('Super Admin');

        $doc1 = $this->firstOrCreateUser('ahmed.rashed', 'doctor123', 'Doctor', 'د. أحمد الراشد', 'ahmed.rashed@alshifa-hospital.com', '+966 50 111 2222', ['أمراض القلب']);
        $doc1->assignRole('Doctor');

        $doc2 = $this->firstOrCreateUser('sara.mansour', 'doctor123', 'Doctor', 'د. سارة المنصور', 'sara.mansour@alshifa-hospital.com', '+966 50 222 3333', ['طب الأطفال']);
        $doc2->assignRole('Doctor');

        $doc3 = $this->firstOrCreateUser('khalid.omari', 'doctor123', 'Doctor', 'د. خالد العمري', 'khalid.omari@alshifa-hospital.com', '+966 50 333 4444', ['جراحة المخ والأعصاب']);
        $doc3->assignRole('Doctor');

        $nurse1 = $this->firstOrCreateUser('nurse.fatima', 'nurse123', 'Nurse', 'فاطمة الزهراء', 'fatima@alshifa-hospital.com', '+966 50 444 5555', ['أمراض القلب', 'طب الأطفال'], ['د. أحمد الراشد', 'د. سارة المنصور']);
        $nurse1->assignRole('Nurse');

        $nurse2 = $this->firstOrCreateUser('nurse.mohammed', 'nurse123', 'Nurse', 'محمد السعيد', 'mohammed@alshifa-hospital.com', '+966 50 555 6666', ['جراحة المخ والأعصاب'], ['د. خالد العمري']);
        $nurse2->assignRole('Nurse');

        $reception = $this->firstOrCreateUser('reception.noura', 'reception123', 'Reception', 'نورة القحطاني', 'noura@alshifa-hospital.com', '+966 50 666 7777');
        $reception->assignRole('Reception');

        $accountant = $this->firstOrCreateUser('accountant.fahad', 'accountant123', 'Accountant', 'فهد العتيبي', 'fahad@alshifa-hospital.com', '+966 50 777 8888');
        $accountant->assignRole('Accountant');

        $this->firstOrCreateDepartment('أمراض القلب', 'Heart', 'تشخيص وعلاج أمراض القلب والأوعية الدموية بأحدث التقنيات وقسطرة القلب', 'from-red-500 to-rose-600');
        $this->firstOrCreateDepartment('جراحة المخ والأعصاب', 'Brain', 'علاج أمراض الدماغ والجهاز العصبي المركزي والطرفي بدقة متناهية', 'from-purple-500 to-violet-600');
        $this->firstOrCreateDepartment('جراحة العظام', 'Bone', 'علاج الإصابات والكسور وتبديل المفاصل وجراحات العمود الفقري', 'from-amber-500 to-orange-600');
        $this->firstOrCreateDepartment('طب الأطفال', 'Baby', 'رعاية صحية متكاملة للأطفال وحديثي الولادة والخدج بأحدث الحضانات', 'from-pink-500 to-rose-600');
        $this->firstOrCreateDepartment('طب العيون', 'Eye', 'تصحيح النظر بالليزك وعلاج أمراض العيون وزراعة القرنية', 'from-cyan-500 to-teal-600');
        $this->firstOrCreateDepartment('الطب الباطني', 'Stethoscope', 'تشخيص وعلاج أمراض الجهاز الهضمي والكبد والغدد الصماء', 'from-blue-500 to-indigo-600');

        $this->firstOrCreateDoctor('د. أحمد الراشد', 'استشاري جراحة القلب والأوعية الدموية', 'أمراض القلب', 'https://images.pexels.com/photos/5452224/pexels-photo-5452224.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400', 4.9, '20 سنة', '+5000', 'from-red-500 to-rose-600');
        $this->firstOrCreateDoctor('د. سارة المنصور', 'استشارية طب الأطفال وحديثي الولادة', 'طب الأطفال', 'https://images.pexels.com/photos/33032998/pexels-photo-33032998.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400', 4.8, '15 سنة', '+3500', 'from-pink-500 to-rose-600');
        $this->firstOrCreateDoctor('د. خالد العمري', 'استشاري جراحة المخ والأعصاب', 'جراحة المخ والأعصاب', 'https://images.pexels.com/photos/14438786/pexels-photo-14438786.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400', 4.9, '18 سنة', '+4200', 'from-purple-500 to-violet-600');
        $this->firstOrCreateDoctor('د. نورة الحربي', 'استشارية طب العيون وجراحة الليزر', 'طب العيون', 'https://images.pexels.com/photos/19260195/pexels-photo-19260195.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400', 4.7, '12 سنة', '+2800', 'from-cyan-500 to-teal-600');

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

        Setting::firstOrCreate(
            ['site_name' => 'مستشفى الشفاء'],
            [
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
            ]
        );

        $screenDefinitions = [
            ['name' => 'الرئيسية', 'component' => 'Hero', 'order' => 1, 'icon' => '🏠'],
            ['name' => 'من نحن', 'component' => 'About', 'order' => 2, 'icon' => '📖'],
            ['name' => 'لماذا تختارنا', 'component' => 'WhyChooseUs', 'order' => 3, 'icon' => '⭐'],
            ['name' => 'الإحصائيات', 'component' => 'Stats', 'order' => 4, 'icon' => '📊'],
            ['name' => 'الأقسام الطبية', 'component' => 'Departments', 'order' => 5, 'icon' => '🏥'],
            ['name' => 'الأطباء', 'component' => 'Doctors', 'order' => 6, 'icon' => '👨‍⚕️'],
            ['name' => 'الخدمات', 'component' => 'Services', 'order' => 7, 'icon' => '💼'],
            ['name' => 'حجز موعد', 'component' => 'Appointment', 'order' => 8, 'icon' => '📅'],
            ['name' => 'حاسبة التكلفة', 'component' => 'CostCalculator', 'order' => 9, 'icon' => '🧮'],
            ['name' => 'الأخبار', 'component' => 'NewsTicker', 'order' => 10, 'icon' => '📰'],
            ['name' => 'الأسئلة الشائعة', 'component' => 'FAQ', 'order' => 11, 'icon' => '❓'],
            ['name' => 'تواصل معنا', 'component' => 'Contact', 'order' => 12, 'icon' => '📞'],
        ];

        Screen::query()->whereNotIn('name', array_column($screenDefinitions, 'name'))->update(['enabled' => false]);

        foreach ($screenDefinitions as $screenData) {
            $this->firstOrCreateScreen($screenData['name'], $screenData['component'], $screenData['order'], $screenData['icon']);
        }
    }

    private function firstOrCreateUser(string $username, string $password, string $role, string $name, string $email, string $phone, array $departments = [], array $doctors = []): User
    {
        return User::updateOrCreate(
            ['username' => $username],
            [
                'password' => Hash::make($password),
                'role' => $role,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'active' => true,
                'assigned_departments' => $departments,
                'assigned_doctors' => $doctors,
            ]
        );
    }

    private function firstOrCreateDepartment(string $name, string $icon, string $description, string $color): Department
    {
        return Department::updateOrCreate(
            ['name' => $name],
            [
                'icon' => $icon,
                'desc' => $description,
                'color' => $color,
                'active' => true,
            ]
        );
    }

    private function firstOrCreateDoctor(string $name, string $specialty, string $department, string $image, float $rating, string $experience, string $patients, string $gradient): Doctor
    {
        return Doctor::updateOrCreate(
            ['name' => $name],
            [
                'specialty' => $specialty,
                'department' => $department,
                'image' => $image,
                'rating' => $rating,
                'experience' => $experience,
                'patients' => $patients,
                'gradient' => $gradient,
                'active' => true,
            ]
        );
    }

    private function firstOrCreateScreen(string $name, string $component, int $order, string $icon): Screen
    {
        return Screen::updateOrCreate(
            ['name' => $name],
            [
                'component' => $component,
                'enabled' => true,
                'order' => $order,
                'icon' => $icon,
            ]
        );
    }
}
