import { useState } from "react";
import { ChevronDown, HelpCircle, MessageCircle } from "lucide-react";
import SectionHeader from "./SectionHeader";
import { useScrollReveal } from "../hooks/useScrollReveal";
import { createScrollHandler } from "../utils/scroll";

const faqs = [
  {
    question: "ما هي ساعات عمل المستشفى؟",
    answer: "يعمل المستشفى من السبت إلى الخميس من الساعة 8 صباحاً حتى 10 مساءً. قسم الطوارئ والعناية المركزة يعملان على مدار الساعة 24/7 طوال أيام الأسبوع بما في ذلك أيام العطل والأعياد.",
  },
  {
    question: "كيف يمكنني حجز موعد مع طبيب؟",
    answer: "يمكنك حجز موعد عبر عدة طرق: من خلال نموذج الحجز على موقعنا الإلكتروني، أو عبر الاتصال بنا على الرقم 920012345، أو عبر تطبيق واتساب، أو بزيارة المستشفى شخصياً. كما نوفر خدمة الحجز عبر تطبيق المستشفى.",
  },
  {
    question: "هل يقبل المستشفى جميع شركات التأمين؟",
    answer: "نتعامل مع أكثر من 25 شركة تأمين طبي معتمدة في المملكة العربية السعودية، تشمل بوبا العربية، التعاونية، ميدغلف، الراجحي تكافل وغيرها. يمكنك التواصل معنا للتحقق من تغطية تأمينك.",
  },
  {
    question: "ما هي التخصصات الطبية المتوفرة؟",
    answer: "يضم المستشفى أكثر من 30 تخصصاً طبياً تشمل: جراحة القلب، جراحة المخ والأعصاب، جراحة العظام، طب الأطفال، طب العيون، الطب الباطني، الأنف والأذن والحنجرة، طب الأسنان، الأمراض الجلدية، وغيرها من التخصصات.",
  },
  {
    question: "هل تتوفر خدمة الطوارئ على مدار الساعة؟",
    answer: "نعم، قسم الطوارئ لدينا يعمل على مدار الساعة 24/7 ومجهز بأحدث المعدات الطبية وفريق طبي متخصص. كما تتوفر سيارات إسعاف مجهزة للنقل الطبي الطارئ.",
  },
  {
    question: "هل يوفر المستشفى خدمات الاستشارات عن بُعد؟",
    answer: "نعم، نوفر خدمة الاستشارات الطبية عن بُعد عبر الفيديو مع أطبائنا المتخصصين. يمكنك حجز استشارة إلكترونية من خلال موقعنا أو تطبيق المستشفى بكل سهولة ويسر.",
  },
  {
    question: "ما هي إجراءات القبول في المستشفى؟",
    answer: "عند الوصول للمستشفى، توجه لمكتب الاستقبال حيث سيتم تسجيل بياناتك ومعلومات التأمين. بعد ذلك سيتم توجيهك للعيادة المناسبة. في حالة التنويم، سيتم تجهيز غرفة خاصة بك مع جميع الاحتياجات اللازمة.",
  },
  {
    question: "هل تتوفر مواقف للسيارات؟",
    answer: "نعم، يوفر المستشفى مواقف سيارات واسعة ومجانية للمراجعين والزوار، بالإضافة إلى مواقف خاصة لذوي الاحتياجات الخاصة ومواقف VIP. كما تتوفر خدمة صف السيارات (Valet Parking).",
  },
];

function FAQItem({ faq, index, isOpen, toggle }: {
  faq: typeof faqs[0];
  index: number;
  isOpen: boolean;
  toggle: () => void;
}) {
  return (
    <div
      className={`bg-white rounded-2xl border transition-all duration-300 overflow-hidden ${
        isOpen ? "border-primary-200 shadow-lg shadow-primary-500/10" : "border-gray-100 shadow-sm hover:shadow-md"
      }`}
    >
      <button
        onClick={toggle}
        className="w-full flex items-center justify-between p-6 text-right"
      >
        <div className="flex items-center gap-4">
          <span className={`w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold transition-all duration-300 ${
            isOpen ? "bg-primary-600 text-white" : "bg-gray-100 text-gray-500"
          }`}>
            {String(index + 1).padStart(2, "0")}
          </span>
          <h4 className={`font-bold text-lg transition-colors ${isOpen ? "text-primary-700" : "text-gray-800"}`}>
            {faq.question}
          </h4>
        </div>
        <ChevronDown
          size={20}
          className={`text-gray-400 transition-transform duration-300 shrink-0 mr-4 ${
            isOpen ? "rotate-180 text-primary-600" : ""
          }`}
        />
      </button>
      <div className={`transition-all duration-300 ${isOpen ? "max-h-60 opacity-100" : "max-h-0 opacity-0"}`}>
        <div className="px-6 pb-6 pr-20">
          <p className="text-gray-600 leading-relaxed">{faq.answer}</p>
        </div>
      </div>
    </div>
  );
}

export default function FAQ() {
  const [openIndex, setOpenIndex] = useState(0);
  const { ref, isVisible } = useScrollReveal();

  return (
    <section className="py-24 bg-gray-50 relative overflow-hidden">
      {/* Decorative */}
      <div className="absolute top-0 right-0 w-80 h-80 bg-primary-100/30 rounded-full blur-3xl"></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <SectionHeader
          badge="الأسئلة الشائعة"
          title="أسئلة"
          highlight="متكررة"
          description="إجابات على أكثر الأسئلة شيوعاً من مرضانا ومراجعينا"
        />

        <div ref={ref} className="grid lg:grid-cols-3 gap-8">
          {/* FAQ List */}
          <div className="lg:col-span-2 space-y-4">
            {faqs.map((faq, index) => (
              <div
                key={index}
                className={isVisible ? "animate-fade-in-up" : "opacity-0"}
                style={{ animationDelay: `${index * 80}ms` }}
              >
                <FAQItem
                  faq={faq}
                  index={index}
                  isOpen={openIndex === index}
                  toggle={() => setOpenIndex(openIndex === index ? -1 : index)}
                />
              </div>
            ))}
          </div>

          {/* Side Card */}
          <div className="space-y-6">
            <div className="bg-gradient-to-br from-primary-600 to-primary-800 rounded-3xl p-8 text-white sticky top-24">
              <div className="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mb-6">
                <HelpCircle className="text-white" size={32} />
              </div>
              <h3 className="text-2xl font-bold mb-3">لم تجد إجابتك؟</h3>
              <p className="text-white/70 mb-6 leading-relaxed">
                فريق خدمة العملاء لدينا جاهز للإجابة على جميع استفساراتكم في أي وقت
              </p>
              <div className="space-y-3">
                <a
                  href="tel:920012345"
                  className="flex items-center gap-3 bg-white/10 rounded-xl p-4 hover:bg-white/20 transition-all group"
                >
                  <div className="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    📞
                  </div>
                  <div>
                    <p className="text-white/60 text-xs">اتصل بنا</p>
                    <p className="font-bold" dir="ltr">920 012 345</p>
                  </div>
                </a>
                <a
                  href="#contact"
                  onClick={createScrollHandler("contact")}
                  className="flex items-center gap-3 bg-white/10 rounded-xl p-4 hover:bg-white/20 transition-all group cursor-pointer"
                >
                  <div className="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <MessageCircle size={20} />
                  </div>
                  <div>
                    <p className="text-white/60 text-xs">أرسل رسالة</p>
                    <p className="font-bold">تواصل معنا</p>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
