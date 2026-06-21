import { useState } from "react";
import { Search, Star, Users, MapPin, ArrowRight } from "lucide-react";
import { useData } from "../context/DataContext";
import { Link } from "react-router-dom";

export default function AllDoctors() {
  const { doctors } = useData();
  const [search, setSearch] = useState("");
  const [departmentFilter, setDepartmentFilter] = useState("");

  const activeDoctors = doctors.filter(d => d.active !== false);

  const filtered = activeDoctors.filter((doctor) => {
    const matchesSearch = 
      doctor.name.toLowerCase().includes(search.toLowerCase()) ||
      doctor.specialty.toLowerCase().includes(search.toLowerCase());
    const matchesDepartment = !departmentFilter || doctor.department === departmentFilter;
    return matchesSearch && matchesDepartment;
  });

  const departmentOptions = Array.from(new Set(activeDoctors.map(d => d.department).filter(Boolean)));

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
          <h1 className="text-4xl md:text-5xl font-black mb-4">أطباؤنا المتميزون</h1>
          <p className="text-xl text-white/80">نخبة من أفضل الأطباء والاستشاريين في مختلف التخصصات</p>
          <div className="flex items-center gap-6 mt-6 text-white/70">
            <div className="flex items-center gap-2">
              <Users size={20} />
              <span>{activeDoctors.length} طبيب</span>
            </div>
            <div className="flex items-center gap-2">
              <MapPin size={20} />
              <span>{departmentOptions.length} تخصص</span>
            </div>
          </div>
        </div>
      </div>

      {/* Filters */}
      <div className="max-w-7xl mx-auto px-4 -mt-8">
        <div className="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
          <div className="grid md:grid-cols-2 gap-4">
            <div className="relative">
              <Search className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={20} />
              <input
                type="text"
                placeholder="ابحث عن طبيب أو تخصص..."
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                className="w-full pr-12 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500"
              />
            </div>
            <select
              value={departmentFilter}
              onChange={(e) => setDepartmentFilter(e.target.value)}
              className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 appearance-none"
            >
              <option value="">جميع التخصصات</option>
              {departmentOptions.map((dept) => (
                <option key={dept} value={dept}>{dept}</option>
              ))}
            </select>
          </div>
        </div>
      </div>

      {/* Doctors Grid */}
      <div className="max-w-7xl mx-auto px-4 py-12">
        {filtered.length === 0 ? (
          <div className="text-center py-16">
            <Users size={64} className="text-gray-300 mx-auto mb-4" />
            <p className="text-gray-500 text-lg">لا يوجد أطباء مطابقين للبحث</p>
          </div>
        ) : (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {filtered.map((doctor) => (
              <Link
                key={doctor.id}
                to={`/doctor/${doctor.id}`}
                className="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100"
              >
                {/* Image */}
                <div className="relative h-64 overflow-hidden">
                  {doctor.image ? (
                    <img
                      src={doctor.image}
                      alt={doctor.name}
                      className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                    />
                  ) : (
                    <div className={`w-full h-full bg-gradient-to-br ${doctor.gradient} flex items-center justify-center text-white text-6xl font-bold`}>
                      {doctor.name.split(" ").slice(1).map(n => n[0]).join("").slice(0, 2)}
                    </div>
                  )}
                  <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                  
                  {/* Rating */}
                  <div className="absolute top-5 left-5 bg-white/95 backdrop-blur-sm rounded-full px-3 py-1.5 flex items-center gap-1 shadow-lg">
                    <Star size={14} className="text-yellow-500 fill-yellow-500" />
                    <span className="text-sm font-bold text-gray-800">{doctor.rating}</span>
                  </div>

                  {/* Department */}
                  {doctor.department && (
                    <div className="absolute bottom-5 right-5 bg-white/95 backdrop-blur-sm rounded-full px-3 py-1.5">
                      <span className="text-xs font-bold text-primary-700">{doctor.department}</span>
                    </div>
                  )}
                </div>

                {/* Info */}
                <div className="p-6">
                  <h3 className="text-xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors">
                    {doctor.name}
                  </h3>
                  <p className="text-primary-600 text-sm font-medium mt-1.5">{doctor.specialty}</p>

                  <div className="flex items-center gap-4 mt-4 pt-4 border-t border-gray-100 text-xs text-gray-500">
                    {doctor.experience && (
                      <div className="flex items-center gap-1">
                        <span>📋</span>
                        <span>{doctor.experience}</span>
                      </div>
                    )}
                    {doctor.patients && (
                      <div className="flex items-center gap-1">
                        <span>👥</span>
                        <span>{doctor.patients} مريض</span>
                      </div>
                    )}
                  </div>

                  <div className="mt-4 text-center">
                    <span className="inline-flex items-center gap-2 text-primary-600 font-bold text-sm group-hover:gap-3 transition-all">
                      <span>عرض الملف الشخصي</span>
                      <span>←</span>
                    </span>
                  </div>
                </div>
              </Link>
            ))}
          </div>
        )}
      </div>
    </div>
  );
}
