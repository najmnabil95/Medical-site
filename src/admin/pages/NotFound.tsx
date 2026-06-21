import { Link } from "react-router-dom";
import { Home, AlertCircle, ArrowRight } from "lucide-react";

export default function NotFound() {
  return (
    <div className="min-h-screen bg-gradient-to-br from-primary-900 via-primary-800 to-gray-900 flex items-center justify-center p-4">
      <div className="max-w-md text-center">
        <div className="inline-flex items-center justify-center w-24 h-24 bg-white/10 backdrop-blur-sm rounded-full mb-6 animate-pulse-soft">
          <AlertCircle className="text-accent-400" size={48} />
        </div>
        <h1 className="text-8xl font-black text-white mb-2">404</h1>
        <h2 className="text-2xl font-bold text-white mb-4">الصفحة غير موجودة</h2>
        <p className="text-white/60 mb-8">
          عذراً، لم نتمكن من العثور على الصفحة التي تبحث عنها. ربما تم نقلها أو حذفها.
        </p>
        <div className="flex flex-col sm:flex-row gap-3 justify-center">
          <Link
            to="/"
            className="inline-flex items-center justify-center gap-2 bg-white text-primary-700 px-8 py-3.5 rounded-2xl font-bold hover:shadow-xl transition-all hover:-translate-y-1"
          >
            <Home size={18} />
            <span>الصفحة الرئيسية</span>
          </Link>
          <Link
            to="/admin/login"
            className="inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm text-white px-8 py-3.5 rounded-2xl font-bold hover:bg-white/20 transition-all border border-white/20"
          >
            <span>لوحة التحكم</span>
            <ArrowRight size={18} />
          </Link>
        </div>
      </div>
    </div>
  );
}
