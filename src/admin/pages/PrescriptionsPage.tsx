import { useState } from "react";
import { FileText, Plus, Search, Eye, Trash2, Edit, Printer, Plus as PlusIcon, X } from "lucide-react";
import { usePrescriptions, Prescription, PrescriptionMedication } from "../../context/PrescriptionContext";
import PageHeader from "../components/PageHeader";
import Modal from "../components/Modal";
import ConfirmDialog from "../components/ConfirmDialog";
import { useToast } from "../components/Toast";
import { useData } from "../../context/DataContext";
import { useApp } from "../../context/AppContext";

export default function PrescriptionsPage() {
  const { prescriptions, setPrescriptions } = usePrescriptions();
  const { currentUser } = useData();
  const { reservations } = useApp();
  const { toast } = useToast();
  const [search, setSearch] = useState("");
  const [modalOpen, setModalOpen] = useState(false);
  const [viewModalOpen, setViewModalOpen] = useState(false);
  const [editingItem, setEditingItem] = useState<Prescription | null>(null);
  const [viewingItem, setViewingItem] = useState<Prescription | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);

  // تحديد الدور الحالي
  const userRole = currentUser?.role || "admin";
  const isDoctor = userRole === "doctor";
  const isNurse = userRole === "nurse";
  const doctorName = currentUser?.name || "";
  const assignedDoctors = currentUser?.assignedDoctors || [];
  
  // تحديد صلاحيات التعديل والحذف
  const canEdit = userRole === "admin" || isDoctor;
  const canDelete = userRole === "admin" || isDoctor;
  const canCreate = userRole === "admin" || isDoctor;
  
  // الحصول على قائمة المرضى المتاحين للطبيب (فقط الحجوزات المكتملة)
  const availablePatients = isDoctor
    ? reservations
        .filter(r => r.doctor === doctorName && r.status === "completed")
        .map(r => ({
          name: r.patientName,
          phone: r.phone,
          reservationId: r.id,
        }))
        // إزالة التكرار
        .filter((patient, index, self) =>
          index === self.findIndex(p => p.name === patient.name)
        )
    : [];

  const [form, setForm] = useState({
    patientName: "",
    patientPhone: "",
    patientAge: "",
    doctorName: "",
    doctorSpecialty: "",
    diagnosis: "",
    notes: "",
  });
  const [medications, setMedications] = useState<PrescriptionMedication[]>([]);

  // فلترة الوصفات حسب الدور
  let doctorPrescriptions = prescriptions;
  
  if (isDoctor) {
    // الطبيب يرى فقط وصفاته
    doctorPrescriptions = prescriptions.filter(p => p.doctorName === doctorName);
  } else if (isNurse) {
    // الممرض يرى وصفات الأطباء المرتبطين بهم
    if (assignedDoctors.length === 0) {
      doctorPrescriptions = [];
    } else {
      doctorPrescriptions = prescriptions.filter(p => assignedDoctors.includes(p.doctorName));
    }
  }

  const filtered = doctorPrescriptions.filter((p) =>
    p.patientName.includes(search) || p.doctorName.includes(search) || p.diagnosis.includes(search)
  );

  const openCreate = () => {
    setForm({
      patientName: "",
      patientPhone: "",
      patientAge: "",
      doctorName: isDoctor ? doctorName : "",
      doctorSpecialty: "",
      diagnosis: "",
      notes: "",
    });
    setMedications([]);
    setEditingItem(null);
    setModalOpen(true);
  };

  const openEdit = (prescription: Prescription) => {
    setForm({
      patientName: prescription.patientName,
      patientPhone: prescription.patientPhone,
      patientAge: prescription.patientAge,
      doctorName: prescription.doctorName,
      doctorSpecialty: prescription.doctorSpecialty,
      diagnosis: prescription.diagnosis,
      notes: prescription.notes,
    });
    setMedications([...prescription.medications]);
    setEditingItem(prescription);
    setModalOpen(true);
  };

  const openView = (prescription: Prescription) => {
    setViewingItem(prescription);
    setViewModalOpen(true);
  };

  const addMedication = () => {
    setMedications([...medications, { name: "", dosage: "", frequency: "", duration: "", notes: "" }]);
  };

  const updateMedication = (index: number, field: keyof PrescriptionMedication, value: string) => {
    const updated = [...medications];
    updated[index] = { ...updated[index], [field]: value };
    setMedications(updated);
  };

  const removeMedication = (index: number) => {
    setMedications(medications.filter((_, i) => i !== index));
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    if (editingItem) {
      setPrescriptions(prescriptions.map((p) => p.id === editingItem.id ? {
        ...p,
        ...form,
        medications,
      } : p));
      toast("success", "تم تحديث الوصفة بنجاح");
    } else {
      const newPrescription: Prescription = {
        id: Date.now().toString(),
        ...form,
        medications,
        createdAt: new Date().toISOString(),
        status: 'active',
      };
      setPrescriptions([newPrescription, ...prescriptions]);
      toast("success", "تم إنشاء الوصفة بنجاح");
    }
    setModalOpen(false);
  };

  const handleDelete = () => {
    if (deleteId) {
      setPrescriptions(prescriptions.filter((p) => p.id !== deleteId));
      toast("success", "تم حذف الوصفة بنجاح");
      setDeleteId(null);
    }
  };

  const printPrescription = (prescription: Prescription) => {
    const printWindow = window.open('', '', 'width=800,height=600');
    if (!printWindow) return;

    const content = `
      <!DOCTYPE html>
      <html dir="rtl" lang="ar">
      <head>
        <title>وصفة طبية - ${prescription.patientName}</title>
        <style>
          body { font-family: 'Tajawal', Arial, sans-serif; padding: 40px; direction: rtl; }
          .header { text-align: center; border-bottom: 3px solid #0e7490; padding-bottom: 20px; margin-bottom: 30px; }
          .header h1 { color: #0e7490; margin: 0; font-size: 28px; }
          .header p { color: #666; margin: 5px 0; }
          .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 30px; }
          .info-item { background: #f5f5f5; padding: 12px; border-radius: 8px; }
          .info-label { font-weight: bold; color: #666; font-size: 12px; }
          .info-value { font-size: 16px; color: #333; margin-top: 4px; }
          .diagnosis { background: #fff3cd; padding: 15px; border-radius: 8px; margin-bottom: 20px; }
          .medications { margin: 20px 0; }
          .medication { background: #f9f9f9; padding: 15px; margin-bottom: 10px; border-radius: 8px; border-right: 4px solid #0e7490; }
          .med-name { font-weight: bold; font-size: 16px; color: #0e7490; }
          .med-details { color: #666; margin-top: 5px; }
          .footer { margin-top: 40px; padding-top: 20px; border-top: 2px solid #ddd; text-align: center; color: #666; font-size: 12px; }
        </style>
      </head>
      <body>
        <div class="header">
          <h1>🏥 مستشفى الشفاء الدولي</h1>
          <p>وصفة طبية</p>
          <p>التاريخ: ${new Date(prescription.createdAt).toLocaleDateString('ar-SA')}</p>
        </div>

        <div class="info-grid">
          <div class="info-item">
            <div class="info-label">اسم المريض</div>
            <div class="info-value">${prescription.patientName}</div>
          </div>
          <div class="info-item">
            <div class="info-label">العمر</div>
            <div class="info-value">${prescription.patientAge} سنة</div>
          </div>
          <div class="info-item">
            <div class="info-label">الطبيب المعالج</div>
            <div class="info-value">${prescription.doctorName}</div>
          </div>
          <div class="info-item">
            <div class="info-label">التخصص</div>
            <div class="info-value">${prescription.doctorSpecialty}</div>
          </div>
        </div>

        <div class="diagnosis">
          <strong>التشخيص:</strong> ${prescription.diagnosis}
        </div>

        <h3 style="color: #0e7490; margin-top: 30px;">الأدوية الموصوفة:</h3>
        <div class="medications">
          ${prescription.medications.map((med, i) => `
            <div class="medication">
              <div class="med-name">${i + 1}. ${med.name}</div>
              <div class="med-details">
                <strong>الجرعة:</strong> ${med.dosage} | 
                <strong>التكرار:</strong> ${med.frequency} | 
                <strong>المدة:</strong> ${med.duration}
                ${med.notes ? `<br><strong>ملاحظات:</strong> ${med.notes}` : ''}
              </div>
            </div>
          `).join('')}
        </div>

        ${prescription.notes ? `
          <div style="background: #e7f3ff; padding: 15px; border-radius: 8px; margin-top: 20px;">
            <strong>ملاحظات إضافية:</strong><br>
            ${prescription.notes}
          </div>
        ` : ''}

        <div class="footer">
          <p>هذه الوصفة صادرة من مستشفى الشفاء الدولي</p>
          <p>للاستفسار: 920 012 345 | info@alshifa-hospital.com</p>
        </div>
      </body>
      </html>
    `;

    printWindow.document.write(content);
    printWindow.document.close();
    printWindow.focus();
    setTimeout(() => {
      printWindow.print();
    }, 250);
  };

  return (
    <div>
      <PageHeader
        title={
          isDoctor ? "وصفاتي الطبية" :
          isNurse ? "وصفات الأطباء المرتبطين" :
          "الوصفات الطبية"
        }
        subtitle={
          isDoctor
            ? `${doctorPrescriptions.length} وصفة خاصة بالدكتور ${doctorName}`
            : isNurse
              ? `${doctorPrescriptions.length} وصفة من الأطباء المرتبطين بك`
              : `${prescriptions.length} وصفة طبية`
        }
        icon={<FileText size={26} />}
        action={
          canCreate && (
            <button
              onClick={openCreate}
              className="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2"
            >
              <Plus size={18} />
              <span>وصفة جديدة</span>
            </button>
          )
        }
      />

      {/* Search */}
      <div className="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
        <div className="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
          <Search size={16} className="text-gray-400" />
          <input
            type="text"
            placeholder="بحث باسم المريض أو الطبيب أو التشخيص..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            className="bg-transparent outline-none flex-1 text-sm"
          />
        </div>
      </div>

      {/* Prescriptions List */}
      <div className="space-y-4">
        {filtered.map((prescription) => (
          <div key={prescription.id} className="bg-white rounded-2xl border border-gray-100 p-6 hover:shadow-lg transition-all">
            <div className="flex items-start justify-between mb-4">
              <div className="flex-1">
                <div className="flex items-center gap-3 mb-2">
                  <h3 className="text-lg font-bold text-gray-800">{prescription.patientName}</h3>
                  <span className={`px-3 py-1 rounded-full text-xs font-bold ${
                    prescription.status === 'active' ? 'bg-green-100 text-green-700' :
                    prescription.status === 'completed' ? 'bg-blue-100 text-blue-700' :
                    'bg-red-100 text-red-700'
                  }`}>
                    {prescription.status === 'active' ? 'نشطة' :
                     prescription.status === 'completed' ? 'مكتملة' : 'ملغاة'}
                  </span>
                </div>
                <p className="text-sm text-gray-600 mb-1">
                  <strong>التشخيص:</strong> {prescription.diagnosis}
                </p>
                <p className="text-sm text-gray-500">
                  <strong>الطبيب:</strong> {prescription.doctorName} - {prescription.doctorSpecialty}
                </p>
                <p className="text-xs text-gray-400 mt-2">
                  {new Date(prescription.createdAt).toLocaleDateString('ar-SA')} | {prescription.medications.length} دواء
                </p>
              </div>
            </div>

            <div className="flex items-center gap-2 pt-4 border-t border-gray-100">
              <button
                onClick={() => openView(prescription)}
                className="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1"
              >
                <Eye size={14} />
                عرض
              </button>
              <button
                onClick={() => printPrescription(prescription)}
                className="flex-1 py-2 bg-purple-50 text-purple-600 rounded-lg text-sm font-bold hover:bg-purple-100 transition-colors flex items-center justify-center gap-1"
              >
                <Printer size={14} />
                طباعة
              </button>
              {canEdit && (
                <button
                  onClick={() => openEdit(prescription)}
                  className="flex-1 py-2 bg-gray-50 text-gray-600 rounded-lg text-sm font-bold hover:bg-gray-100 transition-colors flex items-center justify-center gap-1"
                >
                  <Edit size={14} />
                  تعديل
                </button>
              )}
              {canDelete && (
                <button
                  onClick={() => setDeleteId(prescription.id)}
                  className="py-2 px-4 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-100 transition-colors"
                >
                  <Trash2 size={14} />
                </button>
              )}
            </div>
          </div>
        ))}
      </div>

      {filtered.length === 0 && (
        <div className="bg-white rounded-2xl p-16 border border-gray-100 text-center">
          <FileText size={48} className="text-gray-300 mx-auto mb-4" />
          <p className="text-gray-500">لا توجد وصفات طبية</p>
        </div>
      )}

      {/* Form Modal */}
      <Modal isOpen={modalOpen} onClose={() => setModalOpen(false)} title={editingItem ? "تعديل الوصفة" : "وصفة طبية جديدة"} size="lg">
        <form onSubmit={handleSubmit} className="space-y-5">
          {/* Patient Info */}
          <div className="grid grid-cols-3 gap-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">اسم المريض <span className="text-red-500">*</span></label>
              {isDoctor ? (
                <>
                  <select
                    value={form.patientName}
                    onChange={(e) => {
                      const patient = availablePatients.find(p => p.name === e.target.value);
                      setForm({ 
                        ...form, 
                        patientName: e.target.value,
                        patientPhone: patient?.phone || ""
                      });
                    }}
                    required
                    className="w-full px-4 py-3 bg-primary-50 border border-primary-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 appearance-none"
                  >
                    <option value="">اختر مريض</option>
                    {availablePatients.map((patient, idx) => (
                      <option key={idx} value={patient.name}>{patient.name}</option>
                    ))}
                  </select>
                  {availablePatients.length === 0 && (
                    <p className="text-xs text-amber-600 mt-1">⚠️ لا يوجد مرضى مكتملي الحجوزات</p>
                  )}
                </>
              ) : (
                <input type="text" value={form.patientName} onChange={(e) => setForm({ ...form, patientName: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
              )}
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">العمر <span className="text-red-500">*</span></label>
              <input type="text" value={form.patientAge} onChange={(e) => setForm({ ...form, patientAge: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="35" />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">الهاتف <span className="text-red-500">*</span></label>
              <input type="tel" value={form.patientPhone} onChange={(e) => setForm({ ...form, patientPhone: e.target.value })} required readOnly={isDoctor} className={`w-full px-4 py-3 border rounded-xl text-sm focus:outline-none focus:border-primary-500 ${isDoctor ? "bg-primary-50 border-primary-200" : "bg-gray-50 border-gray-200"}`} />
            </div>
          </div>
          
          {isDoctor && availablePatients.length > 0 && (
            <div className="bg-blue-50 border border-blue-200 rounded-lg p-2 text-xs text-blue-700">
              💡 يظهر لك فقط المرضى الذين أكملوا حجوزاتهم عندك
            </div>
          )}

          {/* Doctor Info */}
          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                الطبيب <span className="text-red-500">*</span>
              </label>
              <input 
                type="text" 
                value={form.doctorName} 
                onChange={(e) => setForm({ ...form, doctorName: e.target.value })} 
                required 
                readOnly={isDoctor}
                className={`w-full px-4 py-3 border rounded-xl text-sm focus:outline-none focus:border-primary-500 ${
                  isDoctor 
                    ? "bg-primary-50 border-primary-200 text-primary-700 cursor-not-allowed" 
                    : "bg-gray-50 border-gray-200"
                }`} 
              />
              {isDoctor && (
                <p className="text-xs text-primary-600 mt-1">🔒 الوصفة تُنسب لك تلقائياً</p>
              )}
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">التخصص <span className="text-red-500">*</span></label>
              <input type="text" value={form.doctorSpecialty} onChange={(e) => setForm({ ...form, doctorSpecialty: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
          </div>

          {/* Diagnosis */}
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">التشخيص <span className="text-red-500">*</span></label>
            <input type="text" value={form.diagnosis} onChange={(e) => setForm({ ...form, diagnosis: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
          </div>

          {/* Medications */}
          <div>
            <div className="flex items-center justify-between mb-3">
              <label className="text-sm font-bold text-gray-700">الأدوية</label>
              <button type="button" onClick={addMedication} className="text-sm text-primary-600 font-bold flex items-center gap-1 hover:text-primary-700">
                <PlusIcon size={16} />
                إضافة دواء
              </button>
            </div>

            {medications.map((med, index) => (
              <div key={index} className="bg-gray-50 rounded-xl p-4 mb-3 relative">
                <button
                  type="button"
                  onClick={() => removeMedication(index)}
                  className="absolute top-2 left-2 w-6 h-6 bg-red-100 text-red-600 rounded-full flex items-center justify-center hover:bg-red-200"
                >
                  <X size={14} />
                </button>
                <div className="grid grid-cols-2 gap-3 mb-3">
                  <input type="text" value={med.name} onChange={(e) => updateMedication(index, 'name', e.target.value)} placeholder="اسم الدواء" required className="px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm" />
                  <input type="text" value={med.dosage} onChange={(e) => updateMedication(index, 'dosage', e.target.value)} placeholder="الجرعة (مثال: 500mg)" required className="px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm" />
                </div>
                <div className="grid grid-cols-2 gap-3">
                  <input type="text" value={med.frequency} onChange={(e) => updateMedication(index, 'frequency', e.target.value)} placeholder="التكرار (مثال: 3 مرات يومياً)" required className="px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm" />
                  <input type="text" value={med.duration} onChange={(e) => updateMedication(index, 'duration', e.target.value)} placeholder="المدة (مثال: 7 أيام)" required className="px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm" />
                </div>
                <input type="text" value={med.notes} onChange={(e) => updateMedication(index, 'notes', e.target.value)} placeholder="ملاحظات (اختياري)" className="mt-3 w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm" />
              </div>
            ))}

            {medications.length === 0 && (
              <div className="text-center py-8 bg-gray-50 rounded-xl">
                <p className="text-gray-400 text-sm">لم يتم إضافة أي أدوية</p>
              </div>
            )}
          </div>

          {/* Notes */}
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">ملاحظات إضافية</label>
            <textarea value={form.notes} onChange={(e) => setForm({ ...form, notes: e.target.value })} rows={3} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 resize-none" />
          </div>

          <div className="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="button" onClick={() => setModalOpen(false)} className="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
            <button type="submit" className="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg">{editingItem ? "حفظ التعديلات" : "إنشاء الوصفة"}</button>
          </div>
        </form>
      </Modal>

      {/* View Modal */}
      <Modal isOpen={viewModalOpen} onClose={() => setViewModalOpen(false)} title="تفاصيل الوصفة" size="md">
        {viewingItem && (
          <div className="space-y-5">
            <div className="bg-gray-50 rounded-xl p-5">
              <div className="grid grid-cols-2 gap-4 mb-4">
                <div>
                  <p className="text-xs text-gray-500">المريض</p>
                  <p className="font-bold text-gray-800">{viewingItem.patientName}</p>
                </div>
                <div>
                  <p className="text-xs text-gray-500">العمر</p>
                  <p className="font-bold text-gray-800">{viewingItem.patientAge} سنة</p>
                </div>
                <div>
                  <p className="text-xs text-gray-500">الطبيب</p>
                  <p className="font-bold text-primary-600">{viewingItem.doctorName}</p>
                </div>
                <div>
                  <p className="text-xs text-gray-500">التخصص</p>
                  <p className="font-bold text-gray-800">{viewingItem.doctorSpecialty}</p>
                </div>
              </div>
              <div className="pt-4 border-t border-gray-200">
                <p className="text-xs text-gray-500 mb-1">التشخيص</p>
                <p className="font-bold text-gray-800">{viewingItem.diagnosis}</p>
              </div>
            </div>

            <div>
              <h4 className="font-bold text-gray-800 mb-3">الأدوية ({viewingItem.medications.length})</h4>
              <div className="space-y-3">
                {viewingItem.medications.map((med, i) => (
                  <div key={i} className="bg-blue-50 rounded-xl p-4">
                    <p className="font-bold text-blue-700 mb-2">{i + 1}. {med.name}</p>
                    <div className="grid grid-cols-3 gap-2 text-sm text-gray-600">
                      <div><strong>الجرعة:</strong> {med.dosage}</div>
                      <div><strong>التكرار:</strong> {med.frequency}</div>
                      <div><strong>المدة:</strong> {med.duration}</div>
                    </div>
                    {med.notes && <p className="text-sm text-gray-500 mt-2"><strong>ملاحظات:</strong> {med.notes}</p>}
                  </div>
                ))}
              </div>
            </div>

            {viewingItem.notes && (
              <div className="bg-yellow-50 rounded-xl p-4">
                <p className="text-xs text-gray-500 mb-1">ملاحظات إضافية</p>
                <p className="text-gray-700">{viewingItem.notes}</p>
              </div>
            )}

            <button
              onClick={() => printPrescription(viewingItem)}
              className="w-full bg-purple-500 text-white py-3 rounded-xl font-bold hover:bg-purple-600 transition-colors flex items-center justify-center gap-2"
            >
              <Printer size={18} />
              <span>طباعة الوصفة</span>
            </button>
          </div>
        )}
      </Modal>

      <ConfirmDialog
        isOpen={!!deleteId}
        onClose={() => setDeleteId(null)}
        onConfirm={handleDelete}
        title="حذف الوصفة"
        message="هل أنت متأكد من حذف هذه الوصفة؟"
        confirmText="نعم، احذف"
      />
    </div>
  );
}
