import { Award, Star } from "lucide-react";
import { useScrollReveal } from "../hooks/useScrollReveal";

const certifications = [
  {
    icon: "🏆",
    name: "JCI",
    fullName: "الاعتماد الدولي",
    desc: "حاصلون على اعتماد الهيئة الدولية لاعتماد المؤسسات الصحية",
    year: "2024",
    color: "from-amber-500 to-yellow-600",
    border: "border-amber-200",
    bg: "bg-amber-50",
  },
  {
    icon: "🌟",
    name: "CBAHI",
    fullName: "المجلس المركزي",
    desc: "اعتماد المجلس المركزي لاعتماد المنشآت الصحية",
    year: "2024",
    color: "from-blue-500 to-indigo-600",
    border: "border-blue-200",
    bg: "bg-blue-50",
  },
  {
    icon: "✅",
    name: "ISO 9001",
    fullName: "معايير الجودة",
    desc: "شهادة نظام إدارة الجودة الدولية ISO 9001:2015",
    year: "2023",
    color: "from-emerald-500 to-teal-600",
    border: "border-emerald-200",
    bg: "bg-emerald-50",
  },
  {
    icon: "💻",
    name: "HIMSS",
    fullName: "التحول الرقمي",
    desc: "المستوى السادس من شهادة التحول الرقمي في الرعاية الصحية",
    year: "2023",
    color: "from-purple-500 to-violet-600",
    border: "border-purple-200",
    bg: "bg-purple-50",
  },
];

const awards = [
  { title: "أفضل مستشفى في المنطقة", year: "2024", org: "جائزة التميز الصحي" },
  { title: "جائزة الابتكار في الرعاية الصحية", year: "2023", org: "المؤتمر الطبي الدولي" },
  { title: "جائزة سلامة المرضى", year: "2023", org: "الهيئة الدولية JCI" },
  { title: "أفضل بيئة عمل صحية", year: "2022", org: "Great Place to Work" },
];

export default function Certifications() {
  const { ref, isVisible } = useScrollReveal();

  return (
    <section className="py-24 bg-white relative overflow-hidden">
      <div className="absolute top-0 right-0 w-80 h-80 bg-amber-50 rounded-full blur-3xl opacity-50"></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        {/* Header */}
        <div className="text-center mb-16">
          <span className="text-amber-600 font-bold text-sm bg-amber-100 px-5 py-2 rounded-full inline-block">
            الاعتمادات والجوائز
          </span>
          <h2 className="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 mt-5 leading-tight">
            شهادات تؤكد
            <span className="gradient-text-gold"> تميزنا</span>
          </h2>
          <p className="text-gray-500 mt-5 max-w-2xl mx-auto text-lg leading-relaxed">
            نفتخر بالاعتمادات الدولية والجوائز التي حصلنا عليها تأكيداً لالتزامنا بأعلى معايير الجودة
          </p>
          <div className="flex items-center justify-center gap-2 mt-6">
            <span className="w-12 h-1 bg-amber-400 rounded-full"></span>
            <span className="w-3 h-3 bg-amber-500 rounded-full"></span>
            <span className="w-12 h-1 bg-amber-400 rounded-full"></span>
          </div>
        </div>

        {/* Certifications Grid */}
        <div ref={ref} className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
          {certifications.map((cert, index) => (
            <div
              key={index}
              className={`group relative rounded-3xl p-7 ${cert.bg} ${cert.border} border-2 hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 cursor-pointer overflow-hidden ${
                isVisible ? "animate-fade-in-up" : "opacity-0"
              }`}
              style={{ animationDelay: `${index * 150}ms` }}
            >
              {/* Hover Gradient */}
              <div className={`absolute inset-0 bg-gradient-to-br ${cert.color} opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl`}></div>

              <div className="relative">
                <div className="flex items-center justify-between mb-4">
                  <span className="text-4xl group-hover:scale-110 transition-transform duration-300 inline-block">
                    {cert.icon}
                  </span>
                  <span className="text-xs font-bold text-gray-400 group-hover:text-white/70 transition-colors bg-white/80 group-hover:bg-white/20 px-3 py-1 rounded-full">
                    {cert.year}
                  </span>
                </div>
                <h3 className="text-2xl font-black text-gray-800 group-hover:text-white transition-colors mb-1">
                  {cert.name}
                </h3>
                <p className="text-sm font-bold text-gray-500 group-hover:text-white/80 transition-colors mb-3">
                  {cert.fullName}
                </p>
                <p className="text-gray-500 text-xs leading-relaxed group-hover:text-white/60 transition-colors">
                  {cert.desc}
                </p>
              </div>
            </div>
          ))}
        </div>

        {/* Awards Section */}
        <div className="bg-gradient-to-l from-gray-900 to-gray-800 rounded-3xl p-8 md:p-12 relative overflow-hidden">
          <div className="absolute inset-0 opacity-[0.03]" style={{
            backgroundImage: `radial-gradient(circle, white 1px, transparent 1px)`,
            backgroundSize: '20px 20px'
          }}></div>

          <div className="relative">
            <div className="flex items-center gap-3 mb-8">
              <Award className="text-amber-400" size={28} />
              <h3 className="text-2xl font-bold text-white">جوائز التميز</h3>
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
              {awards.map((award, i) => (
                <div
                  key={i}
                  className={`bg-white/[0.05] rounded-2xl p-5 border border-white/10 hover:bg-white/[0.1] hover:border-amber-500/30 transition-all duration-300 group cursor-pointer ${
                    isVisible ? "animate-fade-in-up" : "opacity-0"
                  }`}
                  style={{ animationDelay: `${(i + 4) * 150}ms` }}
                >
                  <div className="flex items-center gap-2 mb-3">
                    <Star size={16} className="text-amber-400 fill-amber-400" />
                    <span className="text-amber-400 text-xs font-bold">{award.year}</span>
                  </div>
                  <h4 className="text-white font-bold text-sm mb-2 group-hover:text-amber-400 transition-colors">
                    {award.title}
                  </h4>
                  <p className="text-white/40 text-xs">{award.org}</p>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
