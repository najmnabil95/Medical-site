import { Link } from "react-router-dom";
import {
  Building2,
  Users,
  Briefcase,
  Package,
  MessageSquare,
  Newspaper,
  ArrowLeft,
  Activity,
  CalendarCheck,
  Mail,
  Tag,
  Image as ImageIcon,
  Clock,
  CheckCircle,
  XCircle,
} from "lucide-react";
import { useData } from "../../context/DataContext";
import { useApp } from "../../context/AppContext";
import PageHeader from "../components/PageHeader";
import StatsCard from "../components/StatsCard";

export default function Dashboard() {
  const { departments, doctors, services, packages, testimonials, news, certifications, faqs, insurances, partners, currentUser } = useData();
  const { reservations, messages } = useApp();

  const userRole = currentUser?.role || "admin";
  const isAdmin = userRole === "admin";
  const isDoctor = userRole === "doctor";

  // فلترة الحجوزات حسب الدور
  const filteredReservations = isDoctor
    ? reservations.filter(r => r.doctor === currentUser?.name)
    : reservations;

  const pendingRes = filteredReservations.filter(r => r.status === "pending").length;
  const newMessages = messages.filter(m => m.status === "new").length;

  // فلترة الإحصائيات حسب الدور
  const stats = isAdmin
    ? [
        { title: "الحجوزات", value: reservations.length, icon: <CalendarCheck size={22} />, color: "bg-gradient-to-br from-teal-500 to-cyan-600", trend: { value: `${reservations.filter(r => r.status === "pending").length} قيد الانتظار`, positive: true }, link: "/admin/reservations" },
        { title: "الرسائل", value: messages.length, icon: <Mail size={22} />, color: "bg-gradient-to-br from-indigo-500 to-blue-600", trend: { value: `${newMessages} جديدة`, positive: newMessages > 0 }, link: "/admin/messages" },
        { title: "الأقسام الطبية", value: departments.length, icon: <Building2 size={22} />, color: "bg-gradient-to-br from-blue-500 to-indigo-600", link: "/admin/departments" },
        { title: "الأطباء", value: doctors.length, icon: <Users size={22} />, color: "bg-gradient-to-br from-emerald-500 to-teal-600", link: "/admin/doctors" },
        { title: "الخدمات", value: services.length, icon: <Briefcase size={22} />, color: "bg-gradient-to-br from-purple-500 to-violet-600", link: "/admin/services" },
        { title: "الباقات", value: packages.length, icon: <Package size={22} />, color: "bg-gradient-to-br from-amber-500 to-orange-600", link: "/admin/packages" },
        { title: "آراء المرضى", value: testimonials.length, icon: <MessageSquare size={22} />, color: "bg-gradient-to-br from-pink-500 to-rose-600", link: "/admin/testimonials" },
        { title: "الأخبار", value: news.length, icon: <Newspaper size={22} />, color: "bg-gradient-to-br from-cyan-500 to-sky-600", link: "/admin/news" },
      ]
    : [
        { title: "حجوزاتي", value: filteredReservations.length, icon: <CalendarCheck size={22} />, color: "bg-gradient-to-br from-teal-500 to-cyan-600", trend: { value: `${pendingRes} قيد الانتظار`, positive: true }, link: "/admin/reservations" },
        { title: "الاستشارات", value: reservations.filter(r => r.department?.includes("استشارة")).length, icon: <Mail size={22} />, color: "bg-gradient-to-br from-indigo-500 to-blue-600", link: "/admin/telemedicine" },
      ];

  const recentReservations = filteredReservations.slice(0, 5);
  const recentMessages = messages.slice(0, 3);

  const statusConfig: Record<string, { label: string; color: string; icon: typeof CheckCircle }> = {
    pending: { label: "قيد الانتظار", color: "bg-yellow-100 text-yellow-700", icon: Clock },
    confirmed: { label: "مؤكد", color: "bg-green-100 text-green-700", icon: CheckCircle },
    completed: { label: "مكتمل", color: "bg-blue-100 text-blue-700", icon: CheckCircle },
    cancelled: { label: "ملغى", color: "bg-red-100 text-red-700", icon: XCircle },
  };

  return (
    <div>
      <PageHeader
        title="لوحة التحكم"
        subtitle={isAdmin
          ? "مرحباً بك في لوحة تحكم مستشفى الشفاء الدولي"
          : `مرحباً ${currentUser?.name} - ${currentUser?.role === "doctor" ? "طبيب" : currentUser?.role}`}
        icon={<Activity size={26} />}
        action={
          <div className="flex items-center gap-2">
            {pendingRes > 0 && (
              <Link to="/admin/reservations" className="flex items-center gap-2 bg-yellow-50 px-4 py-2 rounded-xl border border-yellow-200">
                <CalendarCheck size={16} className="text-yellow-600" />
                <span className="text-sm font-bold text-yellow-700">{pendingRes} حجز ينتظر التأكيد</span>
              </Link>
            )}
            {newMessages > 0 && isAdmin && (
              <Link to="/admin/messages" className="flex items-center gap-2 bg-blue-50 px-4 py-2 rounded-xl border border-blue-200">
                <Mail size={16} className="text-blue-600" />
                <span className="text-sm font-bold text-blue-700">{newMessages} رسالة جديدة</span>
              </Link>
            )}
          </div>
        }
      />

      {/* Stats Grid */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {stats.map((stat, index) => (
          <Link key={index} to={stat.link}>
            <StatsCard
              title={stat.title}
              value={stat.value}
              icon={stat.icon}
              color={stat.color}
              trend={stat.trend}
              onClick={() => {}}
            />
          </Link>
        ))}
      </div>

      <div className="grid lg:grid-cols-3 gap-6">
        {/* Recent Reservations */}
        <div className={`${isAdmin ? "lg:col-span-2" : "lg:col-span-3"} bg-white rounded-2xl p-6 border border-gray-100`}>
          <div className="flex items-center justify-between mb-6">
            <h3 className="text-lg font-bold text-gray-800 flex items-center gap-2">
              <CalendarCheck size={20} className="text-primary-600" />
              <span>{isAdmin ? "آخر الحجوزات" : "حجوزاتي"}</span>
            </h3>
            <Link to="/admin/reservations" className="text-sm text-primary-600 font-bold flex items-center gap-1 hover:gap-2 transition-all">
              عرض الكل
              <ArrowLeft size={14} />
            </Link>
          </div>

          {recentReservations.length > 0 ? (
            <div className="space-y-3">
              {recentReservations.map((res) => {
                const StatusIcon = statusConfig[res.status]?.icon || Clock;
                return (
                  <div key={res.id} className="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-xl transition-colors">
                    <div className="w-10 h-10 bg-primary-50 rounded-xl flex items-center justify-center shrink-0">
                      <CalendarCheck size={18} className="text-primary-600" />
                    </div>
                    <div className="flex-1 min-w-0">
                      <p className="text-sm font-bold text-gray-800 truncate">{res.patientName}</p>
                      <p className="text-xs text-gray-500">{res.department} {res.doctor ? `• ${res.doctor}` : ""}</p>
                    </div>
                    <div className="text-left shrink-0">
                      <p className="text-xs text-gray-500">{res.date}</p>
                      <span className={`inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold ${statusConfig[res.status]?.color || "bg-gray-100 text-gray-600"}`}>
                        <StatusIcon size={10} />
                        {statusConfig[res.status]?.label || res.status}
                      </span>
                    </div>
                  </div>
                );
              })}
            </div>
          ) : (
            <div className="py-8 text-center">
              <CalendarCheck size={40} className="text-gray-300 mx-auto mb-2" />
              <p className="text-gray-400 text-sm">لا توجد حجوزات حتى الآن</p>
              {isDoctor && <p className="text-gray-400 text-xs mt-1">ستظهر هنا الحجوزات الخاصة بك فقط</p>}
            </div>
          )}
        </div>

        {/* Right Sidebar - Admin Only */}
        {isAdmin && (
          <div className="space-y-6">
            {/* Recent Messages */}
            <div className="bg-white rounded-2xl p-6 border border-gray-100">
              <div className="flex items-center justify-between mb-4">
                <h3 className="text-base font-bold text-gray-800 flex items-center gap-2">
                  <Mail size={18} className="text-blue-600" />
                  <span>آخر الرسائل</span>
                </h3>
                <Link to="/admin/messages" className="text-xs text-primary-600 font-bold">عرض الكل</Link>
              </div>
              {recentMessages.length > 0 ? (
                <div className="space-y-3">
                  {recentMessages.map((msg) => (
                    <div key={msg.id} className="bg-gray-50 rounded-xl p-3 hover:bg-gray-100 transition-colors">
                      <div className="flex items-start justify-between gap-2 mb-1">
                        <p className="text-sm font-bold text-gray-800 truncate">{msg.name}</p>
                        <span className={`px-2 py-0.5 rounded-full text-[10px] font-bold whitespace-nowrap ${msg.status === "new" ? "bg-blue-100 text-blue-700" : msg.status === "read" ? "bg-gray-100 text-gray-700" : "bg-green-100 text-green-700"}`}>
                          {msg.status === "new" ? "جديد" : msg.status === "read" ? "مقروء" : "تم الرد"}
                        </span>
                      </div>
                      <p className="text-xs text-gray-500 truncate">{msg.subject}</p>
                    </div>
                  ))}
                </div>
              ) : (
                <p className="text-gray-400 text-sm text-center py-4">لا توجد رسائل</p>
              )}
            </div>

            {/* Quick Actions */}
            <div className="bg-white rounded-2xl p-6 border border-gray-100">
              <h3 className="text-base font-bold text-gray-800 mb-4">إجراءات سريعة</h3>
              <div className="space-y-2">
                {[
                  { label: "إضافة قسم", icon: Building2, color: "bg-blue-500", link: "/admin/departments" },
                  { label: "إضافة طبيب", icon: Users, color: "bg-emerald-500", link: "/admin/doctors" },
                  { label: "نشر خبر", icon: Newspaper, color: "bg-purple-500", link: "/admin/news" },
                  { label: "إضافة عرض", icon: Tag, color: "bg-amber-500", link: "/admin/offers" },
                  { label: "إضافة صورة", icon: ImageIcon, color: "bg-pink-500", link: "/admin/media" },
                ].map((action, i) => (
                  <Link
                    key={i}
                    to={action.link}
                    className="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition-all group"
                  >
                    <div className="flex items-center gap-3">
                      <div className={`w-8 h-8 ${action.color} rounded-lg flex items-center justify-center`}>
                        <action.icon size={14} className="text-white" />
                      </div>
                      <span className="text-sm font-bold text-gray-700">{action.label}</span>
                    </div>
                    <span className="text-lg text-gray-300 group-hover:text-primary-500 group-hover:-translate-x-1 transition-all">+</span>
                  </Link>
                ))}
              </div>
            </div>

            {/* Summary Card */}
            <div className="bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl p-6 text-white">
              <h4 className="font-bold mb-4">📊 ملخص سريع</h4>
              <div className="space-y-2.5 text-sm">
                <div className="flex items-center justify-between">
                  <span className="text-white/70">الأقسام</span>
                  <span className="font-bold">{departments.length}</span>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-white/70">الأطباء</span>
                  <span className="font-bold">{doctors.length}</span>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-white/70">الأسئلة الشائعة</span>
                  <span className="font-bold">{faqs.length}</span>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-white/70">شركات التأمين</span>
                  <span className="font-bold">{insurances.length}</span>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-white/70">الشركاء</span>
                  <span className="font-bold">{partners.length}</span>
                </div>
                <div className="flex items-center justify-between">
                  <span className="text-white/70">الشهادات</span>
                  <span className="font-bold">{certifications.length}</span>
                </div>
              </div>
            </div>
          </div>
        )}
      </div>
    </div>
  );
}
