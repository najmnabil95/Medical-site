import { X, ArrowLeft, Clock, Users, Award, CheckCircle, Star, Stethoscope, Activity, Heart, Brain, Bone, Baby, Eye } from "lucide-react";
import { useState } from "react";
import AppointmentModal from "./AppointmentModal";
import { useData, Department } from "../context/DataContext";

const iconMap: Record<string, React.ComponentType<{ className?: string; size?: number }>> = {
  Heart, Brain, Bone, Baby, Eye, Stethoscope, Activity,
};

interface DepartmentDetailProps {
  department: Department;
  onClose: () => void;
}

export default function DepartmentDetailModal({ department, onClose }: DepartmentDetailProps) {
  const [appointmentOpen, setAppointmentOpen] = useState(false);
  const [selectedDoctor, setSelectedDoctor] = useState<string>("");
  const { doctors } = useData();

  if (!department) return null;

  // مطابقة الأطباء بالقسم باستخدام حقل department مباشرة
  const deptDoctors = doctors.filter((d) => {
    if (!d.active && d.active !== undefined) return false;
    return d.department === department.name;
  });

  const services = [
    "تشخيص دقيق بأحدث التقنيات",
    "علاج متقدم وفعال",
    "متابعة مستمرة بعد العلاج",
    "رعاية إنسانية متميزة",
    "فريق طبي متخصص",
    "أحدث الأجهزة الطبية",
  ];

  return (
    <>
      <div className="fixed inset-0 z-[90] flex items-center justify-center p-4">
        <div className="fixed inset-0 bg-black/70 backdrop-blur-sm" onClick={onClose}></div>
        <div className="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto animate-scale-in">
          {/* Header with gradient */}
          <div className={`relative h-48 bg-gradient-to-br ${department.color} overflow-hidden`}>
            <div className="absolute inset-0 opacity-20" style={{
              backgroundImage: `radial-gradient(circle, white 1px, transparent 1px)`,
              backgroundSize: '25px 25px'
            }}></div>
            <button
              onClick={onClose}
              className="absolute top-4 left-4 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-colors"
            >
              <X size={20} />
            </button>
            <div className="absolute bottom-6 right-6 text-white">
              <div className="flex items-center gap-3 mb-3">
                <div className="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                  {(() => {
                    const Icon = iconMap[department.icon];
                    return Icon ? <Icon className="text-white" size={28} /> : null;
                  })()}
                </div>
                <div>
                  <p className="text-white/70 text-xs">قسم طبي</p>
                  <h2 className="text-3xl font-black">{department.name}</h2>
                </div>
              </div>
            </div>
          </div>

          {/* Content */}
          <div className="p-8 grid md:grid-cols-3 gap-8">
            {/* Main Info */}
            <div className="md:col-span-2 space-y-6">
              <div>
                <h3 className="text-lg font-bold text-gray-800 mb-3">نبذة عن القسم</h3>
                <p className="text-gray-600 leading-relaxed">{department.desc}</p>
              </div>

              {/* Services */}
              <div>
                <h3 className="text-lg font-bold text-gray-800 mb-4">خدماتنا في هذا القسم</h3>
                <div className="grid grid-cols-2 gap-3">
                  {services.map((service, i) => (
                    <div key={i} className="flex items-center gap-2 bg-gray-50 rounded-xl p-3">
                      <CheckCircle size={16} className="text-accent-500 shrink-0" />
                      <span className="text-sm text-gray-700">{service}</span>
                    </div>
                  ))}
                </div>
              </div>

              {/* Stats */}
              <div className="grid grid-cols-3 gap-3">
                <div className="bg-primary-50 rounded-2xl p-4 text-center">
                  <Users className="text-primary-600 mx-auto mb-2" size={22} />
                  <div className="text-xl font-black text-primary-700">+2K</div>
                  <div className="text-xs text-gray-500">مريض/سنة</div>
                </div>
                <div className="bg-accent-50 rounded-2xl p-4 text-center">
                  <Award className="text-accent-600 mx-auto mb-2" size={22} />
                  <div className="text-xl font-black text-accent-700">98%</div>
                  <div className="text-xs text-gray-500">نسبة النجاح</div>
                </div>
                <div className="bg-purple-50 rounded-2xl p-4 text-center">
                  <Activity className="text-purple-600 mx-auto mb-2" size={22} />
                  <div className="text-xl font-black text-purple-700">24/7</div>
                  <div className="text-xs text-gray-500">خدمة مستمرة</div>
                </div>
              </div>
            </div>

            {/* Sidebar - Doctors */}
            <div className="space-y-4">
              <h3 className="text-lg font-bold text-gray-800">أطباؤنا المتخصصون</h3>

              {deptDoctors.length > 0 ? (
                <>
                <p className="text-xs text-gray-500 mb-2">
                  {deptDoctors.length} {deptDoctors.length === 1 ? "طبيب" : "أطباء"} في هذا القسم
                </p>
                <div className="space-y-3">
                  {deptDoctors.map((doc, i) => (
                    <div key={i} className="bg-white rounded-2xl border border-gray-100 p-4 hover:shadow-md transition-all">
                      <div className="flex items-center gap-3 mb-2">
                        <div className={`w-12 h-12 bg-gradient-to-br ${doc.gradient} rounded-xl flex items-center justify-center text-white font-bold`}>
                          {doc.name.split(" ").slice(1).map(n => n[0]).join("").slice(0, 2)}
                        </div>
                        <div className="flex-1 min-w-0">
                          <p className="font-bold text-gray-800 text-sm truncate">{doc.name}</p>
                          <div className="flex items-center gap-1 mt-0.5">
                            <Star size={10} className="text-yellow-500 fill-yellow-500" />
                            <span className="text-xs text-gray-500">{doc.rating}</span>
                          </div>
                        </div>
                      </div>
                      <p className="text-xs text-gray-500 truncate mb-2">{doc.specialty}</p>
                      <button
                        onClick={() => {
                          setSelectedDoctor(doc.name);
                          setAppointmentOpen(true);
                        }}
                        className="w-full bg-primary-50 text-primary-600 py-2 rounded-lg text-xs font-bold hover:bg-primary-100 transition-colors flex items-center justify-center gap-1"
                      >
                        <Clock size={12} />
                        <span>احجز مع {doc.name.split(" ").slice(1).join(" ")}</span>
                      </button>
                    </div>
                  ))}
                </div>
                </>
              ) : (
                <div className="bg-gray-50 rounded-2xl p-6 text-center">
                  <Stethoscope className="text-gray-300 mx-auto mb-3" size={40} />
                  <p className="text-gray-500 text-sm">لا يوجد أطباء في هذا القسم حالياً</p>
                  <p className="text-xs text-gray-400 mt-2">يمكنك الحجز العام للقسم وسيتم تعيين طبيب مناسب لك</p>
                </div>
              )}

              <button
                onClick={() => {
                  setSelectedDoctor("");
                  setAppointmentOpen(true);
                }}
                className="w-full bg-gradient-to-l from-primary-500 to-primary-700 text-white py-4 rounded-2xl font-bold hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2"
              >
                <span>احجز موعد الآن</span>
                <ArrowLeft size={16} />
              </button>

              <a
                href="tel:920012345"
                className="w-full bg-red-50 text-red-600 py-3 rounded-2xl font-bold hover:bg-red-100 transition-colors flex items-center justify-center gap-2 text-sm"
              >
                📞 للاستفسار: 920 012 345
              </a>
            </div>
          </div>
        </div>
      </div>

      {/* Nested Appointment Modal */}
      <AppointmentModal
        isOpen={appointmentOpen}
        onClose={() => setAppointmentOpen(false)}
        prefill={{
          department: department.name,
          doctor: selectedDoctor || undefined,
          locked: selectedDoctor ? true : false, // قفل الحقول فقط عند اختيار طبيب محدد
        }}
      />
    </>
  );
}
