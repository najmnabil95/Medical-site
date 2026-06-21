import { AlertCircle } from "lucide-react";

const newsItems = [
  "🎉 مستشفى الشفاء يحصل على اعتماد JCI للمرة الثالثة",
  "📢 افتتاح قسم جراحة القلب بالروبوت الجراحي",
  "🏆 جائزة أفضل مستشفى في المنطقة لعام 2024",
  "💉 حملة التطعيم المجانية متاحة الآن",
  "⭐ نسبة رضا المرضى تصل إلى 98%",
  "🔬 تدشين أحدث جهاز رنين مغناطيسي 3 تسلا",
];

export default function NewsTicker() {
  return (
    <div className="bg-gradient-to-l from-accent-600 to-accent-500 text-white py-2.5 overflow-hidden relative">
      <div className="flex items-center">
        {/* Label */}
        <div className="bg-white/20 px-4 py-1 flex items-center gap-2 shrink-0 z-10 backdrop-blur-sm">
          <AlertCircle size={14} />
          <span className="text-xs font-bold whitespace-nowrap">آخر الأخبار</span>
        </div>

        {/* Scrolling Text */}
        <div className="flex animate-marquee whitespace-nowrap">
          {[...newsItems, ...newsItems].map((item, i) => (
            <span key={i} className="mx-8 text-sm font-medium">
              {item}
            </span>
          ))}
        </div>
      </div>
    </div>
  );
}
