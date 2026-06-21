import SectionHeader from "./SectionHeader";
import { useScrollReveal } from "../hooks/useScrollReveal";
import { createScrollHandler } from "../utils/scroll";
import { Shield, CheckCircle } from "lucide-react";

const insuranceCompanies = [
  { name: "بوبا العربية", abbr: "BUPA" },
  { name: "التعاونية", abbr: "TAWU" },
  { name: "ميدغلف", abbr: "MEDG" },
  { name: "الراجحي تكافل", abbr: "RAJH" },
  { name: "ملاذ للتأمين", abbr: "MALZ" },
  { name: "وفا للتأمين", abbr: "WAFA" },
  { name: "سلامة للتأمين", abbr: "SALA" },
  { name: "الأهلية للتأمين", abbr: "AHLI" },
  { name: "اتحاد الخليج", abbr: "GULF" },
  { name: "الوطنية للتأمين", abbr: "WATN" },
];

export default function Insurance() {
  const { ref, isVisible } = useScrollReveal();

  return (
    <section className="py-24 bg-white relative overflow-hidden">
      <div className="max-w-7xl mx-auto px-4">
        <SectionHeader
          badge="التأمين الطبي"
          title="شركات التأمين"
          highlight="المعتمدة لدينا"
          description="نتعامل مع أكبر شركات التأمين الطبي في المملكة لتسهيل حصولكم على الرعاية الصحية"
        />

        <div ref={ref}>
          {/* Insurance Grid */}
          <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-5 mb-12">
            {insuranceCompanies.map((company, index) => (
              <div
                key={index}
                className={`group bg-gray-50 hover:bg-gradient-to-br hover:from-primary-500 hover:to-primary-700 rounded-2xl p-6 flex flex-col items-center justify-center text-center transition-all duration-500 hover:-translate-y-2 hover:shadow-xl hover:shadow-primary-500/20 cursor-pointer border border-gray-100 hover:border-transparent ${
                  isVisible ? "animate-fade-in-up" : "opacity-0"
                }`}
                style={{ animationDelay: `${index * 70}ms` }}
              >
                <div className="w-14 h-14 bg-white group-hover:bg-white/20 rounded-xl flex items-center justify-center mb-3 shadow-sm transition-all duration-300 group-hover:scale-110">
                  <span className="text-xl font-black text-primary-600 group-hover:text-white transition-colors">
                    {company.abbr.slice(0, 2)}
                  </span>
                </div>
                <h4 className="text-sm font-bold text-gray-700 group-hover:text-white transition-colors">
                  {company.name}
                </h4>
              </div>
            ))}
          </div>

          {/* Benefits */}
          <div className="bg-gradient-to-l from-primary-50 to-accent-50 rounded-3xl p-8 md:p-12 border border-primary-100/50">
            <div className="grid md:grid-cols-2 gap-8 items-center">
              <div>
                <div className="flex items-center gap-3 mb-4">
                  <div className="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center">
                    <Shield className="text-white" size={24} />
                  </div>
                  <h3 className="text-2xl font-bold text-gray-900">مزايا التأمين الطبي</h3>
                </div>
                <p className="text-gray-600 leading-relaxed mb-6">
                  نوفر لكم تجربة سلسة وميسرة مع جميع شركات التأمين المعتمدة لدينا، مع خدمة
                  الموافقات الفورية والتغطية الشاملة لجميع التخصصات الطبية.
                </p>
                <a href="#contact" onClick={createScrollHandler("contact")} className="inline-flex items-center gap-2 bg-primary-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-primary-700 transition-all hover:shadow-lg cursor-pointer">
                  استفسر عن تأمينك
                </a>
              </div>
              <div className="space-y-3">
                {[
                  "موافقات فورية بدون انتظار",
                  "تغطية شاملة لجميع التخصصات",
                  "لا حاجة للدفع المسبق",
                  "خدمة تنسيق مع شركة التأمين",
                  "دعم في حالة رفض المطالبات",
                  "تحديث مستمر لشبكة التأمين",
                ].map((benefit, i) => (
                  <div key={i} className="flex items-center gap-3 bg-white rounded-xl p-3 shadow-sm">
                    <CheckCircle className="text-accent-500 shrink-0" size={20} />
                    <span className="text-gray-700 text-sm font-medium">{benefit}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
