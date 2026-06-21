import { useState } from "react";
import { Tag, Clock, Sparkles, Gift, Percent, X, Check, Calendar } from "lucide-react";
import SectionHeader from "./SectionHeader";
import { useScrollReveal } from "../hooks/useScrollReveal";
import AppointmentModal from "./AppointmentModal";

const offers = [
  {
    id: "1",
    title: "خصم 30% على فحص القلب الشامل",
    desc: "احصل على فحص شامل للقلب يشمل تخطيط القلب، الإيكو، وتحاليل الدم بتخفيض خاص",
    discount: "30%",
    originalPrice: "1,500",
    newPrice: "1,050",
    validUntil: "31 يناير 2024",
    category: "فحوصات",
    color: "from-red-500 to-rose-600",
    icon: "❤️",
  },
  {
    id: "2",
    title: "باقة الولادة الذهبية مجاناً",
    desc: "احجزي الآن باقة الولادة واحصلي على جلسات علاج طبيعي بعد الولادة مجاناً",
    discount: "هدية",
    originalPrice: "8,000",
    newPrice: "8,000",
    validUntil: "28 فبراير 2024",
    category: "ولادة",
    color: "from-pink-500 to-rose-600",
    icon: "👶",
  },
  {
    id: "3",
    title: "خصم 50% على استشارات الأسنان",
    desc: "استشارة مجانية مع أفضل أطباء الأسنان مع خصم 50% على خطة العلاج",
    discount: "50%",
    originalPrice: "500",
    newPrice: "250",
    validUntil: "15 فبراير 2024",
    category: "أسنان",
    color: "from-blue-500 to-indigo-600",
    icon: "🦷",
  },
  {
    id: "4",
    title: "باقة الفحص الشامل VIP",
    desc: "فحص طبي شامل مع استشارة مع أفضل الأطباء وتقرير مفصل",
    discount: "25%",
    originalPrice: "3,000",
    newPrice: "2,250",
    validUntil: "30 مارس 2024",
    category: "فحوصات",
    color: "from-amber-500 to-orange-600",
    icon: "🔬",
  },
  {
    id: "5",
    title: "خصم خاص للسياحة العلاجية",
    desc: "باقة شاملة للسياحة العلاجية تشمل الإقامة والنقل والرعاية الطبية",
    discount: "20%",
    originalPrice: "15,000",
    newPrice: "12,000",
    validUntil: "31 ديسمبر 2024",
    category: "سياحة علاجية",
    color: "from-purple-500 to-violet-600",
    icon: "✈️",
  },
  {
    id: "6",
    title: "خصم 40% على جراحة العيون",
    desc: "تصحيح النظر بالليزك مع ضمان مدى الحياة وخصم خاص لفترة محدودة",
    discount: "40%",
    originalPrice: "5,000",
    newPrice: "3,000",
    validUntil: "30 يناير 2024",
    category: "عيون",
    color: "from-emerald-500 to-teal-600",
    icon: "👁️",
  },
];

export default function Offers() {
  const { ref, isVisible } = useScrollReveal();
  const [selectedOffer, setSelectedOffer] = useState<any | null>(null);
  const [appointmentOpen, setAppointmentOpen] = useState(false);
  const [claimed, setClaimed] = useState(false);

  return (
    <section className="py-24 bg-gradient-to-b from-white to-rose-50/30 relative overflow-hidden">
      <div className="absolute top-0 right-0 w-72 h-72 bg-rose-100/30 rounded-full blur-3xl"></div>
      <div className="absolute bottom-0 left-0 w-72 h-72 bg-amber-100/30 rounded-full blur-3xl"></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <SectionHeader
          badge="🎁 العروض والخصومات"
          title="عروض"
          highlight="حصرية"
          description="استفد من أفضل العروض والخصومات الحصرية على خدماتنا الطبية المتميزة"
        />

        <div ref={ref} className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {offers.map((offer, index) => (
            <div
              key={offer.id}
              className={`group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-gray-100 relative ${
                isVisible ? "animate-fade-in-up" : "opacity-0"
              }`}
              style={{ animationDelay: `${index * 100}ms` }}
            >
              {/* Discount Badge */}
              <div className={`absolute top-5 left-5 bg-gradient-to-br ${offer.color} text-white px-4 py-2 rounded-xl font-black text-lg shadow-lg z-10 flex items-center gap-1`}>
                <Percent size={14} />
                <span>{offer.discount}</span>
              </div>

              {/* Icon Header */}
              <div className={`relative h-32 bg-gradient-to-br ${offer.color} flex items-center justify-center`}>
                <span className="text-7xl opacity-30 absolute animate-float">{offer.icon}</span>
                <div className="relative z-10 text-center">
                  <span className="text-5xl">{offer.icon}</span>
                  <p className="text-white/80 text-xs mt-2 font-medium">{offer.category}</p>
                </div>
              </div>

              {/* Content */}
              <div className="p-6">
                <h3 className="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-primary-600 transition-colors">
                  {offer.title}
                </h3>
                <p className="text-gray-500 text-sm leading-relaxed mb-4 line-clamp-2">
                  {offer.desc}
                </p>

                {/* Price */}
                <div className="flex items-center gap-3 mb-4">
                  <span className="text-2xl font-black text-gray-800">{offer.newPrice} ر.س</span>
                  {offer.originalPrice !== offer.newPrice && (
                    <span className="text-sm text-gray-400 line-through">{offer.originalPrice} ر.س</span>
                  )}
                </div>

                {/* Valid Until */}
                <div className="flex items-center gap-2 text-xs text-gray-400 mb-5">
                  <Clock size={12} />
                  <span>صالح حتى: {offer.validUntil}</span>
                </div>

                <button
                  onClick={() => setSelectedOffer(offer)}
                  className="w-full bg-gradient-to-l from-primary-500 to-primary-700 text-white py-3 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all flex items-center justify-center gap-2"
                >
                  <Gift size={16} />
                  <span>احصل على العرض</span>
                </button>
              </div>
            </div>
          ))}
        </div>

        {/* Terms */}
        <div className="mt-10 bg-amber-50 border border-amber-200 rounded-2xl p-5 flex items-start gap-3">
          <Tag size={20} className="text-amber-600 shrink-0 mt-0.5" />
          <div className="text-sm text-amber-800">
            <p className="font-bold mb-1">الشروط والأحكام:</p>
            <ul className="space-y-0.5 text-amber-700">
              <li>• العروض غير قابلة للدمج مع عروض أخرى</li>
              <li>• سارية خلال فترة العرض المذكورة فقط</li>
              <li>• قابلة للتغيير دون إشعار مسبق</li>
            </ul>
          </div>
        </div>
      </div>

      {/* Modal */}
      {selectedOffer && (
        <div className="fixed inset-0 z-[100] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4" onClick={() => { setSelectedOffer(null); setClaimed(false); }}>
          <div className="bg-white rounded-3xl max-w-lg w-full p-8 relative animate-scale-in" onClick={(e) => e.stopPropagation()}>
            <button onClick={() => { setSelectedOffer(null); setClaimed(false); }} className="absolute top-4 left-4 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-200">
              <X size={16} />
            </button>

            <div className={`w-full h-32 bg-gradient-to-br ${selectedOffer.color} rounded-2xl flex items-center justify-center mb-6 relative overflow-hidden`}>
              <span className="text-6xl opacity-30 absolute">{selectedOffer.icon}</span>
              <span className="text-6xl relative z-10">{selectedOffer.icon}</span>
            </div>

            <h3 className="text-xl font-bold text-gray-900 mb-3">{selectedOffer.title}</h3>
            <p className="text-gray-500 text-sm leading-relaxed mb-5">{selectedOffer.desc}</p>

            <div className="bg-gray-50 rounded-xl p-4 mb-5">
              <div className="flex items-baseline justify-between mb-2">
                <span className="text-sm text-gray-500">السعر بعد الخصم:</span>
                <span className="text-2xl font-black text-primary-600">{selectedOffer.newPrice} ر.س</span>
              </div>
              {selectedOffer.originalPrice !== selectedOffer.newPrice && (
                <div className="flex items-baseline justify-between">
                  <span className="text-sm text-gray-500">السعر الأصلي:</span>
                  <span className="text-sm text-gray-400 line-through">{selectedOffer.originalPrice} ر.س</span>
                </div>
              )}
              <div className="flex items-baseline justify-between mt-2 pt-2 border-t border-gray-200">
                <span className="text-sm text-gray-500">صالح حتى:</span>
                <span className="text-sm font-bold text-gray-700">{selectedOffer.validUntil}</span>
              </div>
            </div>

            {/* How to get the offer */}
            {!claimed ? (
              <>
                <div className="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-5">
                  <p className="text-sm font-bold text-blue-700 mb-2 flex items-center gap-2">
                    <Sparkles size={14} />
                    <span>كيفية الحصول على العرض:</span>
                  </p>
                  <ol className="space-y-1.5 text-xs text-blue-600">
                    <li className="flex items-start gap-2"><span className="font-bold">1.</span> اضغط على "احجز الآن"</li>
                    <li className="flex items-start gap-2"><span className="font-bold">2.</span> املأ بيانات الحجز</li>
                    <li className="flex items-start gap-2"><span className="font-bold">3.</span> اذكر كود العرض: <span className="font-black">{selectedOffer.id}</span></li>
                    <li className="flex items-start gap-2"><span className="font-bold">4.</span> سيتم خصم القيمة عند الحضور</li>
                  </ol>
                </div>

                <button
                  onClick={() => {
                    setAppointmentOpen(true);
                  }}
                  className="w-full bg-gradient-to-l from-primary-500 to-primary-700 text-white py-3.5 rounded-xl font-bold text-base hover:shadow-lg transition-all flex items-center justify-center gap-2 mb-3"
                >
                  <Calendar size={18} />
                  <span>احجز الآن واحصل على العرض</span>
                </button>
              </>
            ) : (
              <div className="bg-green-50 border border-green-200 rounded-xl p-5 mb-5 text-center">
                <div className="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                  <Check size={28} className="text-green-600" />
                </div>
                <h4 className="text-lg font-bold text-green-700 mb-1">تم الحجز بنجاح!</h4>
                <p className="text-green-600 text-sm">
                  كود العرض: <span className="font-black">{selectedOffer.id}</span>
                  <br />
                  سيتم التواصل معك لتأكيد الموعد
                </p>
              </div>
            )}

            <button
              onClick={() => { setSelectedOffer(null); setClaimed(false); }}
              className="w-full py-3 text-sm text-gray-500 hover:bg-gray-50 rounded-xl transition-colors"
            >
              إغلاق
            </button>
          </div>
        </div>
      )}

      <AppointmentModal
        isOpen={appointmentOpen}
        onClose={() => setAppointmentOpen(false)}
        onSuccess={() => {
          setClaimed(true);
        }}
        offerId={selectedOffer?.id} // ✅ تمرير معرف العرض
      />
    </section>
  );
}
