import { LineChart, Line, BarChart, Bar, PieChart, Pie, Cell, AreaChart, Area, XAxis, YAxis, CartesianGrid, Tooltip, Legend, ResponsiveContainer } from "recharts";
import { TrendingUp, TrendingDown, Calendar, Activity } from "lucide-react";
import { useApp } from "../../context/AppContext";
import { useData } from "../../context/DataContext";
import PageHeader from "../components/PageHeader";

export default function AnalyticsPage() {
  const { reservations } = useApp();
  const { departments, doctors, currentUser } = useData();

  // تحديد إذا كان المستخدم طبيباً
  const isDoctor = currentUser?.role === "doctor";
  const doctorName = currentUser?.name || "";

  // فلترة الحجوزات حسب الدور
  const filteredReservations = isDoctor
    ? reservations.filter(r => r.doctor === doctorName)
    : reservations;

  // Reservations by Status
  const statusData = [
    { name: "قيد الانتظار", value: filteredReservations.filter(r => r.status === "pending").length, color: "#eab308" },
    { name: "مؤكد", value: filteredReservations.filter(r => r.status === "confirmed").length, color: "#22c55e" },
    { name: "مكتمل", value: filteredReservations.filter(r => r.status === "completed").length, color: "#3b82f6" },
    { name: "ملغى", value: filteredReservations.filter(r => r.status === "cancelled").length, color: "#ef4444" },
  ].filter(d => d.value > 0);

  // Monthly data (simulated)
  const monthlyData = [
    { month: "يناير", bookings: 120, visitors: 450 },
    { month: "فبراير", bookings: 145, visitors: 520 },
    { month: "مارس", bookings: 178, visitors: 610 },
    { month: "أبريل", bookings: 165, visitors: 580 },
    { month: "مايو", bookings: 198, visitors: 680 },
    { month: "يونيو", bookings: 210, visitors: 720 },
    { month: "يوليو", bookings: 185, visitors: 650 },
  ];

  // Departments stats
  const departmentStats = departments.slice(0, 6).map((d) => ({
    name: d.name,
    bookings: Math.floor(Math.random() * 50) + 20,
    revenue: Math.floor(Math.random() * 30000) + 10000,
  }));

  // Doctors performance
  const doctorPerformance = doctors.map((d) => ({
    name: d.name,
    patients: parseInt(d.patients.replace("+", "")) || 1000,
    rating: d.rating * 100,
  }));

  // حساب الإحصائيات حسب الدور
  const totalBookings = filteredReservations.length;
  const completedBookings = filteredReservations.filter(r => r.status === "completed").length;
  const cancelledBookings = filteredReservations.filter(r => r.status === "cancelled").length;
  const completionRate = totalBookings > 0 ? Math.round((completedBookings / totalBookings) * 100) : 0;
  const cancellationRate = totalBookings > 0 ? Math.round((cancelledBookings / totalBookings) * 100) : 0;

  const kpis = isDoctor
    ? [
        { label: "إجمالي حجوزاتي", value: totalBookings, trend: "خاص بي", positive: true, icon: Calendar },
        { label: "الحجوزات المكتملة", value: completedBookings, trend: `${completionRate}%`, positive: true, icon: TrendingUp },
        { label: "نسبة الإكمال", value: `${completionRate}%`, trend: "أداء ممتاز", positive: true, icon: Activity },
        { label: "معدل الإلغاء", value: `${cancellationRate}%`, trend: cancellationRate < 10 ? "منخفض" : "مرتفع", positive: cancellationRate < 10, icon: TrendingDown },
      ]
    : [
        { label: "إجمالي الحجوزات", value: totalBookings, trend: "+12.5%", positive: true, icon: Calendar },
        { label: "متوسط الزوار/يوم", value: "124", trend: "+8.2%", positive: true, icon: Activity },
        { label: "نسبة الإكمال", value: "92%", trend: "+3.1%", positive: true, icon: TrendingUp },
        { label: "معدل الإلغاء", value: "5.2%", trend: "-2.3%", positive: true, icon: TrendingDown },
      ];

  return (
    <div>
      <PageHeader
        title={isDoctor ? "إحصائياتي الشخصية" : "التحليلات والإحصائيات"}
        subtitle={isDoctor 
          ? `نظرة شاملة على أداء الدكتور ${doctorName}` 
          : "نظرة شاملة على أداء المستشفى"}
        icon={<TrendingUp size={26} />}
      />

      {/* KPI Cards */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {kpis.map((kpi, i) => (
          <div key={i} className="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-all">
            <div className="flex items-start justify-between mb-4">
              <div className="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center text-white shadow-lg">
                <kpi.icon size={22} />
              </div>
              <span className={`text-xs font-bold px-2 py-1 rounded-full ${kpi.positive ? "bg-green-100 text-green-600" : "bg-red-100 text-red-600"}`}>
                {kpi.trend}
              </span>
            </div>
            <p className="text-3xl font-black text-gray-800 mb-1">{kpi.value}</p>
            <p className="text-sm text-gray-500">{kpi.label}</p>
          </div>
        ))}
      </div>

      {/* Charts Row 1 */}
      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        {/* Monthly Bookings */}
        <div className="bg-white rounded-2xl p-6 border border-gray-100">
          <h3 className="text-lg font-bold text-gray-800 mb-6">الحجوزات الشهرية</h3>
          <ResponsiveContainer width="100%" height={280}>
            <AreaChart data={monthlyData}>
              <defs>
                <linearGradient id="colorBookings" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="5%" stopColor="#0e7490" stopOpacity={0.8} />
                  <stop offset="95%" stopColor="#0e7490" stopOpacity={0} />
                </linearGradient>
              </defs>
              <CartesianGrid strokeDasharray="3 3" stroke="#f1f5f9" />
              <XAxis dataKey="month" stroke="#94a3b8" fontSize={12} />
              <YAxis stroke="#94a3b8" fontSize={12} />
              <Tooltip contentStyle={{ borderRadius: 12, border: "1px solid #e2e8f0" }} />
              <Area type="monotone" dataKey="bookings" stroke="#0e7490" fillOpacity={1} fill="url(#colorBookings)" strokeWidth={3} name="الحجوزات" />
            </AreaChart>
          </ResponsiveContainer>
        </div>

        {/* Reservations by Status */}
        <div className="bg-white rounded-2xl p-6 border border-gray-100">
          <h3 className="text-lg font-bold text-gray-800 mb-6">توزيع الحجوزات حسب الحالة</h3>
          <ResponsiveContainer width="100%" height={280}>
            <PieChart>
              <Pie data={statusData} cx="50%" cy="50%" innerRadius={60} outerRadius={100} paddingAngle={3} dataKey="value" label={(entry) => entry.name}>
                {statusData.map((entry, index) => (
                  <Cell key={index} fill={entry.color} />
                ))}
              </Pie>
              <Tooltip contentStyle={{ borderRadius: 12, border: "1px solid #e2e8f0" }} />
              <Legend />
            </PieChart>
          </ResponsiveContainer>
        </div>
      </div>

      {/* Charts Row 2 - يظهر فقط للمدير */}
      {!isDoctor && (
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          {/* Departments Bar */}
          <div className="bg-white rounded-2xl p-6 border border-gray-100">
            <h3 className="text-lg font-bold text-gray-800 mb-6">حجوزات الأقسام</h3>
            <ResponsiveContainer width="100%" height={280}>
              <BarChart data={departmentStats}>
                <CartesianGrid strokeDasharray="3 3" stroke="#f1f5f9" />
                <XAxis dataKey="name" stroke="#94a3b8" fontSize={10} angle={-15} textAnchor="end" height={60} />
                <YAxis stroke="#94a3b8" fontSize={12} />
                <Tooltip contentStyle={{ borderRadius: 12, border: "1px solid #e2e8f0" }} />
                <Bar dataKey="bookings" fill="#0e7490" radius={[8, 8, 0, 0]} name="الحجوزات" />
              </BarChart>
            </ResponsiveContainer>
          </div>

          {/* Visitors Trend */}
          <div className="bg-white rounded-2xl p-6 border border-gray-100">
            <h3 className="text-lg font-bold text-gray-800 mb-6">حركة الزوار</h3>
          <ResponsiveContainer width="100%" height={280}>
            <LineChart data={monthlyData}>
              <CartesianGrid strokeDasharray="3 3" stroke="#f1f5f9" />
              <XAxis dataKey="month" stroke="#94a3b8" fontSize={12} />
              <YAxis stroke="#94a3b8" fontSize={12} />
              <Tooltip contentStyle={{ borderRadius: 12, border: "1px solid #e2e8f0" }} />
              <Legend />
              <Line type="monotone" dataKey="visitors" stroke="#10b981" strokeWidth={3} name="الزوار" dot={{ r: 5 }} activeDot={{ r: 7 }} />
            </LineChart>
          </ResponsiveContainer>
        </div>
      </div>
      )}

      {/* Top Doctors Table - يظهر فقط للمدير */}
      {!isDoctor && (
        <div className="mt-6 bg-white rounded-2xl p-6 border border-gray-100">
          <h3 className="text-lg font-bold text-gray-800 mb-6">أداء الأطباء</h3>
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead className="bg-gray-50 border-b border-gray-100">
                <tr>
                  <th className="text-right px-6 py-3 text-xs font-bold text-gray-500">الطبيب</th>
                  <th className="text-right px-6 py-3 text-xs font-bold text-gray-500">عدد المرضى</th>
                  <th className="text-right px-6 py-3 text-xs font-bold text-gray-500">التقييم</th>
                </tr>
              </thead>
              <tbody>
                {doctorPerformance.map((d, i) => (
                  <tr key={i} className="border-b border-gray-50 hover:bg-gray-50/50">
                    <td className="px-6 py-4 font-bold text-gray-800 text-sm">{d.name}</td>
                    <td className="px-6 py-4 text-sm text-gray-600">{d.patients.toLocaleString()}</td>
                    <td className="px-6 py-4">
                      <div className="flex items-center gap-2">
                        <div className="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden max-w-[150px]">
                          <div className="h-full bg-gradient-to-l from-amber-400 to-yellow-500 rounded-full" style={{ width: `${d.rating / 5}%` }}></div>
                        </div>
                        <span className="text-xs font-bold text-gray-600">{(d.rating / 100).toFixed(1)}</span>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}
    </div>
  );
}
