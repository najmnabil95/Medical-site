import { Smartphone, Calendar, FileText, Bell, MapPin, MessageSquare } from "lucide-react";
import { useScrollReveal } from "../hooks/useScrollReveal";

const features = [
  { icon: Calendar, title: "حجز المواعيد", desc: "احجز موعدك بنقرة واحدة" },
  { icon: FileText, title: "التقارير الطبية", desc: "اطلع على نتائجك فوراً" },
  { icon: Bell, title: "التذكيرات", desc: "تنبيهات للمواعيد والأدوية" },
  { icon: MapPin, title: "الملاحة", desc: "توجه للمستشفى بسهولة" },
  { icon: MessageSquare, title: "استشارة عن بُعد", desc: "تحدث مع طبيبك أونلاين" },
  { icon: Smartphone, title: "السجل الطبي", desc: "ملفك الطبي في جيبك" },
];

export default function MobileApp() {
  const { ref, isVisible } = useScrollReveal();

  return (
    <section className="py-24 bg-gradient-to-br from-primary-800 via-primary-900 to-gray-900 relative overflow-hidden">
      {/* Decorative */}
      <div className="absolute inset-0 pointer-events-none">
        <div className="absolute top-0 right-1/4 w-96 h-96 bg-accent-500/5 rounded-full blur-3xl"></div>
        <div className="absolute bottom-0 left-1/4 w-96 h-96 bg-primary-500/10 rounded-full blur-3xl"></div>
        <div className="absolute inset-0 opacity-[0.03]" style={{
          backgroundImage: `radial-gradient(circle, white 1px, transparent 1px)`,
          backgroundSize: '40px 40px'
        }}></div>
      </div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <div ref={ref} className="grid lg:grid-cols-2 gap-16 items-center">
          {/* Content */}
          <div className={`space-y-8 ${isVisible ? "animate-fade-in-up" : "opacity-0"}`}>
            <div>
              <span className="text-accent-400 font-bold text-sm bg-accent-500/10 px-5 py-2 rounded-full">
                تطبيق المستشفى
              </span>
              <h2 className="text-3xl md:text-4xl lg:text-5xl font-black text-white mt-5 leading-tight">
                حمّل تطبيقنا
                <br />
                <span className="text-accent-400">وابقَ على تواصل</span>
              </h2>
              <p className="text-white/60 mt-5 text-lg leading-relaxed max-w-lg">
                احصل على جميع خدمات المستشفى في هاتفك. حجز المواعيد، الاطلاع على النتائج،
                الاستشارات عن بُعد والمزيد بنقرة واحدة.
              </p>
            </div>

            {/* Features Grid */}
            <div className="grid grid-cols-2 sm:grid-cols-3 gap-4">
              {features.map((feature, i) => (
                <div
                  key={i}
                  className="bg-white/[0.06] backdrop-blur-sm rounded-2xl p-4 border border-white/10 hover:bg-white/[0.1] transition-all duration-300 group cursor-pointer"
                >
                  <feature.icon className="text-accent-400 mb-3 group-hover:scale-110 transition-transform" size={24} />
                  <h4 className="text-white font-bold text-sm mb-1">{feature.title}</h4>
                  <p className="text-white/40 text-xs">{feature.desc}</p>
                </div>
              ))}
            </div>

            {/* Download Buttons */}
            <div className="flex flex-wrap gap-4">
              <button
                onClick={() => alert("سيتم توفير تطبيق App Store قريباً 🎉\nيمكنك الآن حجز موعدك عبر الموقع الإلكتروني." )}
                className="flex items-center gap-3 bg-white text-gray-900 px-6 py-3.5 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group"
              >
                <svg className="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
                </svg>
                <div className="text-right">
                  <p className="text-[10px] text-gray-500 leading-none">حمل من</p>
                  <p className="font-bold text-sm">App Store</p>
                </div>
              </button>
              <button
                onClick={() => alert("سيتم توفير تطبيق Google Play قريباً 🎉\nيمكنك الآن حجز موعدك عبر الموقع الإلكتروني." )}
                className="flex items-center gap-3 bg-white text-gray-900 px-6 py-3.5 rounded-2xl hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group"
              >
                <svg className="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M3.18 23.71c-.38-.21-.68-.66-.68-1.26V1.55c0-.6.3-1.05.68-1.26l11.07 11.71L3.18 23.71zm1.44-23.16L15.7 11.12l-2.84 2.84L4.62.55zM20.16 10.12l-3.03 1.75-3.2-3.38 3.2-3.38 3.03 1.75c.84.49.84 1.77 0 2.26v1zm-3.03 2.37l-3.2 3.38-8.44 4.84 11.64-8.22z"/>
                </svg>
                <div className="text-right">
                  <p className="text-[10px] text-gray-500 leading-none">حمل من</p>
                  <p className="font-bold text-sm">Google Play</p>
                </div>
              </button>
            </div>
          </div>

          {/* Phone Mockup */}
          <div className={`flex justify-center ${isVisible ? "animate-slide-in-left" : "opacity-0"}`}>
            <div className="relative">
              {/* Phone Frame */}
              <div className="w-72 h-[560px] bg-gradient-to-b from-gray-800 to-gray-900 rounded-[3rem] p-3 shadow-2xl shadow-black/50 border border-gray-700">
                <div className="w-full h-full bg-gradient-to-b from-primary-600 to-primary-800 rounded-[2.4rem] overflow-hidden relative">
                  {/* Status Bar */}
                  <div className="flex items-center justify-between px-6 py-3">
                    <span className="text-white text-xs font-bold">9:41</span>
                    <div className="w-20 h-5 bg-black rounded-full"></div>
                    <div className="flex gap-1">
                      <div className="w-4 h-2 bg-white/60 rounded-sm"></div>
                      <div className="w-4 h-2 bg-white/60 rounded-sm"></div>
                    </div>
                  </div>
                  {/* App Content */}
                  <div className="px-5 pt-4 space-y-4">
                    <div className="flex items-center gap-3">
                      <div className="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center text-lg">🏥</div>
                      <div>
                        <h4 className="text-white font-bold text-sm">مستشفى الشفاء</h4>
                        <p className="text-white/50 text-xs">مرحباً، محمد 👋</p>
                      </div>
                    </div>
                    <div className="bg-white/10 rounded-2xl p-4 border border-white/10">
                      <p className="text-accent-400 text-xs font-bold mb-2">موعدك القادم</p>
                      <p className="text-white font-bold text-sm">د. أحمد الراشد</p>
                      <p className="text-white/50 text-xs">أمراض القلب • الأحد 10:00 ص</p>
                    </div>
                    <div className="grid grid-cols-3 gap-2">
                      {["حجز موعد", "تقاريري", "الأطباء"].map((label, i) => (
                        <div key={i} className="bg-white/10 rounded-xl p-3 text-center border border-white/5">
                          <div className="w-8 h-8 bg-white/10 rounded-lg mx-auto mb-2 flex items-center justify-center text-xs">
                            {["📅", "📋", "👨‍⚕️"][i]}
                          </div>
                          <p className="text-white text-[10px] font-medium">{label}</p>
                        </div>
                      ))}
                    </div>
                    <div className="bg-white/10 rounded-2xl p-4 border border-white/10">
                      <p className="text-white/60 text-xs mb-2">آخر النتائج</p>
                      <div className="space-y-2">
                        <div className="flex items-center justify-between">
                          <span className="text-white text-xs">تحليل الدم</span>
                          <span className="text-accent-400 text-xs font-bold">طبيعي ✓</span>
                        </div>
                        <div className="flex items-center justify-between">
                          <span className="text-white text-xs">أشعة الصدر</span>
                          <span className="text-accent-400 text-xs font-bold">طبيعي ✓</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {/* Glow effect */}
              <div className="absolute -inset-8 bg-gradient-to-b from-accent-500/10 to-primary-500/10 rounded-full blur-3xl -z-10"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
