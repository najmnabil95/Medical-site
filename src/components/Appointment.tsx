import { useState } from "react";
import { Calendar, Clock, User, Phone, Stethoscope, MessageSquare, Send, CheckCircle, Shield, Star } from "lucide-react";
import { useScrollReveal } from "../hooks/useScrollReveal";
import { useData } from "../context/DataContext";
import { useApp } from "../context/AppContext";
import { useToast } from "../admin/components/Toast";

export default function Appointment() {
  const { departments, doctors } = useData();
  const { reservations, setReservations } = useApp();
  const { toast } = useToast();
  const [submitted, setSubmitted] = useState(false);
  const { ref, isVisible } = useScrollReveal();

  const [form, setForm] = useState({
    patientName: "",
    phone: "",
    department: "",
    doctor: "",
    date: "",
    time: "",
    notes: "",
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const newReservation = {
      id: Date.now().toString(),
      ...form,
      status: "pending" as const,
      type: "normal" as const, // ✅ حجز عادي
      createdAt: new Date().toISOString(),
    };
    setReservations([newReservation, ...reservations]);
    toast("success", "تم حجز الموعد بنجاح! سيتم التواصل معك للتأكيد");
    setSubmitted(true);
    setTimeout(() => {
      setSubmitted(false);
      setForm({ patientName: "", phone: "", department: "", doctor: "", date: "", time: "", notes: "" });
    }, 4000);
  };

  const today = new Date().toISOString().split("T")[0];

  // Filter doctors by selected department
  const filteredDoctors = doctors.filter(d => {
    if (d.active === false) return false;
    if (form.department && d.department) return d.department === form.department;
    return true;
  });

  return (
    <section id="appointment" className="py-24 bg-white relative overflow-hidden">
      {/* Background */}
      <div className="absolute inset-0 pointer-events-none">
        <div className="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary-50/80 to-transparent"></div>
        <div className="absolute bottom-0 left-0 w-72 h-72 bg-accent-100/30 rounded-full blur-3xl"></div>
      </div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <div ref={ref} className="grid lg:grid-cols-2 gap-16 items-stretch">
          {/* Info */}
          <div className={`space-y-7 ${isVisible ? "animate-fade-in-up" : "opacity-0"}`}>
            <div>
              <span className="text-accent-600 font-bold text-sm tracking-wider bg-accent-100 px-5 py-2 rounded-full inline-block">
                احجز موعدك
              </span>
              <h2 className="text-3xl md:text-4xl lg:text-[2.75rem] font-black text-gray-900 mt-5 leading-tight">
                احجز موعدك
                <br />
                <span className="gradient-text">بكل سهولة ويسر</span>
              </h2>
              <p className="text-gray-500 mt-5 text-lg leading-relaxed max-w-lg">
                يمكنك حجز موعدك مع الطبيب المختص بكل سهولة من خلال تعبئة النموذج التالي
              </p>
            </div>

            {/* Features */}
            <div className="space-y-4">
              {[
                { icon: Clock, title: "مواعيد مرنة", desc: "اختر الوقت والتاريخ المناسب لك", color: "bg-primary-50 text-primary-600" },
                { icon: CheckCircle, title: "تأكيد فوري", desc: "ستتلقى تأكيد الموعد برسالة نصية فوراً", color: "bg-accent-50 text-accent-600" },
                { icon: Stethoscope, title: "اختر طبيبك", desc: "حرية اختيار الطبيب والتخصص المناسب", color: "bg-purple-50 text-purple-600" },
                { icon: Shield, title: "تأمين طبي", desc: "نتعامل مع أكثر من 25 شركة تأمين معتمدة", color: "bg-blue-50 text-blue-600" },
              ].map((feature, i) => (
                <div key={i} className="flex items-center gap-4 bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                  <div className={`w-12 h-12 ${feature.color} rounded-xl flex items-center justify-center shrink-0`}>
                    <feature.icon size={22} />
                  </div>
                  <div>
                    <h4 className="font-bold text-gray-900 text-sm">{feature.title}</h4>
                    <p className="text-gray-500 text-xs">{feature.desc}</p>
                  </div>
                </div>
              ))}
            </div>

            {/* Emergency Card */}
            <div className="bg-gradient-to-l from-red-500 to-red-600 rounded-2xl p-7 text-white relative overflow-hidden">
              <div className="absolute top-0 left-0 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
              <div className="flex items-center gap-5 relative">
                <div className="w-16 h-16 bg-white/15 rounded-2xl flex items-center justify-center animate-pulse-soft shrink-0">
                  <Phone className="text-white" size={30} />
                </div>
                <div>
                  <p className="text-white/70 text-sm font-medium">للحالات الطارئة اتصل بنا الآن</p>
                  <a href="tel:920012345" className="text-3xl font-black mt-1 block" dir="ltr">920 012 345</a>
                  <div className="flex items-center gap-1 mt-1">
                    <span className="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                    <span className="text-white/60 text-xs">متاح على مدار الساعة</span>
                  </div>
                </div>
              </div>
            </div>

            {/* Trust Badges */}
            <div className="flex items-center gap-4 pt-2">
              <div className="flex items-center gap-1">
                {[...Array(5)].map((_, i) => (
                  <Star key={i} size={16} className="text-yellow-500 fill-yellow-500" />
                ))}
              </div>
              <span className="text-gray-500 text-sm">تقييم 4.9 من أصل 5 | أكثر من 5000 تقييم</span>
            </div>
          </div>

          {/* Form */}
          <div className={`bg-white rounded-3xl p-8 md:p-10 shadow-2xl border border-gray-100 relative ${isVisible ? "animate-slide-in-left" : "opacity-0"}`}>
            <div className="absolute top-0 left-0 w-20 h-20 bg-gradient-to-br from-primary-500 to-accent-500 rounded-br-3xl rounded-tl-3xl opacity-10"></div>

            {submitted ? (
              <div className="text-center py-20 space-y-5">
                <div className="w-24 h-24 bg-accent-100 rounded-full flex items-center justify-center mx-auto animate-scale-in">
                  <CheckCircle className="text-accent-500" size={48} />
                </div>
                <h3 className="text-2xl font-bold text-gray-900">تم الحجز بنجاح! 🎉</h3>
                <p className="text-gray-500 max-w-sm mx-auto">سيتم التواصل معك قريباً عبر رسالة نصية لتأكيد موعدك</p>
              </div>
            ) : (
              <form onSubmit={handleSubmit} className="space-y-5 relative">
                <h3 className="text-2xl font-bold text-gray-900 mb-8">نموذج حجز موعد</h3>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div className="relative">
                    <User className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                    <input
                      type="text"
                      value={form.patientName}
                      onChange={(e) => setForm({ ...form, patientName: e.target.value })}
                      placeholder="الاسم الكامل"
                      required
                      className="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm"
                    />
                  </div>
                  <div className="relative">
                    <Phone className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                    <input
                      type="tel"
                      value={form.phone}
                      onChange={(e) => setForm({ ...form, phone: e.target.value })}
                      placeholder="رقم الجوال"
                      required
                      className="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm"
                    />
                  </div>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div className="relative">
                    <Stethoscope className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                    <select
                      value={form.department}
                      onChange={(e) => setForm({ ...form, department: e.target.value, doctor: "" })}
                      required
                      className="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm appearance-none text-gray-600"
                    >
                      <option value="">اختر القسم المطلوب</option>
                      {departments.filter(d => d.active !== false).map((d) => (
                        <option key={d.id} value={d.name}>{d.name}</option>
                      ))}
                    </select>
                  </div>
                  <div className="relative">
                    <User className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                    <select
                      value={form.doctor}
                      onChange={(e) => setForm({ ...form, doctor: e.target.value })}
                      className="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm appearance-none text-gray-600"
                    >
                      <option value="">اختر الطبيب (اختياري)</option>
                      {filteredDoctors.map((d) => (
                        <option key={d.id} value={d.name}>{d.name}</option>
                      ))}
                    </select>
                  </div>
                </div>

                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                  <div className="relative">
                    <Calendar className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                    <input
                      type="date"
                      value={form.date}
                      onChange={(e) => setForm({ ...form, date: e.target.value })}
                      min={today}
                      required
                      className="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm"
                    />
                  </div>
                  <div className="relative">
                    <Clock className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                    <select
                      value={form.time}
                      onChange={(e) => setForm({ ...form, time: e.target.value })}
                      required
                      className="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm appearance-none text-gray-600"
                    >
                      <option value="">اختر الوقت المفضل</option>
                      {["08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00"].map(t => (
                        <option key={t} value={t}>{t}</option>
                      ))}
                    </select>
                  </div>
                </div>

                <div className="relative">
                  <MessageSquare className="absolute right-4 top-4 text-gray-400" size={18} />
                  <textarea
                    value={form.notes}
                    onChange={(e) => setForm({ ...form, notes: e.target.value })}
                    placeholder="ملاحظات إضافية أو وصف للحالة (اختياري)"
                    rows={3}
                    className="w-full pr-12 pl-4 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm resize-none"
                  ></textarea>
                </div>

                <button
                  type="submit"
                  className="w-full bg-gradient-to-l from-primary-500 to-primary-700 text-white py-4.5 rounded-xl font-bold text-lg hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-1 flex items-center justify-center gap-3 group"
                >
                  <Send size={20} className="group-hover:-translate-x-1 group-hover:-translate-y-1 transition-transform" />
                  <span>تأكيد الحجز</span>
                </button>

                <p className="text-gray-400 text-xs text-center mt-2">
                  🔒 بياناتك محمية وسرية بالكامل
                </p>
              </form>
            )}
          </div>
        </div>
      </div>
    </section>
  );
}
