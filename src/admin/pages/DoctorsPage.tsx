import { useState } from "react";
import { Users, Plus, Search, Edit, Trash2, ToggleLeft, ToggleRight, Star, UserCircle } from "lucide-react";
import { useData, Doctor } from "../../context/DataContext";
import PageHeader from "../components/PageHeader";
import Modal from "../components/Modal";
import ConfirmDialog from "../components/ConfirmDialog";
import { useToast } from "../components/Toast";

const GRADIENTS = [
  "from-red-500 to-rose-600",
  "from-blue-500 to-indigo-600",
  "from-purple-500 to-violet-600",
  "from-emerald-500 to-teal-600",
  "from-pink-500 to-rose-600",
  "from-cyan-500 to-sky-600",
  "from-amber-500 to-orange-600",
  "from-lime-500 to-green-600",
];

export default function DoctorsPage() {
  const { doctors, setDoctors, departments, users, setUsers } = useData();
  const { toast } = useToast();
  const [search, setSearch] = useState("");
  const [modalOpen, setModalOpen] = useState(false);
  const [editingItem, setEditingItem] = useState<Doctor | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);
  const [createUserAccount, setCreateUserAccount] = useState(false);

  const [form, setForm] = useState({
    name: "", specialty: "", department: "", image: "", experience: 0, patients: 0, rating: 4.5, gradient: "from-red-500 to-rose-600",
    email: "", password: "",
  });

  const filtered = doctors.filter((d) =>
    d.name.includes(search) || d.specialty.includes(search) || d.department?.includes(search)
  );

  const activeDepartments = departments.filter(d => d.active !== false);

  const openCreate = () => {
    setForm({
      name: "", specialty: "", department: "", image: "", experience: 0, patients: 0, rating: 4.5,
      gradient: "from-red-500 to-rose-600",
      email: "", password: "",
    });
    setCreateUserAccount(false);
    setEditingItem(null);
    setModalOpen(true);
  };

  const openEdit = (doctor: Doctor) => {
    const expNum = parseInt(String(doctor.experience).replace(/[^0-9]/g, "")) || 0;
    const patNum = parseInt(String(doctor.patients).replace(/[^0-9]/g, "")) || 0;
    setForm({
      name: doctor.name, specialty: doctor.specialty, department: doctor.department || "", image: doctor.image || "",
      experience: expNum, patients: patNum, rating: doctor.rating,
      gradient: doctor.gradient,
      email: "", password: "",
    });
    setCreateUserAccount(false);
    setEditingItem(doctor);
    setModalOpen(true);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const docData = {
      name: form.name,
      specialty: form.specialty,
      department: form.department,
      image: form.image,
      experience: form.experience > 0 ? `${form.experience} سنة` : "",
      patients: form.patients > 0 ? `+${form.patients}` : "",
      rating: form.rating,
      gradient: form.gradient,
    };

    if (editingItem) {
      setDoctors(doctors.map((d) => d.id === editingItem.id ? { ...d, ...docData } : d));
      toast("success", "تم تحديث بيانات الطبيب بنجاح");
    } else {
      const newDoctorId = Date.now().toString();
      setDoctors([...doctors, {
        id: newDoctorId,
        ...docData,
        active: true,
      }]);

      // إنشاء حساب مستخدم للطبيب إذا تم اختيار ذلك
      if (createUserAccount && form.email) {
        const username = form.email.split("@")[0].replace(/[^a-zA-Z0-9]/g, "");
        const newUser = {
          id: (Date.now() + 1).toString(),
          username: username,
          password: form.password || "123456", // كلمة مرور افتراضية
          role: "doctor" as const,
          name: form.name,
          email: form.email,
          phone: "",
          active: true,
          createdAt: new Date().toISOString(),
        };
        setUsers([...users, newUser]);
        toast("success", `تم إضافة الطبيب وإنشاء حسابه بنجاح! بيانات الدخول: ${username} / ${form.password || "123456"}`);
      } else {
        toast("success", "تم إضافة الطبيب بنجاح");
      }
    }
    setModalOpen(false);
  };

  const handleDelete = () => {
    if (deleteId) {
      setDoctors(doctors.filter((d) => d.id !== deleteId));
      toast("success", "تم حذف الطبيب بنجاح");
      setDeleteId(null);
    }
  };

  const toggleActive = (id: string) => {
    setDoctors(doctors.map((d) => d.id === id ? { ...d, active: !d.active } : d));
    toast("info", "تم تحديث حالة الطبيب");
  };

  return (
    <div>
      <PageHeader
        title="الأطباء"
        subtitle={`إدارة ${doctors.length} طبيب واستشاري`}
        icon={<Users size={26} />}
        action={
          <button
            onClick={openCreate}
            className="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2"
          >
            <Plus size={18} />
            <span>إضافة طبيب</span>
          </button>
        }
      />

      <div className="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
        <div className="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
          <Search size={16} className="text-gray-400" />
          <input
            type="text"
            placeholder="بحث بالاسم أو التخصص أو القسم..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            className="bg-transparent outline-none flex-1 text-sm"
          />
        </div>
      </div>

      {/* Cards Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        {filtered.map((doctor) => (
          <div
            key={doctor.id}
            className={`bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all ${
              !doctor.active ? "opacity-60" : ""
            }`}
          >
            {/* Image or Placeholder */}
            <div className="relative h-48">
              {doctor.image ? (
                <img src={doctor.image} alt={doctor.name} className="w-full h-full object-cover" />
              ) : (
                <div className={`w-full h-full bg-gradient-to-br ${doctor.gradient} flex items-center justify-center`}>
                  <UserCircle size={64} className="text-white/40" />
                </div>
              )}
              <div className="absolute top-3 left-3 bg-white/90 backdrop-blur-sm rounded-full px-2 py-1 flex items-center gap-1">
                <Star size={12} className="text-yellow-500 fill-yellow-500" />
                <span className="text-xs font-bold">{doctor.rating}</span>
              </div>
              {doctor.department && (
                <div className="absolute bottom-3 right-3 bg-white/90 backdrop-blur-sm rounded-full px-2.5 py-1">
                  <span className="text-xs font-bold text-primary-700">{doctor.department}</span>
                </div>
              )}
            </div>
            <div className="p-5">
              <div className="flex items-start justify-between mb-3">
                <div>
                  <h3 className="font-bold text-gray-800">{doctor.name}</h3>
                  <p className="text-xs text-primary-600 font-medium mt-1">{doctor.specialty}</p>
                </div>
                <button onClick={() => toggleActive(doctor.id)} className="shrink-0">
                  {doctor.active ? (
                    <ToggleRight size={22} className="text-green-500" />
                  ) : (
                    <ToggleLeft size={22} className="text-gray-400" />
                  )}
                </button>
              </div>
              <div className="flex items-center gap-3 text-xs text-gray-500 mb-4">
                {doctor.experience && <span>📋 {doctor.experience}</span>}
                {doctor.patients && <span>👥 {doctor.patients} مريض</span>}
              </div>
              <div className="flex items-center gap-2">
                <button
                  onClick={() => openEdit(doctor)}
                  className="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1"
                >
                  <Edit size={14} />
                  تعديل
                </button>
                <button
                  onClick={() => setDeleteId(doctor.id)}
                  className="flex-1 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-100 transition-colors flex items-center justify-center gap-1"
                >
                  <Trash2 size={14} />
                  حذف
                </button>
              </div>
            </div>
          </div>
        ))}
      </div>

      {filtered.length === 0 && (
        <div className="bg-white rounded-2xl p-16 border border-gray-100 text-center">
          <Users size={48} className="text-gray-300 mx-auto mb-4" />
          <p className="text-gray-500">لا يوجد أطباء</p>
        </div>
      )}

      {/* Form Modal */}
      <Modal isOpen={modalOpen} onClose={() => setModalOpen(false)} title={editingItem ? "تعديل بيانات الطبيب" : "إضافة طبيب جديد"} size="md">
        <form onSubmit={handleSubmit} className="space-y-5">
          {/* الاسم والتخصص */}
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">اسم الطبيب <span className="text-red-500">*</span></label>
              <input type="text" value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="د. أحمد الراشد" />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">التخصص <span className="text-red-500">*</span></label>
              <input type="text" value={form.specialty} onChange={(e) => setForm({ ...form, specialty: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="استشاري جراحة القلب" />
            </div>
          </div>

          {/* القسم - من الأقسام المتوفرة فقط */}
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">القسم <span className="text-red-500">*</span></label>
            <select
              value={form.department}
              onChange={(e) => setForm({ ...form, department: e.target.value })}
              required
              className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 appearance-none"
            >
              <option value="">اختر القسم</option>
              {activeDepartments.map((dept) => (
                <option key={dept.id} value={dept.name}>{dept.name}</option>
              ))}
            </select>
            {activeDepartments.length === 0 && (
              <p className="text-xs text-red-500 mt-1">⚠️ لا توجد أقسام متاحة. أضف أقسام أولاً.</p>
            )}
          </div>

          {/* إنشاء حساب مستخدم - فقط عند إضافة طبيب جديد */}
          {!editingItem && (
            <div className="bg-gradient-to-l from-purple-50 to-indigo-50 rounded-xl p-4 border border-purple-200">
              <label className="flex items-start gap-3 cursor-pointer">
                <input
                  type="checkbox"
                  checked={createUserAccount}
                  onChange={(e) => setCreateUserAccount(e.target.checked)}
                  className="mt-1 w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500"
                />
                <div className="flex-1">
                  <div className="flex items-center gap-2">
                    <UserCircle size={18} className="text-purple-600" />
                    <span className="font-bold text-gray-800">إنشاء حساب مستخدم للطبيب</span>
                  </div>
                  <p className="text-xs text-gray-600 mt-1">
                    سيتم إنشاء حساب دخول لل doktor ليعرض حجوزاته الخاصة في لوحة التحكم
                  </p>
                </div>
              </label>

              {createUserAccount && (
                <div className="mt-4 space-y-3 pl-8">
                  <div>
                    <label className="block text-sm font-bold text-gray-700 mb-2">
                      البريد الإلكتروني <span className="text-red-500">*</span>
                    </label>
                    <input
                      type="email"
                      value={form.email}
                      onChange={(e) => setForm({ ...form, email: e.target.value })}
                      required={createUserAccount}
                      className="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
                      placeholder="doctor@example.com"
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-bold text-gray-700 mb-2">
                      كلمة المرور
                      <span className="text-gray-400 font-normal mr-2">(اختياري - الافتراضية: 123456)</span>
                    </label>
                    <input
                      type="text"
                      value={form.password}
                      onChange={(e) => setForm({ ...form, password: e.target.value })}
                      className="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
                      placeholder="123456"
                    />
                  </div>
                  <div className="bg-blue-50 border border-blue-200 rounded-lg p-3 text-xs text-blue-700">
                    💡 اسم المستخدم سيُشتق تلقائياً من البريد الإلكتروني. سيستطيع الطبيب الدخول باسم المستخدم من البريد وكلمة المرور المحددة.
                  </div>
                </div>
              )}
            </div>
          )}

          {/* رابط الصورة - اختياري */}
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">
              رابط الصورة
              <span className="text-gray-400 font-normal mr-2">(اختياري)</span>
            </label>
            <input type="url" value={form.image} onChange={(e) => setForm({ ...form, image: e.target.value })} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="https://example.com/photo.jpg" />
            {form.image && (
              <div className="mt-2 w-20 h-20 rounded-xl overflow-hidden border border-gray-200">
                <img src={form.image} alt="معاينة" className="w-full h-full object-cover" onError={(e) => { (e.target as HTMLImageElement).style.display = "none"; }} />
              </div>
            )}
          </div>

          {/* سنوات الخبرة + المرضى + التقييم */}
          <div className="grid grid-cols-3 gap-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                سنوات الخبرة
                <span className="text-gray-400 font-normal block text-xs">(اختياري)</span>
              </label>
              <input
                type="number"
                min="0"
                max="60"
                step="1"
                value={form.experience}
                onChange={(e) => setForm({ ...form, experience: parseInt(e.target.value) || 0 })}
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
              />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                عدد المرضى
                <span className="text-gray-400 font-normal block text-xs">(اختياري)</span>
              </label>
              <input
                type="number"
                min="0"
                max="100000"
                step="100"
                value={form.patients}
                onChange={(e) => setForm({ ...form, patients: parseInt(e.target.value) || 0 })}
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
              />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                التقييم
                <span className="text-gray-400 font-normal block text-xs">من 5</span>
              </label>
              <input
                type="number"
                min="0"
                max="5"
                step="0.1"
                value={form.rating}
                onChange={(e) => setForm({ ...form, rating: parseFloat(e.target.value) || 0 })}
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
              />
            </div>
          </div>

          {/* اللون */}
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">لون البطاقة</label>
            <div className="grid grid-cols-8 gap-2">
              {GRADIENTS.map((g) => (
                <button
                  key={g}
                  type="button"
                  onClick={() => setForm({ ...form, gradient: g })}
                  className={`h-10 bg-gradient-to-br ${g} rounded-xl transition-all ${form.gradient === g ? "ring-4 ring-offset-2 ring-primary-500 scale-110" : "hover:scale-105"}`}
                />
              ))}
            </div>
          </div>

          {/* الأزرار */}
          <div className="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="button" onClick={() => setModalOpen(false)} className="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
            <button type="submit" className="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg">{editingItem ? "حفظ التعديلات" : "إضافة الطبيب"}</button>
          </div>
        </form>
      </Modal>

      <ConfirmDialog
        isOpen={!!deleteId}
        onClose={() => setDeleteId(null)}
        onConfirm={handleDelete}
        title="حذف الطبيب"
        message="هل أنت متأكد من حذف بيانات الطبيب؟"
        confirmText="نعم، احذف"
      />
    </div>
  );
}
