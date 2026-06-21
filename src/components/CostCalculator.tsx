import { useState } from "react";
import { Calculator, ChevronDown, Plus, Minus } from "lucide-react";
import SectionHeader from "./SectionHeader";
import { useScrollReveal } from "../hooks/useScrollReveal";
import { createScrollHandler } from "../utils/scroll";

const services = [
  { id: "1", name: "كشف طبي عام", price: 200, category: "استشارات" },
  { id: "2", name: "استشارة طبيب متخصص", price: 300, category: "استشارات" },
  { id: "3", name: "استشارة استشاري", price: 500, category: "استشارات" },
  { id: "4", name: "تحليل دم شامل", price: 250, category: "تحاليل" },
  { id: "5", name: "تحليل سكر تراكمي", price: 150, category: "تحاليل" },
  { id: "6", name: "تحليل وظائف كبد", price: 180, category: "تحاليل" },
  { id: "7", name: "تحليل وظائف كلى", price: 180, category: "تحاليل" },
  { id: "8", name: "أشعة سينية", price: 150, category: "أشعة" },
  { id: "9", name: "أشعة صوتية", price: 300, category: "أشعة" },
  { id: "10", name: "أشعة مقطعية", price: 1200, category: "أشعة" },
  { id: "11", name: "رنين مغناطيسي", price: 2500, category: "أشعة" },
  { id: "12", name: "رسم قلب", price: 200, category: "فحوصات" },
  { id: "13", name: "إيكو القلب", price: 500, category: "فحوصات" },
  { id: "14", name: "منظار معدة", price: 1500, category: "فحوصات" },
  { id: "15", name: "تنظيف أسنان", price: 300, category: "أسنان" },
  { id: "16", name: "حشو أسنان", price: 400, category: "أسنان" },
  { id: "17", name: "خلع ضرس", price: 500, category: "أسنان" },
  { id: "18", name: "زراعة سن", price: 4000, category: "أسنان" },
];

export default function CostCalculator() {
  const { ref, isVisible } = useScrollReveal();
  const [selectedServices, setSelectedServices] = useState<string[]>([]);
  const [openCategory, setOpenCategory] = useState<string>("استشارات");

  const categories = Array.from(new Set(services.map(s => s.category)));

  const toggleService = (id: string) => {
    setSelectedServices(prev =>
      prev.includes(id) ? prev.filter(s => s !== id) : [...prev, id]
    );
  };

  const selectedItems = services.filter(s => selectedServices.includes(s.id));
  const total = selectedItems.reduce((sum, s) => sum + s.price, 0);
  const vat = total * 0.15;
  const grandTotal = total + vat;

  const resetCalculator = () => {
    setSelectedServices([]);
  };

  return (
    <section className="py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
      <div className="absolute top-0 right-0 w-80 h-80 bg-primary-100/30 rounded-full blur-3xl"></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <SectionHeader
          badge="💰 حاسبة التكلفة"
          title="احسب تكلفة"
          highlight="خدمتك"
          description="اختر الخدمات التي تحتاجها واحصل على تقدير فوري للتكلفة الإجمالية"
        />

        <div ref={ref} className="grid lg:grid-cols-3 gap-6">
          {/* Services Selection */}
          <div className={`lg:col-span-2 space-y-3 ${isVisible ? "animate-fade-in-up" : "opacity-0"}`}>
            {categories.map((category) => (
              <div key={category} className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <button
                  onClick={() => setOpenCategory(openCategory === category ? "" : category)}
                  className="w-full p-4 flex items-center justify-between hover:bg-gray-50 transition-colors"
                >
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center text-white">
                      <Calculator size={18} />
                    </div>
                    <span className="font-bold text-gray-800">{category}</span>
                    <span className="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                      {services.filter(s => s.category === category).length} خدمة
                    </span>
                  </div>
                  <ChevronDown
                    size={20}
                    className={`text-gray-400 transition-transform ${openCategory === category ? "rotate-180" : ""}`}
                  />
                </button>

                {openCategory === category && (
                  <div className="border-t border-gray-100 p-4 grid grid-cols-1 md:grid-cols-2 gap-2">
                    {services.filter(s => s.category === category).map((service) => (
                      <button
                        key={service.id}
                        onClick={() => toggleService(service.id)}
                        className={`flex items-center justify-between p-3 rounded-xl border-2 transition-all text-right ${
                          selectedServices.includes(service.id)
                            ? "border-primary-500 bg-primary-50"
                            : "border-gray-100 hover:border-gray-200"
                        }`}
                      >
                        <div className="flex-1">
                          <p className="font-medium text-gray-800 text-sm">{service.name}</p>
                          <p className="text-primary-600 font-bold text-sm mt-1">{service.price} ر.س</p>
                        </div>
                        <div className={`w-7 h-7 rounded-lg flex items-center justify-center shrink-0 transition-all ${
                          selectedServices.includes(service.id)
                            ? "bg-primary-500 text-white"
                            : "bg-gray-100 text-gray-400"
                        }`}>
                          {selectedServices.includes(service.id) ? <Minus size={14} /> : <Plus size={14} />}
                        </div>
                      </button>
                    ))}
                  </div>
                )}
              </div>
            ))}
          </div>

          {/* Summary */}
          <div className={`lg:col-span-1 ${isVisible ? "animate-slide-in-left" : "opacity-0"}`}>
            <div className="bg-gradient-to-br from-primary-600 to-primary-800 rounded-3xl p-6 text-white shadow-2xl shadow-primary-500/20 sticky top-24">
              <h3 className="text-xl font-bold mb-6 flex items-center gap-2">
                <Calculator size={22} />
                <span>ملخص التكلفة</span>
              </h3>

              {selectedItems.length === 0 ? (
                <div className="text-center py-8">
                  <div className="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <Calculator className="text-white/60" size={28} />
                  </div>
                  <p className="text-white/60 text-sm">اختر الخدمات لعرض التكلفة</p>
                </div>
              ) : (
                <>
                  <div className="space-y-3 mb-5 max-h-60 overflow-y-auto">
                    {selectedItems.map((item) => (
                      <div key={item.id} className="flex items-center justify-between bg-white/10 rounded-xl p-3">
                        <div className="flex-1 min-w-0">
                          <p className="text-sm font-medium truncate">{item.name}</p>
                        </div>
                        <div className="flex items-center gap-2">
                          <span className="text-sm font-bold">{item.price} ر.س</span>
                          <button
                            onClick={() => toggleService(item.id)}
                            className="w-6 h-6 bg-white/20 rounded-md flex items-center justify-center hover:bg-white/30"
                          >
                            <Minus size={12} />
                          </button>
                        </div>
                      </div>
                    ))}
                  </div>

                  <div className="border-t border-white/20 pt-4 space-y-2">
                    <div className="flex items-center justify-between text-sm">
                      <span className="text-white/60">المجموع الفرعي</span>
                      <span className="font-bold">{total.toLocaleString()} ر.س</span>
                    </div>
                    <div className="flex items-center justify-between text-sm">
                      <span className="text-white/60">ضريبة القيمة المضافة (15%)</span>
                      <span className="font-bold">{vat.toLocaleString()} ر.س</span>
                    </div>
                    <div className="flex items-center justify-between pt-3 border-t border-white/20">
                      <span className="font-bold text-lg">الإجمالي</span>
                      <span className="text-3xl font-black text-accent-400">{grandTotal.toLocaleString()} ر.س</span>
                    </div>
                  </div>

                  <div className="mt-6 space-y-2">
                    <a
                      href="#appointment"
                      onClick={createScrollHandler("appointment")}
                      className="w-full bg-white text-primary-700 py-3 rounded-xl font-bold text-sm hover:bg-gray-100 transition-colors flex items-center justify-center gap-2 cursor-pointer"
                    >
                      احجز الآن
                    </a>
                    <button
                      onClick={resetCalculator}
                      className="w-full bg-white/10 text-white py-3 rounded-xl font-bold text-sm hover:bg-white/20 transition-colors"
                    >
                      إعادة تعيين
                    </button>
                  </div>
                </>
              )}

              <p className="text-white/40 text-xs text-center mt-5">
                * الأسعار تقديرية وقد تتغير حسب الحالة
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
