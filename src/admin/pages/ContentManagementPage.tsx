import { useState } from "react";
import { FileText, Save, RotateCcw, Edit, Check, X } from "lucide-react";
import PageHeader from "../components/PageHeader";
import { useToast } from "../components/Toast";

interface ContentItem {
  id: string;
  screen: string;
  field: string;
  label: string;
  value: string;
  type: "text" | "textarea";
}

const defaultContent: ContentItem[] = [
  // Hero Section
  { id: "hero-title1", screen: "Hero", field: "title1", label: "العنوان الرئيسي", value: "صحتك أولاً", type: "text" },
  { id: "hero-title2", screen: "Hero", field: "title2", label: "العنوان الفرعي", value: "رعاية طبية متميزة", type: "text" },
  { id: "hero-desc", screen: "Hero", field: "description", label: "الوصف", value: "نقدم لكم أرقى خدمات الرعاية الصحية بأحدث التقنيات العالمية وفريق طبي متميز", type: "textarea" },
  
  // About Section
  { id: "about-title", screen: "About", field: "title", label: "العنوان", value: "نبذة عن المستشفى", type: "text" },
  { id: "about-desc", screen: "About", field: "description", label: "الوصف", value: "مستشفى الشفاء الدولي هو صرح طبي متكامل يقدم خدمات الرعاية الصحية وفق أعلى المعايير", type: "textarea" },
  
  // Services Section
  { id: "services-title", screen: "Services", field: "title", label: "العنوان", value: "خدماتنا", type: "text" },
  { id: "services-desc", screen: "Services", field: "description", label: "الوصف", value: "نقدم مجموعة شاملة من الخدمات الطبية", type: "textarea" },
];

export default function ContentManagementPage() {
  const { toast } = useToast();
  const [content, setContent] = useState<ContentItem[]>(() => {
    const saved = localStorage.getItem("siteContent");
    if (saved) return JSON.parse(saved);
    return defaultContent;
  });
  const [editingId, setEditingId] = useState<string | null>(null);
  const [editValue, setEditValue] = useState("");

  const screens = Array.from(new Set(content.map(c => c.screen)));

  const handleSave = () => {
    localStorage.setItem("siteContent", JSON.stringify(content));
    toast("success", "تم حفظ المحتوى بنجاح");
  };

  const handleReset = () => {
    if (confirm("هل أنت متأكد من إعادة تعيين المحتوى؟")) {
      setContent(defaultContent);
      localStorage.removeItem("siteContent");
      toast("success", "تم إعادة تعيين المحتوى");
    }
  };

  const handleStartEdit = (id: string, currentValue: string) => {
    setEditingId(id);
    setEditValue(currentValue);
  };

  const handleSaveEdit = (id: string) => {
    if (editValue.trim()) {
      setContent(content.map(c => c.id === id ? { ...c, value: editValue.trim() } : c));
      toast("success", "تم تحديث المحتوى");
    }
    setEditingId(null);
    setEditValue("");
  };

  const handleCancelEdit = () => {
    setEditingId(null);
    setEditValue("");
  };

  return (
    <div>
      <PageHeader
        title="إدارة المحتوى"
        subtitle={`${content.length} عنصر محتوى`}
        icon={<FileText size={26} />}
        action={
          <div className="flex items-center gap-2">
            <button
              onClick={handleReset}
              className="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all flex items-center gap-2"
            >
              <RotateCcw size={16} />
              <span>إعادة تعيين</span>
            </button>
            <button
              onClick={handleSave}
              className="px-4 py-2.5 bg-green-600 text-white rounded-xl text-sm font-bold hover:bg-green-700 transition-all flex items-center gap-2"
            >
              <Save size={16} />
              <span>حفظ</span>
            </button>
          </div>
        }
      />

      {/* Info Box */}
      <div className="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 flex items-start gap-3">
        <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
          <FileText size={20} className="text-blue-600" />
        </div>
        <div>
          <p className="font-bold text-blue-700 mb-1">كيفية إدارة المحتوى</p>
          <ul className="text-sm text-blue-600 space-y-1">
            <li>• اضغط على زر <Edit className="inline w-4 h-4" /> لتعديل المحتوى</li>
            <li>• اكتب النص الجديد واضغط <Check className="inline w-4 h-4" /> للحفظ</li>
            <li>• اضغط <X className="inline w-4 h-4" /> للإلغاء</li>
            <li>• لا تنسَ الضغط على "حفظ" لحفظ جميع التغييرات</li>
          </ul>
        </div>
      </div>

      {/* Content by Screen */}
      <div className="space-y-6">
        {screens.map((screen) => (
          <div key={screen} className="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div className="bg-gray-50 px-6 py-4 border-b border-gray-200">
              <h3 className="font-bold text-gray-800">{screen}</h3>
            </div>
            <div className="p-6 space-y-4">
              {content
                .filter(c => c.screen === screen)
                .map((item) => (
                  <div key={item.id} className="border border-gray-100 rounded-lg p-4">
                    <div className="flex items-start justify-between mb-3">
                      <div className="flex-1">
                        <label className="block text-sm font-bold text-gray-700 mb-2">
                          {item.label}
                        </label>
                        {editingId === item.id ? (
                          <div className="space-y-2">
                            {item.type === "textarea" ? (
                              <textarea
                                value={editValue}
                                onChange={(e) => setEditValue(e.target.value)}
                                rows={4}
                                className="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-primary-500 resize-none"
                                autoFocus
                              />
                            ) : (
                              <input
                                type="text"
                                value={editValue}
                                onChange={(e) => setEditValue(e.target.value)}
                                className="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-primary-500"
                                autoFocus
                              />
                            )}
                            <div className="flex items-center gap-2">
                              <button
                                onClick={() => handleSaveEdit(item.id)}
                                className="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-bold hover:bg-green-700 transition-all flex items-center gap-2"
                              >
                                <Check size={14} />
                                <span>حفظ</span>
                              </button>
                              <button
                                onClick={handleCancelEdit}
                                className="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-200 transition-all flex items-center gap-2"
                              >
                                <X size={14} />
                                <span>إلغاء</span>
                              </button>
                            </div>
                          </div>
                        ) : (
                          <div className="flex items-start gap-3">
                            <p className="flex-1 text-gray-600 text-sm">{item.value}</p>
                            <button
                              onClick={() => handleStartEdit(item.id, item.value)}
                              className="w-9 h-9 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-all shrink-0"
                              title="تعديل"
                            >
                              <Edit size={16} />
                            </button>
                          </div>
                        )}
                      </div>
                    </div>
                  </div>
                ))}
            </div>
          </div>
        ))}
      </div>

      {content.length === 0 && (
        <div className="bg-white rounded-2xl p-16 border border-gray-100 text-center">
          <FileText size={48} className="text-gray-300 mx-auto mb-4" />
          <p className="text-gray-500">لا يوجد محتوى</p>
        </div>
      )}
    </div>
  );
}
