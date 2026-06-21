import { useState } from "react";
import { Package as PackageIcon, Plus, Search, Edit, Trash2, ToggleLeft, ToggleRight, Star, X } from "lucide-react";
import { useData, Package as PackageType } from "../../context/DataContext";
import PageHeader from "../components/PageHeader";
import Modal from "../components/Modal";
import ConfirmDialog from "../components/ConfirmDialog";
import { useToast } from "../components/Toast";

const GRADIENTS = [
  "from-gray-600 to-gray-800",
  "from-amber-500 to-yellow-600",
  "from-violet-600 to-purple-800",
  "from-emerald-500 to-teal-600",
  "from-blue-500 to-indigo-600",
];

export default function PackagesPage() {
  const { packages, setPackages } = useData();
  const { toast } = useToast();
  const [search, setSearch] = useState("");
  const [modalOpen, setModalOpen] = useState(false);
  const [editingItem, setEditingItem] = useState<PackageType | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);
  const [form, setForm] = useState({ name: "", nameEn: "", price: "", period: "سنوياً", icon: "🩺", popular: false, gradient: "from-gray-600 to-gray-800", featureInput: "", features: [] as string[] });

  const filtered = packages.filter((p) => p.name.includes(search) || p.nameEn.toLowerCase().includes(search.toLowerCase()));

  const openCreate = () => {
    setForm({ name: "", nameEn: "", price: "", period: "سنوياً", icon: "🩺", popular: false, gradient: "from-gray-600 to-gray-800", featureInput: "", features: [] });
    setEditingItem(null);
    setModalOpen(true);
  };

  const openEdit = (pkg: PackageType) => {
    setForm({ name: pkg.name, nameEn: pkg.nameEn, price: pkg.price, period: pkg.period, icon: pkg.icon, popular: pkg.popular, gradient: pkg.gradient, featureInput: "", features: [...pkg.features] });
    setEditingItem(pkg);
    setModalOpen(true);
  };

  const addFeature = () => {
    if (form.featureInput.trim()) {
      setForm({ ...form, features: [...form.features, form.featureInput.trim()], featureInput: "" });
    }
  };

  const removeFeature = (i: number) => {
    setForm({ ...form, features: form.features.filter((_, idx) => idx !== i) });
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (editingItem) {
      setPackages(packages.map((p) => p.id === editingItem.id ? { ...p, name: form.name, nameEn: form.nameEn, price: form.price, period: form.period, icon: form.icon, popular: form.popular, gradient: form.gradient, features: form.features } : p));
      toast("success", "تم التحديث بنجاح");
    } else {
      setPackages([...packages, { id: Date.now().toString(), name: form.name, nameEn: form.nameEn, price: form.price, period: form.period, icon: form.icon, popular: form.popular, gradient: form.gradient, features: form.features, active: true }]);
      toast("success", "تمت الإضافة بنجاح");
    }
    setModalOpen(false);
  };

  const handleDelete = () => {
    if (deleteId) {
      setPackages(packages.filter((p) => p.id !== deleteId));
      toast("success", "تم الحذف بنجاح");
      setDeleteId(null);
    }
  };

  const toggle = (id: string) => {
    setPackages(packages.map((p) => p.id === id ? { ...p, active: !p.active } : p));
  };

  const togglePopular = (id: string) => {
    setPackages(packages.map((p) => p.id === id ? { ...p, popular: !p.popular } : p));
  };

  return (
    <div>
      <PageHeader
        title="الباقات المميزة"
        subtitle={`إدارة ${packages.length} باقة طبية`}
        icon={<PackageIcon size={26} />}
        action={
          <button onClick={openCreate} className="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg transition-all flex items-center gap-2">
            <Plus size={18} /><span>إضافة باقة</span>
          </button>
        }
      />

      <div className="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
        <div className="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
          <Search size={16} className="text-gray-400" />
          <input type="text" placeholder="بحث..." value={search} onChange={(e) => setSearch(e.target.value)} className="bg-transparent outline-none flex-1 text-sm" />
        </div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        {filtered.map((pkg) => (
          <div key={pkg.id} className={`bg-white rounded-2xl border-2 ${pkg.popular ? "border-amber-400" : "border-gray-100"} overflow-hidden hover:shadow-xl transition-all`}>
            <div className={`bg-gradient-to-l ${pkg.gradient} p-6 text-white relative`}>
              {pkg.popular && (
                <div className="absolute top-3 left-3 bg-white/20 backdrop-blur-sm rounded-full px-3 py-1 flex items-center gap-1">
                  <Star size={12} fill="white" />
                  <span className="text-xs font-bold">الأكثر طلباً</span>
                </div>
              )}
              <div className="text-5xl mb-3">{pkg.icon}</div>
              <h3 className="text-xl font-bold">{pkg.name}</h3>
              <p className="text-white/60 text-xs">{pkg.nameEn}</p>
              <div className="mt-3 flex items-baseline gap-1">
                <span className="text-3xl font-black">{pkg.price}</span>
                <span className="text-sm opacity-70">ر.س / {pkg.period}</span>
              </div>
            </div>
            <div className="p-5">
              <div className="mb-4">
                <p className="text-xs font-bold text-gray-400 mb-2">المميزات ({pkg.features.length})</p>
                <ul className="space-y-1">
                  {pkg.features.slice(0, 3).map((f, i) => (
                    <li key={i} className="text-xs text-gray-600 flex items-start gap-1">
                      <span className="text-primary-500">✓</span>
                      <span>{f}</span>
                    </li>
                  ))}
                  {pkg.features.length > 3 && <li className="text-xs text-gray-400">+{pkg.features.length - 3} مميزات أخرى</li>}
                </ul>
              </div>
              <div className="flex items-center gap-2">
                <button onClick={() => togglePopular(pkg.id)} className={`flex-1 py-2 rounded-lg text-xs font-bold ${pkg.popular ? "bg-amber-100 text-amber-600" : "bg-gray-100 text-gray-500"} hover:bg-opacity-70`}>
                  {pkg.popular ? "⭐ مميز" : "مميز"}
                </button>
                <button onClick={() => toggle(pkg.id)} className="p-2 text-gray-400 hover:text-green-500">
                  {pkg.active !== false ? <ToggleRight size={20} className="text-green-500" /> : <ToggleLeft size={20} />}
                </button>
                <button onClick={() => openEdit(pkg)} className="p-2 bg-blue-50 text-blue-500 rounded-lg hover:bg-blue-100">
                  <Edit size={14} />
                </button>
                <button onClick={() => setDeleteId(pkg.id)} className="p-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-100">
                  <Trash2 size={14} />
                </button>
              </div>
            </div>
          </div>
        ))}
      </div>

      <Modal isOpen={modalOpen} onClose={() => setModalOpen(false)} title={editingItem ? "تعديل الباقة" : "إضافة باقة جديدة"} size="lg">
        <form onSubmit={handleSubmit} className="space-y-4">
          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">اسم الباقة</label>
              <input type="text" value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">الاسم بالإنجليزية</label>
              <input type="text" value={form.nameEn} onChange={(e) => setForm({ ...form, nameEn: e.target.value })} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
          </div>

          <div className="grid grid-cols-3 gap-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">السعر</label>
              <input type="text" value={form.price} onChange={(e) => setForm({ ...form, price: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="1,500" />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">الفترة</label>
              <input type="text" value={form.period} onChange={(e) => setForm({ ...form, period: e.target.value })} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">الإيموجي</label>
              <input type="text" value={form.icon} onChange={(e) => setForm({ ...form, icon: e.target.value })} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
          </div>

          <div>
            <label className="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" checked={form.popular} onChange={(e) => setForm({ ...form, popular: e.target.checked })} className="w-5 h-5 rounded" />
              <span className="text-sm font-bold text-gray-700">⭐ تعيين كباقة مميزة (الأكثر طلباً)</span>
            </label>
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">اللون</label>
            <div className="grid grid-cols-5 gap-2">
              {GRADIENTS.map((g) => (
                <button key={g} type="button" onClick={() => setForm({ ...form, gradient: g })} className={`h-12 bg-gradient-to-br ${g} rounded-xl transition-all ${form.gradient === g ? "ring-4 ring-offset-2 ring-primary-500" : ""}`} />
              ))}
            </div>
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">المميزات</label>
            <div className="flex gap-2 mb-3">
              <input type="text" value={form.featureInput} onChange={(e) => setForm({ ...form, featureInput: e.target.value })} placeholder="أضف ميزة..." className="flex-1 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" onKeyDown={(e) => { if (e.key === "Enter") { e.preventDefault(); addFeature(); } }} />
              <button type="button" onClick={addFeature} className="px-4 py-2.5 bg-primary-500 text-white rounded-xl text-sm font-bold hover:bg-primary-600">إضافة</button>
            </div>
            <div className="space-y-2">
              {form.features.map((f, i) => (
                <div key={i} className="flex items-center justify-between bg-gray-50 px-4 py-2 rounded-xl">
                  <span className="text-sm text-gray-700">✓ {f}</span>
                  <button type="button" onClick={() => removeFeature(i)} className="text-red-500 hover:text-red-600">
                    <X size={16} />
                  </button>
                </div>
              ))}
            </div>
          </div>

          <div className="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="button" onClick={() => setModalOpen(false)} className="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
            <button type="submit" className="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl">{editingItem ? "حفظ" : "إضافة"}</button>
          </div>
        </form>
      </Modal>

      <ConfirmDialog isOpen={!!deleteId} onClose={() => setDeleteId(null)} onConfirm={handleDelete} title="حذف الباقة" message="هل أنت متأكد من حذف هذه الباقة؟" confirmText="نعم، احذف" />
    </div>
  );
}
