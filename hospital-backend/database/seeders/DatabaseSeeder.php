<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        DB::table('users')->insert([
            ['username' => 'admin', 'password' => Hash::make('admin123'), 'role' => 'admin', 'name' => 'مدير النظام', 'email' => 'admin@alshifa-hospital.com', 'phone' => '+966 50 123 4567', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['username' => 'ahmed.rashed', 'password' => Hash::make('doctor123'), 'role' => 'doctor', 'name' => 'د. أحمد الراشد', 'email' => 'ahmed.rashed@alshifa-hospital.com', 'phone' => '+966 50 111 2222', 'active' => true, 'assigned_departments' => '["أمراض القلب"]', 'created_at' => now(), 'updated_at' => now()],
            ['username' => 'sara.mansour', 'password' => Hash::make('doctor123'), 'role' => 'doctor', 'name' => 'د. سارة المنصور', 'email' => 'sara.mansour@alshifa-hospital.com', 'phone' => '+966 50 222 3333', 'active' => true, 'assigned_departments' => '["طب الأطفال"]', 'created_at' => now(), 'updated_at' => now()],
            ['username' => 'khalid.omari', 'password' => Hash::make('doctor123'), 'role' => 'doctor', 'name' => 'د. خالد العمري', 'email' => 'khalid.omari@alshifa-hospital.com', 'phone' => '+966 50 333 4444', 'active' => true, 'assigned_departments' => '["جراحة المخ والأعصاب"]', 'created_at' => now(), 'updated_at' => now()],
            ['username' => 'nurse.fatima', 'password' => Hash::make('nurse123'), 'role' => 'nurse', 'name' => 'فاطمة الزهراء', 'email' => 'fatima@alshifa-hospital.com', 'phone' => '+966 50 444 5555', 'active' => true, 'assigned_departments' => '["أمراض القلب","طب الأطفال"]', 'assigned_doctors' => '["د. أحمد الراشد","د. سارة المنصور"]', 'created_at' => now(), 'updated_at' => now()],
            ['username' => 'nurse.mohammed', 'password' => Hash::make('nurse123'), 'role' => 'nurse', 'name' => 'محمد السعيد', 'email' => 'mohammed@alshifa-hospital.com', 'phone' => '+966 50 555 6666', 'active' => true, 'assigned_departments' => '["جراحة المخ والأعصاب"]', 'assigned_doctors' => '["د. خالد العمري"]', 'created_at' => now(), 'updated_at' => now()],
            ['username' => 'reception.noura', 'password' => Hash::make('reception123'), 'role' => 'reception', 'name' => 'نورة القحطاني', 'email' => 'noura@alshifa-hospital.com', 'phone' => '+966 50 666 7777', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['username' => 'accountant.fahad', 'password' => Hash::make('accountant123'), 'role' => 'accountant', 'name' => 'فهد العتيبي', 'email' => 'fahad@alshifa-hospital.com', 'phone' => '+966 50 777 8888', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Departments
        DB::table('departments')->insert([
            ['icon' => 'Heart', 'name' => 'أمراض القلب', 'desc' => 'تشخيص وعلاج أمراض القلب والأوعية الدموية بأحدث التقنيات وقسطرة القلب', 'color' => 'from-red-500 to-rose-600', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'Brain', 'name' => 'جراحة المخ والأعصاب', 'desc' => 'علاج أمراض الدماغ والجهاز العصبي المركزي والطرفي بدقة متناهية', 'color' => 'from-purple-500 to-violet-600', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'Bone', 'name' => 'جراحة العظام', 'desc' => 'علاج الإصابات والكسور وتبديل المفاصل وجراحات العمود الفقري', 'color' => 'from-amber-500 to-orange-600', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'Baby', 'name' => 'طب الأطفال', 'desc' => 'رعاية صحية متكاملة للأطفال وحديثي الولادة والخدج بأحدث الحضانات', 'color' => 'from-pink-500 to-rose-600', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'Eye', 'name' => 'طب العيون', 'desc' => 'تصحيح النظر بالليزك وعلاج أمراض العيون وزراعة القرنية', 'color' => 'from-cyan-500 to-teal-600', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'Stethoscope', 'name' => 'الطب الباطني', 'desc' => 'تشخيص وعلاج أمراض الجهاز الهضمي والكبد والغدد الصماء', 'color' => 'from-blue-500 to-indigo-600', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Doctors
        DB::table('doctors')->insert([
            ['name' => 'د. أحمد الراشد', 'specialty' => 'استشاري جراحة القلب والأوعية الدموية', 'department' => 'أمراض القلب', 'image' => 'https://images.pexels.com/photos/5452224/pexels-photo-5452224.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400', 'rating' => 4.9, 'experience' => '20 سنة', 'patients' => '+5000', 'gradient' => 'from-red-500 to-rose-600', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'د. سارة المنصور', 'specialty' => 'استشارية طب الأطفال وحديثي الولادة', 'department' => 'طب الأطفال', 'image' => 'https://images.pexels.com/photos/33032998/pexels-photo-33032998.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400', 'rating' => 4.8, 'experience' => '15 سنة', 'patients' => '+3500', 'gradient' => 'from-pink-500 to-rose-600', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'د. خالد العمري', 'specialty' => 'استشاري جراحة المخ والأعصاب', 'department' => 'جراحة المخ والأعصاب', 'image' => 'https://images.pexels.com/photos/14438786/pexels-photo-14438786.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400', 'rating' => 4.9, 'experience' => '18 سنة', 'patients' => '+4200', 'gradient' => 'from-purple-500 to-violet-600', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'د. نورة الحربي', 'specialty' => 'استشارية طب العيون وجراحة الليزر', 'department' => 'طب العيون', 'image' => 'https://images.pexels.com/photos/19260195/pexels-photo-19260195.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400', 'rating' => 4.7, 'experience' => '12 سنة', 'patients' => '+2800', 'gradient' => 'from-cyan-500 to-teal-600', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Services
        DB::table('services')->insert([
            ['icon' => 'Ambulance', 'title' => 'خدمة الإسعاف', 'desc' => 'سيارات إسعاف مجهزة بأحدث المعدات الطبية للنقل الآمن والسريع', 'color' => 'from-red-500 to-rose-600', 'number' => '01', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'Clock', 'title' => 'طوارئ 24/7', 'desc' => 'قسم طوارئ يعمل على مدار الساعة بفريق طبي متخصص ومؤهل', 'color' => 'from-orange-500 to-amber-600', 'number' => '02', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'FlaskConical', 'title' => 'مختبرات متقدمة', 'desc' => 'تحاليل طبية شاملة بأحدث الأجهزة ونتائج دقيقة وسريعة', 'color' => 'from-blue-500 to-indigo-600', 'number' => '03', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['icon' => 'Scan', 'title' => 'الأشعة والتصوير', 'desc' => 'أجهزة تصوير متطورة تشمل الرنين المغناطيسي والأشعة المقطعية', 'color' => 'from-purple-500 to-violet-600', 'number' => '04', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Packages
        DB::table('packages')->insert([
            ['name' => 'الباقة الأساسية', 'name_en' => 'Basic', 'price' => '500', 'period' => 'سنوياً', 'icon' => '🩺', 'popular' => false, 'gradient' => 'from-gray-600 to-gray-800', 'features' => '["كشف طبي شامل سنوي","تحاليل دم أساسية","أشعة صدر"]', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'الباقة الذهبية', 'name_en' => 'Gold', 'price' => '1,500', 'period' => 'سنوياً', 'icon' => '👑', 'popular' => true, 'gradient' => 'from-amber-500 to-yellow-600', 'features' => '["كشف طبي شامل مرتين سنوياً","تحاليل دم شاملة","خصم 25%"]', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'الباقة البلاتينية', 'name_en' => 'Platinum', 'price' => '3,000', 'period' => 'سنوياً', 'icon' => '💎', 'popular' => false, 'gradient' => 'from-violet-600 to-purple-800', 'features' => '["كشف طبي شامل 4 مرات","جميع التحاليل","خصم 40%"]', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Testimonials
        DB::table('testimonials')->insert([
            ['name' => 'محمد بن عبدالله', 'role' => 'مريض - جراحة القلب', 'text' => 'تجربة رائعة في مستشفى الشفاء. الفريق الطبي كان محترفاً للغاية.', 'rating' => 5, 'avatar' => 'م', 'color' => 'from-primary-500 to-primary-600', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'فاطمة الزهراء', 'role' => 'مريضة - طب العيون', 'text' => 'أجريت عملية تصحيح النظر بالليزر وكانت النتائج مذهلة.', 'rating' => 5, 'avatar' => 'ف', 'color' => 'from-accent-500 to-accent-600', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'عبدالرحمن السعيد', 'role' => 'مريض - جراحة العظام', 'text' => 'الفريق الطبي في مستشفى الشفاء أعاد لي الثقة وتعافيت بشكل كامل.', 'rating' => 5, 'avatar' => 'ع', 'color' => 'from-purple-500 to-violet-600', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // News
        DB::table('news')->insert([
            ['image' => 'https://images.pexels.com/photos/24193873/pexels-photo-24193873.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=350&w=550', 'category' => 'أخبار المستشفى', 'title' => 'مستشفى الشفاء يحصل على اعتماد JCI الدولي', 'excerpt' => 'حصل المستشفى على تجديد الاعتماد الدولي', 'content' => null, 'date' => '2024-01-15', 'author' => 'إدارة المستشفى', 'read_time' => '5 دقائق', 'category_color' => 'bg-primary-100 text-primary-700', 'featured' => true, 'created_at' => now(), 'updated_at' => now()],
            ['image' => 'https://images.pexels.com/photos/18112241/pexels-photo-18112241.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=350&w=550', 'category' => 'تقنية طبية', 'title' => 'إطلاق أحدث جهاز للتصوير بالرنين المغناطيسي', 'excerpt' => 'دشن المستشفى أحدث جهاز تصوير بالرنين', 'content' => null, 'date' => '2024-01-08', 'author' => 'القسم التقني', 'read_time' => '3 دقائق', 'category_color' => 'bg-purple-100 text-purple-700', 'featured' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // FAQs
        DB::table('faqs')->insert([
            ['question' => 'ما هي ساعات عمل المستشفى؟', 'answer' => 'يعمل المستشفى من السبت إلى الخميس من الساعة 8 صباحاً حتى 10 مساءً.', 'created_at' => now(), 'updated_at' => now()],
            ['question' => 'كيف يمكنني حجز موعد مع طبيب؟', 'answer' => 'يمكنك حجز موعد عبر النموذج الإلكتروني أو الاتصال بنا على الرقم 920012345.', 'created_at' => now(), 'updated_at' => now()],
            ['question' => 'هل يقبل المستشفى جميع شركات التأمين؟', 'answer' => 'نتعامل مع أكثر من 25 شركة تأمين طبي معتمدة.', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Insurances
        DB::table('insurances')->insert([
            ['name' => 'بوبا العربية', 'abbr' => 'BUPA', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'التعاونية', 'abbr' => 'TAWU', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ميدغلف', 'abbr' => 'MEDG', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'الراجحي تكافل', 'abbr' => 'RAJH', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Partners
        DB::table('partners')->insert([
            ['name' => 'JCI', 'sub' => 'الاعتماد الدولي', 'emoji' => '🏆', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'WHO', 'sub' => 'منظمة الصحة العالمية', 'emoji' => '🌍', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CBAHI', 'sub' => 'المجلس المركزي', 'emoji' => '🏛️', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Certifications
        DB::table('certifications')->insert([
            ['icon' => '🏆', 'name' => 'JCI', 'full_name' => 'الاعتماد الدولي', 'desc' => 'حاصلون على اعتماد الهيئة الدولية', 'year' => '2024', 'color' => 'from-amber-500 to-yellow-600', 'border' => 'border-amber-200', 'bg' => 'bg-amber-50', 'created_at' => now(), 'updated_at' => now()],
            ['icon' => '🌟', 'name' => 'CBAHI', 'full_name' => 'المجلس المركزي', 'desc' => 'اعتماد المجلس المركزي', 'year' => '2024', 'color' => 'from-blue-500 to-indigo-600', 'border' => 'border-blue-200', 'bg' => 'bg-blue-50', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Price Items
        DB::table('price_items')->insert([
            ['service' => 'استشارة عامة', 'category' => 'استشارة', 'price' => 100, 'currency' => 'ر.س', 'duration' => '30 دقيقة', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['service' => 'استشارة متخصصة', 'category' => 'استشارة', 'price' => 200, 'currency' => 'ر.س', 'duration' => '30 دقيقة', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['service' => 'استشارة استشاري', 'category' => 'استشارة', 'price' => 300, 'currency' => 'ر.س', 'duration' => '45 دقيقة', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['service' => 'فحص دم شامل', 'category' => 'تحليل', 'price' => 150, 'currency' => 'ر.س', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['service' => 'تحليل سكر تراكمي', 'category' => 'تحليل', 'price' => 80, 'currency' => 'ر.س', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['service' => 'أشعة سينية', 'category' => 'أشعة', 'price' => 120, 'currency' => 'ر.س', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['service' => 'أشعة مقطعية', 'category' => 'أشعة', 'price' => 800, 'currency' => 'ر.س', 'duration' => '20 دقيقة', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['service' => 'رنين مغناطيسي', 'category' => 'أشعة', 'price' => 1500, 'currency' => 'ر.س', 'duration' => '45 دقيقة', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['service' => 'عملية جراحية بسيطة', 'category' => 'جراحة', 'price' => 5000, 'currency' => 'ر.س', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['service' => 'عملية جراحية معقدة', 'category' => 'جراحة', 'price' => 15000, 'currency' => 'ر.س', 'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Settings
        DB::table('settings')->insert([
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
    }
}
