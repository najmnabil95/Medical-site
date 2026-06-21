import { Phone, Calendar, ArrowLeft } from "lucide-react";
import { createScrollHandler } from "../utils/scroll";

export default function CTASection() {
  return (
    <section className="py-20 relative overflow-hidden">
      <div className="absolute inset-0 bg-gradient-to-l from-accent-600 via-accent-500 to-primary-600"></div>
      <div className="absolute inset-0 opacity-[0.05]" style={{
        backgroundImage: `radial-gradient(circle, white 1px, transparent 1px)`,
        backgroundSize: '25px 25px'
      }}></div>

      <div className="max-w-5xl mx-auto px-4 relative text-center text-white">
        <div className="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full border border-white/20 mb-6">
          <span className="w-2 h-2 bg-white rounded-full animate-pulse"></span>
          <span className="text-sm font-medium">نحن هنا لمساعدتك 24/7</span>
        </div>

        <h2 className="text-3xl md:text-4xl lg:text-5xl font-black leading-tight mb-6">
          صحتك أولويتنا
          <br />
          <span className="text-white/90">احجز موعدك اليوم</span>
        </h2>

        <p className="text-white/70 text-lg max-w-2xl mx-auto mb-10 leading-relaxed">
          فريقنا الطبي المتميز جاهز لتقديم أفضل رعاية صحية لك ولعائلتك.
          لا تؤجل صحة من تحب.
        </p>

        <div className="flex flex-wrap gap-4 justify-center">
          <a
            href="#appointment"
            onClick={createScrollHandler("appointment")}
            className="group bg-white text-primary-700 px-8 py-4 rounded-2xl font-bold text-lg hover:shadow-2xl hover:shadow-black/20 transition-all hover:-translate-y-1 flex items-center gap-3 cursor-pointer"
          >
            <Calendar size={22} />
            <span>احجز موعدك الآن</span>
            <ArrowLeft size={18} className="group-hover:-translate-x-1 transition-transform" />
          </a>
          <a
            href="tel:920012345"
            className="bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all border border-white/30 flex items-center gap-3"
          >
            <Phone size={22} />
            <span>اتصل بنا الآن</span>
          </a>
        </div>

        {/* Trust badges */}
        <div className="flex items-center justify-center gap-6 mt-12 text-white/60 text-sm">
          <div className="flex items-center gap-2">
            <span className="text-yellow-400">★★★★★</span>
            <span>4.9/5 تقييم المرضى</span>
          </div>
          <div className="hidden md:flex items-center gap-2">
            <span className="text-accent-400">✓</span>
            <span>+50 ألف مريض سعيد</span>
          </div>
          <div className="hidden md:flex items-center gap-2">
            <span className="text-accent-400">✓</span>
            <span>اعتماد JCI دولي</span>
          </div>
        </div>
      </div>
    </section>
  );
}
