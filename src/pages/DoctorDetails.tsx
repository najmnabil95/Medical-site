import { useParams, Link } from "react-router-dom";
import { Star, Calendar, Users, MapPin, Award, Clock, Phone, Mail, Briefcase, CheckCircle, ArrowRight } from "lucide-react";
import { useData } from "../context/DataContext";
import { useState } from "react";
import AppointmentModal from "../components/AppointmentModal";

export default function DoctorDetails() {
  const { id } = useParams<{ id: string }>();
  const { doctors } = useData();
  const [appointmentOpen, setAppointmentOpen] = useState(false);

  const doctor = doctors.find(d => d.id === id);

  if (!doctor) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="text-center">
          <Users size={64} className="text-gray-300 mx-auto mb-4" />
          <h2 className="text-2xl font-bold text-gray-800 mb-2">الطبيب غير موجود</h2>
          <p className="text-gray-500 mb-6">لم نتمكن من العثور على الطبيب المطلوب</p>
          <Link to="/doctors" className="bg-primary-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-primary-700 transition-colors">
            العودة لقائمة الأطباء
          </Link>
        </div>
      </div>
    );
  }

  // حساب سنوات الخبرة
  const experienceYears = doctor.experience ? parseInt(doctor.experience.replace(/[^0-9]/g, "")) : 0;

  // حساب عدد المرضى
  const patientsCount = doctor.patients ? parseInt(doctor.patients.replace(/[^0-9]/g, "")) : 0;

  // معلومات الاتصال (محاكاة)
  const contactInfo = {
    email: `${doctor.name.split(" ").slice(1).join(".").toLowerCase()}@alshifa-hospital.com`,
    phone: "+966 50 " + Math.floor(1000000 + Math.random() * 9000000),
    office: "العيادة رقم " + Math.floor(1 + Math.random() * 20),
  };

  // الشهادات (محاكاة)
  const certifications = [
    "بكالوريوس طب وجراحة - جامعة الملك سعود",
    "ماجستير في " + doctor.specialty,
    "زمالة البورد السعودي",
    "عضو الجمعية الطبية السعودية",
  ];

  // التخصصات الفرعية (محاكاة)
  const subSpecialties = [
    doctor.specialty,
    "التشخيص المتقدم",
    "العلاج التحفظي",
    "العمليات الجراحية",
  ];

  // أوقات العمل (محاكاة)
  const workingHours = [
    { day: "السبت - الأربعاء", time: "8:00 ص - 4:00 م" },
    { day: "الخميس", time: "8:00 ص - 2:00 م" },
    { day: "الجمعة", time: "إجازة" },
  ];

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className={`relative bg-gradient-to-l ${doctor.gradient} text-white`}>
        <div className="absolute inset-0 bg-black/30"></div>
        
        <div className="relative max-w-7xl mx-auto px-4 py-12">
          {/* Back Button */}
          <button
            onClick={() => window.history.back()}
            className="flex items-center gap-2 text-white/80 hover:text-white mb-4 transition-colors"
          >
            <ArrowRight size={20} />
            <span>العودة</span>
          </button>
          
          {/* Breadcrumb */}
          <div className="flex items-center gap-2 text-white/70 text-sm mb-8">
            <Link to="/" className="hover:text-white transition-colors">الرئيسية</Link>
            <span>/</span>
            <Link to="/doctors" className="hover:text-white transition-colors">الأطباء</Link>
            <span>/</span>
            <span className="text-white">{doctor.name}</span>
          </div>

          <div className="grid md:grid-cols-3 gap-8 items-center">
            {/* Image */}
            <div className="md:col-span-1">
              <div className="w-48 h-48 md:w-64 md:h-64 mx-auto rounded-3xl overflow-hidden shadow-2xl border-4 border-white/20">
                {doctor.image ? (
                  <img src={doctor.image} alt={doctor.name} className="w-full h-full object-cover" />
                ) : (
                  <div className="w-full h-full bg-white/10 flex items-center justify-center text-white text-6xl font-bold">
                    {doctor.name.split(" ").slice(1).map(n => n[0]).join("").slice(0, 2)}
                  </div>
                )}
              </div>
            </div>

            {/* Info */}
            <div className="md:col-span-2 text-center md:text-right">
              <h1 className="text-4xl md:text-5xl font-black mb-3">{doctor.name}</h1>
              <p className="text-xl text-white/90 mb-4">{doctor.specialty}</p>
              
              {doctor.department && (
                <div className="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full mb-6">
                  <MapPin size={18} />
                  <span>{doctor.department}</span>
                </div>
              )}

              <div className="flex items-center justify-center md:justify-start gap-6 mb-6">
                <div className="flex items-center gap-2">
                  <div className="flex items-center gap-1">
                    <Star size={20} className="text-yellow-400 fill-yellow-400" />
                    <span className="text-2xl font-bold">{doctor.rating}</span>
                  </div>
                  <span className="text-white/70">/ 5</span>
                </div>
                {experienceYears > 0 && (
                  <div className="flex items-center gap-2">
                    <Award size={20} />
                    <span className="font-bold">{experienceYears} سنة خبرة</span>
                  </div>
                )}
                {patientsCount > 0 && (
                  <div className="flex items-center gap-2">
                    <Users size={20} />
                    <span className="font-bold">+{patientsCount} مريض</span>
                  </div>
                )}
              </div>

              <button
                onClick={() => setAppointmentOpen(true)}
                className="bg-white text-primary-700 px-8 py-3 rounded-xl font-bold hover:bg-gray-100 transition-colors inline-flex items-center gap-2 shadow-xl"
              >
                <Calendar size={20} />
                <span>حجز موعد مع الطبيب</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      {/* Content */}
      <div className="max-w-7xl mx-auto px-4 py-12">
        <div className="grid lg:grid-cols-3 gap-8">
          {/* Main Content */}
          <div className="lg:col-span-2 space-y-8">
            {/* نبذة عن الطبيب */}
            <div className="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
              <h2 className="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <Users size={24} className="text-primary-600" />
                <span>نبذة عن الطبيب</span>
              </h2>
              <p className="text-gray-600 leading-relaxed text-lg">
                {doctor.name} هو {doctor.specialty} متميز في {doctor.department || "مستشفى الشفاء الدولي"}. 
                يتميز بخبرة واسعة تمتد لـ {experienceYears > 0 ? experienceYears + " سنة" : "سنوات عديدة"} في مجال 
                {doctor.specialty}، وقد عالج أكثر من {patientsCount > 0 ? patientsCount.toLocaleString() : "آلاف"} المرضى 
                بنسبة نجاح عالية وتقييم ممتاز من المرضى.
              </p>
              <p className="text-gray-600 leading-relaxed text-lg mt-4">
                يلتزم الطبيب بتقديم أحدث العلاجات والتقنيات الطبية لضمان أفضل النتائج للمرضى، 
                مع الاهتمام بالجانب الإنساني والتواصل الفعال مع المرضى وأسرهم.
              </p>
            </div>

            {/* الشهادات */}
            <div className="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
              <h2 className="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <Award size={24} className="text-primary-600" />
                <span>الشهادات والمؤهلات</span>
              </h2>
              <ul className="space-y-3">
                {certifications.map((cert, i) => (
                  <li key={i} className="flex items-start gap-3">
                    <CheckCircle size={20} className="text-green-500 mt-1 shrink-0" />
                    <span className="text-gray-700">{cert}</span>
                  </li>
                ))}
              </ul>
            </div>

            {/* التخصصات */}
            <div className="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
              <h2 className="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <Briefcase size={24} className="text-primary-600" />
                <span>التخصصات والخدمات</span>
              </h2>
              <div className="grid md:grid-cols-2 gap-3">
                {subSpecialties.map((spec, i) => (
                  <div key={i} className="flex items-center gap-2 bg-primary-50 rounded-xl p-3">
                    <CheckCircle size={18} className="text-primary-600" />
                    <span className="text-gray-700 font-medium">{spec}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>

          {/* Sidebar */}
          <div className="lg:col-span-1 space-y-6">
            {/* معلومات الاتصال */}
            <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-24">
              <h3 className="text-xl font-bold text-gray-800 mb-4">معلومات الاتصال</h3>
              
              <div className="space-y-4">
                <div className="flex items-start gap-3">
                  <Mail size={20} className="text-primary-600 mt-1 shrink-0" />
                  <div>
                    <p className="text-xs text-gray-500 mb-1">البريد الإلكتروني</p>
                    <p className="text-gray-700 font-medium text-sm break-all">{contactInfo.email}</p>
                  </div>
                </div>
                <div className="flex items-start gap-3">
                  <Phone size={20} className="text-primary-600 mt-1 shrink-0" />
                  <div>
                    <p className="text-xs text-gray-500 mb-1">الهاتف</p>
                    <p className="text-gray-700 font-medium text-sm">{contactInfo.phone}</p>
                  </div>
                </div>
                <div className="flex items-start gap-3">
                  <MapPin size={20} className="text-primary-600 mt-1 shrink-0" />
                  <div>
                    <p className="text-xs text-gray-500 mb-1">العيادة</p>
                    <p className="text-gray-700 font-medium text-sm">{contactInfo.office}</p>
                  </div>
                </div>
              </div>

              <hr className="my-6 border-gray-200" />

              <h3 className="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <Clock size={20} className="text-primary-600" />
                <span>أوقات العمل</span>
              </h3>
              <div className="space-y-3">
                {workingHours.map((wh, i) => (
                  <div key={i} className="flex items-center justify-between text-sm">
                    <span className="text-gray-600">{wh.day}</span>
                    <span className={`font-bold ${wh.time === "إجازة" ? "text-red-500" : "text-gray-800"}`}>
                      {wh.time}
                    </span>
                  </div>
                ))}
              </div>

              <button
                onClick={() => setAppointmentOpen(true)}
                className="w-full mt-6 bg-gradient-to-l from-primary-500 to-primary-700 text-white py-3 rounded-xl font-bold hover:shadow-lg transition-all flex items-center justify-center gap-2"
              >
                <Calendar size={18} />
                <span>احجز موعد الآن</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <AppointmentModal
        isOpen={appointmentOpen}
        onClose={() => setAppointmentOpen(false)}
        prefill={{ doctor: doctor.name, department: doctor.department, locked: true }}
      />
    </div>
  );
}
