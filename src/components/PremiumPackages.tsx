import { Check, Crown, Star, ArrowLeft } from "lucide-react";
import SectionHeader from "./SectionHeader";
import { useScrollReveal } from "../hooks/useScrollReveal";
import { createScrollHandler } from "../utils/scroll";

const packages = [
  {
    name: "الباقة الأساسية",
    nameEn: "Basic",
    price: "500",
    period: "سنوياً",
    icon: "🩺",
    popular: false,
    gradient: "from-gray-600 to-gray-800",
    features: [
      "كشف طبي شامل سنوي",
      "تحاليل دم أساسية",
      "أشعة صدر",
      "قياس ضغط الدم والسكر",
      "تقرير طبي مفصل",
      "خصم 10% على الخدمات",
    ],
  },
  {
    name: "الباقة الذهبية",
    nameEn: "Gold",
    price: "1,500",
    period: "سنوياً",
    icon: "👑",
    popular: true,
    gradient: "from-amber-500 to-yellow-600",
    features: [
      "كشف طبي شامل مرتين سنوياً",
      "تحاليل دم شاملة مع الهرمونات",
      "تصوير بالموجات فوق الصوتية",
      "فحص القلب (ECG)",
      "فحص العيون الشامل",
      "خصم 25% على جميع الخدمات",
      "أولوية في حجز المواعيد",
      "استشارة طبية عن بُعد مجانية",
    ],
  },
  {
    name: "الباقة البلاتينية",
    nameEn: "Platinum",
    price: "3,000",
    period: "سنوياً",
    icon: "💎",
    popular: false,
    gradient: "from-violet-600 to-purple-800",
    features: [
      "كشف طبي شامل 4 مرات سنوياً",
      "جميع التحاليل والفحوصات",
      "تصوير بالرنين المغناطيسي",
      "فحص القلب بالإيكو",
      "فحص كثافة العظام",
      "خصم 40% على جميع الخدمات",
      "غرفة VIP عند التنويم",
      "طبيب خاص ومنسق رعاية",
      "خدمة نقل من وإلى المستشفى",
      "استشارات طبية غير محدودة",
    ],
  },
];

export default function PremiumPackages() {
  const { ref, isVisible } = useScrollReveal();

  return (
    <section className="py-24 bg-gradient-to-b from-gray-900 via-gray-900 to-primary-900 relative overflow-hidden">
      {/* Decorative */}
      <div className="absolute inset-0 pointer-events-none">
        <div className="absolute top-1/4 right-0 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl"></div>
        <div className="absolute bottom-0 left-1/4 w-96 h-96 bg-purple-500/5 rounded-full blur-3xl"></div>
        <div className="absolute inset-0 opacity-[0.02]" style={{
          backgroundImage: `radial-gradient(circle, white 1px, transparent 1px)`,
          backgroundSize: '40px 40px'
        }}></div>
      </div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <SectionHeader
          badge="باقات الفحص الشامل"
          title="باقات صحية"
          highlight="مميزة"
          description="اختر الباقة المناسبة لك واحصل على فحص طبي شامل بأسعار مميزة"
          light
        />

        <div ref={ref} className="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
          {packages.map((pkg, index) => (
            <div
              key={index}
              className={`relative rounded-3xl overflow-hidden transition-all duration-500 hover:-translate-y-4 ${
                pkg.popular
                  ? "bg-gradient-to-b from-amber-500/10 to-amber-500/5 border-2 border-amber-500/30 scale-105 md:scale-110 z-10 shadow-2xl shadow-amber-500/10"
                  : "bg-white/[0.04] border border-white/10 hover:border-white/20"
              } ${isVisible ? "animate-fade-in-up" : "opacity-0"}`}
              style={{ animationDelay: `${index * 200}ms` }}
            >
              {/* Popular Badge */}
              {pkg.popular && (
                <div className="absolute top-0 left-0 right-0 bg-gradient-to-l from-amber-500 to-yellow-500 py-2 text-center">
                  <div className="flex items-center justify-center gap-2 text-sm font-bold text-gray-900">
                    <Crown size={16} />
                    <span>الأكثر طلباً</span>
                    <Star size={14} className="fill-gray-900" />
                  </div>
                </div>
              )}

              <div className={`p-8 ${pkg.popular ? "pt-16" : "pt-8"}`}>
                {/* Icon & Name */}
                <div className="text-center mb-6">
                  <span className="text-4xl block mb-3">{pkg.icon}</span>
                  <h3 className="text-xl font-bold text-white">{pkg.name}</h3>
                  <p className="text-white/30 text-xs tracking-wider mt-1">{pkg.nameEn}</p>
                </div>

                {/* Price */}
                <div className="text-center mb-8">
                  <div className="flex items-baseline justify-center gap-1">
                    <span className={`text-5xl font-black ${pkg.popular ? "gradient-text-gold" : "text-white"}`}>
                      {pkg.price}
                    </span>
                    <span className="text-white/40 text-sm">ر.س</span>
                  </div>
                  <p className="text-white/30 text-sm mt-1">{pkg.period}</p>
                </div>

                {/* Divider */}
                <div className={`h-px ${pkg.popular ? "bg-amber-500/20" : "bg-white/10"} mb-6`}></div>

                {/* Features */}
                <ul className="space-y-3 mb-8">
                  {pkg.features.map((feature, i) => (
                    <li key={i} className="flex items-start gap-3">
                      <Check size={16} className={`mt-0.5 shrink-0 ${pkg.popular ? "text-amber-400" : "text-accent-400"}`} />
                      <span className="text-white/70 text-sm">{feature}</span>
                    </li>
                  ))}
                </ul>

                {/* Button */}
                <a
                  href="#appointment"
                  onClick={createScrollHandler("appointment")}
                  className={`w-full py-4 rounded-2xl font-bold text-base flex items-center justify-center gap-2 transition-all duration-300 hover:-translate-y-1 group cursor-pointer ${
                    pkg.popular
                      ? "bg-gradient-to-l from-amber-500 to-yellow-500 text-gray-900 hover:shadow-xl hover:shadow-amber-500/30"
                      : "bg-white/10 text-white hover:bg-white/20 border border-white/10"
                  }`}
                >
                  <span>اشترك الآن</span>
                  <ArrowLeft size={16} className="group-hover:-translate-x-1 transition-transform" />
                </a>
              </div>
            </div>
          ))}
        </div>

        {/* Note */}
        <p className="text-center text-white/30 text-sm mt-10 max-w-2xl mx-auto">
          * جميع الأسعار شاملة ضريبة القيمة المضافة. يمكن تقسيط الباقات على دفعات شهرية. للمزيد من التفاصيل تواصل معنا.
        </p>
      </div>
    </section>
  );
}
