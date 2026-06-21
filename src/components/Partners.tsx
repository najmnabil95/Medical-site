import { useScrollReveal } from "../hooks/useScrollReveal";

export default function Partners() {
  const { ref, isVisible } = useScrollReveal();

  const partners = [
    { name: "JCI", sub: "الاعتماد الدولي", emoji: "🏆" },
    { name: "WHO", sub: "منظمة الصحة العالمية", emoji: "🌍" },
    { name: "CBAHI", sub: "المجلس المركزي", emoji: "🏛️" },
    { name: "MOH", sub: "وزارة الصحة", emoji: "🏥" },
    { name: "ISO", sub: "معايير الجودة", emoji: "✅" },
    { name: "HIMSS", sub: "التحول الرقمي", emoji: "💻" },
  ];

  return (
    <section className="py-16 bg-gray-50 border-y border-gray-100 overflow-hidden">
      <div className="max-w-7xl mx-auto px-4">
        <div className="text-center mb-10">
          <h3 className="text-lg font-bold text-gray-400">شركاؤنا واعتماداتنا الدولية</h3>
          <div className="flex items-center justify-center gap-2 mt-3">
            <span className="w-8 h-0.5 bg-gray-200 rounded-full"></span>
            <span className="w-2 h-2 bg-primary-500 rounded-full"></span>
            <span className="w-8 h-0.5 bg-gray-200 rounded-full"></span>
          </div>
        </div>
        <div ref={ref} className="grid grid-cols-3 md:grid-cols-6 gap-6 items-center">
          {partners.map((partner, index) => (
            <div
              key={index}
              className={`flex flex-col items-center justify-center group cursor-pointer ${
                isVisible ? "animate-fade-in-up" : "opacity-0"
              }`}
              style={{ animationDelay: `${index * 100}ms` }}
            >
              <div className="w-22 h-22 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center justify-center group-hover:shadow-xl group-hover:-translate-y-2 group-hover:border-primary-200 transition-all duration-300 w-[88px] h-[88px]">
                <span className="text-xl mb-1">{partner.emoji}</span>
                <span className="text-lg font-black text-gray-300 group-hover:text-primary-600 transition-colors">
                  {partner.name}
                </span>
              </div>
              <span className="text-xs text-gray-400 mt-2 font-medium">{partner.sub}</span>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
