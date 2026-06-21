import {
  Heart,
  Brain,
  Bone,
  Baby,
  Eye,
  Stethoscope,
  Syringe,
  Activity,
  Pill,
  Microscope,
  Ear,
  Smile,
} from "lucide-react";
import { useState } from "react";
import SectionHeader from "./SectionHeader";
import { useScrollReveal } from "../hooks/useScrollReveal";
import DepartmentDetailModal from "./DepartmentDetailModal";
import { useData } from "../context/DataContext";

// خريطة الأيقونات
const iconMap: Record<string, any> = {
  Heart,
  Brain,
  Bone,
  Baby,
  Eye,
  Stethoscope,
  Syringe,
  Activity,
  Pill,
  Microscope,
  Ear,
  Smile,
};

// الألوان الافتراضية للدوران
const defaultColors = [
  { color: "from-red-500 to-rose-600", lightColor: "bg-red-50 text-red-600" },
  { color: "from-purple-500 to-violet-600", lightColor: "bg-purple-50 text-purple-600" },
  { color: "from-amber-500 to-orange-600", lightColor: "bg-amber-50 text-amber-600" },
  { color: "from-pink-500 to-rose-600", lightColor: "bg-pink-50 text-pink-600" },
  { color: "from-cyan-500 to-teal-600", lightColor: "bg-cyan-50 text-cyan-600" },
  { color: "from-blue-500 to-indigo-600", lightColor: "bg-blue-50 text-blue-600" },
  { color: "from-emerald-500 to-teal-600", lightColor: "bg-emerald-50 text-emerald-600" },
  { color: "from-indigo-500 to-blue-600", lightColor: "bg-indigo-50 text-indigo-600" },
  { color: "from-teal-500 to-cyan-600", lightColor: "bg-teal-50 text-teal-600" },
  { color: "from-sky-500 to-blue-600", lightColor: "bg-sky-50 text-sky-600" },
  { color: "from-lime-500 to-green-600", lightColor: "bg-lime-50 text-lime-600" },
];

export default function Departments() {
  const { ref, isVisible } = useScrollReveal();
  const { departments: departmentsData } = useData();
  const [selectedDept, setSelectedDept] = useState<any>(null);

  // فلترة الأقسام النشطة فقط
  const activeDepartments = departmentsData.filter(d => d.active !== false);

  // تحويل بيانات DataContext إلى صيغة العرض
  const departments = activeDepartments.map((dept, index) => {
    const colors = defaultColors[index % defaultColors.length];
    const Icon = iconMap[dept.icon] || Heart;
    return {
      ...dept,
      icon: Icon,
      color: dept.color || colors.color,
      lightColor: colors.lightColor,
    };
  });

  return (
    <section id="departments" className="py-24 bg-gray-50 relative overflow-hidden">
      <div className="absolute bottom-0 right-0 w-80 h-80 bg-primary-100/30 rounded-full blur-3xl"></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <SectionHeader
          badge="أقسامنا الطبية"
          title="تخصصات طبية"
          highlight="متكاملة"
          description="نقدم مجموعة شاملة من التخصصات الطبية لتلبية جميع احتياجاتكم الصحية تحت سقف واحد"
        />

        <div ref={ref} className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
          {departments.map((dept, index) => (
            <div
              key={dept.id || index}
              onClick={() => setSelectedDept(dept)}
              className={`group bg-white rounded-2xl p-6 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-gray-100 cursor-pointer relative overflow-hidden ${
                isVisible ? "animate-fade-in-up" : "opacity-0"
              }`}
              style={{ animationDelay: `${index * 80}ms` }}
            >
              <div className={`absolute inset-0 bg-gradient-to-br ${dept.color} opacity-0 group-hover:opacity-100 transition-opacity duration-500`}></div>

              <div className="relative">
                <div
                  className={`w-14 h-14 ${dept.lightColor} group-hover:bg-white/20 rounded-2xl flex items-center justify-center mb-4 transition-all duration-300 group-hover:scale-110 group-hover:rotate-3`}
                >
                  <dept.icon className="group-hover:text-white transition-colors" size={26} />
                </div>
                <h3 className="text-lg font-bold text-gray-900 mb-2 group-hover:text-white transition-colors">
                  {dept.name}
                </h3>
                <p className="text-gray-500 text-sm leading-relaxed group-hover:text-white/80 transition-colors">{dept.desc}</p>
                <div className="mt-4 flex items-center gap-2 text-primary-600 group-hover:text-white text-sm font-bold opacity-0 group-hover:opacity-100 transition-all translate-y-2 group-hover:translate-y-0">
                  <span>اكتشف القسم</span>
                  <span>←</span>
                </div>
              </div>
            </div>
          ))}
        </div>

        {departments.length === 0 && (
          <div className="text-center py-16">
            <p className="text-gray-400 text-lg">لا توجد أقسام متاحة حالياً</p>
          </div>
        )}
      </div>

      <DepartmentDetailModal
        department={selectedDept}
        onClose={() => setSelectedDept(null)}
      />
    </section>
  );
}
