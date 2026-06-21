import { Plane, Heart, Globe, Shield, Star, ArrowLeft } from "lucide-react";
import { useScrollReveal } from "../hooks/useScrollReveal";
import { createScrollHandler } from "../utils/scroll";

const features = [
  { icon: Shield, title: "رعاية عالمية", desc: "معايير صحية عالمية معتمدة من JCI" },
  { icon: Star, title: "أطباء خبراء", desc: "نخبة من أفضل الأطباء على المستوى الدولي" },
  { icon: Globe, title: "دعم متعدد اللغات", desc: "خدمات بلغات متعددة لراحتك" },
  { icon: Heart, title: "رعاية شاملة", desc: "من الاستقبال حتى المغادرة" },
];

export default function MedicalTourism() {
  const { ref, isVisible } = useScrollReveal();

  return (
    <section className="py-24 bg-gradient-to-l from-primary-900 via-primary-800 to-primary-700 relative overflow-hidden">
      <div className="absolute inset-0 opacity-[0.03]" style={{
        backgroundImage: `radial-gradient(circle, white 1px, transparent 1px)`,
        backgroundSize: '30px 30px'
      }}></div>
      <div className="absolute top-0 left-0 w-80 h-80 bg-accent-500/5 rounded-full blur-3xl"></div>

      <div className="max-w-7xl mx-auto px-4 relative" ref={ref}>
        <div className="grid lg:grid-cols-2 gap-16 items-center">
          {/* Content */}
          <div className={`text-white space-y-7 ${isVisible ? "animate-fade-in-up" : "opacity-0"}`}>
            <span className="inline-flex items-center gap-2 text-accent-400 font-bold text-sm bg-accent-500/10 px-5 py-2 rounded-full">
              <Plane size={16} />
              <span>السياحة العلاجية</span>
            </span>

            <h2 className="text-3xl md:text-4xl lg:text-5xl font-black leading-tight">
              رحلتك العلاجية
              <br />
              <span className="text-accent-400">تبدأ من هنا</span>
            </h2>

            <p className="text-white/70 text-lg leading-relaxed">
              نقدم خدمات شاملة للسياحة العلاجية تشمل الاستقبال من المطار، الإقامة، الرعاية الطبية،
              والجولات السياحية. استمتع بأفضل رعاية طبية في بيئة مريحة وآمنة.
            </p>

            <div className="grid grid-cols-2 gap-4">
              {features.map((feature, i) => (
                <div key={i} className="bg-white/5 backdrop-blur-sm rounded-2xl p-5 border border-white/10 hover:bg-white/10 transition-all">
                  <div className="w-12 h-12 bg-gradient-to-br from-accent-500 to-accent-600 rounded-xl flex items-center justify-center mb-3 shadow-lg">
                    <feature.icon className="text-white" size={22} />
                  </div>
                  <h4 className="font-bold mb-1">{feature.title}</h4>
                  <p className="text-white/50 text-xs">{feature.desc}</p>
                </div>
              ))}
            </div>

            <div className="flex flex-wrap gap-4 pt-2">
              <a href="#contact" onClick={createScrollHandler("contact")} className="bg-gradient-to-l from-accent-500 to-accent-600 text-white px-7 py-3.5 rounded-2xl font-bold hover:shadow-xl hover:shadow-accent-500/30 transition-all hover:-translate-y-1 flex items-center gap-2 cursor-pointer">
                <span>استفسر الآن</span>
                <ArrowLeft size={18} />
              </a>
              <div className="flex items-center gap-3">
                <div className="text-center">
                  <div className="text-3xl font-black text-accent-400">+1000</div>
                  <div className="text-xs text-white/50">مريض دولي</div>
                </div>
                <div className="h-10 w-px bg-white/10"></div>
                <div className="text-center">
                  <div className="text-3xl font-black text-accent-400">+30</div>
                  <div className="text-xs text-white/50">دولة</div>
                </div>
              </div>
            </div>
          </div>

          {/* Stats Cards */}
          <div className={`grid grid-cols-2 gap-4 ${isVisible ? "animate-slide-in-left" : "opacity-0"}`}>
            {[
              { value: "+50", label: "تخصص طبي", color: "from-blue-500 to-indigo-600" },
              { value: "24/7", label: "دعم دولي", color: "from-emerald-500 to-teal-600" },
              { value: "+98%", label: "نسبة النجاح", color: "from-amber-500 to-orange-600" },
              { value: "+15", label: "لغة مدعومة", color: "from-purple-500 to-violet-600" },
            ].map((stat, i) => (
              <div key={i} className="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/15 transition-all hover:-translate-y-1">
                <div className={`w-14 h-14 bg-gradient-to-br ${stat.color} rounded-2xl flex items-center justify-center mb-4 shadow-lg`}>
                  <span className="text-white font-black text-lg">{stat.value.slice(0, 2)}</span>
                </div>
                <div className="text-3xl font-black text-white mb-1">{stat.value}</div>
                <div className="text-white/50 text-sm">{stat.label}</div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
