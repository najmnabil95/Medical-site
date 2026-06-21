import SectionHeader from "./SectionHeader";
import { useScrollReveal } from "../hooks/useScrollReveal";

const milestones = [
  {
    year: "1999",
    title: "تأسيس المستشفى",
    desc: "تم تأسيس مستشفى الشفاء الدولي بطاقة استيعابية 100 سرير",
    icon: "🏗️",
  },
  {
    year: "2005",
    title: "أول اعتماد JCI",
    desc: "حصلنا على أول اعتماد دولي من الهيئة الدولية لاعتماد المؤسسات الصحية",
    icon: "🏆",
  },
  {
    year: "2010",
    title: "التوسعة الأولى",
    desc: "توسعة المستشفى لتصل الطاقة الاستيعابية إلى 300 سرير مع أقسام جديدة",
    icon: "📈",
  },
  {
    year: "2015",
    title: "مركز القلب",
    desc: "افتتاح مركز القلب المتخصص المجهز بأحدث تقنيات قسطرة القلب والجراحة",
    icon: "❤️",
  },
  {
    year: "2020",
    title: "التحول الرقمي",
    desc: "إطلاق تطبيق المستشفى والسجلات الطبية الإلكترونية والاستشارات عن بُعد",
    icon: "📱",
  },
  {
    year: "2024",
    title: "الريادة الطبية",
    desc: "أكثر من 200 طبيب و30 قسم طبي ونسبة رضا مرضى تتجاوز 98%",
    icon: "⭐",
  },
];

export default function Timeline() {
  const { ref, isVisible } = useScrollReveal();

  return (
    <section className="py-24 bg-white relative overflow-hidden">
      <div className="absolute top-0 left-1/2 w-px h-full bg-gray-100 hidden lg:block"></div>

      <div className="max-w-7xl mx-auto px-4">
        <SectionHeader
          badge="مسيرتنا"
          title="رحلة"
          highlight="25 عاماً من التميز"
          description="نفخر بمسيرة حافلة بالإنجازات والنجاحات المتتالية"
        />

        <div ref={ref} className="relative max-w-4xl mx-auto">
          {/* Center Line */}
          <div className="absolute right-1/2 translate-x-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-primary-500 via-accent-500 to-primary-500 hidden md:block"></div>

          {milestones.map((milestone, index) => (
            <div
              key={index}
              className={`relative flex items-center mb-12 last:mb-0 ${
                index % 2 === 0 ? "md:flex-row" : "md:flex-row-reverse"
              } flex-col md:gap-0 gap-4 ${
                isVisible ? "animate-fade-in-up" : "opacity-0"
              }`}
              style={{ animationDelay: `${index * 150}ms` }}
            >
              {/* Content */}
              <div className={`md:w-1/2 ${index % 2 === 0 ? "md:pr-12 md:text-right" : "md:pl-12 md:text-left"}`}>
                <div className="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                  <div className="flex items-center gap-3 mb-3">
                    <span className="text-2xl">{milestone.icon}</span>
                    <span className="text-sm font-bold text-primary-600 bg-primary-50 px-3 py-1 rounded-full">
                      {milestone.year}
                    </span>
                  </div>
                  <h3 className="text-xl font-bold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
                    {milestone.title}
                  </h3>
                  <p className="text-gray-500 text-sm leading-relaxed">{milestone.desc}</p>
                </div>
              </div>

              {/* Center Dot */}
              <div className="hidden md:flex absolute right-1/2 translate-x-1/2 w-5 h-5 bg-gradient-to-br from-primary-500 to-accent-500 rounded-full border-4 border-white shadow-lg z-10"></div>

              {/* Empty Space */}
              <div className="md:w-1/2 hidden md:block"></div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
