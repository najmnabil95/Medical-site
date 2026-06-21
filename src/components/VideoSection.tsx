import { useState } from "react";
import { Play, X, Award, Users, Clock, Heart } from "lucide-react";
import { useScrollReveal } from "../hooks/useScrollReveal";

export default function VideoSection() {
  const [showVideo, setShowVideo] = useState(false);
  const { ref, isVisible } = useScrollReveal();

  return (
    <section className="py-24 relative overflow-hidden">
      {/* Background */}
      <div className="absolute inset-0">
        <img
          src="https://images.pexels.com/photos/36488764/pexels-photo-36488764.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=800&w=1600"
          alt="مبنى المستشفى"
          className="w-full h-full object-cover"
        />
        <div className="absolute inset-0 bg-gradient-to-l from-primary-900/95 via-primary-900/85 to-primary-800/80"></div>
      </div>

      <div className="max-w-7xl mx-auto px-4 relative" ref={ref}>
        <div className="grid lg:grid-cols-2 gap-16 items-center">
          {/* Video Player */}
          <div className={`relative ${isVisible ? "animate-fade-in-up" : "opacity-0"}`}>
            <div className="relative rounded-3xl overflow-hidden shadow-2xl group cursor-pointer" onClick={() => setShowVideo(true)}>
              <img
                src="https://images.pexels.com/photos/31836902/pexels-photo-31836902.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700"
                alt="جولة في المستشفى"
                className="w-full h-80 object-cover group-hover:scale-105 transition-transform duration-700"
              />
              <div className="absolute inset-0 bg-black/30 group-hover:bg-black/40 transition-colors flex items-center justify-center">
                {/* Play Button */}
                <div className="relative">
                  <div className="w-20 h-20 bg-white/90 rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-300">
                    <Play className="text-primary-600 mr-[-3px]" size={32} fill="currentColor" />
                  </div>
                  {/* Ripple */}
                  <div className="absolute inset-0 border-2 border-white/40 rounded-full animate-ripple"></div>
                  <div className="absolute inset-0 border-2 border-white/20 rounded-full animate-ripple animation-delay-500"></div>
                </div>
              </div>

              {/* Label */}
              <div className="absolute bottom-5 right-5 bg-white/90 backdrop-blur-sm rounded-xl px-4 py-2 flex items-center gap-2">
                <Play size={14} className="text-primary-600" fill="currentColor" />
                <span className="text-sm font-bold text-gray-800">شاهد الجولة الافتراضية</span>
              </div>
            </div>

            {/* Decorative */}
            <div className="absolute -bottom-4 -left-4 w-24 h-24 bg-accent-500/20 rounded-2xl -z-10"></div>
            <div className="absolute -top-4 -right-4 w-16 h-16 bg-primary-500/20 rounded-2xl -z-10"></div>
          </div>

          {/* Content */}
          <div className={`text-white space-y-8 ${isVisible ? "animate-slide-in-left" : "opacity-0"}`}>
            <div>
              <span className="text-accent-400 font-bold text-sm bg-accent-500/10 px-5 py-2 rounded-full inline-block">
                تعرف علينا
              </span>
              <h2 className="text-3xl md:text-4xl lg:text-[2.75rem] font-black mt-5 leading-tight">
                جولة افتراضية داخل
                <br />
                <span className="text-accent-400">مستشفى الشفاء</span>
              </h2>
              <p className="text-white/60 mt-5 text-lg leading-relaxed max-w-lg">
                شاهد مرافقنا المتطورة وتجهيزاتنا الحديثة واكتشف لماذا نحن الخيار الأول للرعاية
                الصحية المتميزة في المملكة
              </p>
            </div>

            {/* Quick Stats */}
            <div className="grid grid-cols-2 gap-4">
              {[
                { icon: Award, value: "3x", label: "اعتماد JCI متتالي" },
                { icon: Users, value: "200+", label: "طبيب واستشاري" },
                { icon: Clock, value: "24/7", label: "خدمة طوارئ" },
                { icon: Heart, value: "98%", label: "نسبة رضا المرضى" },
              ].map((stat, i) => (
                <div key={i} className="flex items-center gap-3 bg-white/[0.06] rounded-xl p-4 border border-white/10">
                  <stat.icon className="text-accent-400 shrink-0" size={22} />
                  <div>
                    <div className="text-xl font-black text-white">{stat.value}</div>
                    <div className="text-white/40 text-xs">{stat.label}</div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>

      {/* Video Modal */}
      {showVideo && (
        <div className="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-4" onClick={() => setShowVideo(false)}>
          <button
            onClick={() => setShowVideo(false)}
            className="absolute top-6 left-6 w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all"
          >
            <X size={24} />
          </button>
          <div onClick={(e) => e.stopPropagation()} className="w-full max-w-4xl animate-scale-in">
            <div className="bg-gray-900 rounded-2xl p-8 text-center">
              <Play className="text-white/20 mx-auto mb-4" size={60} />
              <h3 className="text-white text-xl font-bold mb-2">جولة افتراضية في مستشفى الشفاء</h3>
              <p className="text-white/40 text-sm">سيتم تشغيل الفيديو التعريفي هنا</p>
              <div className="mt-6 aspect-video bg-gray-800 rounded-xl flex items-center justify-center">
                <div className="text-center">
                  <div className="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <Play className="text-white/60" size={40} fill="currentColor" />
                  </div>
                  <p className="text-white/30 text-sm">الفيديو التعريفي للمستشفى</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}
    </section>
  );
}
