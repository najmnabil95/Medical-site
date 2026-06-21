import { Tag, Plus, Search, Edit, Trash2, Percent, Calendar } from "lucide-react";
import { useState } from "react";
import PageHeader from "../components/PageHeader";
import Modal from "../components/Modal";
import ConfirmDialog from "../components/ConfirmDialog";
import { useToast } from "../components/Toast";

interface Offer {
  id: string;
  title: string;
  desc: string;
  discount: string;
  originalPrice: string;
  newPrice: string;
  validUntil: string;
  category: string;
  icon: string;
  color: string;
  active: boolean;
}

const ICONS = ["❤️", "👶", "🦷", "🔬", "✈️", "👁️", "🎁", "💊", "🩺", "🏥"];
const COLORS = [
  "from-red-500 to-rose-600",
  "from-pink-500 to-rose-600",
  "from-blue-500 to-indigo-600",
  "from-amber-500 to-orange-600",
  "from-purple-500 to-violet-600",
  "from-emerald-500 to-teal-600",
];
const CATEGORIES = ["فحوصات", "ولادة", "أسنان", "عيون", "سياحة علاجية", "قلب", "جراحة", "أخرى"];

export default function OffersPage() {
  const [offers, setOffers] = useState<Offer[]>(() => {
    const saved = localStorage.getItem("offers");
    if (saved) return JSON.parse(saved);
    return [
      { id: "1", title: "خصم 30% على فحص القلب", desc: "فحص شامل للقلب بتخفيض خاص", discount: "30%", originalPrice: "1500", newPrice: "1050", validUntil: "2024-12-31", category: "قلب", icon: "❤️", color: "from-red-500 to-rose-600", active: true },
      { id: "2", title: "باقة الولادة الذهبية", desc: "باقة شاملة مع جلسات علاج طبيعي", discount: "هدية", originalPrice: "8000", newPrice: "8000", validUntil: "2024-12-31", category: "ولادة", icon: "👶", color: "from-pink-500 to-rose-600", active: true },
    ];
  });
  const { toast } = useToast();
  const [search, setSearch] = useState("");
  const [modalOpen, setModalOpen] = useState(false);
  const [editingItem, setEditingItem] = useState<Offer | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);
  const [form, setForm] = useState<Partial<Offer>>({});

  // Persist
  useState(() => {
    localStorage.setItem("offers", JSON.stringify(offers));
  });

  const filtered = offers.filter(o => o.title.includes(search) || o.category.includes(search));

  const openCreate = () => {
    setForm({ title: "", desc: "", discount: "", originalPrice: "", newPrice: "", validUntil: "", category: "", icon: "❤️", color: "from-red-500 to-rose-600" });
    setEditingItem(null);
    setModalOpen(true);
  };

  const openEdit = (offer: Offer) => {
    setForm(offer);
    setEditingItem(offer);
    setModalOpen(true);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (editingItem) {
      setOffers(offers.map(o => o.id === editingItem.id ? { ...o, ...form } as Offer : o));
      toast("success", "تم تحديث العرض بنجاح");
    } else {
      setOffers([...offers, { id: Date.now().toString(), ...form, active: true } as Offer]);
      toast("success", "تم إضافة العرض بنجاح");
    }
    setModalOpen(false);
  };

  const handleDelete = () => {
    if (deleteId) {
      setOffers(offers.filter(o => o.id !== deleteId));
      toast("success", "تم حذف العرض بنجاح");
      setDeleteId(null);
    }
  };

  const toggleActive = (id: string) => {
    setOffers(offers.map(o => o.id === id ? { ...o, active: !o.active } : o));
    toast("info", "تم تحديث حالة العرض");
  };

  return (
    <div>
      <PageHeader
        title="العروض والخصومات"
        subtitle={`إدارة ${offers.length} عرض`}
        icon={<Tag size={26} />}
        action={
          <button onClick={openCreate} className="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg flex items-center gap-2">
            <Plus size={18} /><span>إضافة عرض</span>
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
        {filtered.map((offer) => (
          <div key={offer.id} className={`bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all ${!offer.active ? "opacity-60" : ""}`}>
            <div className={`h-28 bg-gradient-to-br ${offer.color} relative flex items-center justify-center`}>
              <span className="text-5xl opacity-30 absolute">{offer.icon}</span>
              <div className="relative text-center">
                <span className="text-4xl">{offer.icon}</span>
              </div>
              <div className="absolute top-3 left-3 bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                <Percent size={12} />
                <span>{offer.discount}</span>
              </div>
            </div>
            <div className="p-5">
              <h3 className="font-bold text-gray-800 mb-2 line-clamp-1">{offer.title}</h3>
              <p className="text-gray-500 text-xs mb-3 line-clamp-2">{offer.desc}</p>
              <div className="flex items-center justify-between mb-3">
                <span className="text-xl font-black text-primary-600">{offer.newPrice} ر.س</span>
                {offer.originalPrice !== offer.newPrice && (
                  <span className="text-sm text-gray-400 line-through">{offer.originalPrice} ر.س</span>
                )}
              </div>
              <div className="flex items-center justify-between text-xs text-gray-400 mb-4">
                <div className="flex items-center gap-1">
                  <Calendar size={12} />
                  <span>{offer.validUntil}</span>
                </div>
                <span className="bg-gray-100 px-2 py-0.5 rounded-full">{offer.category}</span>
              </div>
              <div className="flex items-center gap-2">
                <button onClick={() => toggleActive(offer.id)} className={`flex-1 py-2 rounded-lg text-xs font-bold ${offer.active ? "bg-green-50 text-green-600" : "bg-gray-100 text-gray-500"}`}>
                  {offer.active ? "✅ نشط" : "⏸️ معطل"}
                </button>
                <button onClick={() => openEdit(offer)} className="p-2 bg-blue-50 text-blue-500 rounded-lg hover:bg-blue-100">
                  <Edit size={14} />
                </button>
                <button onClick={() => setDeleteId(offer.id)} className="p-2 bg-red-50 text-red-500 rounded-lg hover:bg-red-100">
                  <Trash2 size={14} />
                </button>
              </div>
            </div>
          </div>
        ))}
      </div>

      <Modal isOpen={modalOpen} onClose={() => setModalOpen(false)} title={editingItem ? "تعديل العرض" : "إضافة عرض جديد"} size="md">
        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">العنوان</label>
            <input type="text" value={form.title || ""} onChange={(e) => setForm({ ...form, title: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
          </div>
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">الوصف</label>
            <textarea value={form.desc || ""} onChange={(e) => setForm({ ...form, desc: e.target.value })} required rows={3} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 resize-none" />
          </div>
          <div className="grid grid-cols-3 gap-3">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">الخصم</label>
              <input type="text" value={form.discount || ""} onChange={(e) => setForm({ ...form, discount: e.target.value })} required placeholder="30%" className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">السعر الأصلي</label>
              <input type="text" value={form.originalPrice || ""} onChange={(e) => setForm({ ...form, originalPrice: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">السعر الجديد</label>
              <input type="text" value={form.newPrice || ""} onChange={(e) => setForm({ ...form, newPrice: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
          </div>
          <div className="grid grid-cols-2 gap-3">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">صالح حتى</label>
              <input type="date" value={form.validUntil || ""} onChange={(e) => setForm({ ...form, validUntil: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">التصنيف</label>
              <select value={form.category || ""} onChange={(e) => setForm({ ...form, category: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500">
                <option value="">اختر</option>
                {CATEGORIES.map(c => <option key={c} value={c}>{c}</option>)}
              </select>
            </div>
          </div>
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">الأيقونة</label>
            <div className="grid grid-cols-10 gap-2">
              {ICONS.map(icon => (
                <button key={icon} type="button" onClick={() => setForm({ ...form, icon })} className={`p-2 border-2 rounded-lg text-xl transition-all ${form.icon === icon ? "border-primary-500 bg-primary-50" : "border-gray-200"}`}>
                  {icon}
                </button>
              ))}
            </div>
          </div>
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">اللون</label>
            <div className="grid grid-cols-6 gap-2">
              {COLORS.map(c => (
                <button key={c} type="button" onClick={() => setForm({ ...form, color: c })} className={`h-10 bg-gradient-to-br ${c} rounded-lg transition-all ${form.color === c ? "ring-4 ring-offset-2 ring-primary-500" : ""}`} />
              ))}
            </div>
          </div>
          <div className="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="button" onClick={() => setModalOpen(false)} className="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
            <button type="submit" className="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl">{editingItem ? "حفظ" : "إضافة"}</button>
          </div>
        </form>
      </Modal>

      <ConfirmDialog isOpen={!!deleteId} onClose={() => setDeleteId(null)} onConfirm={handleDelete} title="حذف العرض" message="هل أنت متأكد من حذف هذا العرض؟" confirmText="نعم، احذف" />
    </div>
  );
}
