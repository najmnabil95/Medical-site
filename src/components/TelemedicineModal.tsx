import { useState } from "react";
import { Video, Phone, MessageSquare, Calendar, Clock, User, FileText, CreditCard, CheckCircle, Wifi } from "lucide-react";
import { useApp } from "../context/AppContext";
import { useToast } from "../admin/components/Toast";

interface TelemedicineModalProps {
  isOpen: boolean;
  onClose: () => void;
}

const consultationTypes = [
  {
    id: "video",
    name: "استشارة فيديو",
    icon: Video,
    price: 150,
    duration: 30,
    description: "مكالمة فيديو مباشرة مع الطبيب",
  },
  {
    id: "audio",
    name: "استشارة صوتية",
    icon: Phone,
    price: 100,
    duration: 20,
    description: "مكالمة صوتية مع الطبيب",
  },
  {
    id: "chat",
    name: "استشارة كتابية",
    icon: MessageSquare,
    price: 75,
    duration: 60,
    description: "محادثة كتابية لمدة ساعة",
  },
];

const platforms = [
  { id: "zoom", name: "Zoom", icon: "🎥" },
  { id: "whatsapp", name: "واتساب", icon: "💬" },
  { id: "skype", name: "سكايب", icon: "🌐" },
  { id: "phone", name: "اتصال هاتفي", icon: "📞" },
];

export default function TelemedicineModal({ isOpen, onClose }: TelemedicineModalProps) {
  const { reservations, setReservations } = useApp();
  const { toast } = useToast();
  const [submitted, setSubmitted] = useState(false);

  const [form, setForm] = useState({
    patientName: "",
    phone: "",
    email: "",
    consultationType: "video",
    platform: "zoom",
    specialty: "",
    date: "",
    time: "",
    symptoms: "",
    paymentMethod: "online",
  });

  const selectedConsultation = consultationTypes.find(c => c.id === form.consultationType);
  const vat = selectedConsultation ? selectedConsultation.price * 0.15 : 0;
  const total = selectedConsultation ? selectedConsultation.price + vat : 0;

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    const newReservation = {
      id: Date.now().toString(),
      patientName: form.patientName,
      phone: form.phone,
      department: `استشارة عن بُعد - ${selectedConsultation?.name}`,
      doctor: "",
      date: form.date,
      time: form.time,
      type: "consultation" as const, // ✅ استشارة عن بُعد
      notes: `نوع الاستشارة: ${selectedConsultation?.name}\nالمنصة: ${platforms.find(p => p.id === form.platform)?.name}\nالمشكلة: ${form.symptoms}\nالبريد: ${form.email}\nطريقة الدفع: ${form.paymentMethod === "online" ? "دفع إلكتروني" : "بعد الاستشارة"}\nالمبلغ: ${total} ر.س`,
      status: "pending" as const,
      createdAt: new Date().toISOString(),
    };

    setReservations([newReservation, ...reservations]);
    toast("success", "تم حجز الاستشارة بنجاح! سيتم التواصل معك لتأكيد الموعد");
    setSubmitted(true);

    setTimeout(() => {
      setSubmitted(false);
      setForm({
        patientName: "",
        phone: "",
        email: "",
        consultationType: "video",
        platform: "zoom",
        specialty: "",
        date: "",
        time: "",
        symptoms: "",
        paymentMethod: "online",
      });
      onClose();
    }, 3000);
  };

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 overflow-y-auto">
      <div className="fixed inset-0 bg-black/70 backdrop-blur-sm" onClick={onClose}></div>
      
      <div className="relative bg-white rounded-3xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto animate-scale-in">
        {/* Header */}
        <div className="sticky top-0 bg-gradient-to-l from-purple-600 to-indigo-700 text-white px-6 py-5 rounded-t-3xl z-10">
          <button
            onClick={onClose}
            className="absolute top-4 left-4 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-colors"
          >
            ✕
          </button>
          <div className="flex items-center gap-3">
            <div className="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <Wifi size={24} className="text-white" />
            </div>
            <div>
              <h3 className="text-2xl font-bold">حجز استشارة عن بُعد</h3>
              <p className="text-sm text-white/70">استشر طبيبك من منزلك</p>
            </div>
          </div>
        </div>

        <div className="p-6">
          {submitted ? (
            <div className="text-center py-16 space-y-5">
              <div className="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto animate-scale-in">
                <CheckCircle className="text-green-500" size={48} />
              </div>
              <h3 className="text-2xl font-bold text-gray-900">تم حجز الاستشارة بنجاح! 🎉</h3>
              <p className="text-gray-500 max-w-md mx-auto">
                سيتم التواصل معك قريباً عبر رسالة نصية وواتساب لتأكيد الموعد وإرسال رابط الاستشارة
              </p>
            </div>
          ) : (
            <form onSubmit={handleSubmit} className="space-y-6">
              {/* Consultation Type */}
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-3">نوع الاستشارة *</label>
                <div className="grid grid-cols-3 gap-3">
                  {consultationTypes.map((type) => (
                    <button
                      key={type.id}
                      type="button"
                      onClick={() => setForm({ ...form, consultationType: type.id })}
                      className={`p-4 rounded-xl border-2 transition-all ${
                        form.consultationType === type.id
                          ? "border-purple-500 bg-purple-50"
                          : "border-gray-200 hover:border-gray-300"
                      }`}
                    >
                      <type.icon
                        size={24}
                        className={`mx-auto mb-2 ${
                          form.consultationType === type.id ? "text-purple-600" : "text-gray-400"
                        }`}
                      />
                      <div className="text-sm font-bold text-gray-800">{type.name}</div>
                      <div className="text-xs text-gray-500 mt-1">{type.duration} دقيقة</div>
                      <div className="text-sm font-bold text-purple-600 mt-2">{type.price} ر.س</div>
                    </button>
                  ))}
                </div>
              </div>

              {/* Platform */}
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-3">منصة التواصل *</label>
                <div className="grid grid-cols-4 gap-2">
                  {platforms.map((platform) => (
                    <button
                      key={platform.id}
                      type="button"
                      onClick={() => setForm({ ...form, platform: platform.id })}
                      className={`p-3 rounded-xl border-2 transition-all ${
                        form.platform === platform.id
                          ? "border-purple-500 bg-purple-50"
                          : "border-gray-200 hover:border-gray-300"
                      }`}
                    >
                      <div className="text-2xl mb-1">{platform.icon}</div>
                      <div className="text-xs font-bold text-gray-700">{platform.name}</div>
                    </button>
                  ))}
                </div>
              </div>

              {/* Patient Info */}
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-bold text-gray-700 mb-2">الاسم الكامل *</label>
                  <div className="relative">
                    <User className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                    <input
                      type="text"
                      value={form.patientName}
                      onChange={(e) => setForm({ ...form, patientName: e.target.value })}
                      required
                      className="w-full pr-10 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-purple-500"
                      placeholder="الاسم الكامل"
                    />
                  </div>
                </div>
                <div>
                  <label className="block text-sm font-bold text-gray-700 mb-2">رقم الجوال *</label>
                  <div className="relative">
                    <Phone className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                    <input
                      type="tel"
                      value={form.phone}
                      onChange={(e) => setForm({ ...form, phone: e.target.value })}
                      required
                      className="w-full pr-10 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-purple-500"
                      placeholder="05xxxxxxxx"
                    />
                  </div>
                </div>
              </div>

              {/* Email */}
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني *</label>
                <input
                  type="email"
                  value={form.email}
                  onChange={(e) => setForm({ ...form, email: e.target.value })}
                  required
                  className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-purple-500"
                  placeholder="example@email.com"
                />
                <p className="text-xs text-gray-500 mt-1">سيتم إرسال رابط الاستشارة على هذا البريد</p>
              </div>

              {/* Specialty */}
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-2">التخصص المطلوب *</label>
                <select
                  value={form.specialty}
                  onChange={(e) => setForm({ ...form, specialty: e.target.value })}
                  required
                  className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-purple-500"
                >
                  <option value="">اختر التخصص</option>
                  <option value="قلب">أمراض القلب</option>
                  <option value="باطنية">الطب الباطني</option>
                  <option value="أطفال">طب الأطفال</option>
                  <option value="نفسية">الطب النفسي</option>
                  <option value="جلدية">الأمراض الجلدية</option>
                  <option value="عظام">جراحة العظام</option>
                  <option value="عيون">طب العيون</option>
                  <option value="أخرى">أخرى</option>
                </select>
              </div>

              {/* Date & Time */}
              <div className="grid grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-bold text-gray-700 mb-2">التاريخ *</label>
                  <div className="relative">
                    <Calendar className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                    <input
                      type="date"
                      value={form.date}
                      onChange={(e) => setForm({ ...form, date: e.target.value })}
                      required
                      min={new Date().toISOString().split("T")[0]}
                      className="w-full pr-10 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-purple-500"
                    />
                  </div>
                </div>
                <div>
                  <label className="block text-sm font-bold text-gray-700 mb-2">الوقت *</label>
                  <div className="relative">
                    <Clock className="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                    <input
                      type="time"
                      value={form.time}
                      onChange={(e) => setForm({ ...form, time: e.target.value })}
                      required
                      className="w-full pr-10 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-purple-500"
                    />
                  </div>
                </div>
              </div>

              {/* Symptoms */}
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-2">وصف المشكلة الصحية *</label>
                <div className="relative">
                  <FileText className="absolute right-3 top-3 text-gray-400" size={18} />
                  <textarea
                    value={form.symptoms}
                    onChange={(e) => setForm({ ...form, symptoms: e.target.value })}
                    required
                    rows={4}
                    className="w-full pr-10 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-purple-500 resize-none"
                    placeholder="اشرح مشكلتك الصحية بالتفصيل لمساعدتنا في تحديد الطبيب المناسب..."
                  />
                </div>
              </div>

              {/* Payment Method */}
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-3">طريقة الدفع *</label>
                <div className="grid grid-cols-2 gap-3">
                  <button
                    type="button"
                    onClick={() => setForm({ ...form, paymentMethod: "online" })}
                    className={`p-4 rounded-xl border-2 transition-all ${
                      form.paymentMethod === "online"
                        ? "border-purple-500 bg-purple-50"
                        : "border-gray-200 hover:border-gray-300"
                    }`}
                  >
                    <CreditCard
                      size={24}
                      className={`mx-auto mb-2 ${
                        form.paymentMethod === "online" ? "text-purple-600" : "text-gray-400"
                      }`}
                    />
                    <div className="text-sm font-bold text-gray-800">دفع إلكتروني</div>
                    <div className="text-xs text-gray-500 mt-1">بطاقة ائتمان / مدى</div>
                  </button>
                  <button
                    type="button"
                    onClick={() => setForm({ ...form, paymentMethod: "after" })}
                    className={`p-4 rounded-xl border-2 transition-all ${
                      form.paymentMethod === "after"
                        ? "border-purple-500 bg-purple-50"
                        : "border-gray-200 hover:border-gray-300"
                    }`}
                  >
                    <Wallet
                      size={24}
                      className={`mx-auto mb-2 ${
                        form.paymentMethod === "after" ? "text-purple-600" : "text-gray-400"
                      }`}
                    />
                    <div className="text-sm font-bold text-gray-800">الدفع بعد الاستشارة</div>
                    <div className="text-xs text-gray-500 mt-1">تحويل بنكي / كاش</div>
                  </button>
                </div>
              </div>

              {/* Price Summary */}
              {selectedConsultation && (
                <div className="bg-purple-50 rounded-xl p-4 space-y-2">
                  <div className="flex items-center justify-between text-sm">
                    <span className="text-gray-600">{selectedConsultation.name}</span>
                    <span className="font-bold text-gray-800">{selectedConsultation.price} ر.س</span>
                  </div>
                  <div className="flex items-center justify-between text-sm">
                    <span className="text-gray-600">المدة</span>
                    <span className="font-bold text-gray-800">{selectedConsultation.duration} دقيقة</span>
                  </div>
                  <div className="flex items-center justify-between text-sm">
                    <span className="text-gray-600">ضريبة القيمة المضافة (15%)</span>
                    <span className="font-bold text-gray-800">{vat.toFixed(2)} ر.س</span>
                  </div>
                  <div className="border-t border-purple-200 pt-2 mt-2">
                    <div className="flex items-center justify-between">
                      <span className="font-bold text-gray-800">الإجمالي</span>
                      <span className="text-2xl font-black text-purple-600">{total.toFixed(2)} ر.س</span>
                    </div>
                  </div>
                </div>
              )}

              {/* Submit Button */}
              <button
                type="submit"
                className="w-full bg-gradient-to-l from-purple-500 to-indigo-600 text-white py-4 rounded-xl font-bold text-lg hover:shadow-xl hover:shadow-purple-500/30 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-3"
              >
                <Wifi size={20} />
                <span>تأكيد حجز الاستشارة</span>
              </button>

              <p className="text-xs text-gray-400 text-center">
                🔒 بياناتك محمية وسرية | سيتم إرسال رابط الاستشارة عبر البريد والواتساب
              </p>
            </form>
          )}
        </div>
      </div>
    </div>
  );
}

const Wallet = ({ size, className }: { size: number; className?: string }) => (
  <svg width={size} height={size} className={className} fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
  </svg>
);
