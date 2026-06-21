import { useState } from "react";
import { Plus, Search, Edit, Trash2, ToggleLeft, ToggleRight } from "lucide-react";
import PageHeader from "../components/PageHeader";
import Modal from "../components/Modal";
import ConfirmDialog from "../components/ConfirmDialog";
import { useToast } from "../components/Toast";

interface Field {
  name: string;
  label: string;
  type?: "text" | "textarea" | "number" | "url" | "select";
  options?: string[];
  placeholder?: string;
}

interface GenericCrudProps {
  title: string;
  subtitle: string;
  icon: React.ReactNode;
  items: any[];
  setItems: (items: any[]) => void;
  fields: Field[];
  searchFields?: string[];
  canToggle?: boolean;
}

export default function GenericCrud({
  title,
  subtitle,
  icon,
  items,
  setItems,
  fields,
  searchFields = [],
  canToggle = false,
}: GenericCrudProps) {
  const { toast } = useToast();
  const [search, setSearch] = useState("");
  const [modalOpen, setModalOpen] = useState(false);
  const [editingItem, setEditingItem] = useState<any | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);
  const [form, setForm] = useState<Record<string, any>>({});

  const filtered = items.filter((item) => {
    if (!search) return true;
    const searchStr = searchFields.length > 0
      ? searchFields.map((f) => item[f] || "").join(" ").toLowerCase()
      : Object.values(item).join(" ").toLowerCase();
    return searchStr.includes(search.toLowerCase());
  });

  const openCreate = () => {
    const initial: Record<string, any> = {};
    fields.forEach((f) => {
      initial[f.name] = f.type === "number" ? 0 : "";
    });
    setForm(initial);
    setEditingItem(null);
    setModalOpen(true);
  };

  const openEdit = (item: any) => {
    const initial: Record<string, any> = {};
    fields.forEach((f) => {
      initial[f.name] = item[f.name] ?? "";
    });
    setForm(initial);
    setEditingItem(item);
    setModalOpen(true);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (editingItem) {
      setItems(items.map((i) => (i.id === editingItem.id ? { ...i, ...form } : i)));
      toast("success", "تم التحديث بنجاح");
    } else {
      setItems([...items, { id: Date.now().toString(), ...form }]);
      toast("success", "تمت الإضافة بنجاح");
    }
    setModalOpen(false);
  };

  const handleDelete = () => {
    if (deleteId) {
      setItems(items.filter((i) => i.id !== deleteId));
      toast("success", "تم الحذف بنجاح");
      setDeleteId(null);
    }
  };

  const toggleActive = (id: string) => {
    setItems(items.map((i) => (i.id === id ? { ...i, active: !i.active } : i)));
    toast("info", "تم تحديث الحالة");
  };

  return (
    <div>
      <PageHeader
        title={title}
        subtitle={subtitle.replace("{count}", String(items.length))}
        icon={icon}
        action={
          <button
            onClick={openCreate}
            className="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2"
          >
            <Plus size={18} />
            <span>إضافة جديد</span>
          </button>
        }
      />

      <div className="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
        <div className="flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
          <Search size={16} className="text-gray-400" />
          <input
            type="text"
            placeholder="بحث..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            className="bg-transparent outline-none flex-1 text-sm"
          />
        </div>
      </div>

      {/* Table */}
      <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-gray-50 border-b border-gray-100">
              <tr>
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">#</th>
                {fields.slice(0, 4).map((f) => (
                  <th key={f.name} className="text-right px-6 py-4 text-xs font-bold text-gray-500">{f.label}</th>
                ))}
                {canToggle && <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">الحالة</th>}
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              {filtered.map((item, index) => (
                <tr key={item.id} className="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                  <td className="px-6 py-4 text-sm text-gray-500">{index + 1}</td>
                  {fields.slice(0, 4).map((f) => (
                    <td key={f.name} className="px-6 py-4 text-sm text-gray-700 max-w-xs">
                      <div className="truncate">{String(item[f.name] || "")}</div>
                    </td>
                  ))}
                  {canToggle && (
                    <td className="px-6 py-4">
                      <button onClick={() => toggleActive(item.id)}>
                        {item.active !== false ? (
                          <ToggleRight size={24} className="text-green-500" />
                        ) : (
                          <ToggleLeft size={24} />
                        )}
                      </button>
                    </td>
                  )}
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-2">
                      <button onClick={() => openEdit(item)} className="w-8 h-8 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center hover:bg-blue-100">
                        <Edit size={14} />
                      </button>
                      <button onClick={() => setDeleteId(item.id)} className="w-8 h-8 bg-red-50 text-red-500 rounded-lg flex items-center justify-center hover:bg-red-100">
                        <Trash2 size={14} />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>

        {filtered.length === 0 && (
          <div className="py-16 text-center">
            <p className="text-gray-500">لا توجد عناصر</p>
          </div>
        )}
      </div>

      <Modal isOpen={modalOpen} onClose={() => setModalOpen(false)} title={editingItem ? "تعديل" : "إضافة جديد"} size="md">
        <form onSubmit={handleSubmit} className="space-y-4">
          {fields.map((field) => (
            <div key={field.name}>
              <label className="block text-sm font-bold text-gray-700 mb-2">{field.label}</label>
              {field.type === "textarea" ? (
                <textarea
                  value={form[field.name] || ""}
                  onChange={(e) => setForm({ ...form, [field.name]: e.target.value })}
                  required
                  rows={3}
                  placeholder={field.placeholder}
                  className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 resize-none"
                />
              ) : field.type === "select" ? (
                <select
                  value={form[field.name] || ""}
                  onChange={(e) => setForm({ ...form, [field.name]: e.target.value })}
                  required
                  className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
                >
                  <option value="">اختر...</option>
                  {field.options?.map((opt) => (
                    <option key={opt} value={opt}>{opt}</option>
                  ))}
                </select>
              ) : (
                <input
                  type={field.type || "text"}
                  value={form[field.name] || ""}
                  onChange={(e) => setForm({ ...form, [field.name]: field.type === "number" ? parseFloat(e.target.value) || 0 : e.target.value })}
                  required
                  placeholder={field.placeholder}
                  className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
                />
              )}
            </div>
          ))}

          <div className="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="button" onClick={() => setModalOpen(false)} className="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
            <button type="submit" className="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg">
              {editingItem ? "حفظ التعديلات" : "إضافة"}
            </button>
          </div>
        </form>
      </Modal>

      <ConfirmDialog
        isOpen={!!deleteId}
        onClose={() => setDeleteId(null)}
        onConfirm={handleDelete}
        title="تأكيد الحذف"
        message="هل أنت متأكد من حذف هذا العنصر؟ لا يمكن التراجع عن هذا الإجراء."
        confirmText="نعم، احذف"
      />
    </div>
  );
}
