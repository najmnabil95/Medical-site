import { useState } from "react";
import { X, MessageCircle } from "lucide-react";
import { FaWhatsapp } from "react-icons/fa";

export default function WhatsAppFloat() {
  const [showTooltip, setShowTooltip] = useState(true);

  return (
    <div className="fixed bottom-8 right-8 z-50 flex flex-col items-end gap-3">
      {/* Tooltip */}
      {showTooltip && (
        <div className="bg-white rounded-2xl p-4 shadow-xl border border-gray-100 max-w-[240px] relative animate-fade-in-up">
          <button
            onClick={() => setShowTooltip(false)}
            className="absolute -top-2 -left-2 w-6 h-6 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 hover:bg-gray-200 transition-colors"
          >
            <X size={12} />
          </button>
          <div className="flex items-start gap-3">
            <div className="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center shrink-0">
              <MessageCircle className="text-white" size={18} />
            </div>
            <div>
              <p className="text-gray-800 text-sm font-bold">مرحباً! 👋</p>
              <p className="text-gray-500 text-xs mt-1 leading-relaxed">
                كيف يمكننا مساعدتك؟ تواصل معنا الآن عبر واتساب
              </p>
            </div>
          </div>
        </div>
      )}

      {/* WhatsApp Button */}
      <a
        href="https://wa.me/966123456789?text=مرحباً، أريد الاستفسار عن خدمات المستشفى"
        target="_blank"
        rel="noopener noreferrer"
        className="relative w-[60px] h-[60px] bg-green-500 text-white rounded-2xl shadow-xl shadow-green-500/30 flex items-center justify-center hover:bg-green-600 hover:scale-110 transition-all duration-300 group"
        title="تواصل معنا عبر واتساب"
        onClick={() => setShowTooltip(false)}
      >
        <FaWhatsapp size={30} className="group-hover:scale-110 transition-transform" />
        {/* Pulse */}
        <span className="absolute -top-1 -right-1 w-4 h-4">
          <span className="absolute inset-0 bg-green-400 rounded-full animate-ping opacity-60"></span>
          <span className="absolute inset-0.5 bg-green-500 rounded-full"></span>
        </span>
      </a>
    </div>
  );
}
