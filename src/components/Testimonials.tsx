import { useState, useEffect } from "react";
import { Star, Quote, ChevronLeft, ChevronRight } from "lucide-react";
import SectionHeader from "./SectionHeader";

const testimonials = [
  {
    name: "محمد بن عبدالله",
    role: "مريض - جراحة القلب",
    text: "تجربة رائعة في مستشفى الشفاء. الفريق الطبي كان محترفاً للغاية والرعاية كانت ممتازة من لحظة الدخول حتى الخروج. أنصح بشدة بهذا المستشفى لكل من يبحث عن رعاية طبية متميزة.",
    rating: 5,
    avatar: "م",
    color: "from-primary-500 to-primary-600",
  },
  {
    name: "فاطمة الزهراء",
    role: "مريضة - طب العيون",
    text: "أجريت عملية تصحيح النظر بالليزر وكانت النتائج مذهلة. الدكتور كان متعاوناً جداً وشرح لي كل الخطوات بالتفصيل. شكراً لمستشفى الشفاء على هذه التجربة المميزة.",
    rating: 5,
    avatar: "ف",
    color: "from-accent-500 to-accent-600",
  },
  {
    name: "عبدالرحمن السعيد",
    role: "مريض - جراحة العظام",
    text: "بعد إصابتي في الركبة، كنت قلقاً جداً من العملية. لكن الفريق الطبي في مستشفى الشفاء أعاد لي الثقة وتعافيت بشكل كامل. خدمة استثنائية ومتابعة دقيقة بعد العملية.",
    rating: 5,
    avatar: "ع",
    color: "from-purple-500 to-violet-600",
  },
  {
    name: "نورة القحطاني",
    role: "أم مريض - طب الأطفال",
    text: "ابني كان يعاني من مشكلة صحية وكان قسم الأطفال ممتازاً. الأطباء والممرضات تعاملوا معه بكل حب واهتمام. أشكرهم من كل قلبي على الرعاية الاستثنائية.",
    rating: 5,
    avatar: "ن",
    color: "from-rose-500 to-pink-600",
  },
  {
    name: "خالد العتيبي",
    role: "مريض - الطب الباطني",
    text: "المستشفى نظيف ومنظم والخدمة سريعة. الأطباء يستمعون بعناية ويشرحون الحالة بالتفصيل. تجربة رائعة بكل المقاييس وأنصح الجميع بزيارة هذا المستشفى المتميز.",
    rating: 4,
    avatar: "خ",
    color: "from-amber-500 to-orange-600",
  },
];

export default function Testimonials() {
  const [active, setActive] = useState(0);
  const [, setDirection] = useState<'next' | 'prev'>('next');

  useEffect(() => {
    const timer = setInterval(() => {
      setDirection('next');
      setActive((prev) => (prev + 1) % testimonials.length);
    }, 5000);
    return () => clearInterval(timer);
  }, [active]);

  const next = () => {
    setDirection('next');
    setActive((prev) => (prev + 1) % testimonials.length);
  };
  const prev = () => {
    setDirection('prev');
    setActive((prev) => (prev - 1 + testimonials.length) % testimonials.length);
  };

  return (
    <section id="testimonials" className="py-24 bg-gray-50 relative overflow-hidden">
      {/* Decorative */}
      <div className="absolute top-20 left-20 w-64 h-64 bg-primary-100/40 rounded-full blur-3xl"></div>
      <div className="absolute bottom-20 right-20 w-64 h-64 bg-accent-100/40 rounded-full blur-3xl"></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <SectionHeader
          badge="آراء المرضى"
          title="ماذا يقول"
          highlight="مرضانا عنا"
          description="رضا مرضانا هو أعظم إنجازاتنا ودافعنا للتميز المستمر"
        />

        <div className="max-w-5xl mx-auto">
          {/* Main Testimonial */}
          <div className="bg-white rounded-[2rem] p-8 md:p-12 shadow-xl border border-gray-100 relative">
            <Quote className="absolute top-8 right-8 text-primary-100" size={70} />
            
            <div className="relative">
              <div key={active} className="animate-fade-in-up">
                <div className="flex items-center gap-5 mb-8">
                  <div className={`w-18 h-18 bg-gradient-to-br ${testimonials[active].color} rounded-2xl flex items-center justify-center text-white text-3xl font-bold shadow-lg w-[72px] h-[72px]`}>
                    {testimonials[active].avatar}
                  </div>
                  <div>
                    <h4 className="text-xl font-bold text-gray-900">{testimonials[active].name}</h4>
                    <p className="text-primary-600 text-sm font-medium mt-1">{testimonials[active].role}</p>
                    <div className="flex items-center gap-1 mt-2">
                      {Array.from({ length: 5 }).map((_, i) => (
                        <Star
                          key={i}
                          size={16}
                          className={
                            i < testimonials[active].rating
                              ? "text-yellow-500 fill-yellow-500"
                              : "text-gray-200"
                          }
                        />
                      ))}
                    </div>
                  </div>
                </div>

                <blockquote className="text-gray-600 text-xl leading-[1.9] font-medium">
                  "{testimonials[active].text}"
                </blockquote>
              </div>
            </div>

            {/* Navigation */}
            <div className="flex items-center justify-between mt-10 pt-8 border-t border-gray-100">
              <div className="flex items-center gap-2">
                {testimonials.map((_, index) => (
                  <button
                    key={index}
                    onClick={() => {
                      setDirection(index > active ? 'next' : 'prev');
                      setActive(index);
                    }}
                    className={`transition-all duration-500 rounded-full ${
                      index === active
                        ? "w-10 h-3 bg-gradient-to-l from-primary-500 to-primary-600"
                        : "w-3 h-3 bg-gray-200 hover:bg-gray-300"
                    }`}
                  />
                ))}
              </div>
              <div className="flex items-center gap-3">
                <button
                  onClick={prev}
                  className="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-gray-600 hover:bg-primary-600 hover:text-white transition-all duration-300 hover:shadow-lg"
                >
                  <ChevronRight size={20} />
                </button>
                <button
                  onClick={next}
                  className="w-12 h-12 bg-primary-600 rounded-xl flex items-center justify-center text-white hover:bg-primary-700 transition-all duration-300 shadow-lg shadow-primary-500/30"
                >
                  <ChevronLeft size={20} />
                </button>
              </div>
            </div>
          </div>

          {/* Testimonial Avatars */}
          <div className="flex items-center justify-center gap-4 mt-8">
            {testimonials.map((t, index) => (
              <button
                key={index}
                onClick={() => {
                  setDirection(index > active ? 'next' : 'prev');
                  setActive(index);
                }}
                className={`transition-all duration-500 ${
                  index === active ? "scale-125 z-10" : "scale-100 opacity-60 hover:opacity-80"
                }`}
              >
                <div className={`w-14 h-14 bg-gradient-to-br ${t.color} rounded-2xl flex items-center justify-center text-white font-bold shadow-lg ${
                  index === active ? "ring-4 ring-white shadow-xl" : ""
                }`}>
                  {t.avatar}
                </div>
              </button>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
