import { useState } from "react";
import { CalendarCheck, Plus, Search, Edit, Trash2, Eye, Filter, Download, CheckCircle, XCircle, Clock, X as XIcon } from "lucide-react";
import { useApp, Reservation } from "../../context/AppContext";
import PageHeader from "../components/PageHeader";
import Modal from "../components/Modal";
import ConfirmDialog from "../components/ConfirmDialog";
import { useToast } from "../components/Toast";
import { useData } from "../../context/DataContext";
import { useNotifications } from "../../context/NotificationContext";
import { createReservationConfirmationMessage, determineNotificationType, formatPhoneNumber } from "../../utils/notificationHelpers";

const STATUS_CONFIG = {
  pending: { label: "قيد الانتظار", color: "bg-yellow-100 text-yellow-700", icon: Clock },
  confirmed: { label: "مؤكد", color: "bg-green-100 text-green-700", icon: CheckCircle },
  completed: { label: "مكتمل", color: "bg-blue-100 text-blue-700", icon: CheckCircle },
  cancelled: { label: "ملغى", color: "bg-red-100 text-red-700", icon: XCircle },
};

export default function ReservationsPage() {
  const { reservations, setReservations } = useApp();
  const { departments, currentUser } = useData();
  const { toast } = useToast();
  const [search, setSearch] = useState("");
  const [statusFilter, setStatusFilter] = useState<string>("all");
  const [typeFilter, setTypeFilter] = useState<string>("all"); // ✅ فلتر النوع
  const [modalOpen, setModalOpen] = useState(false);
  const [viewModalOpen, setViewModalOpen] = useState(false);
  const [editingItem, setEditingItem] = useState<Reservation | null>(null);
  const [viewingItem, setViewingItem] = useState<Reservation | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);

  // تحديد الدور الحالي
  const userRole = currentUser?.role || "admin";
  const isDoctor = userRole === "doctor";
  const isNurse = userRole === "nurse";
  const isReception = userRole === "reception";
  const doctorName = currentUser?.name || "";
  const assignedDepartments = currentUser?.assignedDepartments || [];
  const assignedDoctors = currentUser?.assignedDoctors || [];
  
  // تحديد صلاحيات التعديل والحذف
  const canEdit = userRole === "admin" || isDoctor || isReception; // استقبال يمكنه التعديل
  const canDelete = userRole === "admin" || isDoctor; // ممرض واستقبال لا يمكنهم الحذف
  const canManage = userRole === "admin" || isDoctor || isReception; // استقبال يمكنه التأكيد/الإلغاء

  // فلترة الحجوزات حسب الدور
  let doctorReservations = reservations;
  
  if (isDoctor) {
    // الطبيب يرى فقط حجوزاته
    doctorReservations = reservations.filter(r => r.doctor === doctorName);
  } else if (isNurse) {
    // الممرض يرى حجوزات الأقسام والأطباء المرتبط بهم
    if (assignedDepartments.length === 0 && assignedDoctors.length === 0) {
      // إذا لم يرتبط بأي شيء، لا يرى شيئاً
      doctorReservations = [];
    } else {
      doctorReservations = reservations.filter(r => {
        // تحقق من القسم
        const matchesDepartment = assignedDepartments.length > 0 && 
          departments.some(d => d.name === r.department && assignedDepartments.includes(d.name));
        // تحقق من الطبيب
        const matchesDoctor = assignedDoctors.length > 0 && 
          assignedDoctors.includes(r.doctor || "");
        return matchesDepartment || matchesDoctor;
      });
    }
  }

  const [form, setForm] = useState<Omit<Reservation, "id" | "createdAt" | "status">>({
    patientName: "", phone: "", department: "", doctor: doctorName, date: "", time: "", notes: "",
  });
  const [status, setStatus] = useState<Reservation["status"]>("pending");

  const filtered = doctorReservations.filter((r) => {
    const matchesSearch = r.patientName.includes(search) || r.phone.includes(search) || r.department.includes(search);
    const matchesStatus = statusFilter === "all" || r.status === statusFilter;
    const matchesType = typeFilter === "all" || r.type === typeFilter;
    return matchesSearch && matchesStatus && matchesType;
  });

  const stats = {
    total: doctorReservations.length,
    pending: doctorReservations.filter(r => r.status === "pending").length,
    confirmed: doctorReservations.filter(r => r.status === "confirmed").length,
    completed: doctorReservations.filter(r => r.status === "completed").length,
    cancelled: doctorReservations.filter(r => r.status === "cancelled").length,
  };

  const openCreate = () => {
    setForm({ patientName: "", phone: "", department: "", doctor: "", date: "", time: "", notes: "" });
    setStatus("pending");
    setEditingItem(null);
    setModalOpen(true);
  };

  const openEdit = (res: Reservation) => {
    setForm({ patientName: res.patientName, phone: res.phone, department: res.department, doctor: res.doctor || "", date: res.date, time: res.time, notes: res.notes || "" });
    setStatus(res.status);
    setEditingItem(res);
    setModalOpen(true);
  };

  const openView = (res: Reservation) => {
    setViewingItem(res);
    setViewModalOpen(true);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (editingItem) {
      setReservations(reservations.map((r) => r.id === editingItem.id ? { ...r, ...form, status } : r));
      toast("success", "تم تحديث الحجز بنجاح");
    } else {
      const newRes: Reservation = {
        id: Date.now().toString(),
        ...form,
        status,
        createdAt: new Date().toISOString(),
      };
      setReservations([newRes, ...reservations]);
      toast("success", "تم إضافة الحجز بنجاح");
    }
    setModalOpen(false);
  };

  const handleDelete = () => {
    if (deleteId) {
      setReservations(reservations.filter((r) => r.id !== deleteId));
      toast("success", "تم حذف الحجز بنجاح");
      setDeleteId(null);
    }
  };

  const { sendNotification, settings } = useNotifications();

  const updateStatus = async (id: string, newStatus: Reservation["status"]) => {
    const reservation = reservations.find(r => r.id === id);
    
    setReservations(reservations.map((r) => r.id === id ? { ...r, status: newStatus } : r));
    const labels = { pending: "قيد الانتظار", confirmed: "مؤكد", completed: "مكتمل", cancelled: "ملغى" };
    toast("success", `تم تحديث حالة الحجز إلى: ${labels[newStatus]}`);
    
    // إرسال إشعار عند تأكيد الحجز
    if (newStatus === "confirmed" && reservation) {
      const message = createReservationConfirmationMessage(reservation);
      const notifType = determineNotificationType(reservation.phone);
      const formattedPhone = formatPhoneNumber(reservation.phone);
      
      // إرسال عبر واتساب إذا مفعّل
      if (settings.enableWhatsApp && notifType === "whatsapp") {
        await sendNotification({
          type: "whatsapp",
          recipient: formattedPhone,
          message,
          reservationId: reservation.id,
          patientName: reservation.patientName,
        });
        toast("success", "تم إرسال إشعار واتساب للمريض");
      }
      // إرسال عبر SMS إذا واتساب غير متاح
      else if (settings.enableSMS) {
        await sendNotification({
          type: "sms",
          recipient: formattedPhone,
          message,
          reservationId: reservation.id,
          patientName: reservation.patientName,
        });
        toast("success", "تم إرسال رسالة SMS للمريض");
      }
      
      // إشعار داخلي
      if (settings.enableInternal) {
        await sendNotification({
          type: "internal",
          recipient: "admin",
          message: `تم تأكيد حجز ${reservation.patientName} - ${reservation.department}`,
          reservationId: reservation.id,
          patientName: reservation.patientName,
        });
      }
    }
  };

  const exportData = () => {
    const csv = [
      ["المريض", "الهاتف", "القسم", "الطبيب", "التاريخ", "الوقت", "الحالة"].join(","),
      ...reservations.map((r) => [r.patientName, r.phone, r.department, r.doctor || "", r.date, r.time, STATUS_CONFIG[r.status].label].join(","))
    ].join("\n");
    const blob = new Blob(["\uFEFF" + csv], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = "reservations.csv";
    a.click();
    toast("success", "تم تصدير البيانات بنجاح");
  };

  return (
    <div>
      <PageHeader
        title={
          isDoctor ? "حجوزاتي" :
          isNurse ? "حجوزات الأقسام المرتبطة" :
          "الحجوزات والمواعيد"
        }
        subtitle={
          isDoctor 
            ? `${stats.total} حجز خاص بالدكتور ${doctorName} | ${stats.pending} قيد الانتظار`
            : isNurse
              ? `${stats.total} حجز في الأقسام المرتبطة بك | ${stats.pending} قيد الانتظار`
              : `${stats.total} حجز | ${stats.pending} قيد الانتظار`
        }
        icon={<CalendarCheck size={26} />}
        action={
          <div className="flex items-center gap-2">
            <button onClick={exportData} className="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-200 flex items-center gap-2">
              <Download size={16} />
              <span className="hidden md:inline">تصدير</span>
            </button>
            {canManage && (
              <button onClick={openCreate} className="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all flex items-center gap-2">
                <Plus size={18} /><span>حجز جديد</span>
              </button>
            )}
          </div>
        }
      />

      {/* Stats Cards */}
      <div className="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
        <div className="bg-white rounded-xl p-4 border border-gray-100">
          <p className="text-xs text-gray-500 mb-1">الإجمالي</p>
          <p className="text-2xl font-black text-gray-800">{stats.total}</p>
        </div>
        <div className="bg-yellow-50 rounded-xl p-4 border border-yellow-100">
          <p className="text-xs text-yellow-600 mb-1">قيد الانتظار</p>
          <p className="text-2xl font-black text-yellow-700">{stats.pending}</p>
        </div>
        <div className="bg-green-50 rounded-xl p-4 border border-green-100">
          <p className="text-xs text-green-600 mb-1">مؤكد</p>
          <p className="text-2xl font-black text-green-700">{stats.confirmed}</p>
        </div>
        <div className="bg-blue-50 rounded-xl p-4 border border-blue-100">
          <p className="text-xs text-blue-600 mb-1">مكتمل</p>
          <p className="text-2xl font-black text-blue-700">{stats.completed}</p>
        </div>
        <div className="bg-red-50 rounded-xl p-4 border border-red-100">
          <p className="text-xs text-red-600 mb-1">ملغى</p>
          <p className="text-2xl font-black text-red-700">{stats.cancelled}</p>
        </div>
      </div>

      {/* Filters */}
      <div className="bg-white rounded-2xl p-4 mb-6 border border-gray-100 flex flex-col md:flex-row gap-3">
        <div className="flex-1 flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
          <Search size={16} className="text-gray-400" />
          <input type="text" placeholder="بحث بالاسم أو الهاتف..." value={search} onChange={(e) => setSearch(e.target.value)} className="bg-transparent outline-none flex-1 text-sm" />
        </div>
        <div className="flex items-center gap-2 bg-gray-50 rounded-xl p-1 border border-gray-100 overflow-x-auto">
          <Filter size={16} className="text-gray-400 mr-2 shrink-0" />
          <span className="text-xs text-gray-500 mr-1">الحالة:</span>
          {[
            { value: "all", label: "الكل" },
            { value: "pending", label: "قيد الانتظار" },
            { value: "confirmed", label: "مؤكد" },
            { value: "completed", label: "مكتمل" },
            { value: "cancelled", label: "ملغى" },
          ].map((f) => (
            <button
              key={f.value}
              onClick={() => setStatusFilter(f.value)}
              className={`px-3 py-1.5 text-xs font-bold rounded-lg transition-all whitespace-nowrap ${
                statusFilter === f.value ? "bg-primary-500 text-white shadow-md" : "text-gray-600 hover:bg-gray-200"
              }`}
            >
              {f.label}
            </button>
          ))}
        </div>
        <div className="flex items-center gap-2 bg-gray-50 rounded-xl p-1 border border-gray-100 overflow-x-auto">
          <Filter size={16} className="text-gray-400 mr-2 shrink-0" />
          <span className="text-xs text-gray-500 mr-1">النوع:</span>
          {[
            { value: "all", label: "الكل" },
            { value: "normal", label: "عادي" },
            { value: "offer", label: "عرض" },
            { value: "consultation", label: "استشارة" },
          ].map((f) => (
            <button
              key={f.value}
              onClick={() => setTypeFilter(f.value)}
              className={`px-3 py-1.5 text-xs font-bold rounded-lg transition-all whitespace-nowrap ${
                typeFilter === f.value ? "bg-primary-500 text-white shadow-md" : "text-gray-600 hover:bg-gray-200"
              }`}
            >
              {f.label}
            </button>
          ))}
        </div>
      </div>

      {/* Table */}
      <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-gray-50 border-b border-gray-100">
              <tr>
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">#</th>
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">المريض</th>
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">القسم</th>
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">النوع</th>
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">التاريخ</th>
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">الحالة</th>
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              {filtered.map((res, index) => {
                const StatusIcon = STATUS_CONFIG[res.status].icon;
                return (
                  <tr key={res.id} className="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                    <td className="px-6 py-4 text-sm text-gray-500">{index + 1}</td>
                    <td className="px-6 py-4">
                      <div>
                        <p className="font-bold text-gray-800 text-sm">{res.patientName}</p>
                        <p className="text-xs text-gray-400">{res.phone}</p>
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      <div>
                        <p className="text-sm font-medium text-gray-700">{res.department}</p>
                        {res.doctor && <p className="text-xs text-primary-600">{res.doctor}</p>}
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      <span className={`inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs font-bold ${
                        res.type === "offer" ? "bg-purple-100 text-purple-700" :
                        res.type === "consultation" ? "bg-blue-100 text-blue-700" :
                        "bg-gray-100 text-gray-700"
                      }`}>
                        {res.type === "offer" ? "🎁 عرض" :
                         res.type === "consultation" ? "💬 استشارة" :
                         "📋 عادي"}
                      </span>
                    </td>
                    <td className="px-6 py-4 text-sm text-gray-700">
                      <div>
                        <p>{res.date}</p>
                        <p className="text-xs text-gray-400">{res.time}</p>
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      <span className={`inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold ${STATUS_CONFIG[res.status].color}`}>
                        <StatusIcon size={12} />
                        <span>{STATUS_CONFIG[res.status].label}</span>
                      </span>
                    </td>
                    <td className="px-6 py-4">
                      <div className="flex items-center gap-1.5">
                        <button onClick={() => openView(res)} className="w-8 h-8 bg-gray-50 text-gray-600 rounded-lg flex items-center justify-center hover:bg-gray-100" title="عرض">
                          <Eye size={14} />
                        </button>
                        {canManage && res.status === "pending" && (
                          <>
                            <button onClick={() => updateStatus(res.id, "confirmed")} className="w-8 h-8 bg-green-50 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-100" title="تأكيد">
                              <CheckCircle size={14} />
                            </button>
                            <button onClick={() => updateStatus(res.id, "cancelled")} className="w-8 h-8 bg-red-50 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-100" title="إلغاء">
                              <XIcon size={14} />
                            </button>
                          </>
                        )}
                        {canEdit && (
                          <button onClick={() => openEdit(res)} className="w-8 h-8 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center hover:bg-blue-100" title="تعديل">
                            <Edit size={14} />
                          </button>
                        )}
                        {canDelete && (
                          <button onClick={() => setDeleteId(res.id)} className="w-8 h-8 bg-red-50 text-red-500 rounded-lg flex items-center justify-center hover:bg-red-100" title="حذف">
                            <Trash2 size={14} />
                          </button>
                        )}
                        {!canManage && !canEdit && !canDelete && (
                          <span className="text-xs text-gray-400 italic">عرض فقط</span>
                        )}
                      </div>
                    </td>
                  </tr>
                );
              })}
            </tbody>
          </table>
        </div>

        {filtered.length === 0 && (
          <div className="py-16 text-center">
            <CalendarCheck size={48} className="text-gray-300 mx-auto mb-4" />
            <p className="text-gray-500">لا توجد حجوزات</p>
          </div>
        )}
      </div>

      {/* Form Modal */}
      <Modal isOpen={modalOpen} onClose={() => setModalOpen(false)} title={editingItem ? "تعديل الحجز" : "حجز جديد"} size="md">
        <form onSubmit={handleSubmit} className="space-y-4">
          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">اسم المريض</label>
              <input type="text" value={form.patientName} onChange={(e) => setForm({ ...form, patientName: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">رقم الهاتف</label>
              <input type="tel" value={form.phone} onChange={(e) => setForm({ ...form, phone: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
          </div>

          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">القسم</label>
              <select value={form.department} onChange={(e) => setForm({ ...form, department: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
                <option value="">اختر القسم</option>
                {departments.map((d) => <option key={d.id} value={d.name}>{d.name}</option>)}
              </select>
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">الطبيب (اختياري)</label>
              <input type="text" value={form.doctor} onChange={(e) => setForm({ ...form, doctor: e.target.value })} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="د. ..." />
            </div>
          </div>

          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">التاريخ</label>
              <input type="date" value={form.date} onChange={(e) => setForm({ ...form, date: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">الوقت</label>
              <input type="time" value={form.time} onChange={(e) => setForm({ ...form, time: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">الحالة</label>
            <div className="grid grid-cols-4 gap-2">
              {(["pending", "confirmed", "completed", "cancelled"] as const).map((s) => (
                <button key={s} type="button" onClick={() => setStatus(s)} className={`py-2 rounded-xl text-xs font-bold transition-all ${status === s ? STATUS_CONFIG[s].color + " ring-2 ring-offset-2 ring-gray-300" : "bg-gray-100 text-gray-500"}`}>
                  {STATUS_CONFIG[s].label}
                </button>
              ))}
            </div>
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">ملاحظات</label>
            <textarea value={form.notes} onChange={(e) => setForm({ ...form, notes: e.target.value })} rows={3} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 resize-none" />
          </div>

          <div className="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="button" onClick={() => setModalOpen(false)} className="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
            <button type="submit" className="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl">{editingItem ? "حفظ" : "إضافة"}</button>
          </div>
        </form>
      </Modal>

      {/* View Modal */}
      <Modal isOpen={viewModalOpen} onClose={() => setViewModalOpen(false)} title="تفاصيل الحجز" size="sm">
        {viewingItem && (
          <div className="space-y-4">
            <div className="bg-gray-50 rounded-xl p-4 space-y-3">
              <div className="flex justify-between">
                <span className="text-sm text-gray-500">اسم المريض:</span>
                <span className="font-bold text-gray-800">{viewingItem.patientName}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-sm text-gray-500">الهاتف:</span>
                <span className="font-bold text-gray-800" dir="ltr">{viewingItem.phone}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-sm text-gray-500">القسم:</span>
                <span className="font-bold text-gray-800">{viewingItem.department}</span>
              </div>
              {viewingItem.doctor && (
                <div className="flex justify-between">
                  <span className="text-sm text-gray-500">الطبيب:</span>
                  <span className="font-bold text-primary-600">{viewingItem.doctor}</span>
                </div>
              )}
              <div className="flex justify-between">
                <span className="text-sm text-gray-500">التاريخ:</span>
                <span className="font-bold text-gray-800">{viewingItem.date}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-sm text-gray-500">الوقت:</span>
                <span className="font-bold text-gray-800">{viewingItem.time}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-sm text-gray-500">الحالة:</span>
                <span className={`inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold ${STATUS_CONFIG[viewingItem.status].color}`}>
                  {STATUS_CONFIG[viewingItem.status].label}
                </span>
              </div>
              {viewingItem.notes && (
                <div className="pt-2 border-t border-gray-200">
                  <span className="text-sm text-gray-500 block mb-1">ملاحظات:</span>
                  <p className="text-sm text-gray-700">{viewingItem.notes}</p>
                </div>
              )}
            </div>
            <button onClick={() => setViewModalOpen(false)} className="w-full py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-200">إغلاق</button>
          </div>
        )}
      </Modal>

      <ConfirmDialog isOpen={!!deleteId} onClose={() => setDeleteId(null)} onConfirm={handleDelete} title="حذف الحجز" message="هل أنت متأكد من حذف هذا الحجز؟" confirmText="نعم، احذف" />
    </div>
  );
}
