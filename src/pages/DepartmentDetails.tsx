import { useParams, Link } from "react-router-dom";
import { Star, Users, MapPin, Clock, Phone, Briefcase, CheckCircle, Award, ArrowRight } from "lucide-react";
import { useData } from "../context/DataContext";

export default function DepartmentDetails() {
  const { id } = useParams<{ id: string }>();
  const { departments, doctors } = useData();

  const deptIndex = id ? parseInt(id) : 0;
  const department = departments[deptIndex];

  if (!department) {
    return (
      <div className="min-h-screen bg-gray-50 flex items-center justify-center">
        <div className="text-center">
          <MapPin size={64} className="text-gray-300 mx-auto mb-4" />
          <h2 className="text-2xl font-bold text-gray-800 mb-2">القسم غير موجود</h2>
          <p className="text-gray-500 mb-6">لم نتمكن من العثور على القسم المطلوب</p>
          <Link to="/departments" className="bg-primary-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-primary-700 transition-colors">
            العودة لقائمة الأقسام
          </Link>
        </div>
      </div>
    );
  }

  const deptDoctors = doctors.filter(d => d.department === department.name && d.active !== false);

  // الخدمات (محاكاة)
  const services = [
    "الفحوصات الشاملة",
    "التشخيص الدقيق",
    "العلاج المتخصص",
    "المتابعة المستمرة",
    "الاستشارات الطبية",
    "العمليات الجراحية",
  ];

  // المعدات والتقنيات (محاكاة)
  const equipment = [
    "أجهزة تشخيص متطورة",
    "تقنيات تصوير حديثة",
    "مختبرات مجهزة بالكامل",
    "غرف عمليات معقمة",
    "وحدات رعاية مركزة",
  ];

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <div className={`relative bg-gradient-to-br ${department.color} text-white`}>
        <div className="absolute inset-0 bg-black/30"></div>
        
        <div className="relative max-w-7xl mx-auto px-4 py-16">
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
            <Link to="/departments" className="hover:text-white transition-colors">الأقسام</Link>
            <span>/</span>
            <span className="text-white">{department.name}</span>
          </div>

          <div className="text-center">
            <div className="w-24 h-24 mx-auto mb-6 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center">
              <span className="text-5xl opacity-80">
                {department.icon === "Heart" ? "❤️" :
                 department.icon === "Brain" ? "🧠" :
                 department.icon === "Bone" ? "🦴" :
                 department.icon === "Baby" ? "👶" :
                 department.icon === "Eye" ? "👁️" :
                 department.icon === "Stethoscope" ? "🩺" : "🏥"}
              </span>
            </div>
            <h1 className="text-5xl md:text-6xl font-black mb-4">{department.name}</h1>
            <p className="text-xl text-white/90 max-w-3xl mx-auto">{department.desc}</p>
            
            <div className="flex items-center justify-center gap-8 mt-8">
              <div className="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full">
                <Users size={24} />
                <span className="font-bold text-lg">{deptDoctors.length} طبيب</span>
              </div>
              <div className="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-6 py-3 rounded-full">
                <Award size={24} />
                <span className="font-bold text-lg">خدمة متميزة</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Content */}
      <div className="max-w-7xl mx-auto px-4 py-12">
        <div className="grid lg:grid-cols-3 gap-8">
          {/* Main Content */}
          <div className="lg:col-span-2 space-y-8">
            {/* نبذة عن القسم */}
            <div className="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
              <h2 className="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <Briefcase size={24} className="text-primary-600" />
                <span>نبذة عن القسم</span>
              </h2>
              <p className="text-gray-600 leading-relaxed text-lg">
                {department.desc}
              </p>
              <p className="text-gray-600 leading-relaxed text-lg mt-4">
                يضم القسم نخبة من أفضل الأطباء والاستشاريين المتخصصين، الذين يقدمون رعاية صحية متميزة 
                باستخدام أحدث التقنيات والأجهزة الطبية المتطورة. يلتزم الفريق الطبي بأعلى معايير الجودة 
                والسلامة لضمان حصول المرضى على أفضل النتائج.
              </p>
            </div>

            {/* الخدمات */}
            <div className="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
              <h2 className="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <CheckCircle size={24} className="text-primary-600" />
                <span>الخدمات المقدمة</span>
              </h2>
              <div className="grid md:grid-cols-2 gap-3">
                {services.map((service, i) => (
                  <div key={i} className="flex items-center gap-3 bg-primary-50 rounded-xl p-4">
                    <CheckCircle size={20} className="text-primary-600 shrink-0" />
                    <span className="text-gray-700 font-medium">{service}</span>
                  </div>
                ))}
              </div>
            </div>

            {/* المعدات والتقنيات */}
            <div className="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
              <h2 className="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <Award size={24} className="text-primary-600" />
                <span>المعدات والتقنيات</span>
              </h2>
              <div className="grid md:grid-cols-2 gap-3">
                {equipment.map((item, i) => (
                  <div key={i} className="flex items-center gap-3 bg-gray-50 rounded-xl p-4">
                    <span className="text-2xl">⚙️</span>
                    <span className="text-gray-700 font-medium">{item}</span>
                  </div>
                ))}
              </div>
            </div>

            {/* الأطباء */}
            <div className="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
              <h2 className="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <Users size={24} className="text-primary-600" />
                <span>أطباء القسم ({deptDoctors.length})</span>
              </h2>
              
              {deptDoctors.length === 0 ? (
                <div className="text-center py-8">
                  <Users size={48} className="text-gray-300 mx-auto mb-3" />
                  <p className="text-gray-500">لا يوجد أطباء في هذا القسم حالياً</p>
                </div>
              ) : (
                <div className="grid md:grid-cols-2 gap-4">
                  {deptDoctors.map((doctor) => (
                    <Link
                      key={doctor.id}
                      to={`/doctor/${doctor.id}`}
                      className="group flex items-center gap-4 bg-gray-50 rounded-xl p-4 hover:bg-primary-50 hover:shadow-md transition-all"
                    >
                      <div className={`w-16 h-16 bg-gradient-to-br ${doctor.gradient} rounded-xl flex items-center justify-center text-white text-xl font-bold shrink-0`}>
                        {doctor.image ? (
                          <img src={doctor.image} alt={doctor.name} className="w-full h-full object-cover rounded-xl" />
                        ) : (
                          doctor.name.split(" ").slice(1).map(n => n[0]).join("").slice(0, 2)
                        )}
                      </div>
                      <div className="flex-1 min-w-0">
                        <h4 className="font-bold text-gray-800 group-hover:text-primary-600 transition-colors">
                          {doctor.name}
                        </h4>
                        <p className="text-sm text-primary-600">{doctor.specialty}</p>
                        <div className="flex items-center gap-1 mt-1">
                          <Star size={12} className="text-yellow-500 fill-yellow-500" />
                          <span className="text-xs text-gray-600">{doctor.rating}</span>
                        </div>
                      </div>
                    </Link>
                  ))}
                </div>
              )}
            </div>
          </div>

          {/* Sidebar */}
          <div className="lg:col-span-1 space-y-6">
            <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-24">
              <h3 className="text-xl font-bold text-gray-800 mb-4">معلومات القسم</h3>
              
              <div className="space-y-4">
                <div className="flex items-start gap-3">
                  <Users size={20} className="text-primary-600 mt-1 shrink-0" />
                  <div>
                    <p className="text-xs text-gray-500 mb-1">عدد الأطباء</p>
                    <p className="text-gray-700 font-bold">{deptDoctors.length} طبيب</p>
                  </div>
                </div>
                <div className="flex items-start gap-3">
                  <Clock size={20} className="text-primary-600 mt-1 shrink-0" />
                  <div>
                    <p className="text-xs text-gray-500 mb-1">ساعات العمل</p>
                    <p className="text-gray-700 font-medium text-sm">السبت - الخميس<br />8:00 ص - 8:00 م</p>
                  </div>
                </div>
                <div className="flex items-start gap-3">
                  <Phone size={20} className="text-primary-600 mt-1 shrink-0" />
                  <div>
                    <p className="text-xs text-gray-500 mb-1">للتواصل</p>
                    <p className="text-gray-700 font-medium text-sm">920012345</p>
                  </div>
                </div>
                <div className="flex items-start gap-3">
                  <MapPin size={20} className="text-primary-600 mt-1 shrink-0" />
                  <div>
                    <p className="text-xs text-gray-500 mb-1">الموقع</p>
                    <p className="text-gray-700 font-medium text-sm">الطابق الثاني<br />مبنى A</p>
                  </div>
                </div>
              </div>

              <Link
                to="/appointment"
                className="w-full mt-6 bg-gradient-to-l from-primary-500 to-primary-700 text-white py-3 rounded-xl font-bold hover:shadow-lg transition-all flex items-center justify-center gap-2"
              >
                <span>احجز موعد الآن</span>
              </Link>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
