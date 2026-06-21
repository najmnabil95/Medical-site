import { useState, useEffect } from "react";
import { Phone, Calendar, ArrowLeft, Shield, Heart, Award, ChevronLeft, ChevronRight } from "lucide-react";
import { createScrollHandler } from "../utils/scroll";

const slides = [
  {
    image: "https://images.pexels.com/photos/18112241/pexels-photo-18112241.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=1000&w=1800",
    title1: "صحتك أولاً",
    title2: "رعاية طبية متميزة",
    desc: "نقدم لكم أرقى خدمات الرعاية الصحية بأحدث التقنيات العالمية وفريق طبي متميز من أفضل الاستشاريين والأطباء المتخصصين",
  },
  {
    image: "https://images.pexels.com/photos/20081928/pexels-photo-20081928.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=1000&w=1800",
    title1: "تقنيات عالمية",
    title2: "جراحات متقدمة",
    desc: "غرف عمليات مجهزة بأحدث الأجهزة العالمية وفريق جراحي متخصص لضمان أعلى معايير السلامة والنجاح",
  },
  {
    image: "https://images.pexels.com/photos/4769133/pexels-photo-4769133.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=1000&w=1800",
    title1: "فريق متخصص",
    title2: "نخبة من الأطباء",
    desc: "أكثر من 200 طبيب واستشاري في مختلف التخصصات الطبية يقدمون لكم أفضل خدمات الرعاية الصحية",
  },
];

export default function Hero() {
  const [current, setCurrent] = useState(0);
  const [isAnimating, setIsAnimating] = useState(false);

  useEffect(() => {
    const timer = setInterval(() => {
      goToSlide((current + 1) % slides.length);
    }, 6000);
    return () => clearInterval(timer);
  }, [current]);

  const goToSlide = (index: number) => {
    if (isAnimating) return;
    setIsAnimating(true);
    setCurrent(index);
    setTimeout(() => setIsAnimating(false), 800);
  };

  const nextSlide = () => goToSlide((current + 1) % slides.length);
  const prevSlide = () => goToSlide((current - 1 + slides.length) % slides.length);

  return (
    <section id="home" className="relative min-h-[92vh] flex items-center overflow-hidden">
      {/* Background Images */}
      {slides.map((slide, index) => (
        <div
          key={index}
          className={`absolute inset-0 transition-all duration-1000 ${
            index === current ? "opacity-100 scale-100" : "opacity-0 scale-105"
          }`}
        >
          <img
            src={slide.image}
            alt="المستشفى"
            className="w-full h-full object-cover"
          />
          <div className="absolute inset-0 bg-gradient-to-l from-primary-900/95 via-primary-800/80 to-primary-700/65"></div>
        </div>
      ))}

      {/* Decorative Elements */}
      <div className="absolute inset-0 pointer-events-none">
        <div className="absolute top-20 left-10 w-80 h-80 bg-accent-500/8 rounded-full blur-3xl animate-float"></div>
        <div className="absolute bottom-20 right-10 w-96 h-96 bg-primary-400/8 rounded-full blur-3xl animate-float animation-delay-500"></div>
        {/* Grid Pattern */}
        <div className="absolute inset-0 opacity-[0.03]" style={{
          backgroundImage: `linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px)`,
          backgroundSize: '50px 50px'
        }}></div>
        {/* Rotating Circle */}
        <div className="absolute -top-32 -left-32 w-64 h-64 border border-white/5 rounded-full animate-rotate-slow"></div>
        <div className="absolute -bottom-20 -right-20 w-96 h-96 border border-white/5 rounded-full animate-rotate-slow" style={{ animationDirection: 'reverse' }}></div>
      </div>

      <div className="relative max-w-7xl mx-auto px-4 py-20 w-full">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          {/* Content */}
          <div className="text-white space-y-8">
            <div key={current} className="animate-fade-in-up">
              <div className="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm px-5 py-2.5 rounded-full border border-white/20 mb-6">
                <span className="w-2.5 h-2.5 bg-accent-500 rounded-full animate-pulse"></span>
                <span className="text-sm font-medium">نرحب بكم في مستشفى الشفاء الدولي</span>
              </div>
              <h1 className="text-4xl md:text-5xl lg:text-[3.5rem] font-black leading-[1.2]">
                {slides[current].title1}
                <br />
                <span className="text-transparent bg-clip-text bg-gradient-to-l from-accent-400 to-emerald-300">
                  {slides[current].title2}
                </span>
              </h1>
            </div>

            <p key={`desc-${current}`} className="text-lg text-white/75 max-w-xl leading-relaxed animate-fade-in-up animation-delay-200">
              {slides[current].desc}
            </p>

            <div className="flex flex-wrap gap-4 animate-fade-in-up animation-delay-400">
              <a
                href="#appointment"
                onClick={createScrollHandler("appointment")}
                className="group bg-gradient-to-l from-accent-500 to-accent-600 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:shadow-2xl hover:shadow-accent-500/30 transition-all duration-300 hover:-translate-y-1 flex items-center gap-3 cursor-pointer"
              >
                <Calendar size={22} />
                <span>احجز موعدك الآن</span>
                <ArrowLeft size={18} className="group-hover:-translate-x-2 transition-transform duration-300" />
              </a>
              <a
                href="tel:920012345"
                className="bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all border border-white/20 flex items-center gap-3 group"
              >
                <Phone size={22} className="group-hover:animate-bounce-gentle" />
                <span>اتصل بنا</span>
              </a>
            </div>

            {/* Stats */}
            <div className="grid grid-cols-3 gap-6 pt-4">
              {[
                { value: "+25", label: "سنة خبرة" },
                { value: "+200", label: "طبيب متخصص" },
                { value: "+50K", label: "مريض سعيد" },
              ].map((stat, i) => (
                <div key={i} className={`text-center ${i === 1 ? "border-x border-white/10" : ""}`}>
                  <div className="text-3xl md:text-4xl font-black text-accent-400">{stat.value}</div>
                  <div className="text-sm text-white/50 mt-1 font-medium">{stat.label}</div>
                </div>
              ))}
            </div>
          </div>

          {/* Right Side - Feature Cards */}
          <div className="hidden lg:block space-y-4">
            {[
              { icon: Shield, title: "رعاية شاملة", desc: "خدمات طبية متكاملة تحت سقف واحد", gradient: "from-accent-500 to-accent-600" },
              { icon: Heart, title: "تقنيات متطورة", desc: "أحدث الأجهزة والتقنيات الطبية العالمية", gradient: "from-blue-500 to-blue-600" },
              { icon: Award, title: "أطباء متميزون", desc: "نخبة من أفضل الأطباء والاستشاريين", gradient: "from-purple-500 to-purple-600" },
            ].map((card, i) => (
              <div
                key={i}
                className="bg-white/[0.07] backdrop-blur-md rounded-2xl p-6 border border-white/10 hover:bg-white/[0.12] transition-all duration-500 cursor-pointer group hover:-translate-x-2"
                style={{ animationDelay: `${i * 200}ms` }}
              >
                <div className="flex items-center gap-4">
                  <div className={`w-14 h-14 bg-gradient-to-br ${card.gradient} rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300`}>
                    <card.icon className="text-white" size={28} />
                  </div>
                  <div className="flex-1">
                    <h3 className="text-white font-bold text-lg">{card.title}</h3>
                    <p className="text-white/50 text-sm">{card.desc}</p>
                  </div>
                  <ArrowLeft size={18} className="text-white/30 group-hover:text-white/80 group-hover:-translate-x-1 transition-all" />
                </div>
              </div>
            ))}
          </div>
        </div>

        {/* Slider Controls */}
        <div className="absolute bottom-28 left-1/2 -translate-x-1/2 flex items-center gap-4">
          <button onClick={prevSlide} className="w-11 h-11 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all">
            <ChevronRight size={20} />
          </button>
          <div className="flex items-center gap-2">
            {slides.map((_, i) => (
              <button
                key={i}
                onClick={() => goToSlide(i)}
                className={`transition-all duration-500 rounded-full ${
                  i === current ? "w-10 h-3 bg-accent-500" : "w-3 h-3 bg-white/30 hover:bg-white/50"
                }`}
              />
            ))}
          </div>
          <button onClick={nextSlide} className="w-11 h-11 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all">
            <ChevronLeft size={20} />
          </button>
        </div>
      </div>

      {/* Bottom Wave */}
      <div className="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M0 120L60 105C120 90 240 60 360 52.5C480 45 600 60 720 67.5C840 75 960 75 1080 67.5C1200 60 1320 45 1380 37.5L1440 30V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="white"/>
        </svg>
      </div>
    </section>
  );
}
