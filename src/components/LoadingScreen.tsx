import { useState, useEffect } from "react";

export default function LoadingScreen() {
  const [progress, setProgress] = useState(0);
  const [visible, setVisible] = useState(true);

  useEffect(() => {
    const timer = setInterval(() => {
      setProgress((prev) => {
        if (prev >= 100) {
          clearInterval(timer);
          setTimeout(() => setVisible(false), 400);
          return 100;
        }
        return prev + 4;
      });
    }, 40);
    return () => clearInterval(timer);
  }, []);

  if (!visible) return null;

  return (
    <div
      className={`fixed inset-0 z-[200] bg-gradient-to-br from-primary-900 via-primary-800 to-gray-900 flex flex-col items-center justify-center transition-opacity duration-500 ${
        progress >= 100 ? "opacity-0 pointer-events-none" : "opacity-100"
      }`}
    >
      {/* Decorative */}
      <div className="absolute inset-0 pointer-events-none">
        <div className="absolute top-20 left-20 w-64 h-64 bg-accent-500/5 rounded-full blur-3xl"></div>
        <div className="absolute bottom-20 right-20 w-64 h-64 bg-primary-500/10 rounded-full blur-3xl"></div>
      </div>

      {/* Logo */}
      <div className="relative mb-8">
        <div className="w-24 h-24 bg-gradient-to-br from-primary-500 to-primary-700 rounded-3xl flex items-center justify-center shadow-2xl shadow-primary-500/30 animate-pulse-soft">
          <span className="text-4xl">🏥</span>
        </div>
        {/* Ripple effect */}
        <div className="absolute inset-0 border-2 border-primary-400/30 rounded-3xl animate-ripple"></div>
      </div>

      {/* Text */}
      <h2 className="text-white text-2xl font-bold mb-2">مستشفى الشفاء الدولي</h2>
      <p className="text-white/40 text-sm mb-8 tracking-wider">AL-SHIFA INTERNATIONAL HOSPITAL</p>

      {/* Progress Bar */}
      <div className="w-64 h-1.5 bg-white/10 rounded-full overflow-hidden">
        <div
          className="h-full bg-gradient-to-l from-accent-400 to-accent-500 rounded-full transition-all duration-200"
          style={{ width: `${progress}%` }}
        ></div>
      </div>
      <p className="text-white/30 text-xs mt-3 font-medium">{progress}%</p>
    </div>
  );
}
