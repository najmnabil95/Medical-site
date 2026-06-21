import { useState, useRef } from "react";
import { DollarSign, Plus, Edit, Trash2, ToggleLeft, ToggleRight, Filter, Upload, Download, FileSpreadsheet } from "lucide-react";
import * as XLSX from "xlsx";
import { useData, PriceItem } from "../../context/DataContext";
import PageHeader from "../components/PageHeader";
import Modal from "../components/Modal";
import ConfirmDialog from "../components/ConfirmDialog";
import { useToast } from "../components/Toast";

const CATEGORIES = [
  { id: "استشارة", name: "استشارة", icon: "💬", color: "from-blue-500 to-indigo-600" },
  { id: "تحليل", name: "تحليل", icon: "🧪", color: "from-emerald-500 to-teal-600" },
  { id: "أشعة", name: "أشعة", icon: "📷", color: "from-purple-500 to-violet-600" },
  { id: "جراحة", name: "جراحة", icon: "⚕️", color: "from-red-500 to-rose-600" },
  { id: "أسنان", name: "أسنان", icon: "🦷", color: "from-cyan-500 to-sky-600" },
  { id: "أخرى", name: "أخرى", icon: "📋", color: "from-amber-500 to-orange-600" },
];

export default function PricesPage() {
  const { prices, setPrices } = useData();
  const { toast } = useToast();
  const [search, setSearch] = useState("");
  const [categoryFilter, setCategoryFilter] = useState<string>("all");
  const [modalOpen, setModalOpen] = useState(false);
  const [editingItem, setEditingItem] = useState<PriceItem | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);
  const [importModalOpen, setImportModalOpen] = useState(false);
  const fileInputRef = useRef<HTMLInputElement>(null);

  const [form, setForm] = useState({
    service: "",
    category: "",
    price: 0,
    priceTo: 0,
    currency: "ر.س",
    duration: "",
    description: "",
    active: true,
  });

  const filtered = prices.filter((p) => {
    const matchesSearch = p.service.toLowerCase().includes(search.toLowerCase());
    const matchesCategory = categoryFilter === "all" || p.category === categoryFilter;
    return matchesSearch && matchesCategory;
  });

  const stats = {
    total: prices.length,
    active: prices.filter(p => p.active).length,
    totalValue: prices.reduce((sum, p) => sum + p.price, 0),
  };

  const openCreate = () => {
    setForm({
      service: "",
      category: "",
      price: 0,
      priceTo: 0,
      currency: "ر.س",
      duration: "",
      description: "",
      active: true,
    });
    setEditingItem(null);
    setModalOpen(true);
  };

  const openEdit = (price: PriceItem) => {
    setForm({
      service: price.service,
      category: price.category,
      price: price.price,
      priceTo: price.priceTo || 0,
      currency: price.currency,
      duration: price.duration || "",
      description: price.description || "",
      active: price.active,
    });
    setEditingItem(price);
    setModalOpen(true);
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (editingItem) {
      setPrices(prices.map((p) => p.id === editingItem.id ? { ...p, ...form } : p));
      toast("success", "تم تحديث الخدمة بنجاح");
    } else {
      setPrices([...prices, {
        id: Date.now().toString(),
        ...form,
      }]);
      toast("success", "تم إضافة الخدمة بنجاح");
    }
    setModalOpen(false);
  };

  const handleDelete = () => {
    if (deleteId) {
      setPrices(prices.filter((p) => p.id !== deleteId));
      toast("success", "تم حذف الخدمة بنجاح");
      setDeleteId(null);
    }
  };

  const toggleActive = (id: string) => {
    setPrices(prices.map((p) => p.id === id ? { ...p, active: !p.active } : p));
    toast("info", "تم تحديث حالة الخدمة");
  };

  const getCategoryInfo = (categoryId: string) => {
    return CATEGORIES.find(c => c.id === categoryId) || { name: categoryId, icon: "📋", color: "from-gray-500 to-gray-600" };
  };

  // استيراد من Excel
  const handleImportExcel = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = (event) => {
      try {
        const data = new Uint8Array(event.target?.result as ArrayBuffer);
        const workbook = XLSX.read(data, { type: "array" });
        const sheetName = workbook.SheetNames[0];
        const worksheet = workbook.Sheets[sheetName];
        const jsonData = XLSX.utils.sheet_to_json(worksheet);

        const importedPrices: PriceItem[] = jsonData.map((row: any, index: number) => ({
          id: `imported-${Date.now()}-${index}`,
          service: row["اسم الخدمة"] || row["service"] || "",
          category: row["التصنيف"] || row["category"] || "أخرى",
          price: parseFloat(row["السعر"] || row["price"] || "0"),
          priceTo: parseFloat(row["السعر إلى"] || row["priceTo"] || "0") || undefined,
          currency: row["العملة"] || row["currency"] || "ر.س",
          duration: row["المدة"] || row["duration"] || "",
          description: row["الوصف"] || row["description"] || "",
          active: true,
        })).filter(p => p.service); // فلترة الصفوف الفارغة

        if (importedPrices.length === 0) {
          toast("error", "لم يتم العثور على بيانات صالحة في الملف");
          return;
        }

        setPrices([...prices, ...importedPrices]);
        toast("success", `تم استيراد ${importedPrices.length} خدمة بنجاح`);
        setImportModalOpen(false);
      } catch (error) {
        toast("error", "حدث خطأ أثناء قراءة الملف");
        console.error(error);
      }
    };
    reader.readAsArrayBuffer(file);
  };

  // تصدير إلى Excel
  const handleExportExcel = () => {
    console.log("📊 بدء تصدير الأسعار الحالية...");
    
    try {
      const exportData = prices.map(p => ({
        "اسم الخدمة": p.service,
        "التصنيف": p.category,
        "السعر": p.price,
        "السعر إلى": p.priceTo || "",
        "العملة": p.currency,
        "المدة": p.duration || "",
        "الوصف": p.description || "",
        "الحالة": p.active ? "نشط" : "غير نشط",
      }));

      console.log(`✅ تم تجهيز ${exportData.length} خدمة للتصدير`);

      const worksheet = XLSX.utils.json_to_sheet(exportData);
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, "الأسعار");
      
      // تعيين عرض الأعمدة
      worksheet['!cols'] = [
        { wch: 30 }, // اسم الخدمة
        { wch: 15 }, // التصنيف
        { wch: 10 }, // السعر
        { wch: 10 }, // السعر إلى
        { wch: 8 },  // العملة
        { wch: 15 }, // المدة
        { wch: 40 }, // الوصف
        { wch: 10 }, // الحالة
      ];

      console.log("✅ تم إنشاء ورقة العمل");

      const fileName = `أسعار_المستشفى_${new Date().toISOString().split('T')[0]}.xlsx`;
      
      // تنزيل الملف مباشرة إلى جهاز المستخدم
      XLSX.writeFile(workbook, fileName);
      
      console.log(`✅ تم تنزيل الملف: ${fileName}`);
      toast("success", `✅ تم تصدير ${exportData.length} خدمة إلى جهازك!`);
    } catch (error) {
      console.error("❌ خطأ في التصدير:", error);
      toast("error", "حدث خطأ أثناء تصدير الأسعار");
    }
  };

  // تنزيل نموذج Excel فارغ
  const handleDownloadTemplate = () => {
    console.log("📥 بدء تنزيل الملف الفارغ...");
    
    try {
      // ملف فارغ مع العناوين فقط
      const emptyTemplate = [
        {
          "اسم الخدمة": "",
          "التصنيف": "",
          "السعر": "",
          "السعر إلى": "",
          "العملة": "ر.س",
          "المدة": "",
          "الوصف": "",
        },
      ];

      console.log("✅ تم إنشاء البيانات");

      const worksheet = XLSX.utils.json_to_sheet(emptyTemplate);
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, "الأسعار");
      
      worksheet['!cols'] = [
        { wch: 30 },
        { wch: 15 },
        { wch: 10 },
        { wch: 10 },
        { wch: 8 },
        { wch: 15 },
        { wch: 40 },
      ];

      console.log("✅ تم إنشاء ورقة العمل");

      // تنزيل الملف مباشرة إلى جهاز المستخدم
      XLSX.writeFile(workbook, "قالب_الأسعار_فارغ.xlsx");
      
      console.log("✅ تم تنزيل الملف بنجاح!");
      toast("success", "✅ تم تنزيل الملف الفارغ إلى جهازك! ابحث عنه في مجلد التنزيلات");
    } catch (error) {
      console.error("❌ خطأ في تنزيل الملف:", error);
      toast("error", "حدث خطأ أثناء تنزيل الملف");
    }
  };

  // تنزيل نموذج مع أمثلة
  const handleDownloadTemplateWithExamples = () => {
    console.log("📥 بدء تنزيل الملف مع الأمثلة...");
    
    try {
      const template = [
        {
          "اسم الخدمة": "استشارة عامة",
          "التصنيف": "استشارة",
          "السعر": 100,
          "السعر إلى": 200,
          "العملة": "ر.س",
          "المدة": "30 دقيقة",
          "الوصف": "استشارة طبية عامة مع طبيب",
        },
        {
          "اسم الخدمة": "فحص دم شامل",
          "التصنيف": "تحليل",
          "السعر": 150,
          "السعر إلى": "",
          "العملة": "ر.س",
          "المدة": "",
          "الوصف": "فحص دم شامل مع جميع التحاليل",
        },
        {
          "اسم الخدمة": "أشعة مقطعية",
          "التصنيف": "أشعة",
          "السعر": 800,
          "السعر إلى": "",
          "العملة": "ر.س",
          "المدة": "20 دقيقة",
          "الوصف": "أشعة مقطعية CT Scan",
        },
        {
          "اسم الخدمة": "رنين مغناطيسي",
          "التصنيف": "أشعة",
          "السعر": 1500,
          "السعر إلى": 2000,
          "العملة": "ر.س",
          "المدة": "45 دقيقة",
          "الوصف": "رنين مغناطيسي MRI",
        },
        {
          "اسم الخدمة": "تنظيف أسنان",
          "التصنيف": "أسنان",
          "السعر": 200,
          "السعر إلى": "",
          "العملة": "ر.س",
          "المدة": "45 دقيقة",
          "الوصف": "تنظيف وتلميع الأسنان",
        },
      ];

      console.log("✅ تم إنشاء البيانات مع 5 أمثلة");

      const worksheet = XLSX.utils.json_to_sheet(template);
      const workbook = XLSX.utils.book_new();
      XLSX.utils.book_append_sheet(workbook, worksheet, "نموذج");
      
      worksheet['!cols'] = [
        { wch: 30 },
        { wch: 15 },
        { wch: 10 },
        { wch: 10 },
        { wch: 8 },
        { wch: 15 },
        { wch: 40 },
      ];

      console.log("✅ تم إنشاء ورقة العمل");

      // تنزيل الملف مباشرة إلى جهاز المستخدم
      XLSX.writeFile(workbook, "نموذج_استيراد_الأسعار_مع_أمثلة.xlsx");
      
      console.log("✅ تم تنزيل الملف بنجاح!");
      toast("success", "✅ تم تنزيل الملف مع الأمثلة إلى جهازك! ابحث عنه في مجلد التنزيلات");
    } catch (error) {
      console.error("❌ خطأ في تنزيل الملف:", error);
      toast("error", "حدث خطأ أثناء تنزيل الملف");
    }
  };

  return (
    <div>
      <PageHeader
        title="إدارة الأسعار والتكلفة"
        subtitle={`${stats.active} خدمة نشطة من أصل ${stats.total}`}
        icon={<DollarSign size={26} />}
        action={
          <div className="flex items-center gap-2">
            <button
              onClick={handleDownloadTemplate}
              className="bg-gray-100 text-gray-700 px-4 py-2.5 rounded-xl font-bold text-sm hover:bg-gray-200 transition-all flex items-center gap-2"
              title="تنزيل ملف فارغ للتعبئة"
            >
              <Download size={18} />
              <span className="hidden md:inline">فارغ</span>
            </button>
            <button
              onClick={handleDownloadTemplateWithExamples}
              className="bg-purple-100 text-purple-700 px-4 py-2.5 rounded-xl font-bold text-sm hover:bg-purple-200 transition-all flex items-center gap-2"
              title="تنزيل نموذج مع أمثلة"
            >
              <Download size={18} />
              <span className="hidden md:inline">أمثلة</span>
            </button>
            <button
              onClick={handleExportExcel}
              className="bg-emerald-100 text-emerald-700 px-4 py-2.5 rounded-xl font-bold text-sm hover:bg-emerald-200 transition-all flex items-center gap-2"
              title="تصدير الأسعار الحالية"
            >
              <FileSpreadsheet size={18} />
              <span className="hidden md:inline">تصدير</span>
            </button>
            <button
              onClick={() => setImportModalOpen(true)}
              className="bg-blue-100 text-blue-700 px-4 py-2.5 rounded-xl font-bold text-sm hover:bg-blue-200 transition-all flex items-center gap-2"
              title="استيراد من Excel"
            >
              <Upload size={18} />
              <span className="hidden md:inline">استيراد</span>
            </button>
            <button
              onClick={openCreate}
              className="bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5 flex items-center gap-2"
            >
              <Plus size={18} />
              <span>إضافة</span>
            </button>
          </div>
        }
      />

      {/* Modal استيراد Excel */}
      <Modal isOpen={importModalOpen} onClose={() => setImportModalOpen(false)} title="استيراد الأسعار من Excel" size="md">
        <div className="space-y-5">
          <div className="bg-blue-50 border border-blue-200 rounded-xl p-4">
            <h4 className="font-bold text-blue-800 mb-2 flex items-center gap-2">
              <FileSpreadsheet size={20} />
              <span>تعليمات الاستيراد</span>
            </h4>
            <ul className="text-sm text-blue-700 space-y-1">
              <li>• قم بتنزيل النموذج أولاً باستخدام زر "نموذج"</li>
              <li>• املأ البيانات في النموذج</li>
              <li>• التصنيفات المتاحة: استشارة، تحليل، أشعة، جراحة، أسنان، أخرى</li>
              <li>• السعر إلى اختياري (للنطاق السعري)</li>
              <li>• ارفع الملف هنا لاستيراد البيانات</li>
            </ul>
          </div>

          <div className="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-primary-500 transition-colors">
            <input
              ref={fileInputRef}
              type="file"
              accept=".xlsx,.xls"
              onChange={handleImportExcel}
              className="hidden"
            />
            <Upload size={48} className="text-gray-400 mx-auto mb-3" />
            <p className="text-gray-600 font-bold mb-2">اسحب الملف هنا أو اضغط للاختيار</p>
            <p className="text-sm text-gray-500 mb-4">يدعم ملفات Excel (.xlsx, .xls)</p>
            <button
              onClick={() => fileInputRef.current?.click()}
              className="bg-primary-500 text-white px-6 py-2.5 rounded-xl font-bold text-sm hover:bg-primary-600 transition-all"
            >
              اختر ملف Excel
            </button>
          </div>

          <div className="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <button
              onClick={() => setImportModalOpen(false)}
              className="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl"
            >
              إلغاء
            </button>
          </div>
        </div>
      </Modal>

      {/* Stats */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div className="bg-white rounded-2xl p-5 border border-gray-100">
          <div className="flex items-center gap-3 mb-3">
            <div className="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center text-white">
              <DollarSign size={22} />
            </div>
            <div>
              <p className="text-xs text-gray-500">إجمالي الخدمات</p>
              <p className="text-2xl font-black text-gray-800">{stats.total}</p>
            </div>
          </div>
        </div>
        <div className="bg-white rounded-2xl p-5 border border-gray-100">
          <div className="flex items-center gap-3 mb-3">
            <div className="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white">
              ✓
            </div>
            <div>
              <p className="text-xs text-gray-500">الخدمات النشطة</p>
              <p className="text-2xl font-black text-gray-800">{stats.active}</p>
            </div>
          </div>
        </div>
        <div className="bg-white rounded-2xl p-5 border border-gray-100">
          <div className="flex items-center gap-3 mb-3">
            <div className="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center text-white">
              💰
            </div>
            <div>
              <p className="text-xs text-gray-500">إجمالي القيمة</p>
              <p className="text-2xl font-black text-gray-800">{stats.totalValue.toLocaleString()} <span className="text-sm text-gray-500">ر.س</span></p>
            </div>
          </div>
        </div>
      </div>

      {/* Filters */}
      <div className="bg-white rounded-2xl p-4 mb-6 border border-gray-100">
        <div className="flex flex-col md:flex-row gap-3">
          <div className="flex-1 flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
            <span className="text-gray-400">🔍</span>
            <input
              type="text"
              placeholder="بحث في الخدمات..."
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              className="bg-transparent outline-none flex-1 text-sm"
            />
          </div>
          <div className="flex items-center gap-2 bg-gray-50 rounded-xl p-1 border border-gray-100 overflow-x-auto">
            <Filter size={16} className="text-gray-400 mr-2 shrink-0" />
            <button
              onClick={() => setCategoryFilter("all")}
              className={`px-3 py-1.5 text-xs font-bold rounded-lg transition-all whitespace-nowrap ${
                categoryFilter === "all" ? "bg-primary-500 text-white" : "text-gray-600 hover:bg-gray-200"
              }`}
            >
              الكل
            </button>
            {CATEGORIES.map((cat) => (
              <button
                key={cat.id}
                onClick={() => setCategoryFilter(cat.id)}
                className={`px-3 py-1.5 text-xs font-bold rounded-lg transition-all whitespace-nowrap ${
                  categoryFilter === cat.id ? "bg-primary-500 text-white" : "text-gray-600 hover:bg-gray-200"
                }`}
              >
                {cat.icon} {cat.name}
              </button>
            ))}
          </div>
        </div>
      </div>

      {/* Prices List */}
      <div className="space-y-3">
        {filtered.map((price) => {
          const catInfo = getCategoryInfo(price.category);
          return (
            <div
              key={price.id}
              className={`bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-lg transition-all ${
                !price.active ? "opacity-60" : ""
              }`}
            >
              <div className="flex items-start justify-between mb-3">
                <div className="flex items-start gap-3 flex-1">
                  <div className={`w-14 h-14 bg-gradient-to-br ${catInfo.color} rounded-xl flex items-center justify-center text-2xl shrink-0`}>
                    {catInfo.icon}
                  </div>
                  <div className="flex-1">
                    <div className="flex items-center gap-2 mb-1">
                      <h3 className="font-bold text-gray-800 text-lg">{price.service}</h3>
                      <span className={`px-2 py-0.5 bg-gradient-to-l ${catInfo.color} text-white text-xs font-bold rounded-full`}>
                        {catInfo.name}
                      </span>
                    </div>
                    {price.description && (
                      <p className="text-sm text-gray-500 mb-2">{price.description}</p>
                    )}
                    <div className="flex items-center gap-4 text-sm text-gray-600">
                      {price.duration && (
                        <span>⏱️ {price.duration}</span>
                      )}
                    </div>
                  </div>
                </div>
                <div className="text-left shrink-0">
                  {price.priceTo && price.priceTo > price.price ? (
                    <>
                      <p className="text-2xl font-black text-primary-600">
                        {price.price.toLocaleString()} - {price.priceTo.toLocaleString()}
                      </p>
                      <p className="text-xs text-gray-500">{price.currency}</p>
                    </>
                  ) : (
                    <>
                      <p className="text-3xl font-black text-primary-600">{price.price.toLocaleString()}</p>
                      <p className="text-xs text-gray-500">{price.currency}</p>
                    </>
                  )}
                </div>
                <button onClick={() => toggleActive(price.id)} className="shrink-0 mr-3">
                  {price.active ? (
                    <ToggleRight size={24} className="text-green-500" />
                  ) : (
                    <ToggleLeft size={24} className="text-gray-400" />
                  )}
                </button>
              </div>
              <div className="flex items-center gap-2 pt-3 border-t border-gray-100">
                <button
                  onClick={() => openEdit(price)}
                  className="flex-1 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-bold hover:bg-blue-100 transition-colors flex items-center justify-center gap-1"
                >
                  <Edit size={14} />
                  تعديل
                </button>
                <button
                  onClick={() => setDeleteId(price.id)}
                  className="flex-1 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-100 transition-colors flex items-center justify-center gap-1"
                >
                  <Trash2 size={14} />
                  حذف
                </button>
              </div>
            </div>
          );
        })}
      </div>

      {filtered.length === 0 && (
        <div className="bg-white rounded-2xl p-16 border border-gray-100 text-center">
          <DollarSign size={48} className="text-gray-300 mx-auto mb-4" />
          <p className="text-gray-500">لا توجد خدمات</p>
        </div>
      )}

      {/* Form Modal */}
      <Modal isOpen={modalOpen} onClose={() => setModalOpen(false)} title={editingItem ? "تعديل الخدمة" : "إضافة خدمة جديدة"} size="md">
        <form onSubmit={handleSubmit} className="space-y-5">
          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">اسم الخدمة <span className="text-red-500">*</span></label>
            <input
              type="text"
              value={form.service}
              onChange={(e) => setForm({ ...form, service: e.target.value })}
              required
              className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
              placeholder="مثال: استشارة عامة"
            />
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">التصنيف <span className="text-red-500">*</span></label>
            <select
              value={form.category}
              onChange={(e) => setForm({ ...form, category: e.target.value })}
              required
              className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 appearance-none"
            >
              <option value="">اختر التصنيف</option>
              {CATEGORIES.map((cat) => (
                <option key={cat.id} value={cat.id}>{cat.icon} {cat.name}</option>
              ))}
            </select>
          </div>

          <div className="grid grid-cols-3 gap-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                السعر من <span className="text-red-500">*</span>
              </label>
              <input
                type="number"
                min="0"
                value={form.price}
                onChange={(e) => setForm({ ...form, price: parseFloat(e.target.value) || 0 })}
                required
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
              />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                السعر إلى
                <span className="text-gray-400 font-normal block text-xs">(اختياري للنطاق)</span>
              </label>
              <input
                type="number"
                min="0"
                value={form.priceTo || 0}
                onChange={(e) => setForm({ ...form, priceTo: parseFloat(e.target.value) || 0 })}
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
              />
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">العملة</label>
              <select
                value={form.currency}
                onChange={(e) => setForm({ ...form, currency: e.target.value })}
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 appearance-none"
              >
                <option value="ر.س">ريال سعودي (ر.س)</option>
                <option value="$">دولار ($)</option>
                <option value="€">يورو (€)</option>
              </select>
            </div>
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">المدة (اختياري)</label>
            <input
              type="text"
              value={form.duration}
              onChange={(e) => setForm({ ...form, duration: e.target.value })}
              className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
              placeholder="مثال: 30 دقيقة"
            />
          </div>

          <div>
            <label className="block text-sm font-bold text-gray-700 mb-2">الوصف (اختياري)</label>
            <textarea
              value={form.description}
              onChange={(e) => setForm({ ...form, description: e.target.value })}
              rows={3}
              className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 resize-none"
              placeholder="وصف مختصر للخدمة..."
            />
          </div>

          <div className="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
            <button type="button" onClick={() => setModalOpen(false)} className="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
            <button type="submit" className="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg">{editingItem ? "حفظ التعديلات" : "إضافة الخدمة"}</button>
          </div>
        </form>
      </Modal>

      <ConfirmDialog
        isOpen={!!deleteId}
        onClose={() => setDeleteId(null)}
        onConfirm={handleDelete}
        title="حذف الخدمة"
        message="هل أنت متأكد من حذف هذه الخدمة؟"
        confirmText="نعم، احذف"
      />
    </div>
  );
}
