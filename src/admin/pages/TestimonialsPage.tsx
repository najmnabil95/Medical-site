import { MessageSquare, Star } from "lucide-react";
import { useData } from "../../context/DataContext";
import PageHeader from "../components/PageHeader";
import { useState } from "react";
import Modal from "../components/Modal";
import ConfirmDialog from "../components/ConfirmDialog";
import { useToast } from "../components/Toast";
import { Edit, Trash2, Plus, Search } from "lucide-react";

const COLORS = [
  "from-primary-500 to-primary-600",
  "from-accent-500 to-accent-600",
  "from-purple-500 to-violet-600",
  "from-rose-500 to-pink-600",
  "from-amber-500 to-orange-600",
];

export default function TestimonialsPage() {
  const { testimonials, setTestimonials } = useData();
  const { toast } = useToast();
  const [search, setSearch] = useState("");
  const [modalOpen, setModalOpen] = useState(false);
  const [editingItem, setEditingItem] = useState<any | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);
  const [form, setForm] = useState({ name: "", role: "", text: "", rating: 5, avatar: "", color: "from-primary-500 to-primary-600" });

  const filtered = testimonials.filter((t) =>
    t.name.includes(search) || t.role.includes(search) || t.text.includes(search)
  );

  const openCreate = () => {
    setForm({ name: "", role: "", text: "", rating: 5, avatar: "", color: "from-primary-500 to-primary-600" });
    setEditingItem(null);
    setModalOpen(true);
  };

  const openEdit = (t: any) => {
    setForm({ name: t.name, role: t.role, text: t.text, rating: t.rating, avatar: t.avatar, color: t.color });
    setEditingItem(t);
    setModalOpen(true);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (editingItem) {
      setTestimonials(testimonials.map((t) => t.id === editingItem.id ? { ...t, ...form } : t));
      toast("success", "تم التحديث بنجاح");
    } else {
      const avatar = form.avatar || form.name.charAt(0);
      setTestimonials([...testimonials, { id: Date.now().toString(), ...form, avatar }]);
      toast("success", "تمت الإضافة بنجاح");
    }
    setModalOpen(false);
  };

  const handleDelete = () => {
    if (deleteId) {
      setTestimonials(testimonials.filter((t) => t.id !== deleteId));
      toast("success", "تم الحذف بنجاح");
      setDeleteId(null);
    }
  };

  return (
    <div>
      <PageHeader
        title="آراء المرضى"
        subtitle={`إدارة ${testimonials.length} رأي من المرضى`}
        icon={<MessageSquare size={26} />}
        action={
          <button onClick={openCreate} className="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg transition-all flex items-center gap-2">
            <Plus size={18} /><span>إضافة رأي</span>
          </button>
        }
      />

      <div className="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
        <div className="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
          <Search size={16} className="text-gray-400" />
          <input type="text" placeholder="بحث..." value={search} onChange={(e) => setSearch(e.target.value)} className="bg-transparent outline-none flex-1 text-sm" />
        </div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
        {filtered.map((t) => (
          <div key={t.id} className="bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-all">
            <div className="flex items-start gap-4 mb-4">
              <div className={`w-14 h-14 bg-gradient-to-br ${t.color} rounded-2xl flex items-center justify-center text-white font-bold text-lg shrink-0`}>
                {t.avatar}
              </div>
              <div className="flex-1">
                <h4 className="font-bold text-gray-800">{t.name}</h4>
                <p className="text-xs text-primary-600 font-medium">{t.role}</p>
                <div className="flex items-center gap-0.5 mt-1">
                  {[...Array(5)].map((_, i) => (
                    <Star key={i} size={12} className={i < t.rating ? "text-yellow-500 fill-yellow-500" : "text-gray-200"} />
                  ))}
                </div>
              </div>
            </div>
            <p className="text-gray-600 text-sm leading-relaxed mb-4">"{t.text}"</p>
            <div className="flex items-center gap-2">
              <button onClick={() => openEdit(t)} className="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-bold hover:bg-blue-100 flex items-center justify-center gap-1">
                <Edit size={14} /> تعديل
              </button>
              <button onClick={() => setDeleteId(t.id)} className="flex-1 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-100 flex items-center justify-center gap-1">
                <Trash2 size={14} /> حذف
              </button>
            </div>
          </div>
        ))}
      </div>

      <Modal isOpen={modalOpen} onClose={() => setModalOpen(false)} title={editingItem ? "تعديل الرأي" : "إضافة رأي جديد"} size="md">
        <form onSubmit={handleSubmit} className="space-y-4">
          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">الاسم</label>
              <input type="text" value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">التوصيف</label>
              <input type="text" value={form.role} onChange={(e) => setForm({ ...form, role: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="مريض - جراحة القلب" />
            </div>
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">النص</label>
            <textarea value={form.text} onChange={(e) => setForm({ ...form, text: e.target.value })} required rows={4} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 resize-none" />
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">التقييم</label>
            <div className="flex items-center gap-1">
              {[1, 2, 3, 4, 5].map((n) => (
                <button key={n} type="button" onClick={() => setForm({ ...form, rating: n })}>
                  <Star size={24} className={n <= form.rating ? "text-yellow-500 fill-yellow-500" : "text-gray-200"} />
                </button>
              ))}
            </div>
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">اللون</label>
            <div className="grid grid-cols-5 gap-2">
              {COLORS.map((c) => (
                <button key={c} type="button" onClick={() => setForm({ ...form, color: c })} className={`h-12 bg-gradient-to-br ${c} rounded-xl transition-all ${form.color === c ? "ring-4 ring-offset-2 ring-primary-500" : ""}`} />
              ))}
            </div>
          </div>

          <div className="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="button" onClick={() => setModalOpen(false)} className="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
            <button type="submit" className="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl">{editingItem ? "حفظ" : "إضافة"}</button>
          </div>
        </form>
      </Modal>

      <ConfirmDialog isOpen={!!deleteId} onClose={() => setDeleteId(null)} onConfirm={handleDelete} title="حذف الرأي" message="هل أنت متأكد من حذف هذا الرأي؟" confirmText="نعم، احذف" />
    </div>
  );
}
