# 🏥 مستشفى الشفاء الدولي

مشروع موقع مستشفى كامل مبني على **Laravel MVC** مع **Blade Templates** و **Tailwind CSS**.

---

## 🚀 التشغيل السريع

```bash
cd hospital-backend

# إعداد قاعدة البيانات
php artisan migrate --seed

# رابط التخزين
php artisan storage:link

# تشغيل الخادم
php artisan serve
# أو
php -S 127.0.0.1:8000 -t public
```

**الوصول:**
- الموقع الرئيسي: `http://127.0.0.1:8000/`
- لوحة التحكم: `http://127.0.0.1:8000/login`
- بيانات الدخول: `admin` / `admin123`

---

## 📁 هيكل المشروع

```
hospital-backend/
├── app/Http/Controllers/
│   ├── HomeController.php         ← الصفحة الرئيسية
│   ├── WebAuthController.php      ← تسجيل الدخول/الخروج
│   ├── Admin/
│   │   ├── DashboardController.php
│   │   ├── UserController.php
│   │   └── SettingsController.php
│   └── Api/                       ← API endpoints (اختياري)
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php      ← تخطيط الموقع العام
│   │   │   └── admin.blade.php    ← تخطيط لوحة التحكم
│   │   ├── components/home/       ← أقسام الصفحة الرئيسية (16)
│   │   ├── auth/login.blade.php
│   │   ├── admin/dashboard.blade.php
│   │   ├── admin/users/index.blade.php
│   │   ├── admin/settings/index.blade.php
│   │   └── home.blade.php
│   ├── css/app.css                ← Tailwind CSS
│   └── js/app.js                  ← Vanilla JS
│
├── routes/
│   ├── web.php                    ← مسارات الموقع
│   └── api.php                    ← مسارات API
│
└── database/
    ├── migrations/
    └── seeders/DatabaseSeeder.php
```

---

## 🛠️ التقنيات

| التقنية | الاستخدام |
|---------|-----------|
| Laravel 11 | MVC Framework |
| Blade Templates | محرك القوالب |
| Tailwind CSS 4 | التصميم |
| MySQL | قاعدة البيانات |
| Vite | تجميع الأصول |
| Lucide Icons | الأيقونات |
| Google Fonts (Tajawal) | الخطوط |

---

## 📋 المسارات الرئيسية

| المسار | الوصف |
|--------|--------|
| `GET /` | الصفحة الرئيسية |
| `POST /appointment` | حجز موعد |
| `POST /message` | إرسال رسالة |
| `GET /login` | صفحة تسجيل الدخول |
| `POST /login` | معالجة تسجيل الدخول |
| `GET /admin` | لوحة التحكم |
| `GET /admin/users` | إدارة المستخدمين |
| `GET /admin/settings` | إعدادات الموقع |

---

## 🗄️ إعداد قاعدة البيانات

```sql
CREATE DATABASE hospital_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

ثم في ملف `.env`:
```
DB_DATABASE=hospital_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

---

## 🏗️ تجميع Assets

```bash
# تثبيت مكتبات Node
cd hospital-backend
npm install

# تطوير
npm run dev

# بناء للإنتاج
npm run build
```
