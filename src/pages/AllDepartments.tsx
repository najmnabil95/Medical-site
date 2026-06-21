import { useState } from "react";
import { Search, Building2, Users, ArrowRight } from "lucide-react";
import { useData } from "../context/DataContext";
import { Link } from "react-router-dom";

export default function AllDepartments() {
  const { departments, doctors } = useData();
  const [search, setSearch] = useState("");

  const activeDepartments = departments.filter(d => d.active !== false);

  const filtered = activeDepartments.filter((dept) =>
    dept.name.toLowerCase().includes(search.toLowerCase()) ||
    dept.desc.toLowerCase().includes(search.toLowerCase())
  );

  // حساب عدد الأطباء في كل قسم
  const getDoctorsCount = (deptName: string) => {
    return doctors.filter(d => d.department === deptName && d.active !== false).length;
  };

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className="bg-gradient-to-l from-primary-600 to-primary-800 text-white py-16">
        <div className="max-w-7xl mx-auto px-4">
          <button
            onClick={() => window.history.back()}
            className="flex items-center gap-2 text-white/80 hover:text-white mb-4 transition-colors"
          >
            <ArrowRight size={20} />
            <span>العودة</span>
          </button>
          <h1 className="text-4xl md:text-5xl font-black mb-4">أقسامنا الطبية</h1>
          <p className="text-xl text-white/80">مجموعة شاملة من التخصصات الطبية لتلبية جميع احتياجاتكم الصحية</p>
          <div className="flex items-center gap-6 mt-6 text-white/70">
            <div className="flex items-center gap-2">
              <Building2 size={20} />
              <span>{activeDepartments.length} قسم طبي</span>
            </div>
            <div className="flex items-center gap-2">
              <Users size={20} />
              <span>{doctors.filter(d => d.active !== false).length} طبيب</span>
            </div>
          </div>
        </div>
      </div>

      {/* Search */}
      <div className="max-w-7xl mx-auto px-4 -mt-8">
        <div className="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
          <div className="relative">
            <Search className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={20} />
            <input
              type="text"
              placeholder="ابحث عن قسم طبي..."
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="w-full pr-12 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500"
            />
          </div>
        </div>
      </div>

      {/* Departments Grid */}
      <div className="max-w-7xl mx-auto px-4 py-12">
        {filtered.length === 0 ? (
          <div className="text-center py-16">
            <Building2 size={64} className="text-gray-300 mx-auto mb-4" />
            <p className="text-gray-500 text-lg">لا توجد أقسام مطابقة للبحث</p>
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {filtered.map((dept, index) => {
              const doctorsCount = getDoctorsCount(dept.name);
              return (
                <Link
                  key={dept.id || index}
                  to={`/department/${dept.id || index}`}
                  className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100"
                >
                  {/* Header with gradient */}
                  <div className={`relative h-32 bg-gradient-to-br ${dept.color} overflow-hidden`}>
                    <div className="absolute inset-0 bg-black/10"></div>
                    <div className="absolute inset-0 flex items-center justify-center">
                      {(() => {
                        const iconMap: Record<string, string> = {
                          Heart: "❤️",
                          Brain: "🧠",
                          Bone: "🦴",
                          Baby: "👶",
                          Eye: "👁️",
                          Stethoscope: "🩺",
                        };
                        return <span className="text-5xl opacity-30">{iconMap[dept.icon] || "🏥"}</span>;
                      })()}
                    </div>
                    <div className="absolute bottom-5 right-5 bg-white/95 backdrop-blur-sm rounded-full px-4 py-2">
                      <span className="text-sm font-bold text-primary-700">
                        {doctorsCount} {doctorsCount === 1 ? "طبيب" : "أطباء"}
                      </span>
                    </div>
                  </div>

                  {/* Content */}
                  <div className="p-6">
                    <h3 className="text-xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors mb-2">
                      {dept.name}
                    </h3>
                    <p className="text-gray-500 text-sm leading-relaxed mb-4 line-clamp-3">
                      {dept.desc}
                    </p>

                    <div className="flex items-center gap-2 text-primary-600 font-bold text-sm">
                      <span>استكشف القسم</span>
                      <span>←</span>
                    </div>
                  </div>
                </Link>
              );
            })}
          </div>
        )}
      </div>
    </div>
  );
}
