import {
  Ambulance,
  Clock,
  FlaskConical,
  Scan,
  Bed,
  Truck,
  HeartPulse,
  Clipboard,
} from "lucide-react";
import SectionHeader from "./SectionHeader";
import { useScrollReveal } from "../hooks/useScrollReveal";
import { createScrollHandler } from "../utils/scroll";

const services = [
  {
    icon: Ambulance,
    title: "خدمة الإسعاف",
    desc: "سيارات إسعاف مجهزة بأحدث المعدات الطبية للنقل الآمن والسريع",
    color: "from-red-500 to-rose-600",
    number: "01",
  },
  {
    icon: Clock,
    title: "طوارئ 24/7",
    desc: "قسم طوارئ يعمل على مدار الساعة بفريق طبي متخصص ومؤهل",
    color: "from-orange-500 to-amber-600",
    number: "02",
  },
  {
    icon: FlaskConical,
    title: "مختبرات متقدمة",
    desc: "تحاليل طبية شاملة بأحدث الأجهزة ونتائج دقيقة وسريعة",
    color: "from-blue-500 to-indigo-600",
    number: "03",
  },
  {
    icon: Scan,
    title: "الأشعة والتصوير",
    desc: "أجهزة تصوير متطورة تشمل الرنين المغناطيسي والأشعة المقطعية",
    color: "from-purple-500 to-violet-600",
    number: "04",
  },
  {
    icon: Bed,
    title: "غرف إقامة فاخرة",
    desc: "غرف مريحة ومجهزة بالكامل لراحة المرضى خلال فترة الإقامة",
    color: "from-emerald-500 to-teal-600",
    number: "05",
  },
  {
    icon: Truck,
    title: "صيدلية متكاملة",
    desc: "صيدلية شاملة تعمل على مدار الساعة مع توصيل الأدوية للمنازل",
    color: "from-cyan-500 to-sky-600",
    number: "06",
  },
  {
    icon: HeartPulse,
    title: "العناية المركزة",
    desc: "وحدة عناية مركزة مجهزة بأحدث أجهزة المراقبة والدعم الحيوي",
    color: "from-pink-500 to-rose-600",
    number: "07",
  },
  {
    icon: Clipboard,
    title: "السجلات الإلكترونية",
    desc: "نظام إلكتروني متكامل لإدارة سجلات المرضى بكفاءة وأمان",
    color: "from-indigo-500 to-blue-600",
    number: "08",
  },
];

export default function Services() {
  const { ref, isVisible } = useScrollReveal();

  return (
    <section id="services" className="py-24 bg-gradient-to-b from-primary-800 via-primary-900 to-gray-900 relative overflow-hidden">
      {/* Decorative */}
      <div className="absolute top-0 left-0 w-96 h-96 bg-primary-600/15 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
      <div className="absolute bottom-0 right-0 w-96 h-96 bg-accent-500/8 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
      <div className="absolute inset-0 opacity-[0.03]" style={{
        backgroundImage: `radial-gradient(circle, white 1px, transparent 1px)`,
        backgroundSize: '30px 30px'
      }}></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <SectionHeader
          badge="خدماتنا"
          title="خدمات طبية"
          highlight="متميزة"
          description="نقدم مجموعة متكاملة من الخدمات الطبية والمساندة لضمان حصولكم على أفضل رعاية ممكنة"
          light
        />

        <div ref={ref} className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          {services.map((service, index) => (
            <div
              key={index}
              className={`group bg-white/[0.04] backdrop-blur-sm rounded-2xl p-7 border border-white/[0.08] hover:bg-white/[0.1] hover:border-white/20 transition-all duration-500 hover:-translate-y-3 cursor-pointer relative overflow-hidden ${
                isVisible ? "animate-fade-in-up" : "opacity-0"
              }`}
              style={{ animationDelay: `${index * 100}ms` }}
            >
              {/* Number */}
              <span className="absolute top-4 left-4 text-[3rem] font-black text-white/[0.03] group-hover:text-white/[0.08] transition-colors">
                {service.number}
              </span>

              {/* Shimmer on hover */}
              <div className="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity animate-shimmer rounded-2xl"></div>

              <div className="relative">
                <div
                  className={`w-14 h-14 bg-gradient-to-br ${service.color} rounded-2xl flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300`}
                >
                  <service.icon className="text-white" size={26} />
                </div>
                <h3 className="text-lg font-bold text-white mb-3 group-hover:text-accent-400 transition-colors">
                  {service.title}
                </h3>
                <p className="text-white/40 text-sm leading-relaxed group-hover:text-white/60 transition-colors">{service.desc}</p>
              </div>
            </div>
          ))}
        </div>

        {/* CTA */}
        <div className="text-center mt-16">
          <a
            href="#contact"
            onClick={createScrollHandler("contact")}
            className="inline-flex items-center gap-3 bg-gradient-to-l from-accent-500 to-accent-600 text-white px-10 py-4.5 rounded-2xl font-bold text-lg hover:shadow-2xl hover:shadow-accent-500/30 transition-all duration-300 hover:-translate-y-1 cursor-pointer"
          >
            <span>تعرف على المزيد من خدماتنا</span>
            <span className="text-xl">←</span>
          </a>
        </div>
      </div>
    </section>
  );
}
