import { X, Calendar, User, Clock, Share2 } from "lucide-react";
import { FaFacebookF, FaTwitter, FaWhatsapp, FaLinkedinIn } from "react-icons/fa";

interface NewsDetailModalProps {
  article: any;
  onClose: () => void;
}

export default function NewsDetailModal({ article, onClose }: NewsDetailModalProps) {
  if (!article) return null;

  const shareUrl = typeof window !== "undefined" ? window.location.href : "";

  const shareLinks = [
    { icon: FaWhatsapp, color: "bg-green-500 hover:bg-green-600", url: `https://wa.me/?text=${encodeURIComponent(article.title + " - " + shareUrl)}` },
    { icon: FaTwitter, color: "bg-sky-500 hover:bg-sky-600", url: `https://twitter.com/intent/tweet?text=${encodeURIComponent(article.title)}&url=${encodeURIComponent(shareUrl)}` },
    { icon: FaFacebookF, color: "bg-blue-600 hover:bg-blue-700", url: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}` },
    { icon: FaLinkedinIn, color: "bg-blue-700 hover:bg-blue-800", url: `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareUrl)}` },
  ];

  return (
    <div className="fixed inset-0 z-[100] flex items-center justify-center p-4">
      <div className="fixed inset-0 bg-black/70 backdrop-blur-sm" onClick={onClose}></div>
      <div className="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto animate-scale-in">
        {/* Header Image */}
        <div className="relative h-72 overflow-hidden">
          <img src={article.image} alt={article.title} className="w-full h-full object-cover" />
          <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
          <button
            onClick={onClose}
            className="absolute top-4 left-4 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-colors"
          >
            <X size={20} />
          </button>
          <div className="absolute top-4 right-4">
            <span className={`${article.categoryColor} text-xs font-bold px-4 py-1.5 rounded-full`}>
              {article.category}
            </span>
          </div>
          <div className="absolute bottom-6 right-6 left-6 text-white">
            <h2 className="text-2xl md:text-3xl font-black leading-tight mb-3">{article.title}</h2>
            <div className="flex flex-wrap items-center gap-4 text-sm text-white/80">
              <div className="flex items-center gap-1.5">
                <Calendar size={14} />
                <span>{article.date}</span>
              </div>
              <div className="flex items-center gap-1.5">
                <User size={14} />
                <span>{article.author}</span>
              </div>
              <div className="flex items-center gap-1.5">
                <Clock size={14} />
                <span>{article.readTime}</span>
              </div>
            </div>
          </div>
        </div>

        {/* Content */}
        <div className="p-8">
          <div className="prose prose-lg max-w-none text-gray-700 leading-loose">
            <p className="text-xl font-bold text-gray-800 mb-4">{article.excerpt}</p>
            <p className="mb-4">
              في إطار سعيه المستمر لتقديم أفضل الخدمات الطبية، يسر مستشفى الشفاء الدولي الإعلان عن هذه الخطوة المهمة التي تعكس التزامنا بالجودة والابتكار في الرعاية الصحية.
            </p>
            <p className="mb-4">
              يأتي هذا التطور امتداداً لجهود المستشفى في توفير أحدث التقنيات الطبية العالمية، حيث يعمل فريقنا المتخصص من الأطباء والاستشاريين على تطبيق أفضل الممارسات العالمية لضمان حصول مرضانا على أعلى مستويات الرعاية.
            </p>
            <h3 className="text-xl font-bold text-gray-800 mt-6 mb-3">أبرز المزايا:</h3>
            <ul className="list-disc pr-6 space-y-2 mb-4">
              <li>تقنيات طبية متطورة ومعدات حديثة</li>
              <li>فريق طبي متخصص ومؤهل على أعلى المستويات</li>
              <li>رعاية شاملة ومتكاملة لجميع الحالات</li>
              <li>متابعة مستمرة بعد العلاج</li>
              <li>بيئة علاجية آمنة ومريحة</li>
            </ul>
            <p className="mb-4">
              ندعو جميع المرضى والمراجعين للاستفادة من هذه الخدمات المتميزة، ويمكنكم التواصل معنا عبر القنوات المختلفة لحجز مواعيدكم أو الاستفسار عن المزيد من التفاصيل.
            </p>
            <div className="bg-primary-50 border border-primary-100 rounded-2xl p-5 mt-6">
              <p className="text-primary-700 font-bold mb-2">📞 للتواصل والاستفسار:</p>
              <p className="text-primary-600 text-sm">الهاتف: 920 012 345</p>
              <p className="text-primary-600 text-sm">البريد: info@alshifa-hospital.com</p>
            </div>
          </div>

          {/* Share */}
          <div className="mt-8 pt-6 border-t border-gray-100">
            <div className="flex items-center gap-3">
              <div className="flex items-center gap-2">
                <Share2 size={18} className="text-gray-500" />
                <span className="text-sm font-bold text-gray-700">شارك الخبر:</span>
              </div>
              <div className="flex items-center gap-2">
                {shareLinks.map((link, i) => (
                  <a
                    key={i}
                    href={link.url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className={`w-10 h-10 ${link.color} text-white rounded-xl flex items-center justify-center transition-all hover:scale-110`}
                  >
                    <link.icon size={16} />
                  </a>
                ))}
              </div>
            </div>
          </div>

          {/* Close */}
          <button
            onClick={onClose}
            className="mt-6 w-full bg-gray-100 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-200 transition-colors"
          >
            إغلاق
          </button>
        </div>
      </div>
    </div>
  );
}
