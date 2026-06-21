import { useState } from "react";
import { Building2, Plus, Search, Edit, Trash2, ToggleLeft, ToggleRight, Filter } from "lucide-react";
import { useData, Department } from "../../context/DataContext";
import PageHeader from "../components/PageHeader";
import Modal from "../components/Modal";
import ConfirmDialog from "../components/ConfirmDialog";
import { useToast } from "../components/Toast";

const ICONS = ["Heart", "Brain", "Bone", "Baby", "Eye", "Stethoscope", "Syringe", "Activity", "Pill", "Microscope", "Ear", "Smile"];

export default function DepartmentsPage() {
  const { departments, setDepartments } = useData();
  const { toast } = useToast();
  const [search, setSearch] = useState("");
  const [filterActive, setFilterActive] = useState<"all" | "active" | "inactive">("all");
  const [modalOpen, setModalOpen] = useState(false);
  const [editingItem, setEditingItem] = useState<Department | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);

  // Form state
  const [form, setForm] = useState({ name: "", desc: "", icon: "Heart", color: "from-red-500 to-rose-600" });

  const filtered = departments.filter((d) => {
    const matchesSearch = d.name.includes(search) || d.desc.includes(search);
    const matchesFilter = filterActive === "all" || (filterActive === "active" ? d.active : !d.active);
    return matchesSearch && matchesFilter;
  });

  const openCreate = () => {
    setForm({ name: "", desc: "", icon: "Heart", color: "from-red-500 to-rose-600" });
    setEditingItem(null);
    setModalOpen(true);
  };

  const openEdit = (dept: Department) => {
    setForm({ name: dept.name, desc: dept.desc, icon: dept.icon, color: dept.color });
    setEditingItem(dept);
    setModalOpen(true);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (editingItem) {
      setDepartments(departments.map((d) => d.id === editingItem.id ? { ...d, ...form } : d));
      toast("success", "تم تحديث القسم بنجاح");
    } else {
      const newItem: Department = {
        id: Date.now().toString(),
        ...form,
        active: true,
      };
      setDepartments([...departments, newItem]);
      toast("success", "تم إضافة القسم بنجاح");
    }
    setModalOpen(false);
  };

  const handleDelete = () => {
    if (deleteId) {
      setDepartments(departments.filter((d) => d.id !== deleteId));
      toast("success", "تم حذف القسم بنجاح");
      setDeleteId(null);
    }
  };

  const toggleActive = (id: string) => {
    setDepartments(departments.map((d) => d.id === id ? { ...d, active: !d.active } : d));
    toast("info", "تم تحديث حالة القسم");
  };

  return (
    <div>
      <PageHeader
        title="الأقسام الطبية"
        subtitle={`إدارة ${departments.length} قسم طبي`}
        icon={<Building2 size={26} />}
        action={
          <button
            onClick={openCreate}
            className="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2"
          >
            <Plus size={18} />
            <span>إضافة قسم جديد</span>
          </button>
        }
      />

      {/* Filters */}
      <div className="bg-white rounded-2xl p-4 mb-6 border border-gray-100 flex flex-col sm:flex-row gap-3">
        <div className="flex-1 flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
          <Search size={16} className="text-gray-400" />
          <input
            type="text"
            placeholder="بحث في الأقسام..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            className="bg-transparent outline-none flex-1 text-sm"
          />
        </div>
        <div className="flex items-center gap-2 bg-gray-50 rounded-xl p-1 border border-gray-100">
          <Filter size={16} className="text-gray-400 mr-2" />
          {(["all", "active", "inactive"] as const).map((f) => (
            <button
              key={f}
              onClick={() => setFilterActive(f)}
              className={`px-4 py-1.5 text-sm font-bold rounded-lg transition-all ${
                filterActive === f ? "bg-primary-500 text-white shadow-md" : "text-gray-600 hover:bg-gray-200"
              }`}
            >
              {f === "all" ? "الكل" : f === "active" ? "نشط" : "معطل"}
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
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">الأيقونة</th>
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">الاسم</th>
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">الوصف</th>
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">الحالة</th>
                <th className="text-right px-6 py-4 text-xs font-bold text-gray-500">الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              {filtered.map((dept, index) => (
                <tr key={dept.id} className="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                  <td className="px-6 py-4 text-sm text-gray-500">{index + 1}</td>
                  <td className="px-6 py-4">
                    <div className={`w-10 h-10 bg-gradient-to-br ${dept.color} rounded-xl flex items-center justify-center text-white text-xs font-bold`}>
                      {dept.icon.slice(0, 2)}
                    </div>
                  </td>
                  <td className="px-6 py-4 font-bold text-gray-800">{dept.name}</td>
                  <td className="px-6 py-4 text-sm text-gray-500 max-w-md truncate">{dept.desc}</td>
                  <td className="px-6 py-4">
                    <button onClick={() => toggleActive(dept.id)} className="text-gray-400 hover:text-primary-600">
                      {dept.active ? (
                        <ToggleRight size={24} className="text-green-500" />
                      ) : (
                        <ToggleLeft size={24} />
                      )}
                    </button>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-2">
                      <button
                        onClick={() => openEdit(dept)}
                        className="w-8 h-8 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center hover:bg-blue-100 transition-colors"
                      >
                        <Edit size={14} />
                      </button>
                      <button
                        onClick={() => setDeleteId(dept.id)}
                        className="w-8 h-8 bg-red-50 text-red-500 rounded-lg flex items-center justify-center hover:bg-red-100 transition-colors"
                      >
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
            <Building2 size={48} className="text-gray-300 mx-auto mb-4" />
            <p className="text-gray-500">لا توجد أقسام</p>
          </div>
        )}
      </div>

      {/* Form Modal */}
      <Modal
        isOpen={modalOpen}
        onClose={() => setModalOpen(false)}
        title={editingItem ? "تعديل القسم" : "إضافة قسم جديد"}
        size="md"
      >
        <form onSubmit={handleSubmit} className="space-y-5">
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">اسم القسم</label>
            <input
              type="text"
              value={form.name}
              onChange={(e) => setForm({ ...form, name: e.target.value })}
              required
              className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all text-sm"
              placeholder="أمراض القلب"
            />
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">الوصف</label>
            <textarea
              value={form.desc}
              onChange={(e) => setForm({ ...form, desc: e.target.value })}
              required
              rows={3}
              className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all text-sm resize-none"
              placeholder="وصف مختصر للقسم..."
            />
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">الأيقونة</label>
            <div className="grid grid-cols-6 gap-2">
              {ICONS.map((icon) => (
                <button
                  key={icon}
                  type="button"
                  onClick={() => setForm({ ...form, icon })}
                  className={`p-3 border-2 rounded-xl text-xs font-bold transition-all ${
                    form.icon === icon ? "border-primary-500 bg-primary-50 text-primary-600" : "border-gray-200 text-gray-500 hover:border-gray-300"
                  }`}
                >
                  {icon}
                </button>
              ))}
            </div>
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">اللون</label>
            <div className="grid grid-cols-4 gap-2">
              {[
                "from-red-500 to-rose-600",
                "from-blue-500 to-indigo-600",
                "from-purple-500 to-violet-600",
                "from-emerald-500 to-teal-600",
                "from-amber-500 to-orange-600",
                "from-pink-500 to-rose-600",
                "from-cyan-500 to-sky-600",
                "from-lime-500 to-green-600",
              ].map((color) => (
                <button
                  key={color}
                  type="button"
                  onClick={() => setForm({ ...form, color })}
                  className={`h-12 bg-gradient-to-br ${color} rounded-xl transition-all ${
                    form.color === color ? "ring-4 ring-offset-2 ring-primary-500" : ""
                  }`}
                />
              ))}
            </div>
          </div>

          <div className="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <button
              type="button"
              onClick={() => setModalOpen(false)}
              className="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl transition-colors"
            >
              إلغاء
            </button>
            <button
              type="submit"
              className="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg transition-all"
            >
              {editingItem ? "حفظ التعديلات" : "إضافة"}
            </button>
          </div>
        </form>
      </Modal>

      {/* Delete Confirm */}
      <ConfirmDialog
        isOpen={!!deleteId}
        onClose={() => setDeleteId(null)}
        onConfirm={handleDelete}
        title="حذف القسم"
        message="هل أنت متأكد من حذف هذا القسم؟ لا يمكن التراجع عن هذا الإجراء."
        confirmText="نعم، احذف"
        variant="danger"
      />
    </div>
  );
}
