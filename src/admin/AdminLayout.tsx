import { Link, useLocation, useNavigate, Outlet } from "react-router-dom";
import {
  LayoutDashboard,
  Building2,
  Users,
  Briefcase,
  Package,
  MessageSquare,
  Newspaper,
  HelpCircle,
  Shield,
  Handshake,
  Award,
  Settings,
  LogOut,
  Menu,
  X,
  Bell,
  Search,
  ChevronDown,
  ExternalLink,
  CalendarCheck,
  Mail,
  TrendingUp,
  Activity,
  Tag,
  Image as ImageIcon,
  UserCircle,
  FileText,
  Video,
  Monitor,
  DollarSign,
} from "lucide-react";
import { useState } from "react";
import DarkModeToggle from "./components/DarkModeToggle";
import { useData } from "../context/DataContext";
import { useApp } from "../context/AppContext";
import { hasPermission, Permission } from "../utils/permissions";

interface MenuItem {
  name: string;
  icon: React.ComponentType<{ size?: number }>;
  path: string;
  permission: Permission;
  isDivider?: boolean;
}

const menuItems: MenuItem[] = [
  { name: "لوحة التحكم", icon: LayoutDashboard, path: "/admin", permission: "view_dashboard" },
  { name: "الحجوزات", icon: CalendarCheck, path: "/admin/reservations", permission: "view_reservations" },
  { name: "الاستشارات عن بُعد", icon: Video, path: "/admin/telemedicine", permission: "view_telemedicine" },
  { name: "الرسائل", icon: Mail, path: "/admin/messages", permission: "view_messages" },
  { name: "التحليلات", icon: TrendingUp, path: "/admin/analytics", permission: "view_analytics" },
  { name: "سجل النشاطات", icon: Activity, path: "/admin/activity", permission: "view_activity_log" },
  { name: "المستخدمون", icon: Users, path: "/admin/users", permission: "view_users" },
  { name: "الوصفات الطبية", icon: FileText, path: "/admin/prescriptions", permission: "view_prescriptions" },
  { name: "الأسعار والتكلفة", icon: DollarSign, path: "/admin/prices", permission: "view_dashboard" },
  { name: "التحكم في الشاشات", icon: Monitor, path: "/admin/screens", permission: "view_screens" },
  { name: "إدارة المحتوى", icon: FileText, path: "/admin/content", permission: "view_dashboard" },
  { name: "إعدادات الموقع", icon: Settings, path: "/admin/general-settings", permission: "view_dashboard" },
  { name: "جدول الصلاحيات", icon: Shield, path: "/admin/permissions", permission: "view_dashboard" },
  { name: "───────", icon: LayoutDashboard, path: "", permission: "view_dashboard", isDivider: true },
  { name: "العروض والخصومات", icon: Tag, path: "/admin/offers", permission: "view_offers" },
  { name: "معرض الصور", icon: ImageIcon, path: "/admin/media", permission: "view_media" },
  { name: "الأقسام الطبية", icon: Building2, path: "/admin/departments", permission: "view_departments" },
  { name: "الأطباء", icon: Users, path: "/admin/doctors", permission: "view_doctors" },
  { name: "الخدمات", icon: Briefcase, path: "/admin/services", permission: "view_services" },
  { name: "الباقات المميزة", icon: Package, path: "/admin/packages", permission: "view_packages" },
  { name: "آراء المرضى", icon: MessageSquare, path: "/admin/testimonials", permission: "view_testimonials" },
  { name: "الأخبار", icon: Newspaper, path: "/admin/news", permission: "view_news" },
  { name: "الأسئلة الشائعة", icon: HelpCircle, path: "/admin/faqs", permission: "view_faqs" },
  { name: "التأمين الطبي", icon: Shield, path: "/admin/insurance", permission: "view_insurance" },
  { name: "الشركاء", icon: Handshake, path: "/admin/partners", permission: "view_partners" },
  { name: "الشهادات", icon: Award, path: "/admin/certifications", permission: "view_certifications" },
  { name: "الإعدادات", icon: Settings, path: "/admin/settings", permission: "view_settings" },
  { name: "إعدادات الإشعارات", icon: Bell, path: "/admin/notification-settings", permission: "view_settings" },
  { name: "الملف الشخصي", icon: UserCircle, path: "/admin/profile", permission: "view_dashboard" },
];

export default function AdminLayout() {
  const location = useLocation();
  const navigate = useNavigate();
  const { logout, settings, currentUser } = useData();
  const { reservations, messages } = useApp();
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [userMenuOpen, setUserMenuOpen] = useState(false);

  // تحديد الدور
  const isDoctor = currentUser?.role === "doctor";
  const doctorName = currentUser?.name || "";

  // فلترة الحجوزات حسب الدور
  const doctorReservations = isDoctor
    ? reservations.filter(r => r.doctor === doctorName)
    : reservations;

  // حساب العدادات (قيد الانتظار فقط = pending)
  const pendingReservations = doctorReservations.filter(r => 
    r.status === "pending"
  ).length;
  const telemedicineReservations = doctorReservations.filter(r => 
    r.department?.includes("استشارة") && r.status === "pending"
  ).length;
  const newMessages = (isDoctor) ? 0 : messages.filter(m => m.status === "new").length;

  // دالة للحصول على العدد لكل قائمة (تُخفي الـ badge إذا كان العدد 0)
  const getBadgeCount = (path: string): number => {
    if (path === "/admin/reservations") return pendingReservations;
    if (path === "/admin/telemedicine") return telemedicineReservations;
    if (path === "/admin/messages") return newMessages;
    return 0;
  };

  const handleLogout = () => {
    logout();
    navigate("/admin/login");
  };

  return (
    <div className="min-h-screen bg-gray-50 font-tajawal" dir="rtl">
      {/* Sidebar */}
      <aside
        className={`fixed top-0 right-0 h-screen w-72 bg-white border-l border-gray-200 shadow-xl z-40 transition-transform duration-300 lg:translate-x-0 ${
          sidebarOpen ? "translate-x-0" : "translate-x-full lg:translate-x-0"
        }`}
      >
        {/* Logo */}
        <div className="h-16 px-6 flex items-center justify-between border-b border-gray-100">
          <Link to="/admin" className="flex items-center gap-3">
            <div className="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/20 overflow-hidden">
              {settings.logo && settings.logo.startsWith("data:") ? (
                <img src={settings.logo} alt="Logo" className="w-full h-full object-cover" />
              ) : (
                <span className="text-white text-base">{settings.logo || "🏥"}</span>
              )}
            </div>
            <div>
              <h1 className="text-base font-bold text-primary-700 leading-tight">{settings.siteName}</h1>
              <p className="text-[9px] text-gray-400 tracking-wider">لوحة التحكم</p>
            </div>
          </Link>
          <button onClick={() => setSidebarOpen(false)} className="lg:hidden text-gray-500 hover:text-gray-700">
            <X size={20} />
          </button>
        </div>

          {/* Menu */}
          <nav className="p-4 overflow-y-auto h-[calc(100vh-8rem)]">
            <p className="text-xs font-bold text-gray-400 mb-3 px-3 tracking-wider">القائمة الرئيسية</p>
            <div className="space-y-1">
              {menuItems
                .filter(item => {
                  // إخفاء الفواصل
                  if (item.isDivider) return true;
                  
                  const role = currentUser?.role || 'admin';
                  
                  // إخفاء جدول الصلاحيات لغير المدير
                  if (item.path === "/admin/permissions") {
                    return role === "admin";
                  }
                  
                  // إخفاء الأسعار والتكلفة عن الطبيب والممرض
                  if (item.path === "/admin/prices") {
                    return role === "admin" || role === "reception" || role === "accountant";
                  }
                  
                  // إخفاء الحجوزات عن المحاسب
                  if (item.path === "/admin/reservations") {
                    return role !== "accountant";
                  }
                  
                  // إخفاء الاستشارات عن بُعد عن المحاسب
                  if (item.path === "/admin/telemedicine") {
                    return role !== "accountant";
                  }
                  
                  // تطبيق الصلاحيات العادية
                  return hasPermission(role, item.permission);
                })
                .map((item, idx) => {
                if (item.isDivider || !item.path) {
                  return <div key={idx} className="h-px bg-gray-100 my-3 mx-3"></div>;
                }
                const isActive = location.pathname === item.path;
                return (
                  <Link
                    key={item.path}
                    to={item.path}
                    onClick={() => setSidebarOpen(false)}
                    className={`flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 ${
                      isActive
                        ? "bg-gradient-to-l from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/20"
                        : "text-gray-600 hover:bg-gray-100 hover:text-primary-600"
                    }`}
                  >
                    <item.icon size={18} />
                    <span className="flex-1">{item.name}</span>
                    {getBadgeCount(item.path) > 0 && (
                      <span className={`px-2 py-0.5 rounded-full text-xs font-bold ${
                        isActive ? "bg-white/20 text-white" : "bg-red-500 text-white animate-pulse"
                      }`}>
                        {getBadgeCount(item.path)}
                      </span>
                    )}
                    {isActive && <span className="w-1.5 h-1.5 bg-white rounded-full"></span>}
                  </Link>
                );
              })}
          </div>

          {/* Website Link */}
          <div className="mt-4 px-3 space-y-2">
            <div className="h-px bg-gray-100 mb-4"></div>
            <a
              href="#/"
              onClick={(e) => { e.preventDefault(); window.location.hash = '#/'; window.location.reload(); }}
              className="flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-l from-accent-500 to-accent-600 text-white rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-accent-500/20 transition-all hover:-translate-y-0.5"
            >
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
              </svg>
              <span>الصفحة الرئيسية</span>
            </a>
            <a
              href="#/"
              onClick={(e) => { e.preventDefault(); window.open(window.location.origin + window.location.pathname + '#/', '_blank'); }}
              className="flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all"
            >
              <ExternalLink size={16} />
              <span>زيارة الموقع (نافذة جديدة)</span>
            </a>
          </div>
        </nav>

        {/* Footer */}
        <div className="absolute bottom-0 right-0 left-0 p-4 border-t border-gray-100 bg-white">
          <button
            onClick={handleLogout}
            className="flex items-center gap-3 w-full px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-xl transition-all"
          >
            <LogOut size={18} />
            <span>تسجيل الخروج</span>
          </button>
        </div>
      </aside>

      {/* Overlay */}
      {sidebarOpen && (
        <div
          onClick={() => setSidebarOpen(false)}
          className="fixed inset-0 bg-black/50 z-30 lg:hidden"
        />
      )}

      {/* Main Content */}
      <div className="lg:mr-72">
        {/* Header */}
        <header className="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30 shadow-sm">
          <div className="flex items-center gap-4">
            <button
              onClick={() => setSidebarOpen(true)}
              className="lg:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-xl"
            >
              <Menu size={20} />
            </button>
            <div className="hidden md:flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-xl w-80 border border-gray-100">
              <Search size={16} className="text-gray-400" />
              <input
                type="text"
                placeholder="بحث..."
                className="bg-transparent outline-none flex-1 text-sm"
              />
            </div>
          </div>

          <div className="flex items-center gap-3">
            <DarkModeToggle />

            {/* Notifications */}
            <button className="relative p-2 text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
              <Bell size={20} />
              <span className="absolute top-1 left-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            {/* User Menu */}
            <div className="relative">
              <button
                onClick={() => setUserMenuOpen(!userMenuOpen)}
                className="flex items-center gap-3 p-1.5 pr-4 hover:bg-gray-50 rounded-xl transition-colors"
              >
                <div className="w-9 h-9 bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                  {currentUser ? currentUser.name.charAt(0) : "م"}
                </div>
                <div className="hidden md:block text-right">
                  <p className="text-sm font-bold text-gray-800">{currentUser ? currentUser.name : "المدير"}</p>
                  <p className="text-xs text-gray-500">{currentUser ? currentUser.email : "admin@alshifa.com"}</p>
                </div>
                <ChevronDown size={16} className="text-gray-400" />
              </button>

              {userMenuOpen && (
                <>
                  <div className="fixed inset-0 z-10" onClick={() => setUserMenuOpen(false)}></div>
                  <div className="absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-20">
                    <button
                      onClick={handleLogout}
                      className="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                    >
                      <LogOut size={16} />
                      <span>تسجيل الخروج</span>
                    </button>
                  </div>
                </>
              )}
            </div>
          </div>
        </header>

        {/* Page Content */}
        <main className="p-4 lg:p-8">
          {/* Breadcrumb */}
          <div className="mb-6 flex items-center gap-2 text-sm text-gray-500">
            <Link to="/admin" className="hover:text-primary-600 transition-colors">الرئيسية</Link>
            {location.pathname !== "/admin" && (
              <>
                <span className="text-gray-300">/</span>
                <span className="text-primary-600 font-medium">
                  {menuItems.find(item => item.path === location.pathname)?.name || "صفحة"}
                </span>
              </>
            )}
          </div>
          <Outlet />
        </main>
      </div>
    </div>
  );
}
