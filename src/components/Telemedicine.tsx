import { useState } from "react";
import { Video, Shield, Clock, Globe, Smartphone, CreditCard, ArrowLeft } from "lucide-react";
import { useScrollReveal } from "../hooks/useScrollReveal";
import TelemedicineModal from "./TelemedicineModal";

const steps = [
  {
    step: "01",
    icon: Smartphone,
    title: "سجّل حسابك",
    desc: "أنشئ حسابك على تطبيق المستشفى أو الموقع الإلكتروني بخطوات بسيطة",
  },
  {
    step: "02",
    icon: Clock,
    title: "اختر موعدك",
    desc: "حدد التخصص المطلوب واختر الطبيب والموعد المناسب لك",
  },
  {
    step: "03",
    icon: Video,
    title: "ابدأ الاستشارة",
    desc: "تواصل مع طبيبك عبر مكالمة فيديو آمنة ومشفرة بجودة عالية",
  },
  {
    step: "04",
    icon: CreditCard,
    title: "استلم الوصفة",
    desc: "احصل على التشخيص والوصفة الطبية إلكترونياً مع التقرير الطبي",
  },
];

export default function Telemedicine() {
  const { ref, isVisible } = useScrollReveal();
  const [modalOpen, setModalOpen] = useState(false);

  return (
    <section className="py-24 bg-gradient-to-b from-white to-primary-50/50 relative overflow-hidden">
      {/* Decorative */}
      <div className="absolute top-0 left-1/3 w-72 h-72 bg-primary-100/40 rounded-full blur-3xl"></div>
      <div className="absolute bottom-0 right-1/4 w-72 h-72 bg-accent-100/30 rounded-full blur-3xl"></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <div ref={ref} className="grid lg:grid-cols-2 gap-16 items-center">
          {/* Content */}
          <div className={`space-y-8 ${isVisible ? "animate-fade-in-up" : "opacity-0"}`}>
            <div>
              <span className="text-primary-600 font-bold text-sm bg-primary-100 px-5 py-2 rounded-full inline-block">
                🩺 خدمة جديدة
              </span>
              <h2 className="text-3xl md:text-4xl lg:text-[2.75rem] font-black text-gray-900 mt-5 leading-tight">
                استشارات طبية
                <br />
                <span className="gradient-text">عن بُعد</span>
              </h2>
              <p className="text-gray-500 mt-5 text-lg leading-relaxed max-w-lg">
                الآن يمكنك استشارة أطبائنا المتخصصين من راحة منزلك عبر مكالمات فيديو آمنة ومشفرة.
                احصل على التشخيص والعلاج المناسب دون الحاجة لزيارة المستشفى.
              </p>
            </div>

            {/* Benefits */}
            <div className="grid grid-cols-2 gap-4">
              {[
                { icon: Shield, text: "خصوصية وأمان تام", color: "text-primary-600 bg-primary-50" },
                { icon: Clock, text: "توفير الوقت والجهد", color: "text-accent-600 bg-accent-50" },
                { icon: Globe, text: "من أي مكان في العالم", color: "text-purple-600 bg-purple-50" },
                { icon: Video, text: "فيديو عالي الجودة", color: "text-blue-600 bg-blue-50" },
              ].map((benefit, i) => (
                <div key={i} className="flex items-center gap-3 p-3 bg-white rounded-xl shadow-sm border border-gray-100">
                  <div className={`w-10 h-10 ${benefit.color} rounded-lg flex items-center justify-center shrink-0`}>
                    <benefit.icon size={18} />
                  </div>
                  <span className="text-gray-700 text-sm font-medium">{benefit.text}</span>
                </div>
              ))}
            </div>

            <div className="flex flex-wrap gap-4">
              <button
                onClick={() => setModalOpen(true)}
                className="group bg-gradient-to-l from-primary-500 to-primary-700 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-1 flex items-center gap-3"
              >
                <Video size={22} />
                <span>احجز استشارتك الآن</span>
                <ArrowLeft size={18} className="group-hover:-translate-x-1 transition-transform" />
              </button>
              <div className="flex items-center gap-2 text-gray-500 text-sm">
                <span className="text-accent-500 text-2xl font-black">99</span>
                <div>
                  <span className="text-gray-400 text-xs">ر.س فقط</span>
                  <br />
                  <span className="text-gray-500 text-xs font-medium">للاستشارة الواحدة</span>
                </div>
              </div>
            </div>
          </div>

          <TelemedicineModal isOpen={modalOpen} onClose={() => setModalOpen(false)} />

          {/* Steps */}
          <div className={`space-y-5 ${isVisible ? "animate-slide-in-left" : "opacity-0"}`}>
            {steps.map((step, i) => (
              <div
                key={i}
                className="group flex items-start gap-5 bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden"
              >
                {/* Step Number Background */}
                <span className="absolute top-2 left-2 text-[5rem] font-black text-gray-50 group-hover:text-primary-50 transition-colors leading-none">
                  {step.step}
                </span>

                <div className="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl flex items-center justify-center shrink-0 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 relative">
                  <step.icon className="text-white" size={24} />
                </div>

                <div className="relative">
                  <div className="flex items-center gap-2 mb-1">
                    <span className="text-xs font-bold text-primary-500 bg-primary-50 px-2 py-0.5 rounded-full">
                      الخطوة {step.step}
                    </span>
                  </div>
                  <h4 className="text-lg font-bold text-gray-900 mb-1 group-hover:text-primary-600 transition-colors">
                    {step.title}
                  </h4>
                  <p className="text-gray-500 text-sm leading-relaxed">{step.desc}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
