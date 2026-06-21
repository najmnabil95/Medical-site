import { Shield, Clock, Award, Heart, Zap, Users, ThumbsUp, Headphones } from "lucide-react";
import SectionHeader from "./SectionHeader";
import { useScrollReveal } from "../hooks/useScrollReveal";

const reasons = [
  {
    icon: Shield,
    title: "اعتماد دولي JCI",
    desc: "حاصلون على الاعتماد الدولي من الهيئة الدولية لاعتماد المؤسسات الصحية",
    color: "from-blue-500 to-indigo-600",
    bg: "bg-blue-50",
  },
  {
    icon: Clock,
    title: "خدمة على مدار الساعة",
    desc: "طوارئ وعناية مركزة تعمل 24 ساعة طوال أيام الأسبوع",
    color: "from-red-500 to-rose-600",
    bg: "bg-red-50",
  },
  {
    icon: Award,
    title: "خبرة +25 سنة",
    desc: "أكثر من ربع قرن من الخبرة في تقديم الرعاية الصحية المتميزة",
    color: "from-amber-500 to-orange-600",
    bg: "bg-amber-50",
  },
  {
    icon: Heart,
    title: "رعاية إنسانية",
    desc: "نضع المريض في قلب اهتمامنا ونتعامل بمنتهى الإنسانية والاحترام",
    color: "from-pink-500 to-rose-600",
    bg: "bg-pink-50",
  },
  {
    icon: Zap,
    title: "أحدث التقنيات",
    desc: "نستخدم أحدث الأجهزة والتقنيات الطبية المتطورة في العالم",
    color: "from-purple-500 to-violet-600",
    bg: "bg-purple-50",
  },
  {
    icon: Users,
    title: "+200 طبيب متخصص",
    desc: "فريق طبي متكامل من أمهر الاستشاريين في مختلف التخصصات",
    color: "from-emerald-500 to-teal-600",
    bg: "bg-emerald-50",
  },
  {
    icon: ThumbsUp,
    title: "نسبة رضا 98%",
    desc: "نفتخر بنسبة رضا مرضانا العالية التي تعكس جودة خدماتنا",
    color: "from-cyan-500 to-sky-600",
    bg: "bg-cyan-50",
  },
  {
    icon: Headphones,
    title: "دعم فني متواصل",
    desc: "فريق خدمة عملاء متاح لمساعدتكم والرد على استفساراتكم",
    color: "from-indigo-500 to-blue-600",
    bg: "bg-indigo-50",
  },
];

export default function WhyChooseUs() {
  const { ref, isVisible } = useScrollReveal();

  return (
    <section className="py-24 bg-gradient-to-b from-white to-gray-50 relative overflow-hidden">
      {/* Decorative Background */}
      <div className="absolute top-0 left-0 w-72 h-72 bg-primary-100/40 rounded-full blur-3xl"></div>
      <div className="absolute bottom-0 right-0 w-72 h-72 bg-accent-100/40 rounded-full blur-3xl"></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <SectionHeader
          badge="لماذا تختارنا"
          title="أسباب تجعلنا"
          highlight="خيارك الأول"
          description="نلتزم بأعلى معايير الجودة والسلامة لنقدم لكم تجربة علاجية استثنائية"
        />

        <div
          ref={ref}
          className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"
        >
          {reasons.map((reason, index) => (
            <div
              key={index}
              className={`group bg-white rounded-3xl p-7 shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-gray-100 cursor-pointer relative overflow-hidden ${
                isVisible ? "animate-fade-in-up" : "opacity-0"
              }`}
              style={{ animationDelay: `${index * 100}ms` }}
            >
              {/* Hover background */}
              <div className={`absolute inset-0 bg-gradient-to-br ${reason.color} opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl`}></div>

              <div className="relative">
                <div
                  className={`w-16 h-16 ${reason.bg} group-hover:bg-white/20 rounded-2xl flex items-center justify-center mb-5 transition-all duration-300 group-hover:scale-110 group-hover:rotate-6`}
                >
                  <reason.icon className={`text-gray-700 group-hover:text-white transition-colors`} size={30} />
                </div>
                <h3 className="text-lg font-bold text-gray-900 mb-3 group-hover:text-white transition-colors">
                  {reason.title}
                </h3>
                <p className="text-gray-500 text-sm leading-relaxed group-hover:text-white/80 transition-colors">
                  {reason.desc}
                </p>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
