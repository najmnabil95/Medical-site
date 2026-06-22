import { useState } from "react";
import { Video, Eye, Trash2, Calendar, Clock, CheckCircle, XCircle, Send } from "lucide-react";
import { useApp, Reservation } from "../../context/AppContext";
import PageHeader from "../components/PageHeader";
import Modal from "../components/Modal";
import ConfirmDialog from "../components/ConfirmDialog";
import { useToast } from "../components/Toast";

export default function TelemedicinePage() {
  const { reservations, setReservations } = useApp();
  const { toast } = useToast();
  const [filter, setFilter] = useState<"all" | "pending" | "confirmed" | "completed" | "cancelled">("all");
  const [viewModalOpen, setViewModalOpen] = useState(false);
  const [selectedReservation, setSelectedReservation] = useState<Reservation | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);
  const [sendModalOpen, setSendModalOpen] = useState(false);

  // تصفية الاستشارات فقط (التي تحتوي على "استشارة عن بُعد" في department)
  const telemedicineReservations = reservations.filter(r => 
    r.department?.includes("استشارة عن بُعد")
  );

  const filtered = filter === "all" 
    ? telemedicineReservations 
    : telemedicineReservations.filter(r => r.status === filter);

  const stats = {
    total: telemedicineReservations.length,
    pending: telemedicineReservations.filter(r => r.status === "pending").length,
    confirmed: telemedicineReservations.filter(r => r.status === "confirmed").length,
    completed: telemedicineReservations.filter(r => r.status === "completed").length,
    cancelled: telemedicineReservations.filter(r => r.status === "cancelled").length,
  };

  const viewDetails = (reservation: Reservation) => {
    setSelectedReservation(reservation);
    setViewModalOpen(true);
  };

  const confirmConsultation = (id: string) => {
    setReservations(
      reservations.map(r => 
        r.id === id 
          ? { ...r, status: "confirmed" as const }
          : r
      )
    );
    toast("success", "تم تأكيد الاستشارة بنجاح! سيتم إرسال الرابط للمريض");
  };

  const completeConsultation = (id: string) => {
    setReservations(
      reservations.map(r => 
        r.id === id 
          ? { ...r, status: "completed" as const }
          : r
      )
    );
    toast("success", "تم تسجيل إتمام الاستشارة");
  };

  const cancelConsultation = (id: string) => {
    setReservations(
      reservations.map(r => 
        r.id === id 
          ? { ...r, status: "cancelled" as const }
          : r
      )
    );
    toast("info", "تم إلغاء الاستشارة");
  };

  const sendLink = () => {
    if (selectedReservation) {
      toast("success", "تم إرسال رابط الاستشارة للمريض عبر البريد والواتساب");
      setSendModalOpen(false);
    }
  };

  const handleDelete = () => {
    if (deleteId) {
      setReservations(reservations.filter(r => r.id !== deleteId));
      toast("success", "تم حذف الاستشارة بنجاح");
      setDeleteId(null);
    }
  };

  const parseNotes = (notes: string) => {
    const lines = notes.split("\n");
    const data: Record<string, string> = {};
    lines.forEach(line => {
      const [key, value] = line.split(": ");
      if (key && value) {
        data[key.trim()] = value.trim();
      }
    });
    return data;
  };

  return (
    <div>
      <PageHeader
        title="الاستشارات عن بُعد"
        subtitle={`${stats.total} استشارة | ${stats.pending} قيد الانتظار`}
        icon={<Video size={26} />}
      />

      {/* Stats */}
      <div className="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <button
          onClick={() => setFilter("all")}
          className={`bg-white rounded-xl p-4 border transition-all ${
            filter === "all" ? "border-primary-500 shadow-lg" : "border-gray-100 hover:shadow-md"
          }`}
        >
          <div className="text-2xl font-black text-gray-800">{stats.total}</div>
          <div className="text-xs text-gray-500">الإجمالي</div>
        </button>
        <button
          onClick={() => setFilter("pending")}
          className={`bg-white rounded-xl p-4 border transition-all ${
            filter === "pending" ? "border-yellow-500 shadow-lg" : "border-gray-100 hover:shadow-md"
          }`}
        >
          <div className="text-2xl font-black text-yellow-600">{stats.pending}</div>
          <div className="text-xs text-gray-500">قيد الانتظار</div>
        </button>
        <button
          onClick={() => setFilter("confirmed")}
          className={`bg-white rounded-xl p-4 border transition-all ${
            filter === "confirmed" ? "border-green-500 shadow-lg" : "border-gray-100 hover:shadow-md"
          }`}
        >
          <div className="text-2xl font-black text-green-600">{stats.confirmed}</div>
          <div className="text-xs text-gray-500">مؤكد</div>
        </button>
        <button
          onClick={() => setFilter("completed")}
          className={`bg-white rounded-xl p-4 border transition-all ${
            filter === "completed" ? "border-blue-500 shadow-lg" : "border-gray-100 hover:shadow-md"
          }`}
        >
          <div className="text-2xl font-black text-blue-600">{stats.completed}</div>
          <div className="text-xs text-gray-500">مكتمل</div>
        </button>
        <button
          onClick={() => setFilter("cancelled")}
          className={`bg-white rounded-xl p-4 border transition-all ${
            filter === "cancelled" ? "border-red-500 shadow-lg" : "border-gray-100 hover:shadow-md"
          }`}
        >
          <div className="text-2xl font-black text-red-600">{stats.cancelled}</div>
          <div className="text-xs text-gray-500">ملغى</div>
        </button>
      </div>

      {/* List */}
      <div className="space-y-4">
        {filtered.map((reservation) => {
          const notes = parseNotes(reservation.notes || "");
          
          return (
            <div key={reservation.id} className="bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-lg transition-all">
              <div className="flex items-start justify-between mb-4">
                <div className="flex items-start gap-4">
                  <div className="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center text-white">
                    <Video size={20} />
                  </div>
                  <div>
                    <h3 className="font-bold text-gray-800 text-lg">{reservation.patientName}</h3>
                    <p className="text-sm text-gray-500">{notes["نوع الاستشارة"] || "استشارة عن بُعد"}</p>
                    <div className="flex items-center gap-4 mt-2 text-sm text-gray-600">
                      <span className="flex items-center gap-1">
                        <Calendar size={14} />
                        {reservation.date}
                      </span>
                      <span className="flex items-center gap-1">
                        <Clock size={14} />
                        {reservation.time}
                      </span>
                    </div>
                  </div>
                </div>
                <span className={`px-3 py-1 rounded-full text-xs font-bold ${
                  reservation.status === "pending" ? "bg-yellow-100 text-yellow-700" :
                  reservation.status === "confirmed" ? "bg-green-100 text-green-700" :
                  reservation.status === "completed" ? "bg-blue-100 text-blue-700" :
                  "bg-red-100 text-red-700"
                }`}>
                  {reservation.status === "pending" ? "قيد الانتظار" :
                   reservation.status === "confirmed" ? "مؤكد" :
                   reservation.status === "completed" ? "مكتمل" :
                   "ملغى"}
                </span>
              </div>

              <div className="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4 text-sm">
                <div className="bg-gray-50 rounded-lg p-3">
                  <p className="text-gray-500 text-xs mb-1">المنصة</p>
                  <p className="font-bold text-gray-800">{notes["المنصة"] || "-"}</p>
                </div>
                <div className="bg-gray-50 rounded-lg p-3">
                  <p className="text-gray-500 text-xs mb-1">التخصص</p>
                  <p className="font-bold text-gray-800">{notes["المشكلة"] || "-"}</p>
                </div>
                <div className="bg-gray-50 rounded-lg p-3">
                  <p className="text-gray-500 text-xs mb-1">طريقة الدفع</p>
                  <p className="font-bold text-gray-800">{notes["طريقة الدفع"] || "-"}</p>
                </div>
                <div className="bg-purple-50 rounded-lg p-3">
                  <p className="text-purple-600 text-xs mb-1">المبلغ</p>
                  <p className="font-bold text-purple-700">{notes["المبلغ"] || "-"}</p>
                </div>
              </div>

              <div className="flex items-center gap-2 pt-4 border-t border-gray-100">
                <button
                  onClick={() => viewDetails(reservation)}
                  className="flex-1 py-2 bg-gray-50 text-gray-600 rounded-lg text-sm font-bold hover:bg-gray-100 transition-colors flex items-center justify-center gap-1"
                >
                  <Eye size={14} />
                  عرض التفاصيل
                </button>
                {reservation.status === "pending" && (
                  <>
                    <button
                      onClick={() => confirmConsultation(reservation.id)}
                      className="flex-1 py-2 bg-green-50 text-green-600 rounded-lg text-sm font-bold hover:bg-green-100 transition-colors flex items-center justify-center gap-1"
                    >
                      <CheckCircle size={14} />
                      تأكيد
                    </button>
                    <button
                      onClick={() => cancelConsultation(reservation.id)}
                      className="py-2 px-4 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-100 transition-colors"
                    >
                      <XCircle size={14} />
                    </button>
                  </>
                )}
                {reservation.status === "confirmed" && (
                  <>
                    <button
                      onClick={() => { viewDetails(reservation); setSendModalOpen(true); }}
                      className="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1"
                    >
                      <Send size={14} />
                      إرسال الرابط
                    </button>
                    <button
                      onClick={() => completeConsultation(reservation.id)}
                      className="flex-1 py-2 bg-purple-50 text-purple-600 rounded-lg text-sm font-bold hover:bg-purple-100 transition-colors flex items-center justify-center gap-1"
                    >
                      <CheckCircle size={14} />
                      إتمام
                    </button>
                  </>
                )}
                <button
                  onClick={() => setDeleteId(reservation.id)}
                  className="py-2 px-4 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-100 transition-colors"
                >
                  <Trash2 size={14} />
                </button>
              </div>
            </div>
          );
        })}
      </div>

      {filtered.length === 0 && (
        <div className="bg-white rounded-2xl p-16 border border-gray-100 text-center">
          <Video size={48} className="text-gray-300 mx-auto mb-4" />
          <p className="text-gray-500">لا توجد استشارات</p>
        </div>
      )}

      {/* View Details Modal */}
      <Modal isOpen={viewModalOpen} onClose={() => { setViewModalOpen(false); setSendModalOpen(false); }} title="تفاصيل الاستشارة" size="md">
        {selectedReservation && (() => {
          const notes = parseNotes(selectedReservation.notes || "");
          return (
            <div className="space-y-5">
              <div className="bg-gradient-to-l from-purple-50 to-indigo-50 rounded-xl p-5">
                <div className="flex items-center gap-3 mb-4">
                  <div className="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center text-white">
                    <Video size={20} />
                  </div>
                  <div>
                    <h3 className="font-bold text-gray-800 text-lg">{selectedReservation.patientName}</h3>
                    <p className="text-sm text-gray-500">{notes["نوع الاستشارة"]}</p>
                  </div>
                </div>

                <div className="grid grid-cols-2 gap-3">
                  <div>
                    <p className="text-xs text-gray-500">رقم الجوال</p>
                    <p className="font-bold text-gray-800">{selectedReservation.phone}</p>
                  </div>
                  <div>
                    <p className="text-xs text-gray-500">البريد الإلكتروني</p>
                    <p className="font-bold text-gray-800 text-sm">{notes["البريد"] || "-"}</p>
                  </div>
                  <div>
                    <p className="text-xs text-gray-500">التاريخ</p>
                    <p className="font-bold text-gray-800">{selectedReservation.date}</p>
                  </div>
                  <div>
                    <p className="text-xs text-gray-500">الوقت</p>
                    <p className="font-bold text-gray-800">{selectedReservation.time}</p>
                  </div>
                  <div>
                    <p className="text-xs text-gray-500">المنصة</p>
                    <p className="font-bold text-gray-800">{notes["المنصة"]}</p>
                  </div>
                  <div>
                    <p className="text-xs text-gray-500">المبلغ</p>
                    <p className="font-bold text-purple-700">{notes["المبلغ"]}</p>
                  </div>
                </div>
              </div>

              <div className="bg-gray-50 rounded-xl p-4">
                <p className="text-xs text-gray-500 mb-2">المشكلة الصحية</p>
                <p className="text-gray-700">{notes["المشكلة"]}</p>
              </div>

              <div className="bg-gray-50 rounded-xl p-4">
                <p className="text-xs text-gray-500 mb-2">طريقة الدفع</p>
                <p className="text-gray-700">{notes["طريقة الدفع"]}</p>
              </div>

              {sendModalOpen && (
                <div className="bg-blue-50 border border-blue-200 rounded-xl p-4">
                  <p className="font-bold text-blue-700 mb-2">📤 إرسال رابط الاستشارة</p>
                  <p className="text-sm text-blue-600 mb-3">
                    سيتم إرسال رابط الاستشارة إلى:
                  </p>
                  <ul className="text-sm text-blue-700 space-y-1 mb-4">
                    <li>✓ البريد الإلكتروني: {notes["البريد"]}</li>
                    <li>✓ الواتساب: {selectedReservation.phone}</li>
                  </ul>
                  <button
                    onClick={sendLink}
                    className="w-full bg-blue-500 text-white py-2.5 rounded-lg font-bold hover:bg-blue-600 transition-colors flex items-center justify-center gap-2"
                  >
                    <Send size={16} />
                    <span>إرسال الآن</span>
                  </button>
                </div>
              )}
            </div>
          );
        })()}
      </Modal>

      <ConfirmDialog
        isOpen={!!deleteId}
        onClose={() => setDeleteId(null)}
        onConfirm={handleDelete}
        title="حذف الاستشارة"
        message="هل أنت متأكد من حذف هذه الاستشارة؟"
        confirmText="نعم، احذف"
      />
    </div>
  );
}
