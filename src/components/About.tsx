import { CheckCircle2, Award, Users, Building2, Play } from "lucide-react";
import { useScrollReveal } from "../hooks/useScrollReveal";
import { createScrollHandler } from "../utils/scroll";

export default function About() {
  const { ref, isVisible } = useScrollReveal();

  const features = [
    "فريق طبي متخصص من أفضل الأطباء والاستشاريين",
    "أحدث الأجهزة والتقنيات الطبية العالمية",
    "غرف عمليات مجهزة بأعلى المعايير الدولية",
    "خدمة طوارئ متكاملة على مدار الساعة",
    "اعتماد دولي من الهيئة الدولية JCI",
    "برامج رعاية صحية شاملة ومتكاملة",
  ];

  return (
    <section id="about" className="py-24 bg-white relative overflow-hidden">
      {/* Decorative */}
      <div className="absolute top-0 left-0 w-80 h-80 bg-primary-50 rounded-full blur-3xl opacity-50"></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <div ref={ref} className="grid lg:grid-cols-2 gap-20 items-center">
          {/* Images Grid */}
          <div className={`relative ${isVisible ? "animate-fade-in-up" : "opacity-0"}`}>
            <div className="grid grid-cols-12 gap-4">
              <div className="col-span-7 space-y-4">
                <div className="rounded-3xl overflow-hidden shadow-2xl">
                  <img
                    src="https://images.pexels.com/photos/20081928/pexels-photo-20081928.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=420&w=380"
                    alt="فريق الجراحة"
                    className="w-full h-64 object-cover hover:scale-105 transition-transform duration-700"
                  />
                </div>
                <div className="rounded-3xl overflow-hidden shadow-2xl">
                  <img
                    src="https://images.pexels.com/photos/33216715/pexels-photo-33216715.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=320&w=380"
                    alt="معدات طبية"
                    className="w-full h-48 object-cover hover:scale-105 transition-transform duration-700"
                  />
                </div>
              </div>
              <div className="col-span-5 space-y-4 pt-10">
                <div className="rounded-3xl overflow-hidden shadow-2xl">
                  <img
                    src="https://images.pexels.com/photos/4769133/pexels-photo-4769133.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=320&w=300"
                    alt="جراحة"
                    className="w-full h-48 object-cover hover:scale-105 transition-transform duration-700"
                  />
                </div>
                <div className="rounded-3xl overflow-hidden shadow-2xl relative group cursor-pointer">
                  <img
                    src="https://images.pexels.com/photos/33216690/pexels-photo-33216690.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=420&w=300"
                    alt="غرفة علاج"
                    className="w-full h-64 object-cover hover:scale-105 transition-transform duration-700"
                  />
                  {/* Video Play Button */}
                  <div className="absolute inset-0 bg-black/30 flex items-center justify-center group-hover:bg-black/40 transition-all">
                    <div className="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform">
                      <Play className="text-primary-600 mr-[-2px]" size={28} fill="currentColor" />
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {/* Experience Badge */}
            <div className="absolute -bottom-4 right-8 bg-gradient-to-br from-primary-500 to-primary-700 text-white rounded-2xl p-6 shadow-2xl shadow-primary-500/30 animate-float">
              <div className="text-center">
                <div className="text-5xl font-black leading-none">25<span className="text-accent-400">+</span></div>
                <div className="text-sm font-medium opacity-90 mt-1">سنة من التميز</div>
                <div className="w-8 h-0.5 bg-accent-400 mx-auto mt-2 rounded-full"></div>
              </div>
            </div>
          </div>

          {/* Content */}
          <div className={`space-y-7 ${isVisible ? "animate-slide-in-left" : "opacity-0"}`}>
            <div>
              <span className="text-accent-600 font-bold text-sm tracking-wider bg-accent-100 px-5 py-2 rounded-full inline-block">
                من نحن
              </span>
              <h2 className="text-3xl md:text-4xl lg:text-[2.75rem] font-black text-gray-900 mt-5 leading-tight">
                نقدم أفضل رعاية صحية
                <br />
                <span className="gradient-text">لصحة أفضل لكم</span>
              </h2>
            </div>

            <p className="text-gray-600 text-lg leading-[1.9]">
              مستشفى الشفاء الدولي هو صرح طبي متكامل يقدم خدمات الرعاية الصحية وفق أعلى
              المعايير العالمية. تأسس المستشفى عام 1999 ويضم نخبة من أفضل الأطباء والاستشاريين
              في مختلف التخصصات الطبية، مع التزامنا الراسخ بتقديم أفضل تجربة علاجية لمرضانا.
            </p>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
              {features.map((feature, index) => (
                <div key={index} className="flex items-start gap-3 group p-2 rounded-xl hover:bg-accent-50 transition-colors">
                  <CheckCircle2
                    size={20}
                    className="text-accent-500 mt-0.5 shrink-0 group-hover:scale-110 transition-transform"
                  />
                  <span className="text-gray-700 text-sm font-medium leading-relaxed">{feature}</span>
                </div>
              ))}
            </div>

            {/* Stats Cards */}
            <div className="grid grid-cols-3 gap-4 pt-2">
              {[
                { icon: Award, value: "15+", label: "جائزة تميز", color: "primary", bg: "bg-primary-50", text: "text-primary-600", valueText: "text-primary-700" },
                { icon: Users, value: "200+", label: "طبيب متخصص", color: "accent", bg: "bg-accent-50", text: "text-accent-600", valueText: "text-accent-700" },
                { icon: Building2, value: "30+", label: "قسم طبي", color: "purple", bg: "bg-purple-50", text: "text-purple-600", valueText: "text-purple-700" },
              ].map((stat, i) => (
                <div key={i} className={`${stat.bg} rounded-2xl p-5 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-2 cursor-pointer group`}>
                  <stat.icon className={`mx-auto ${stat.text} mb-2 group-hover:scale-110 transition-transform`} size={28} />
                  <div className={`text-2xl font-black ${stat.valueText}`}>{stat.value}</div>
                  <div className="text-xs text-gray-500 mt-1 font-medium">{stat.label}</div>
                </div>
              ))}
            </div>

            <a
              href="#departments"
              onClick={createScrollHandler("departments")}
              className="inline-flex items-center gap-3 bg-gradient-to-l from-primary-500 to-primary-700 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-1 cursor-pointer"
            >
              <span>اكتشف أقسامنا</span>
              <span className="text-xl">←</span>
            </a>
          </div>
        </div>
      </div>
    </section>
  );
}
