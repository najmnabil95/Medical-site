import { useState, useEffect } from "react";
import { Calendar, Clock, User, Phone, Stethoscope, Send, CheckCircle, X } from "lucide-react";
import { useData } from "../context/DataContext";
import { useApp } from "../context/AppContext";
import { useToast } from "../admin/components/Toast";

interface AppointmentModalProps {
  isOpen: boolean;
  onClose: () => void;
  onSuccess?: () => void; // يُستدعى فقط عند الحجز الناجح
  offerId?: string; // معرف العرض (إذا كان حجز عرض)
  prefill?: {
    doctor?: string;
    department?: string;
    locked?: boolean; // لقفل حقول الطبيب والقسم
  };
}

export default function AppointmentModal({ isOpen, onClose, onSuccess, offerId, prefill }: AppointmentModalProps) {
  const { departments, doctors } = useData();
  const { reservations, setReservations } = useApp();
  const { toast } = useToast();

  const [form, setForm] = useState({
    patientName: "",
    phone: "",
    department: "",
    doctor: "",
    date: "",
    time: "",
    notes: "",
  });
  const [submitted, setSubmitted] = useState(false);

  // إعادة تعيين النموذج عند فتح المودال
  useEffect(() => {
    if (isOpen) {
      setForm({
        patientName: "",
        phone: "",
        department: prefill?.department || "",
        doctor: prefill?.doctor || "",
        date: "",
        time: "",
        notes: "",
      });
      setSubmitted(false);
    }
  }, [isOpen, prefill?.department, prefill?.doctor]);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const newRes = {
      id: Date.now().toString(),
      ...form,
      status: "pending" as const,
      type: offerId ? "offer" as const : "normal" as const, // ✅ حجز عرض أو عادي
      offerId: offerId, // ✅ حفظ معرف العرض
      createdAt: new Date().toISOString(),
    };
    setReservations([newRes, ...reservations]);
    setSubmitted(true);
    toast("success", "تم حجز الموعد بنجاح! سيتم التواصل معك للتأكيد");

    // استدعاء onSuccess عند الحجز الناجح
    if (onSuccess) {
      onSuccess();
    }

    setTimeout(() => {
      setSubmitted(false);
      setForm({ patientName: "", phone: "", department: "", doctor: "", date: "", time: "", notes: "" });
      onClose();
    }, 2500);
  };

  if (!isOpen) return null;

  const today = new Date().toISOString().split("T")[0];

  return (
    <div className="fixed inset-0 z-[100] flex items-center justify-center p-4">
      <div className="fixed inset-0 bg-black/70 backdrop-blur-sm" onClick={onClose}></div>
      <div className="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto animate-scale-in">
        {/* Header */}
        <div className="sticky top-0 bg-gradient-to-l from-primary-600 to-primary-800 text-white px-6 py-5 rounded-t-3xl z-10">
          <button
            onClick={onClose}
            className="absolute top-4 left-4 w-8 h-8 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/30 transition-colors"
          >
            <X size={16} />
          </button>
          <div className="flex items-center gap-3">
            <div className="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
              <Calendar size={24} className="text-white" />
            </div>
            <div>
              <h3 className="text-xl font-bold">حجز موعد جديد</h3>
              <p className="text-sm text-white/70">املأ البيانات التالية لحجز موعدك</p>
            </div>
          </div>
        </div>

        {/* Content */}
        <div className="p-6">
          {submitted ? (
            <div className="text-center py-12">
              <div className="w-20 h-20 bg-accent-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-scale-in">
                <CheckCircle className="text-accent-500" size={40} />
              </div>
              <h3 className="text-2xl font-bold text-gray-900 mb-2">تم الحجز بنجاح! 🎉</h3>
              <p className="text-gray-500">سيتم التواصل معك قريباً عبر رسالة نصية لتأكيد موعدك</p>
            </div>
          ) : (
            <form onSubmit={handleSubmit} className="space-y-4">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="relative">
                  <User className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                  <input
                    type="text"
                    value={form.patientName}
                    onChange={(e) => setForm({ ...form, patientName: e.target.value })}
                    placeholder="الاسم الكامل *"
                    required
                    className="w-full pr-12 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
                  />
                </div>
                <div className="relative">
                  <Phone className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                  <input
                    type="tel"
                    value={form.phone}
                    onChange={(e) => setForm({ ...form, phone: e.target.value })}
                    placeholder="رقم الجوال *"
                    required
                    className="w-full pr-12 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20"
                  />
                </div>
              </div>

              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="relative">
                  <Stethoscope className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                  <select
                    value={form.department}
                    onChange={(e) => setForm({ ...form, department: e.target.value, doctor: "" })}
                    disabled={prefill?.locked}
                    required
                    className={`w-full pr-12 pl-4 py-3.5 border rounded-xl text-sm focus:outline-none focus:border-primary-500 appearance-none ${
                      prefill?.locked 
                        ? "bg-primary-50 border-primary-200 text-primary-700 cursor-not-allowed" 
                        : "bg-gray-50 border-gray-200"
                    }`}
                  >
                    <option value="">اختر القسم *</option>
                    {departments.filter(d => d.active !== false).map((d) => (
                      <option key={d.id} value={d.name}>{d.name}</option>
                    ))}
                  </select>
                  {prefill?.locked && (
                    <div className="absolute left-3 top-1/2 -translate-y-1/2 bg-primary-100 text-primary-700 text-xs px-2 py-0.5 rounded-full font-bold">
                      🔒 مقفل
                    </div>
                  )}
                </div>
                <div className="relative">
                  <User className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                  <select
                    value={form.doctor}
                    onChange={(e) => setForm({ ...form, doctor: e.target.value })}
                    disabled={prefill?.locked}
                    className={`w-full pr-12 pl-4 py-3.5 border rounded-xl text-sm focus:outline-none focus:border-primary-500 appearance-none ${
                      prefill?.locked 
                        ? "bg-primary-50 border-primary-200 text-primary-700 cursor-not-allowed" 
                        : "bg-gray-50 border-gray-200"
                    }`}
                  >
                    {prefill?.locked ? (
                      <option value={form.doctor}>{form.doctor || "اختر الطبيب"}</option>
                    ) : (
                      <>
                        <option value="">اختر الطبيب (اختياري)</option>
                        {doctors.filter(d => {
                          if (d.active === false) return false;
                          // If department is selected, filter by it
                          if (form.department && d.department) {
                            return d.department === form.department;
                          }
                          return true;
                        }).map((d) => (
                          <option key={d.id} value={d.name}>{d.name}</option>
                        ))}
                      </>
                    )}
                  </select>
                  {prefill?.locked && (
                    <div className="absolute left-3 top-1/2 -translate-y-1/2 bg-primary-100 text-primary-700 text-xs px-2 py-0.5 rounded-full font-bold">
                      🔒 مقفل
                    </div>
                  )}
                </div>
              </div>

              {prefill?.locked && (
                <div className="bg-blue-50 border border-blue-200 rounded-xl p-3 flex items-start gap-2">
                  <span className="text-blue-500 mt-0.5">ℹ️</span>
                  <p className="text-xs text-blue-700">
                    تم تحديد الطبيب والقسم مسبقاً. يمكنك فقط اختيار التاريخ والوقت.
                  </p>
                </div>
              )}

              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="relative">
                  <Calendar className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                  <input
                    type="date"
                    value={form.date}
                    onChange={(e) => setForm({ ...form, date: e.target.value })}
                    min={today}
                    required
                    className="w-full pr-12 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
                  />
                </div>
                <div className="relative">
                  <Clock className="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400" size={18} />
                  <select
                    value={form.time}
                    onChange={(e) => setForm({ ...form, time: e.target.value })}
                    required
                    className="w-full pr-12 pl-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 appearance-none"
                  >
                    <option value="">اختر الوقت *</option>
                    {["08:00", "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00"].map(t => (
                      <option key={t} value={t}>{t}</option>
                    ))}
                  </select>
                </div>
              </div>

              <div>
                <textarea
                  value={form.notes}
                  onChange={(e) => setForm({ ...form, notes: e.target.value })}
                  placeholder="ملاحظات إضافية (اختياري)"
                  rows={3}
                  className="w-full px-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 resize-none"
                />
              </div>

              {/* Prefill info */}
              {prefill && (prefill.doctor || prefill.department) && (
                <div className="bg-primary-50 border border-primary-100 rounded-xl p-3 text-sm">
                  <p className="text-primary-700 font-bold text-xs mb-1">ℹ️ تم تعبئة البيانات تلقائياً:</p>
                  {prefill.doctor && <p className="text-primary-600 text-xs">👨‍⚕️ الطبيب: {prefill.doctor}</p>}
                  {prefill.department && <p className="text-primary-600 text-xs">🏥 القسم: {prefill.department}</p>}
                </div>
              )}

              <div className="flex items-center gap-3 pt-3">
                <button
                  type="submit"
                  className="flex-1 bg-gradient-to-l from-primary-500 to-primary-700 text-white py-3.5 rounded-xl font-bold text-sm hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2"
                >
                  <Send size={18} />
                  <span>تأكيد الحجز</span>
                </button>
                <button
                  type="button"
                  onClick={onClose}
                  className="px-6 py-3.5 bg-gray-100 text-gray-600 rounded-xl font-bold text-sm hover:bg-gray-200 transition-colors"
                >
                  إلغاء
                </button>
              </div>

              <p className="text-xs text-gray-400 text-center">
                🔒 بياناتك محمية وسرية بالكامل ولن يتم مشاركتها مع أي طرف ثالث
              </p>
            </form>
          )}
        </div>
      </div>
    </div>
  );
}
