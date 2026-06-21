import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { Eye, EyeOff, LogIn, Home } from "lucide-react";
import { useData } from "../../context/DataContext";
import { useToast } from "../components/Toast";

export default function Login() {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  const [showPassword, setShowPassword] = useState(false);
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();
  const { login } = useData();
  const { toast } = useToast();

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);

    setTimeout(() => {
      const success = login(username, password);
      if (success) {
        toast("success", `مرحباً ${username}! تم تسجيل الدخول بنجاح`);
        navigate("/admin");
      } else {
        toast("error", "فشل تسجيل الدخول. تأكد من اسم المستخدم وكلمة المرور، وأن الحساب نشط");
      }
      setLoading(false);
    }, 500);
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-900 via-primary-800 to-gray-900 p-4 relative overflow-hidden">
      {/* Decorative */}
      <div className="absolute top-20 left-20 w-64 h-64 bg-accent-500/10 rounded-full blur-3xl"></div>
      <div className="absolute bottom-20 right-20 w-80 h-80 bg-primary-500/10 rounded-full blur-3xl"></div>

      <div className="w-full max-w-md relative">
        {/* Logo */}
        <div className="text-center mb-8">
          <div className="inline-flex items-center gap-3 mb-6">
            <div className="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center shadow-2xl shadow-primary-500/30">
              <span className="text-white text-xl">🏥</span>
            </div>
            <div className="text-right">
              <h1 className="text-2xl font-bold text-white">مستشفى الشفاء</h1>
              <p className="text-xs text-white/40 tracking-wider">لوحة التحكم</p>
            </div>
          </div>
        </div>

        {/* Form */}
        <div className="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl p-8">
          <h2 className="text-xl font-bold text-gray-800 mb-2">مرحباً بعودتك 👋</h2>
          <p className="text-sm text-gray-500 mb-6">سجل دخولك للوصول إلى لوحة التحكم</p>

          <form onSubmit={handleSubmit} className="space-y-5">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">اسم المستخدم</label>
              <input
                type="text"
                value={username}
                onChange={(e) => setUsername(e.target.value)}
                required
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all text-sm"
                placeholder="admin"
              />
            </div>

            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">كلمة المرور</label>
              <div className="relative">
                <input
                  type={showPassword ? "text" : "password"}
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  required
                  className="w-full px-4 py-3 pr-4 pl-12 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all text-sm"
                  placeholder="••••••••"
                />
                <button
                  type="button"
                  onClick={() => setShowPassword(!showPassword)}
                  className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600"
                >
                  {showPassword ? <EyeOff size={18} /> : <Eye size={18} />}
                </button>
              </div>
            </div>

            <button
              type="submit"
              disabled={loading}
              className="w-full bg-gradient-to-l from-primary-500 to-primary-700 text-white py-3.5 rounded-xl font-bold hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed flex items-center justify-center gap-2"
            >
              {loading ? (
                <span className="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
              ) : (
                <>
                  <LogIn size={18} />
                  <span>تسجيل الدخول</span>
                </>
              )}
            </button>
          </form>

          <button
            onClick={() => navigate("/")}
            className="w-full mt-4 bg-gray-100 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-200 transition-all flex items-center justify-center gap-2"
          >
            <Home size={18} />
            <span>العودة إلى الموقع الرئيسي</span>
          </button>

          <div className="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
            <p className="text-xs text-blue-600 font-bold mb-1">💡 بيانات الدخول الافتراضية:</p>
            <p className="text-xs text-blue-500">اسم المستخدم: <span className="font-bold">admin</span></p>
            <p className="text-xs text-blue-500">كلمة المرور: <span className="font-bold">admin123</span></p>
            <p className="text-xs text-blue-400 mt-2">يمكنك إضافة مستخدمين جدد من صفحة "المستخدمون" في لوحة التحكم</p>
          </div>
        </div>

        <p className="text-center text-white/30 text-xs mt-6">© 2024 مستشفى الشفاء الدولي</p>
      </div>
    </div>
  );
}
