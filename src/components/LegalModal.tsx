import { X, Shield, FileText, Info } from "lucide-react";

interface LegalModalProps {
  type: "privacy" | "terms";
  onClose: () => void;
}

export default function LegalModal({ type, onClose }: LegalModalProps) {
  const content = {
    privacy: {
      icon: Shield,
      title: "سياسة الخصوصية",
      sections: [
        {
          title: "1. مقدمة",
          text: "نحترم خصوصيتك ونلتزم بحماية بياناتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع واستخدام وحماية المعلومات التي تقدمها لنا عند استخدام موقعنا الإلكتروني.",
        },
        {
          title: "2. المعلومات التي نجمعها",
          text: "نقوم بجمع المعلومات التالية: الاسم الكامل، رقم الهاتف، البريد الإلكتروني، التاريخ الطبي (عند الضرورة)، ومعلومات الحجز والمواعيد.",
        },
        {
          title: "3. كيفية استخدام المعلومات",
          text: "نستخدم معلوماتك لتقديم خدمات الرعاية الصحية، حجز المواعيد، التواصل معك، وتحسين خدماتنا. لا نشارك معلوماتك مع أطراف ثالثة دون موافقتك.",
        },
        {
          title: "4. حماية البيانات",
          text: "نتخذ إجراءات أمنية صارمة لحماية بياناتك من الوصول غير المصرح به أو التعديل أو الإفصاح أو الإتلاف. جميع البيانات مشفرة ومخزنة بشكل آمن.",
        },
        {
          title: "5. حقوقك",
          text: "لديك الحق في الوصول إلى بياناتك، تصحيحها، حذفها، أو الاعتراض على استخدامها. يمكنك التواصل معنا في أي وقت لممارسة هذه الحقوق.",
        },
        {
          title: "6. ملفات تعريف الارتباط",
          text: "نستخدم ملفات تعريف الارتباط لتحسين تجربتك على موقعنا. يمكنك التحكم في إعدادات الكوكيز من خلال متصفحك.",
        },
        {
          title: "7. التواصل",
          text: "لأي استفسارات حول سياسة الخصوصية، يمكنك التواصل معنا عبر البريد الإلكتروني: privacy@alshifa-hospital.com",
        },
      ],
    },
    terms: {
      icon: FileText,
      title: "الشروط والأحكام",
      sections: [
        {
          title: "1. القبول بالشروط",
          text: "باستخدامك لموقع مستشفى الشفاء الدولي، فإنك توافق على الالتزام بهذه الشروط والأحكام. إذا لم توافق على أي من هذه الشروط، يرجى عدم استخدام الموقع.",
        },
        {
          title: "2. الخدمات المقدمة",
          text: "يقدم الموقع معلومات عن خدماتنا الطبية، إمكانية حجز المواعيد، والاستشارات الطبية. الخدمات الطبية الفعلية تخضع لتقييم الأطباء المعالجين.",
        },
        {
          title: "3. حجز المواعيد",
          text: "حجز الموعد عبر الموقع يخضع للتأكيد من قبل المستشفى. الاحتفاظ بالموعد ليس مضموناً حتى يتم تأكيد الحجز عبر رسالة نصية أو اتصال هاتفي.",
        },
        {
          title: "4. الإلغاء والتعديل",
          text: "يمكنك إلغاء أو تعديل موعدك قبل 24 ساعة من الموعد المحدد. الإلغاءات المتأخرة قد تخضع لرسوم إلغاء.",
        },
        {
          title: "5. المسؤولية الطبية",
          text: "المعلومات المقدمة على الموقع هي لأغراض إعلامية فقط ولا تشكل استشارة طبية. يجب دائماً استشارة الطبيب المختص للحصول على تشخيص وعلاج مناسب.",
        },
        {
          title: "6. الأسعار والمدفوعات",
          text: "الأسعار المعروضة قابلة للتغيير دون إشعار مسبق. يتم الدفع وفقاً للتعريفة المعتمدة في وقت تقديم الخدمة.",
        },
        {
          title: "7. الملكية الفكرية",
          text: "جميع المحتويات على الموقع (نصوص، صور، شعارات) هي ملكية حصرية لمستشفى الشفاء الدولي ويحظر استخدامها دون إذن كتابي.",
        },
        {
          title: "8. التعديلات",
          text: "نحتفظ بالحق في تعديل هذه الشروط والأحكام في أي وقت. الاستخدام المستمر للموقع بعد التعديل يعني قبولك للشروط المعدلة.",
        },
      ],
    },
  };

  const data = content[type];
  const Icon = data.icon;

  return (
    <div className="fixed inset-0 z-[110] flex items-center justify-center p-4">
      <div className="fixed inset-0 bg-black/70 backdrop-blur-sm" onClick={onClose}></div>
      <div className="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-hidden animate-scale-in">
        {/* Header */}
        <div className="sticky top-0 bg-gradient-to-l from-primary-600 to-primary-800 text-white px-6 py-5 z-10">
          <button
            onClick={onClose}
            className="absolute top-4 left-4 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-colors"
          >
            <X size={20} />
          </button>
          <div className="flex items-center gap-3">
            <div className="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <Icon size={24} />
            </div>
            <div>
              <h3 className="text-2xl font-bold">{data.title}</h3>
              <p className="text-sm text-white/70">آخر تحديث: يناير 2024</p>
            </div>
          </div>
        </div>

        {/* Content */}
        <div className="p-8 overflow-y-auto max-h-[70vh]">
          <div className="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 flex items-start gap-3">
            <Info size={18} className="text-blue-600 shrink-0 mt-0.5" />
            <p className="text-sm text-blue-700 leading-relaxed">
              نرجو قراءة هذه الوثيقة بعناية. باستخدامك لخدماتنا، فإنك توافق على جميع الشروط والأحكام المذكورة أدناه.
            </p>
          </div>

          <div className="space-y-6">
            {data.sections.map((section, i) => (
              <div key={i} className="border-r-4 border-primary-500 pr-4">
                <h4 className="text-lg font-bold text-gray-800 mb-2">{section.title}</h4>
                <p className="text-gray-600 leading-relaxed">{section.text}</p>
              </div>
            ))}
          </div>

          <div className="mt-8 pt-6 border-t border-gray-100 text-center">
            <p className="text-sm text-gray-500">
              © 2024 مستشفى الشفاء الدولي - جميع الحقوق محفوظة
            </p>
            <button
              onClick={onClose}
              className="mt-4 bg-gradient-to-l from-primary-500 to-primary-700 text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg transition-all"
            >
              فهمت، إغلاق
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
