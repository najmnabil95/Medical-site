import { useState } from "react";
import { Shield, Plus, Search, Edit, Trash2, ToggleLeft, ToggleRight, User as UserIcon } from "lucide-react";
import { useData } from "../../context/DataContext";
import { User, UserRole, ROLE_LABELS, ROLE_COLORS } from "../../utils/roles";
import PageHeader from "../components/PageHeader";
import Modal from "../components/Modal";
import ConfirmDialog from "../components/ConfirmDialog";
import { useToast } from "../components/Toast";

const ROLES: UserRole[] = ['admin', 'doctor', 'nurse', 'reception', 'accountant'];

export default function UsersPage() {
  const { users, setUsers, departments, doctors } = useData();
  const { toast } = useToast();
  const [search, setSearch] = useState("");
  const [modalOpen, setModalOpen] = useState(false);
  const [editingItem, setEditingItem] = useState<User | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);
  const [roleFilter, setRoleFilter] = useState<UserRole | 'all'>('all');

  const [form, setForm] = useState({
    username: "",
    password: "",
    role: "doctor" as UserRole,
    name: "",
    email: "",
    phone: "",
    active: true,
    assignedDepartments: [] as string[],
    assignedDoctors: [] as string[],
  });

  const filtered = users.filter((u: User) => {
    const matchesSearch = u.name.includes(search) || u.username.includes(search) || u.email.includes(search);
    const matchesRole = roleFilter === 'all' || u.role === roleFilter;
    return matchesSearch && matchesRole;
  });

  const openCreate = () => {
    setForm({
      username: "",
      password: "",
      role: "doctor",
      name: "",
      email: "",
      phone: "",
      active: true,
      assignedDepartments: [],
      assignedDoctors: [],
    });
    setEditingItem(null);
    setModalOpen(true);
  };

  const openEdit = (user: User) => {
    setForm({
      username: user.username,
      password: "",
      role: user.role as UserRole,
      name: user.name,
      email: user.email,
      phone: user.phone,
      active: user.active,
      assignedDepartments: user.assignedDepartments || [],
      assignedDoctors: user.assignedDoctors || [],
    });
    setEditingItem(user);
    setModalOpen(true);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    if (editingItem) {
      const updatedUser = { ...editingItem, ...form };
      if (form.password) {
        updatedUser.password = form.password;
      }
      setUsers(users.map((u: User) => u.id === editingItem.id ? updatedUser : u));
      toast("success", "تم تحديث المستخدم بنجاح");
    } else {
      const newUser: User = {
        id: Date.now().toString(),
        ...form,
        createdAt: new Date().toISOString(),
      };
      setUsers([...users, newUser]);
      toast("success", "تم إضافة المستخدم بنجاح");
    }
    setModalOpen(false);
  };

  const handleDelete = () => {
    if (deleteId) {
      const user = users.find((u: User) => u.id === deleteId);
      if (user && user.role === "admin") {
        toast("error", "لا يمكن حذف حساب مدير النظام");
        setDeleteId(null);
        return;
      }
      setUsers(users.filter((u: User) => u.id !== deleteId));
      toast("success", "تم حذف المستخدم بنجاح");
      setDeleteId(null);
    }
  };

  const toggleActive = (id: string) => {
    const user = users.find((u: User) => u.id === id);
    if (user && user.role === "admin") {
      toast("error", "لا يمكن إيقاف حساب مدير النظام");
      return;
    }
    setUsers(users.map((u: User) => u.id === id ? { ...u, active: !u.active } : u));
    toast("info", "تم تحديث حالة المستخدم");
  };

  const stats = {
    total: users.length,
    admin: users.filter((u: User) => u.role === 'admin').length,
    doctor: users.filter((u: User) => u.role === 'doctor').length,
    nurse: users.filter((u: User) => u.role === 'nurse').length,
    reception: users.filter((u: User) => u.role === 'reception').length,
    accountant: users.filter((u: User) => u.role === 'accountant').length,
  };

  return (
    <div>
      <PageHeader
        title="إدارة المستخدمين"
        subtitle={`${stats.total} مستخدم في النظام`}
        icon={<Shield size={26} />}
        action={
          <button
            onClick={openCreate}
            className="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2"
          >
            <Plus size={18} />
            <span>إضافة مستخدم</span>
          </button>
        }
      />

      {/* Stats */}
      <div className="grid grid-cols-2 md:grid-cols-6 gap-4 mb-6">
        {ROLES.map((role) => (
          <button
            key={role}
            onClick={() => setRoleFilter(roleFilter === role ? 'all' : role)}
            className={`bg-white rounded-xl p-4 border transition-all ${
              roleFilter === role ? 'border-primary-500 shadow-lg' : 'border-gray-100 hover:shadow-md'
            }`}
          >
            <div className={`w-10 h-10 bg-gradient-to-br ${ROLE_COLORS[role]} rounded-lg flex items-center justify-center text-white mb-2`}>
              <UserIcon size={20} />
            </div>
            <div className="text-2xl font-black text-gray-800">
              {stats[role]}
            </div>
            <div className="text-xs text-gray-500">{ROLE_LABELS[role]}</div>
          </button>
        ))}
      </div>

      {/* Filters */}
      <div className="bg-white rounded-2xl p-4 mb-6 border border-gray-100 flex flex-col md:flex-row gap-3">
        <div className="flex-1 flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
          <Search size={16} className="text-gray-400" />
          <input
            type="text"
            placeholder="بحث بالاسم أو اسم المستخدم..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            className="bg-transparent outline-none flex-1 text-sm"
          />
        </div>
        {roleFilter !== 'all' && (
          <button
            onClick={() => setRoleFilter('all')}
            className="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-200"
          >
            إزالة الفلتر ✕
          </button>
        )}
      </div>

      {/* Users Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        {filtered.map((user: User) => (
          <div
            key={user.id}
            className={`bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl transition-all ${
              !user.active ? "opacity-60" : ""
            }`}
          >
            <div className={`h-2 bg-gradient-to-l ${ROLE_COLORS[user.role]}`}></div>
            <div className="p-5">
              <div className="flex items-start justify-between mb-3">
                <div className="flex items-center gap-3">
                  <div className={`w-12 h-12 bg-gradient-to-br ${ROLE_COLORS[user.role]} rounded-xl flex items-center justify-center text-white font-bold`}>
                    {user.name.charAt(0)}
                  </div>
                  <div>
                    <h3 className="font-bold text-gray-800">{user.name}</h3>
                    <p className="text-xs text-gray-500">@{user.username}</p>
                  </div>
                </div>
                <button 
                  onClick={() => toggleActive(user.id)} 
                  className={`shrink-0 ${user.role === 'admin' ? "cursor-not-allowed opacity-50" : ""}`}
                  disabled={user.role === 'admin'}
                  title={user.role === 'admin' ? "لا يمكن إيقاف حساب مدير النظام" : ""}
                >
                  {user.active ? (
                    <ToggleRight size={22} className="text-green-500" />
                  ) : (
                    <ToggleLeft size={22} className="text-gray-400" />
                  )}
                </button>
              </div>

              <div className="space-y-2 mb-4">
                <div className="flex items-center gap-2 text-sm text-gray-600">
                  <span className="text-gray-400">📧</span>
                  <span className="truncate">{user.email}</span>
                </div>
                <div className="flex items-center gap-2 text-sm text-gray-600">
                  <span className="text-gray-400">📱</span>
                  <span>{user.phone}</span>
                </div>
                <div className="flex items-center gap-2">
                  <span className={`inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-l ${ROLE_COLORS[user.role]} text-white`}>
                    {ROLE_LABELS[user.role]}
                  </span>
                </div>
              </div>

              <div className="flex items-center gap-2">
                <button
                  onClick={() => openEdit(user)}
                  className="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1"
                >
                  <Edit size={14} />
                  تعديل
                </button>
                <button
                  onClick={() => setDeleteId(user.id)}
                  disabled={user.role === 'admin'}
                  className={`flex-1 py-2 rounded-lg text-sm font-bold transition-colors flex items-center justify-center gap-1 ${
                    user.role === 'admin'
                      ? "bg-gray-100 text-gray-400 cursor-not-allowed"
                      : "bg-red-50 text-red-600 hover:bg-red-100"
                  }`}
                  title={user.role === 'admin' ? "لا يمكن حذف حساب مدير النظام" : ""}
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
          <Shield size={48} className="text-gray-300 mx-auto mb-4" />
          <p className="text-gray-500">لا يوجد مستخدمين</p>
        </div>
      )}

      {/* Form Modal */}
      <Modal isOpen={modalOpen} onClose={() => setModalOpen(false)} title={editingItem ? "تعديل المستخدم" : "إضافة مستخدم جديد"} size="md">
        <form onSubmit={handleSubmit} className="space-y-5">
          {editingItem?.role === 'admin' && (
            <div className="bg-amber-50 border border-amber-200 rounded-xl p-3 text-xs text-amber-700 font-bold">
              ⚠️ لا يمكن تعديل صلاحيات أو رقم هاتف مدير النظام لحماية الحساب من الإيقاف.
            </div>
          )}
          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">الاسم الكامل <span className="text-red-500">*</span></label>
              <input
                type="text"
                value={form.name}
                onChange={(e) => setForm({ ...form, name: e.target.value })}
                required
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
                placeholder="د. أحمد محمد"
              />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">اسم المستخدم <span className="text-red-500">*</span></label>
              <input
                type="text"
                value={form.username}
                onChange={(e) => setForm({ ...form, username: e.target.value })}
                required
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
                placeholder="ahmed.doctor"
              />
            </div>
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">
              كلمة المرور {editingItem ? <span className="text-gray-400 font-normal">(اتركها فارغة إذا لم ترد تغييرها)</span> : <span className="text-red-500">*</span>}
            </label>
            <input
              type="password"
              value={form.password}
              onChange={(e) => setForm({ ...form, password: e.target.value })}
              required={!editingItem}
              className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
              placeholder={editingItem ? "••••••••" : "كلمة مرور قوية"}
            />
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">الدور <span className="text-red-500">*</span></label>
            <select
              value={form.role}
              onChange={(e) => setForm({ ...form, role: e.target.value as UserRole })}
              required
              disabled={editingItem?.role === 'admin'}
              className={`w-full px-4 py-3 border rounded-xl text-sm focus:outline-none focus:border-primary-500 appearance-none ${
                editingItem?.role === 'admin'
                  ? "bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200"
                  : "bg-gray-50 border-gray-200"
              }`}
            >
              {ROLES.map((role) => (
                <option key={role} value={role}>{ROLE_LABELS[role]}</option>
              ))}
            </select>
          </div>

          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني <span className="text-red-500">*</span></label>
              <input
                type="email"
                value={form.email}
                onChange={(e) => setForm({ ...form, email: e.target.value })}
                required
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
                placeholder="user@alshifa-hospital.com"
              />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">رقم الهاتف <span className="text-red-500">*</span></label>
              <input
                type="tel"
                value={form.phone}
                onChange={(e) => setForm({ ...form, phone: e.target.value })}
                required
                disabled={editingItem?.role === 'admin'}
                className={`w-full px-4 py-3 border rounded-xl text-sm focus:outline-none focus:border-primary-500 ${
                  editingItem?.role === 'admin'
                    ? "bg-gray-100 text-gray-400 cursor-not-allowed border-gray-200"
                    : "bg-gray-50 border-gray-200"
                }`}
                placeholder="+966 5X XXX XXXX"
                title={editingItem?.role === 'admin' ? "لا يمكن تغيير رقم هاتف مدير النظام" : ""}
              />
            </div>
          </div>

          {/* حقل القسم للطبيب */}
          {form.role === "doctor" && (
            <div className="bg-gradient-to-l from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-200">
              <h4 className="font-bold text-gray-800 mb-3 flex items-center gap-2">
                👨‍⚕️ قسم الطبيب
              </h4>
              <p className="text-xs text-gray-600 mb-4">
                حدد القسم الذي ينتمي إليه الطبيب (سيظهر في بطاقته ويُستخدم في الفلترة)
              </p>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                القسم <span className="text-red-500">*</span>
              </label>
              <select
                value={form.assignedDepartments?.[0] || ""}
                onChange={(e) => {
                  setForm({ 
                    ...form, 
                    assignedDepartments: e.target.value ? [e.target.value] : [] 
                  });
                }}
                required
                className="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 appearance-none"
              >
                <option value="">اختر القسم</option>
                {departments.filter(d => d.active !== false).map((dept) => (
                  <option key={dept.id} value={dept.name}>{dept.name}</option>
                ))}
              </select>
              {departments.filter(d => d.active !== false).length === 0 && (
                <p className="text-xs text-red-500 mt-2">⚠️ لا توجد أقسام متاحة. أضف أقسام أولاً.</p>
              )}
              <div className="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-2 text-xs text-blue-700">
                💡 القسم سيُستخدم لعرض الطبيب في صفحة القسم وإدارة حجوزاته
              </div>
            </div>
          )}

          {/* حقول الارتباط للممرض فقط */}
          {form.role === "nurse" && (
            <div className="bg-gradient-to-l from-emerald-50 to-teal-50 rounded-xl p-4 border border-emerald-200">
              <h4 className="font-bold text-gray-800 mb-3 flex items-center gap-2">
                👩‍⚕️ ربط الممرض بالأقسام والأطباء
              </h4>
              <p className="text-xs text-gray-600 mb-4">
                حدد الأقسام أو الأطباء الذي يمكن للممرض الاطلاع على حجوزاتهم
              </p>

              {/* الأقسام المرتبطة */}
              <div className="mb-4">
                <label className="block text-sm font-bold text-gray-700 mb-2">
                  الأقسام المرتبطة
                  <span className="text-gray-400 font-normal mr-2">(اختياري)</span>
                </label>
                <div className="space-y-2 max-h-40 overflow-y-auto bg-white rounded-lg p-3 border border-gray-200">
                  {departments.filter(d => d.active !== false).map((dept) => (
                    <label key={dept.id} className="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-1.5 rounded">
                      <input
                        type="checkbox"
                        checked={form.assignedDepartments?.includes(dept.name) || false}
                        onChange={(e) => {
                          const current = form.assignedDepartments || [];
                          if (e.target.checked) {
                            setForm({ ...form, assignedDepartments: [...current, dept.name] });
                          } else {
                            setForm({ ...form, assignedDepartments: current.filter(d => d !== dept.name) });
                          }
                        }}
                        className="w-4 h-4 rounded"
                      />
                      <span className="text-sm text-gray-700">{dept.name}</span>
                    </label>
                  ))}
                  {departments.filter(d => d.active !== false).length === 0 && (
                    <p className="text-xs text-gray-400 text-center py-2">لا توجد أقسام</p>
                  )}
                </div>
              </div>

              {/* الأطباء المرتبطون */}
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-2">
                  الأطباء المرتبطون
                  <span className="text-gray-400 font-normal mr-2">(اختياري)</span>
                </label>
                <div className="space-y-2 max-h-40 overflow-y-auto bg-white rounded-lg p-3 border border-gray-200">
                  {doctors.filter(d => d.active !== false).map((doc) => (
                    <label key={doc.id} className="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-1.5 rounded">
                      <input
                        type="checkbox"
                        checked={form.assignedDoctors?.includes(doc.name) || false}
                        onChange={(e) => {
                          const current = form.assignedDoctors || [];
                          if (e.target.checked) {
                            setForm({ ...form, assignedDoctors: [...current, doc.name] });
                          } else {
                            setForm({ ...form, assignedDoctors: current.filter(d => d !== doc.name) });
                          }
                        }}
                        className="w-4 h-4 rounded"
                      />
                      <div className="flex-1">
                        <span className="text-sm text-gray-700 font-medium">{doc.name}</span>
                        <span className="text-xs text-gray-400 mr-2">- {doc.department}</span>
                      </div>
                    </label>
                  ))}
                  {doctors.filter(d => d.active !== false).length === 0 && (
                    <p className="text-xs text-gray-400 text-center py-2">لا يوجد أطباء</p>
                  )}
                </div>
              </div>

              <div className="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-2 text-xs text-blue-700">
                💡 الممرض سيتمكن من الاطلاع على حجوزات ووصفات الأقسام والأطباء المختارين فقط
              </div>
            </div>
          )}

          <div className="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="button" onClick={() => setModalOpen(false)} className="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
            <button type="submit" className="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg">{editingItem ? "حفظ التعديلات" : "إضافة المستخدم"}</button>
          </div>
        </form>
      </Modal>

      <ConfirmDialog
        isOpen={!!deleteId}
        onClose={() => setDeleteId(null)}
        onConfirm={handleDelete}
        title="حذف المستخدم"
        message="هل أنت متأكد من حذف هذا المستخدم؟ لن يتمكن من الدخول إلى النظام."
        confirmText="نعم، احذف"
      />
    </div>
  );
}
