import { useState } from "react";
import { Monitor, Eye, EyeOff, ArrowUp, ArrowDown, Save, RotateCcw, Edit, Check, X } from "lucide-react";
import { useApp } from "../../context/AppContext";
import PageHeader from "../components/PageHeader";
import { useToast } from "../components/Toast";

export default function ScreensControlPage() {
  const { screens, setScreens, toggleScreen, updateScreenOrder } = useApp();
  const { toast } = useToast();
  const [filter, setFilter] = useState<"all" | "enabled" | "disabled">("all");

  const sortedScreens = [...screens].sort((a, b) => a.order - b.order);
  const filteredScreens = sortedScreens.filter(s => {
    if (filter === "all") return true;
    if (filter === "enabled") return s.enabled;
    if (filter === "disabled") return !s.enabled;
    return true;
  });

  const stats = {
    total: screens.length,
    enabled: screens.filter(s => s.enabled).length,
    disabled: screens.filter(s => !s.enabled).length,
  };

  const handleMoveUp = (id: string) => {
    const screen = screens.find(s => s.id === id);
    if (!screen || screen.order <= 1) return;
    
    const newOrder = screen.order - 1;
    const screenAbove = screens.find(s => s.order === newOrder);
    
    if (screenAbove) {
      updateScreenOrder(screenAbove.id, screen.order);
    }
    updateScreenOrder(id, newOrder);
    toast("success", "تم نقل الشاشة لأعلى");
  };

  const handleMoveDown = (id: string) => {
    const screen = screens.find(s => s.id === id);
    if (!screen || screen.order >= screens.length) return;
    
    const newOrder = screen.order + 1;
    const screenBelow = screens.find(s => s.order === newOrder);
    
    if (screenBelow) {
      updateScreenOrder(screenBelow.id, screen.order);
    }
    updateScreenOrder(id, newOrder);
    toast("success", "تم نقل الشاشة لأسفل");
  };

  const handleToggle = (id: string) => {
    toggleScreen(id);
    const screen = screens.find(s => s.id === id);
    toast(
      screen?.enabled ? "info" : "success",
      `تم ${screen?.enabled ? "إخفاء" : "إظهار"} الشاشة`
    );
  };

  const handleReset = () => {
    if (confirm("هل أنت متأكد من إعادة تعيين جميع الشاشات؟")) {
      const defaultScreens = screens.map((s, i) => ({
        ...s,
        enabled: true,
        order: i + 1,
      }));
      setScreens(defaultScreens);
      toast("success", "تم إعادة تعيين جميع الشاشات");
    }
  };

  const [editingId, setEditingId] = useState<string | null>(null);
  const [editName, setEditName] = useState("");

  const handleStartEdit = (id: string, currentName: string) => {
    setEditingId(id);
    setEditName(currentName);
  };

  const handleSaveEdit = (id: string) => {
    if (editName.trim()) {
      const updatedScreens = screens.map(s => 
        s.id === id ? { ...s, name: editName.trim() } : s
      );
      setScreens(updatedScreens);
      toast("success", "تم تحديث اسم الشاشة");
    }
    setEditingId(null);
    setEditName("");
  };

  const handleCancelEdit = () => {
    setEditingId(null);
    setEditName("");
  };

  return (
    <div>
      <PageHeader
        title="التحكم في الشاشات"
        subtitle={`${stats.enabled} شاشة مفعلة من أصل ${stats.total}`}
        icon={<Monitor size={26} />}
        action={
          <button
            onClick={handleReset}
            className="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all flex items-center gap-2"
          >
            <RotateCcw size={16} />
            <span>إعادة تعيين</span>
          </button>
        }
      />

      {/* Stats */}
      <div className="grid grid-cols-3 gap-4 mb-6">
        <button
          onClick={() => setFilter("all")}
          className={`bg-white rounded-xl p-4 border transition-all ${
            filter === "all" ? "border-primary-500 shadow-lg" : "border-gray-100 hover:shadow-md"
          }`}
        >
          <div className="text-2xl font-black text-gray-800">{stats.total}</div>
          <div className="text-xs text-gray-500">جميع الشاشات</div>
        </button>
        <button
          onClick={() => setFilter("enabled")}
          className={`bg-white rounded-xl p-4 border transition-all ${
            filter === "enabled" ? "border-green-500 shadow-lg" : "border-gray-100 hover:shadow-md"
          }`}
        >
          <div className="text-2xl font-black text-green-600">{stats.enabled}</div>
          <div className="text-xs text-gray-500">مفعلة</div>
        </button>
        <button
          onClick={() => setFilter("disabled")}
          className={`bg-white rounded-xl p-4 border transition-all ${
            filter === "disabled" ? "border-red-500 shadow-lg" : "border-gray-100 hover:shadow-md"
          }`}
        >
          <div className="text-2xl font-black text-red-600">{stats.disabled}</div>
          <div className="text-xs text-gray-500">مخفية</div>
        </button>
      </div>

      {/* Info Box */}
      <div className="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 flex items-start gap-3">
        <div className="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center shrink-0">
          <Monitor size={20} className="text-blue-600" />
        </div>
        <div>
          <p className="font-bold text-blue-700 mb-1">كيفية التحكم في الشاشات</p>
          <ul className="text-sm text-blue-600 space-y-1">
            <li>• اضغط على أيقونة <EyeOff className="inline w-4 h-4" /> لإخفاء الشاشة من الموقع</li>
            <li>• اضغط على <ArrowUp className="inline w-4 h-4" /> أو <ArrowDown className="inline w-4 h-4" /> لتغيير ترتيب الشاشات</li>
            <li>• التغييرات تُطبق فوراً على الموقع الرئيسي</li>
          </ul>
        </div>
      </div>

      {/* Screens List */}
      <div className="space-y-3">
        {filteredScreens.map((screen) => (
          <div
            key={screen.id}
            className={`bg-white rounded-xl border p-4 transition-all hover:shadow-md ${
              screen.enabled ? "border-gray-100" : "border-red-200 bg-red-50/30"
            }`}
          >
            <div className="flex items-center gap-4">
              {/* Icon */}
              <div className="text-3xl">{screen.icon}</div>

              {/* Info */}
              <div className="flex-1 min-w-0">
                {editingId === screen.id ? (
                  // Edit Mode
                  <div className="flex items-center gap-2 mb-1">
                    <input
                      type="text"
                      value={editName}
                      onChange={(e) => setEditName(e.target.value)}
                      className="flex-1 px-3 py-1.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary-500"
                      autoFocus
                      onKeyDown={(e) => {
                        if (e.key === 'Enter') handleSaveEdit(screen.id);
                        if (e.key === 'Escape') handleCancelEdit();
                      }}
                    />
                    <button
                      onClick={() => handleSaveEdit(screen.id)}
                      className="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-200 transition-all"
                      title="حفظ"
                    >
                      <Check size={16} />
                    </button>
                    <button
                      onClick={handleCancelEdit}
                      className="w-8 h-8 bg-gray-100 text-gray-600 rounded-lg flex items-center justify-center hover:bg-gray-200 transition-all"
                      title="إلغاء"
                    >
                      <X size={16} />
                    </button>
                  </div>
                ) : (
                  // Display Mode
                  <>
                    <div className="flex items-center gap-2 mb-1">
                      <h3 className={`font-bold ${screen.enabled ? "text-gray-800" : "text-gray-400"}`}>
                        {screen.name}
                      </h3>
                      <span className={`px-2 py-0.5 rounded-full text-xs font-bold ${
                        screen.enabled ? "bg-green-100 text-green-700" : "bg-red-100 text-red-700"
                      }`}>
                        {screen.enabled ? "مفعلة" : "مخفية"}
                      </span>
                    </div>
                    <p className="text-xs text-gray-500">
                      الترتيب: {screen.order} | المكون: {screen.component}
                    </p>
                  </>
                )}
              </div>

              {/* Actions */}
              <div className="flex items-center gap-2">
                {/* Edit Name */}
                {editingId !== screen.id && (
                  <button
                    onClick={() => handleStartEdit(screen.id, screen.name)}
                    className="w-9 h-9 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-200 transition-all"
                    title="تعديل الاسم"
                  >
                    <Edit size={16} />
                  </button>
                )}

                {/* Move Up */}
                <button
                  onClick={() => handleMoveUp(screen.id)}
                  disabled={screen.order <= 1}
                  className="w-9 h-9 bg-gray-100 text-gray-600 rounded-lg flex items-center justify-center hover:bg-gray-200 disabled:opacity-30 disabled:cursor-not-allowed transition-all"
                  title="نقل لأعلى"
                >
                  <ArrowUp size={16} />
                </button>

                {/* Move Down */}
                <button
                  onClick={() => handleMoveDown(screen.id)}
                  disabled={screen.order >= screens.length}
                  className="w-9 h-9 bg-gray-100 text-gray-600 rounded-lg flex items-center justify-center hover:bg-gray-200 disabled:opacity-30 disabled:cursor-not-allowed transition-all"
                  title="نقل لأسفل"
                >
                  <ArrowDown size={16} />
                </button>

                {/* Toggle */}
                <button
                  onClick={() => handleToggle(screen.id)}
                  className={`w-9 h-9 rounded-lg flex items-center justify-center transition-all ${
                    screen.enabled
                      ? "bg-green-100 text-green-600 hover:bg-green-200"
                      : "bg-red-100 text-red-600 hover:bg-red-200"
                  }`}
                  title={screen.enabled ? "إخفاء الشاشة" : "إظهار الشاشة"}
                >
                  {screen.enabled ? <Eye size={16} /> : <EyeOff size={16} />}
                </button>
              </div>
            </div>
          </div>
        ))}
      </div>

      {filteredScreens.length === 0 && (
        <div className="bg-white rounded-2xl p-16 border border-gray-100 text-center">
          <Monitor size={48} className="text-gray-300 mx-auto mb-4" />
          <p className="text-gray-500">لا توجد شاشات</p>
        </div>
      )}

      {/* Save Notice */}
      <div className="fixed bottom-6 left-6 bg-white rounded-xl shadow-2xl border border-gray-200 p-4 flex items-center gap-3 z-50">
        <div className="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
          <Save size={20} className="text-green-600" />
        </div>
        <div>
          <p className="font-bold text-gray-800 text-sm">التغييرات محفوظة تلقائياً</p>
          <p className="text-xs text-gray-500">جميع التعديلات تُطبق فوراً على الموقع</p>
        </div>
      </div>
    </div>
  );
}
