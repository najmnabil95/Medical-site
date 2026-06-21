import { useParams, useNavigate } from "react-router-dom";
import { ArrowRight, Star, Clock, Users, Award, Calendar, Phone, MapPin, ChevronLeft } from "lucide-react";
import { useData } from "../../context/DataContext";
import { useState } from "react";
import AppointmentModal from "../../components/AppointmentModal";

export default function DoctorDetailPage() {
  const { id } = useParams<{ id: string }>();
  const navigate = useNavigate();
  const { doctors, departments } = useData();
  const [appointmentOpen, setAppointmentOpen] = useState(false);

  const doctor = doctors.find((d) => d.id === id);

  if (!doctor) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h2 className="text-2xl font-bold text-gray-800 mb-4">الطبيب غير موجود</h2>
          <button
            onClick={() => navigate("/")}
            className="px-6 py-3 bg-primary-500 text-white rounded-xl font-bold hover:bg-primary-600"
          >
            العودة للرئيسية
          </button>
        </div>
      </div>
    );
  }

  const department = departments.find((d) => d.name === doctor.department);

  const stats = [
    { icon: Users, label: "المرضى", value: doctor.patients || "0", color: "from-blue-500 to-indigo-600" },
    { icon: Clock, label: "الخبرة", value: doctor.experience || "0", color: "from-emerald-500 to-teal-600" },
    { icon: Star, label: "التقييم", value: doctor.rating.toString(), color: "from-amber-500 to-orange-600" },
    { icon: Award, label: "الشهادات", value: "+15", color: "from-purple-500 to-violet-600" },
  ];

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className={`relative h-64 bg-gradient-to-br ${doctor.gradient}`}>
        <div className="absolute inset-0 bg-black/20"></div>
        <button
          onClick={() => navigate(-1)}
          className="absolute top-6 right-6 w-12 h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-colors"
        >
          <ArrowRight size={24} />
        </button>
      </div>

      {/* Content */}
      <div className="max-w-6xl mx-auto px-4 -mt-32 relative z-10">
        {/* Doctor Card */}
        <div className="bg-white rounded-3xl shadow-xl overflow-hidden">
          <div className="p-8">
            <div className="flex flex-col md:flex-row gap-8">
              {/* Image */}
              <div className="shrink-0">
                <div className={`w-48 h-48 rounded-2xl bg-gradient-to-br ${doctor.gradient} flex items-center justify-center text-white text-6xl font-bold shadow-lg`}>
                  {doctor.image ? (
                    <img src={doctor.image} alt={doctor.name} className="w-full h-full object-cover rounded-2xl" />
                  ) : (
                    doctor.name.charAt(2)
                  )}
                </div>
              </div>

              {/* Info */}
              <div className="flex-1">
                <div className="flex items-center gap-3 mb-2">
                  <h1 className="text-3xl font-black text-gray-800">{doctor.name}</h1>
                  <div className="flex items-center gap-1 bg-amber-100 px-3 py-1 rounded-full">
                    <Star size={14} className="text-amber-500 fill-amber-500" />
                    <span className="text-sm font-bold text-amber-700">{doctor.rating}</span>
                  </div>
                </div>
                <p className="text-lg text-primary-600 font-medium mb-4">{doctor.specialty}</p>

                {department && (
                  <div className="inline-flex items-center gap-2 bg-gray-100 px-4 py-2 rounded-xl mb-6">
                    <MapPin size={16} className="text-gray-500" />
                    <span className="text-sm font-medium text-gray-700">قسم {department.name}</span>
                  </div>
                )}

                <p className="text-gray-600 leading-relaxed mb-6">
                  طبيب متخصص ذو خبرة واسعة في {doctor.specialty}. يلتزم بتقديم أفضل رعاية صحية للمرضى
                  باستخدام أحدث التقنيات والأساليب الطبية المتطورة.
                </p>

                {/* Stats */}
                <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                  {stats.map((stat, i) => (
                    <div key={i} className="bg-gray-50 rounded-xl p-4 text-center">
                      <div className={`w-12 h-12 bg-gradient-to-br ${stat.color} rounded-lg flex items-center justify-center text-white mx-auto mb-2`}>
                        <stat.icon size={20} />
                      </div>
                      <div className="text-2xl font-black text-gray-800">{stat.value}</div>
                      <div className="text-xs text-gray-500">{stat.label}</div>
                    </div>
                  ))}
                </div>

                {/* Actions */}
                <div className="flex flex-wrap gap-3">
                  <button
                    onClick={() => setAppointmentOpen(true)}
                    className="flex-1 min-w-[200px] bg-gradient-to-l from-primary-500 to-primary-700 text-white px-6 py-3.5 rounded-xl font-bold hover:shadow-lg hover:shadow-primary-500/30 transition-all flex items-center justify-center gap-2"
                  >
                    <Calendar size={20} />
                    <span>احجز موعد الآن</span>
                  </button>
                  <a
                    href="tel:920012345"
                    className="flex-1 min-w-[200px] bg-green-500 text-white px-6 py-3.5 rounded-xl font-bold hover:bg-green-600 transition-all flex items-center justify-center gap-2"
                  >
                    <Phone size={20} />
                    <span>اتصل بالطبيب</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Additional Info */}
        <div className="grid md:grid-cols-2 gap-6 mt-6">
          {/* Qualifications */}
          <div className="bg-white rounded-2xl p-6 shadow-sm">
            <h3 className="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
              <Award size={24} className="text-primary-600" />
              <span>المؤهلات والشهادات</span>
            </h3>
            <ul className="space-y-3">
              {[
                "بكالوريوس طب وجراحة - جامعة الملك سعود",
                "ماجستير في التخصص - جامعة هارفارد",
                "زمالة البورد الأمريكي",
                "عضو الجمعية الطبية السعودية",
                "شهادة الاعتماد الدولي JCI",
              ].map((qual, i) => (
                <li key={i} className="flex items-start gap-3">
                  <div className="w-6 h-6 bg-primary-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                    <ChevronLeft size={12} className="text-primary-600" />
                  </div>
                  <span className="text-gray-700">{qual}</span>
                </li>
              ))}
            </ul>
          </div>

          {/* Working Hours */}
          <div className="bg-white rounded-2xl p-6 shadow-sm">
            <h3 className="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
              <Clock size={24} className="text-primary-600" />
              <span>ساعات العمل</span>
            </h3>
            <div className="space-y-3">
              {[
                { day: "السبت - الأربعاء", time: "8:00 ص - 4:00 م" },
                { day: "الخميس", time: "8:00 ص - 2:00 م" },
                { day: "الجمعة", time: "إجازة" },
              ].map((schedule, i) => (
                <div key={i} className="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                  <span className="font-medium text-gray-700">{schedule.day}</span>
                  <span className={`font-bold ${schedule.time === "إجازة" ? "text-red-500" : "text-primary-600"}`}>
                    {schedule.time}
                  </span>
                </div>
              ))}
            </div>

            <div className="mt-6 p-4 bg-blue-50 rounded-xl">
              <p className="text-sm text-blue-700 font-medium mb-2">📞 للحجز والاستفسار:</p>
              <p className="text-lg font-bold text-blue-800" dir="ltr">920 012 345</p>
            </div>
          </div>
        </div>
      </div>

      <AppointmentModal
        isOpen={appointmentOpen}
        onClose={() => setAppointmentOpen(false)}
        prefill={{ doctor: doctor.name, department: doctor.department }}
      />
    </div>
  );
}
