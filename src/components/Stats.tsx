import { useEffect, useState, useRef } from "react";
import { Users, Award, Building2, HeartHandshake, Stethoscope, ThumbsUp } from "lucide-react";

function useCountUp(target: number, duration: number = 2000) {
  const [count, setCount] = useState(0);
  const [isVisible, setIsVisible] = useState(false);
  const ref = useRef<HTMLDivElement>(null);

  useEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) setIsVisible(true);
      },
      { threshold: 0.5 }
    );
    if (ref.current) observer.observe(ref.current);
    return () => observer.disconnect();
  }, []);

  useEffect(() => {
    if (!isVisible) return;
    let start = 0;
    const increment = target / (duration / 16);
    const timer = setInterval(() => {
      start += increment;
      if (start >= target) {
        setCount(target);
        clearInterval(timer);
      } else {
        setCount(Math.floor(start));
      }
    }, 16);
    return () => clearInterval(timer);
  }, [isVisible, target, duration]);

  return { count, ref };
}

const stats = [
  { icon: Users, value: 200, suffix: "+", label: "طبيب واستشاري", color: "from-blue-500 to-indigo-600" },
  { icon: HeartHandshake, value: 50000, suffix: "+", label: "مريض تم علاجه", color: "from-emerald-500 to-teal-600" },
  { icon: Building2, value: 30, suffix: "+", label: "قسم طبي متخصص", color: "from-purple-500 to-violet-600" },
  { icon: Award, value: 15, suffix: "+", label: "جائزة تميز دولية", color: "from-amber-500 to-orange-600" },
  { icon: Stethoscope, value: 25, suffix: "+", label: "سنة من الخبرة", color: "from-rose-500 to-pink-600" },
  { icon: ThumbsUp, value: 98, suffix: "%", label: "نسبة رضا المرضى", color: "from-cyan-500 to-sky-600" },
];

function StatCard({ stat }: { stat: (typeof stats)[0] }) {
  const { count, ref } = useCountUp(stat.value);

  const displayValue = () => {
    if (stat.value >= 1000) return `${Math.floor(count / 1000)}K`;
    return count;
  };

  return (
    <div ref={ref} className="text-center group">
      <div className={`w-18 h-18 bg-gradient-to-br ${stat.color} rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300 w-[72px] h-[72px]`}>
        <stat.icon className="text-white" size={32} />
      </div>
      <div className="text-4xl md:text-5xl font-black text-white mb-2 tabular-nums">
        {displayValue()}
        <span className="text-accent-400">{stat.suffix}</span>
      </div>
      <div className="text-white/50 font-medium text-sm">{stat.label}</div>
    </div>
  );
}

export default function Stats() {
  return (
    <section className="py-24 bg-gradient-to-l from-primary-800 via-primary-900 to-gray-900 relative overflow-hidden">
      {/* Decorative */}
      <div className="absolute inset-0 pointer-events-none">
        <div className="absolute top-0 right-0 w-72 h-72 bg-accent-500/5 rounded-full blur-3xl"></div>
        <div className="absolute bottom-0 left-0 w-72 h-72 bg-primary-400/10 rounded-full blur-3xl"></div>
        <div className="absolute inset-0 opacity-[0.03]" style={{
          backgroundImage: `radial-gradient(circle, white 1px, transparent 1px)`,
          backgroundSize: '30px 30px'
        }}></div>
      </div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <div className="text-center mb-16">
          <span className="text-accent-400 font-bold text-sm bg-accent-500/10 px-5 py-2 rounded-full inline-block">إنجازاتنا</span>
          <h2 className="text-3xl md:text-4xl lg:text-5xl font-black text-white mt-5">
            أرقام تتحدث عن
            <span className="text-accent-400"> نجاحنا</span>
          </h2>
          <div className="flex items-center justify-center gap-2 mt-6">
            <span className="w-12 h-1 bg-white/20 rounded-full"></span>
            <span className="w-3 h-3 bg-accent-500 rounded-full"></span>
            <span className="w-12 h-1 bg-white/20 rounded-full"></span>
          </div>
        </div>
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-10">
          {stats.map((stat, index) => (
            <StatCard key={index} stat={stat} />
          ))}
        </div>
      </div>
    </section>
  );
}
