import { Home, Phone, Shield, Heart, Clock, UserCheck, Check } from "lucide-react";
import { useScrollReveal } from "../hooks/useScrollReveal";
import { createScrollHandler } from "../utils/scroll";

const services = [
  { icon: Heart, title: "تمريض منزلي", desc: "تمريض مؤهل على مدار الساعة" },
  { icon: UserCheck, title: "رعاية كبار السن", desc: "رعاية متخصصة للمسنين" },
  { icon: Shield, title: "رعاية ما بعد الجراحة", desc: "متابعة بعد العمليات" },
  { icon: Clock, title: "زيارات طبية", desc: "أطباء يزورون منزلك" },
];

const features = [
  "طاقم تمريض مؤهل ومدرب",
  "أجهزة طبية منزلية حديثة",
  "متابعة مستمرة من الأطباء",
  "تقارير دورية للأهل",
  "دعم نفسي واجتماعي",
  "أدوية ومستلزمات طبية",
];

export default function HomeCare() {
  const { ref, isVisible } = useScrollReveal();

  return (
    <section className="py-24 bg-white relative overflow-hidden">
      <div className="absolute top-0 left-0 w-72 h-72 bg-teal-100/30 rounded-full blur-3xl"></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <div ref={ref} className="grid lg:grid-cols-2 gap-16 items-center">
          {/* Content */}
          <div className={`space-y-7 ${isVisible ? "animate-fade-in-up" : "opacity-0"}`}>
            <div>
              <span className="text-teal-600 font-bold text-sm bg-teal-100 px-5 py-2 rounded-full inline-block flex items-center gap-2">
                <Home size={16} />
                <span>رعاية منزلية</span>
              </span>
              <h2 className="text-3xl md:text-4xl lg:text-[2.75rem] font-black text-gray-900 mt-5 leading-tight">
                رعاية طبية
                <br />
                <span className="gradient-text">في منزلك</span>
              </h2>
              <p className="text-gray-500 mt-5 text-lg leading-relaxed">
                نقدم خدمات الرعاية الصحية المنزلية بأعلى معايير الجودة، مع طاقم تمريض مؤهل وأطباء
                متخصصين يصلون إلى منزلك لتقديم أفضل رعاية ممكنة.
              </p>
            </div>

            {/* Services Grid */}
            <div className="grid grid-cols-2 gap-4">
              {services.map((service, i) => (
                <div key={i} className="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all group">
                  <div className="w-12 h-12 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-xl flex items-center justify-center mb-3 shadow-lg group-hover:scale-110 transition-transform">
                    <service.icon className="text-white" size={22} />
                  </div>
                  <h4 className="font-bold text-gray-900 mb-1">{service.title}</h4>
                  <p className="text-gray-500 text-xs">{service.desc}</p>
                </div>
              ))}
            </div>

            <div className="flex flex-wrap gap-4">
              <a
                href="#contact"
                onClick={createScrollHandler("contact")}
                className="bg-gradient-to-l from-teal-500 to-emerald-600 text-white px-7 py-3.5 rounded-2xl font-bold hover:shadow-xl hover:shadow-teal-500/30 transition-all hover:-translate-y-1 flex items-center gap-2 cursor-pointer"
              >
                <Phone size={18} />
                <span>اطلب الخدمة</span>
              </a>
              <a
                href="tel:920012345"
                className="bg-white text-gray-700 border-2 border-gray-200 px-7 py-3.5 rounded-2xl font-bold hover:border-teal-500 hover:text-teal-600 transition-all flex items-center gap-2"
              >
                <span>اتصل بنا</span>
              </a>
            </div>
          </div>

          {/* Features List */}
          <div className={`relative ${isVisible ? "animate-slide-in-left" : "opacity-0"}`}>
            <div className="bg-gradient-to-br from-teal-500 to-emerald-600 rounded-3xl p-8 md:p-10 text-white shadow-2xl shadow-teal-500/20">
              <h3 className="text-2xl font-bold mb-6">لماذا تختار رعايتنا المنزلية؟</h3>
              <ul className="space-y-4">
                {features.map((feature, i) => (
                  <li key={i} className="flex items-start gap-3">
                    <div className="w-7 h-7 bg-white/20 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                      <Check size={14} className="text-white" />
                    </div>
                    <span className="text-white/90">{feature}</span>
                  </li>
                ))}
              </ul>

              <div className="mt-8 pt-6 border-t border-white/20">
                <div className="grid grid-cols-3 gap-4 text-center">
                  <div>
                    <div className="text-3xl font-black">+500</div>
                    <div className="text-xs text-white/70 mt-1">مريض</div>
                  </div>
                  <div>
                    <div className="text-3xl font-black">24/7</div>
                    <div className="text-xs text-white/70 mt-1">خدمة</div>
                  </div>
                  <div>
                    <div className="text-3xl font-black">98%</div>
                    <div className="text-xs text-white/70 mt-1">رضا</div>
                  </div>
                </div>
              </div>
            </div>

            {/* Decorative */}
            <div className="absolute -top-4 -right-4 w-24 h-24 bg-teal-200/40 rounded-2xl -z-10"></div>
            <div className="absolute -bottom-4 -left-4 w-20 h-20 bg-emerald-200/40 rounded-2xl -z-10"></div>
          </div>
        </div>
      </div>
    </section>
  );
}
