import { Image as ImageIcon, Plus, Search, Trash2, Edit, Link as LinkIcon, Folder } from "lucide-react";
import { useState } from "react";
import PageHeader from "../components/PageHeader";
import Modal from "../components/Modal";
import ConfirmDialog from "../components/ConfirmDialog";
import { useToast } from "../components/Toast";

interface MediaItem {
  id: string;
  url: string;
  title: string;
  category: string;
}

const defaultMedia: MediaItem[] = [
  { id: "1", url: "https://images.pexels.com/photos/18112241/pexels-photo-18112241.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700", title: "غرفة العمليات", category: "المرافق" },
  { id: "2", url: "https://images.pexels.com/photos/33216715/pexels-photo-33216715.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700", title: "قسم الأشعة", category: "الأجهزة" },
  { id: "3", url: "https://images.pexels.com/photos/20081928/pexels-photo-20081928.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700", title: "فريق الجراحة", category: "الفريق الطبي" },
  { id: "4", url: "https://images.pexels.com/photos/33216690/pexels-photo-33216690.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700", title: "غرف العلاج", category: "المرافق" },
  { id: "5", url: "https://images.pexels.com/photos/4769133/pexels-photo-4769133.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700", title: "أثناء العملية", category: "الفريق الطبي" },
  { id: "6", url: "https://images.pexels.com/photos/15238817/pexels-photo-15238817.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700", title: "الطاقم الطبي", category: "الفريق الطبي" },
];

export default function MediaPage() {
  const [media, setMedia] = useState<MediaItem[]>(() => {
    const saved = localStorage.getItem("media");
    return saved ? JSON.parse(saved) : defaultMedia;
  });
  const { toast } = useToast();
  const [search, setSearch] = useState("");
  const [categoryFilter, setCategoryFilter] = useState("all");
  const [modalOpen, setModalOpen] = useState(false);
  const [editingItem, setEditingItem] = useState<MediaItem | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);
  const [form, setForm] = useState<Partial<MediaItem>>({});

  const saveMedia = (newMedia: MediaItem[]) => {
    setMedia(newMedia);
    localStorage.setItem("media", JSON.stringify(newMedia));
  };

  const categories = ["all", ...Array.from(new Set(media.map(m => m.category)))];
  const filtered = media.filter(m => {
    const matchesSearch = m.title.includes(search);
    const matchesCat = categoryFilter === "all" || m.category === categoryFilter;
    return matchesSearch && matchesCat;
  });

  const openCreate = () => {
    setForm({ url: "", title: "", category: "" });
    setEditingItem(null);
    setModalOpen(true);
  };

  const openEdit = (item: MediaItem) => {
    setForm(item);
    setEditingItem(item);
    setModalOpen(true);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (editingItem) {
      saveMedia(media.map(m => m.id === editingItem.id ? { ...m, ...form } as MediaItem : m));
      toast("success", "تم تحديث الصورة بنجاح");
    } else {
      saveMedia([{ id: Date.now().toString(), ...form } as MediaItem, ...media]);
      toast("success", "تم إضافة الصورة بنجاح");
    }
    setModalOpen(false);
  };

  const handleDelete = () => {
    if (deleteId) {
      saveMedia(media.filter(m => m.id !== deleteId));
      toast("success", "تم حذف الصورة بنجاح");
      setDeleteId(null);
    }
  };

  const copyUrl = (url: string) => {
    navigator.clipboard.writeText(url);
    toast("success", "تم نسخ الرابط");
  };

  return (
    <div>
      <PageHeader
        title="معرض الصور"
        subtitle={`إدارة ${media.length} صورة`}
        icon={<ImageIcon size={26} />}
        action={
          <button onClick={openCreate} className="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg flex items-center gap-2">
            <Plus size={18} /><span>إضافة صورة</span>
          </button>
        }
      />

      {/* Filters */}
      <div className="bg-white rounded-2xl p-4 mb-6 border border-gray-100 flex flex-col md:flex-row gap-3">
        <div className="flex-1 flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
          <Search size={16} className="text-gray-400" />
          <input type="text" placeholder="بحث..." value={search} onChange={(e) => setSearch(e.target.value)} className="bg-transparent outline-none flex-1 text-sm" />
        </div>
        <div className="flex items-center gap-2 bg-gray-50 rounded-xl p-1 border border-gray-100 overflow-x-auto">
          <Folder size={16} className="text-gray-400 mr-2 shrink-0" />
          {categories.map((c) => (
            <button key={c} onClick={() => setCategoryFilter(c)} className={`px-3 py-1.5 text-xs font-bold rounded-lg whitespace-nowrap ${categoryFilter === c ? "bg-primary-500 text-white" : "text-gray-600 hover:bg-gray-200"}`}>
              {c === "all" ? "الكل" : c}
            </button>
          ))}
        </div>
      </div>

      {/* Grid */}
      <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        {filtered.map((item) => (
          <div key={item.id} className="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all">
            <div className="relative aspect-square overflow-hidden">
              <img src={item.url} alt={item.title} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" />
              <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-3">
                <div className="flex items-center gap-1 w-full">
                  <button onClick={() => copyUrl(item.url)} className="flex-1 py-1.5 bg-white/90 text-gray-800 rounded-lg text-xs font-bold flex items-center justify-center gap-1">
                    <LinkIcon size={10} /> نسخ
                  </button>
                  <button onClick={() => openEdit(item)} className="p-1.5 bg-blue-500 text-white rounded-lg">
                    <Edit size={12} />
                  </button>
                  <button onClick={() => setDeleteId(item.id)} className="p-1.5 bg-red-500 text-white rounded-lg">
                    <Trash2 size={12} />
                  </button>
                </div>
              </div>
            </div>
            <div className="p-3">
              <p className="font-bold text-sm text-gray-800 line-clamp-1">{item.title}</p>
              <p className="text-xs text-primary-600 font-medium">{item.category}</p>
            </div>
          </div>
        ))}
      </div>

      {filtered.length === 0 && (
        <div className="bg-white rounded-2xl p-16 border border-gray-100 text-center">
          <ImageIcon size={48} className="text-gray-300 mx-auto mb-4" />
          <p className="text-gray-500">لا توجد صور</p>
        </div>
      )}

      <Modal isOpen={modalOpen} onClose={() => setModalOpen(false)} title={editingItem ? "تعديل الصورة" : "إضافة صورة"} size="sm">
        <form onSubmit={handleSubmit} className="space-y-4">
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">رابط الصورة</label>
            <input type="url" value={form.url || ""} onChange={(e) => setForm({ ...form, url: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="https://..." />
          </div>
          {form.url && (
            <div className="aspect-video rounded-xl overflow-hidden border border-gray-200">
              <img src={form.url} alt="preview" className="w-full h-full object-cover" onError={(e) => (e.currentTarget.style.display = "none")} />
            </div>
          )}
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">العنوان</label>
            <input type="text" value={form.title || ""} onChange={(e) => setForm({ ...form, title: e.target.value })} required className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" />
          </div>
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">التصنيف</label>
            <input type="text" value={form.category || ""} onChange={(e) => setForm({ ...form, category: e.target.value })} required list="categories" className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500" placeholder="المرافق" />
            <datalist id="categories">
              <option value="المرافق" />
              <option value="الأجهزة" />
              <option value="الفريق الطبي" />
              <option value="الغرف" />
              <option value="المعدات" />
            </datalist>
          </div>
          <div className="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="button" onClick={() => setModalOpen(false)} className="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
            <button type="submit" className="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl">{editingItem ? "حفظ" : "إضافة"}</button>
          </div>
        </form>
      </Modal>

      <ConfirmDialog isOpen={!!deleteId} onClose={() => setDeleteId(null)} onConfirm={handleDelete} title="حذف الصورة" message="هل أنت متأكد من حذف هذه الصورة؟" confirmText="نعم، احذف" />
    </div>
  );
}
