import { useState, useEffect } from "react";
import { UserCircle, Save, Camera, Shield, Bell, Lock } from "lucide-react";
import PageHeader from "../components/PageHeader";
import { useToast } from "../components/Toast";
import { useData } from "../../context/DataContext";
import { getRoleLabel } from "../../utils/roles";

export default function ProfilePage() {
  const { toast } = useToast();
  const { currentUser, users, setUsers } = useData();
  
  const [profile, setProfile] = useState({
    name: currentUser?.name || "",
    email: currentUser?.email || "",
    phone: currentUser?.phone || "",
    role: currentUser ? getRoleLabel(currentUser.role) : "",
    bio: "",
    avatar: "",
  });

  useEffect(() => {
    if (currentUser) {
      setProfile({
        name: currentUser.name,
        email: currentUser.email,
        phone: currentUser.phone,
        role: getRoleLabel(currentUser.role),
        bio: "",
        avatar: "",
      });
    }
  }, [currentUser]);

  const [notifications, setNotifications] = useState({
    email: true,
    sms: true,
    push: true,
    marketing: false,
  });

  const [password, setPassword] = useState({
    current: "",
    new: "",
    confirm: "",
  });

  const handleSave = (e: React.FormEvent) => {
    e.preventDefault();
    localStorage.setItem("adminProfile", JSON.stringify(profile));
    toast("success", "تم حفظ الملف الشخصي بنجاح");
  };

  const handlePasswordChange = (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!currentUser) {
      toast("error", "لم يتم العثور على المستخدم الحالي");
      return;
    }

    // التحقق من كلمة المرور الحالية
    if (currentUser.password !== password.current) {
      toast("error", "كلمة المرور الحالية غير صحيحة");
      return;
    }

    if (password.new !== password.confirm) {
      toast("error", "كلمة المرور الجديدة غير متطابقة");
      return;
    }

    if (password.new.length < 6) {
      toast("error", "كلمة المرور يجب أن تكون 6 أحرف على الأقل");
      return;
    }

    // تحديث كلمة المرور في DataContext
    const updatedUsers = users.map(u => 
      u.id === currentUser.id 
        ? { ...u, password: password.new }
        : u
    );
    setUsers(updatedUsers);
    
    toast("success", "تم تغيير كلمة المرور بنجاح");
    setPassword({ current: "", new: "", confirm: "" });
  };

  return (
    <div>
      <PageHeader
        title="الملف الشخصي"
        subtitle="إدارة معلومات حسابك الشخصي"
        icon={<UserCircle size={26} />}
      />

      <div className="grid lg:grid-cols-3 gap-6">
        {/* Profile Card */}
        <div className="lg:col-span-1">
          <div className="bg-white rounded-2xl border border-gray-100 p-6 text-center sticky top-24">
            <div className="relative inline-block">
              <img src={profile.avatar} alt={profile.name} className="w-32 h-32 rounded-full object-cover mx-auto border-4 border-primary-100 shadow-lg" />
              <button className="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-2 w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                <Camera size={16} />
              </button>
            </div>
            <h3 className="mt-4 text-xl font-bold text-gray-800">{profile.name}</h3>
            <p className="text-sm text-gray-500 mt-1">{profile.email}</p>
            <span className="inline-block mt-3 px-4 py-1 bg-primary-100 text-primary-700 rounded-full text-xs font-bold">
              {profile.role}
            </span>

            <div className="mt-6 pt-6 border-t border-gray-100">
              <h4 className="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                <Shield size={16} />
                <span>الصلاحيات</span>
              </h4>
              <div className="space-y-2 text-sm">
                <div className="flex items-center justify-between">
                  <span className="text-gray-600">لوحة التحكم</span>
                  <span className="text-green-600 text-xs font-bold">✅ كامل</span>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-gray-600">إدارة المحتوى</span>
                  <span className="text-green-600 text-xs font-bold">✅ كامل</span>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-gray-600">الإعدادات</span>
                  <span className="text-green-600 text-xs font-bold">✅ كامل</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Forms */}
        <div className="lg:col-span-2 space-y-6">
          {/* Personal Info */}
          <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div className="px-6 py-4 border-b border-gray-100 bg-gray-50">
              <h3 className="font-bold text-gray-800">المعلومات الشخصية</h3>
            </div>
            <form onSubmit={handleSave} className="p-6 space-y-4">
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-bold text-gray-700 mb-2">الاسم</label>
                  <input type="text" value={profile.name} onChange={(e) => setProfile({ ...profile, name: e.target.value })} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
                </div>
                <div>
                  <label className="block text-sm font-bold text-gray-700 mb-2">الدور</label>
                  <input type="text" value={profile.role} onChange={(e) => setProfile({ ...profile, role: e.target.value })} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
                </div>
              </div>
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني</label>
                <input type="email" value={profile.email} onChange={(e) => setProfile({ ...profile, email: e.target.value })} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
              </div>
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-2">رقم الجوال</label>
                <input type="tel" value={profile.phone} onChange={(e) => setProfile({ ...profile, phone: e.target.value })} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
              </div>
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-2">نبذة</label>
                <textarea value={profile.bio} onChange={(e) => setProfile({ ...profile, bio: e.target.value })} rows={3} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 resize-none" />
              </div>
              <button type="submit" className="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg transition-all flex items-center gap-2">
                <Save size={16} />
                <span>حفظ التغييرات</span>
              </button>
            </form>
          </div>

          {/* Password Change */}
          <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div className="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
              <Lock size={18} className="text-gray-600" />
              <h3 className="font-bold text-gray-800">تغيير كلمة المرور</h3>
            </div>
            <form onSubmit={handlePasswordChange} className="p-6 space-y-4">
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-2">كلمة المرور الحالية</label>
                <input type="password" value={password.current} onChange={(e) => setPassword({ ...password, current: e.target.value })} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
              </div>
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-bold text-gray-700 mb-2">كلمة المرور الجديدة</label>
                  <input type="password" value={password.new} onChange={(e) => setPassword({ ...password, new: e.target.value })} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
                </div>
                <div>
                  <label className="block text-sm font-bold text-gray-700 mb-2">تأكيد كلمة المرور</label>
                  <input type="password" value={password.confirm} onChange={(e) => setPassword({ ...password, confirm: e.target.value })} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
                </div>
              </div>
              <button type="submit" className="bg-gray-800 text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-900 transition-all">تغيير كلمة المرور</button>
            </form>
          </div>

          {/* Notifications */}
          <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            <div className="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
              <Bell size={18} className="text-gray-600" />
              <h3 className="font-bold text-gray-800">الإشعارات</h3>
            </div>
            <div className="p-6 space-y-4">
              {[
                { key: "email", label: "إشعارات البريد الإلكتروني", desc: "استقبال إشعارات الحجوزات والرسائل" },
                { key: "sms", label: "إشعارات الرسائل النصية", desc: "استقبال رسائل SMS للحالات الطارئة" },
                { key: "push", label: "إشعارات المتصفح", desc: "إشعارات فورية على سطح المكتب" },
                { key: "marketing", label: "النشرة التسويقية", desc: "أخبار وعروض المستشفى" },
              ].map((item) => (
                <div key={item.key} className="flex items-center justify-between p-3 hover:bg-gray-50 rounded-xl">
                  <div>
                    <p className="font-bold text-gray-800 text-sm">{item.label}</p>
                    <p className="text-xs text-gray-500 mt-0.5">{item.desc}</p>
                  </div>
                  <button
                    onClick={() => setNotifications({ ...notifications, [item.key]: !notifications[item.key as keyof typeof notifications] })}
                    className={`relative w-12 h-6 rounded-full transition-colors ${notifications[item.key as keyof typeof notifications] ? "bg-primary-500" : "bg-gray-300"}`}
                  >
                    <span className={`absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-all ${notifications[item.key as keyof typeof notifications] ? "right-0.5" : "right-6"}`}></span>
                  </button>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
