import { useState, useEffect } from "react";
import { Cookie, Check } from "lucide-react";
import LegalModal from "./LegalModal";

export default function CookieBanner() {
  const [visible, setVisible] = useState(false);
  const [showPrivacy, setShowPrivacy] = useState(false);

  useEffect(() => {
    const accepted = localStorage.getItem("cookieConsent");
    if (!accepted) {
      setTimeout(() => setVisible(true), 1500);
    }
  }, []);

  const accept = () => {
    localStorage.setItem("cookieConsent", "accepted");
    setVisible(false);
  };

  const decline = () => {
    localStorage.setItem("cookieConsent", "declined");
    setVisible(false);
  };

  if (!visible) return null;

  return (
    <div className="fixed bottom-0 right-0 left-0 z-[80] p-4 animate-slide-up">
      <div className="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl border border-gray-100 p-5 flex flex-col md:flex-row items-start md:items-center gap-4">
        <div className="flex items-start gap-3 flex-1">
          <div className="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center shrink-0">
            <Cookie className="text-amber-600" size={20} />
          </div>
          <div>
            <h4 className="font-bold text-gray-800 text-sm mb-1">نحن نحترم خصوصيتك</h4>
            <p className="text-gray-500 text-xs leading-relaxed">
              نستخدم ملفات تعريف الارتباط لتحسين تجربتك على موقعنا. من خلال الاستمرار في التصفح، فإنك توافق على استخدامنا لها.
              <button onClick={() => setShowPrivacy(true)} className="text-primary-600 font-bold mx-1 hover:underline cursor-pointer">سياسة الخصوصية</button>
            </p>
          </div>
        </div>
        <div className="flex items-center gap-2 w-full md:w-auto shrink-0">
          <button onClick={decline} className="flex-1 md:flex-none px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl transition-colors">
            رفض
          </button>
          <button onClick={accept} className="flex-1 md:flex-none px-5 py-2 bg-gradient-to-l from-primary-500 to-primary-700 text-white text-sm font-bold rounded-xl hover:shadow-lg hover:shadow-primary-500/30 transition-all flex items-center justify-center gap-2">
            <Check size={16} />
            <span>موافق</span>
          </button>
        </div>
      </div>

      {showPrivacy && (
        <LegalModal type="privacy" onClose={() => setShowPrivacy(false)} />
      )}
    </div>
  );
}
