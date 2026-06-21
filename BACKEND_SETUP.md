# 📚 Backend Documentation - مستشفى الشفاء

## 🎯 نظرة عامة

هذا المشروع يحتوي على Frontend كامل (React + Vite + Tailwind) مع محاكاة Backend باستخدام localStorage.

للانتقال إلى Backend حقيقي، اتبع الخطوات التالية:

---

## 🚀 الانتقال إلى Backend حقيقي

### **الخطوة 1: اختيار Backend Framework**

#### **الخيار الموصى به: Laravel (PHP)**

**المميزات:**
- ✅ سهل التعلم
- ✅ مجتمع كبير
- ✅ جاهز للمستشفيات
- ✅ أمان عالي
- ✅ نظام مصادقة جاهز

**التثبيت:**
```bash
# تثبيت Laravel
composer create-project laravel/laravel hospital-backend

# الدخول للمجلد
cd hospital-backend

# تشغيل السيرفر
php artisan serve
```

---

### **الخطوة 2: إعداد قاعدة البيانات**

**إنشاء قاعدة البيانات:**
```bash
# إنشاء قاعدة بيانات MySQL
mysql -u root -p
CREATE DATABASE hospital_db;
CREATE USER 'hospital_user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON hospital_db.* TO 'hospital_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

**إعداد .env:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hospital_db
DB_USERNAME=hospital_user
DB_PASSWORD=password
```

---

### **الخطوة 3: إنشاء Models**

**User Model:**
```bash
php artisan make:model User -m
```

```php
// app/Models/User.php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
```

**Appointment Model:**
```bash
php artisan make:model Appointment -m
```

```php
// app/Models/Appointment.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_name',
        'phone',
        'department',
        'doctor',
        'date',
        'time',
        'status',
        'type',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

**Doctor Model:**
```bash
php artisan make:model Doctor -m
```

```php
// app/Models/Doctor.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'specialty',
        'department',
        'image',
        'rating',
        'experience',
        'patients',
        'gradient',
        'active',
    ];
}
```

---

### **الخطوة 4: تشغيل Migrations**

```bash
php artisan migrate
```

---

### **الخطوة 5: إنشاء Controllers**

**Auth Controller:**
```bash
php artisan make:controller AuthController
```

```php
// app/Http/Controllers/AuthController.php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'اسم المستخدم أو كلمة المرور غير صحيحة'
            ], 401);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'تم تسجيل الخروج بنجاح'
        ]);
    }
}
```

**Users Controller:**
```bash
php artisan make:controller UserController
```

```php
// app/Http/Controllers/UserController.php
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email' => $request->email,
            'phone' => $request->phone,
            'active' => $request->active ?? true,
        ]);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->all());

        return response()->json($user);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json(['message' => 'تم الحذف بنجاح']);
    }
}
```

---

### **الخطوة 6: إعداد Routes**

```php
// routes/api.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;

// Public routes
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    // Users
    Route::apiResource('users', UserController::class);
    
    // Appointments
    Route::apiResource('appointments', AppointmentController::class);
    
    // Doctors
    Route::apiResource('doctors', DoctorController::class);
});
```

---

### **الخطوة 7: إعداد CORS**

```php
// config/cors.php
<?php

return [
    'paths' => ['api/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:5173'], // Frontend URL
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
```

---

### **الخطوة 8: تحديث Frontend**

**تحديث src/services/api.ts:**

```typescript
const API_BASE_URL = 'http://localhost:8000/api';

async function apiRequest(endpoint: string, options: RequestInit = {}) {
  const token = localStorage.getItem('authToken');
  
  const headers = {
    'Content-Type': 'application/json',
    ...(token && { 'Authorization': `Bearer ${token}` }),
    ...options.headers,
  };

  const response = await fetch(`${API_BASE_URL}${endpoint}`, {
    ...options,
    headers,
  });

  if (!response.ok) {
    const error = await response.json();
    throw new Error(error.message || 'حدث خطأ في السيرفر');
  }

  return response.json();
}

// Auth API
export const AuthAPI = {
  login: async (username: string, password: string) => {
    const response = await apiRequest('/auth/login', {
      method: 'POST',
      body: JSON.stringify({ username, password }),
    });
    
    localStorage.setItem('authToken', response.token);
    localStorage.setItem('currentUser', JSON.stringify(response.user));
    
    return response;
  },

  logout: async () => {
    await apiRequest('/auth/logout', { method: 'POST' });
    localStorage.removeItem('authToken');
    localStorage.removeItem('currentUser');
  },

  getCurrentUser: () => {
    const user = localStorage.getItem('currentUser');
    return user ? JSON.parse(user) : null;
  },

  isAuthenticated: () => {
    return !!localStorage.getItem('authToken');
  },
};

// Users API
export const UsersAPI = {
  getAll: async () => {
    return apiRequest('/users');
  },

  create: async (userData: any) => {
    return apiRequest('/users', {
      method: 'POST',
      body: JSON.stringify(userData),
    });
  },

  update: async (id: string, userData: any) => {
    return apiRequest(`/users/${id}`, {
      method: 'PUT',
      body: JSON.stringify(userData),
    });
  },

  delete: async (id: string) => {
    return apiRequest(`/users/${id}`, { method: 'DELETE' });
  },
};
```

---

## 📋 Checklist للانتقال إلى Backend

### **Backend Setup:**
- [ ] تثبيت Laravel
- [ ] إعداد قاعدة البيانات
- [ ] إنشاء Models
- [ ] تشغيل Migrations
- [ ] إنشاء Controllers
- [ ] إعداد Routes
- [ ] إعداد CORS
- [ ] اختبار API

### **Authentication:**
- [ ] نظام تسجيل الدخول
- [ ] JWT Tokens
- [ ] حماية المسارات
- [ ] اختبار المصادقة

### **API Endpoints:**
- [ ] Users API
- [ ] Appointments API
- [ ] Doctors API
- [ ] Departments API
- [ ] Notifications API

### **Frontend Update:**
- [ ] تحديث api.ts
- [ ] اختبار الاتصال
- [ ] معالجة الأخطاء
- [ ] اختبار كامل

### **Deployment:**
- [ ] اختيار استضافة
- [ ] رفع Backend
- [ ] رفع Frontend
- [ ] إعداد DNS
- [ ] اختبار نهائي

---

## 🎯 الخطوات التالية

1. **تثبيت Laravel** (يوم 1)
2. **إعداد قاعدة البيانات** (يوم 1)
3. **إنشاء Models و Controllers** (يوم 2-3)
4. **اختبار API** (يوم 3-4)
5. **تحديث Frontend** (يوم 4-5)
6. **اختبار كامل** (يوم 5-6)
7. **النشر** (يوم 6-7)

---

## 💡 نصائح مهمة

### **الأمان:**
- ✅ استخدم HTTPS في الإنتاج
- ✅ تحقق من جميع المدخلات
- ✅ استخدم Prepared Statements
- ✅ لا تخزن كلمات المرور نصاً

### **الأداء:**
- ✅ استخدم Caching
- ✅ استخدم Indexes في قاعدة البيانات
- ✅ قلل من عدد الاستعلامات
- ✅ استخدم Pagination

### **الصيانة:**
- ✅ احتفظ بنسخ احتياطية
- ✅ راقب الأداء
- ✅ سجل الأخطاء
- ✅ تحديث دوري

---

## 📞 الدعم

إذا واجهت أي مشكلة:
1. راجع التوثيق الرسمي: https://laravel.com/docs
2. تحقق من الأخطاء في logs
3. اختبر API باستخدام Postman
4. تأكد من إعدادات CORS

---

**جاهز للبدء! 🚀✨**
