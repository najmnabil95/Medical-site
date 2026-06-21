import { Activity, Clock, User, Trash2, Filter } from "lucide-react";
import { useApp } from "../../context/AppContext";
import PageHeader from "../components/PageHeader";
import { useToast } from "../components/Toast";
import { useState } from "react";

const TYPE_CONFIG = {
  create: { label: "إضافة", color: "bg-green-100 text-green-700" },
  update: { label: "تعديل", color: "bg-blue-100 text-blue-700" },
  delete: { label: "حذف", color: "bg-red-100 text-red-700" },
  login: { label: "تسجيل دخول", color: "bg-purple-100 text-purple-700" },
  logout: { label: "تسجيل خروج", color: "bg-gray-100 text-gray-700" },
};

export default function ActivityLogPage() {
  const { activityLogs, clearLogs } = useApp();
  const { toast } = useToast();
  const [filter, setFilter] = useState<string>("all");

  const filtered = filter === "all" ? activityLogs : activityLogs.filter(l => l.type === filter);

  const handleClear = () => {
    if (confirm("هل أنت متأكد من مسح جميع السجلات؟")) {
      clearLogs();
      toast("success", "تم مسح جميع السجلات");
    }
  };

  const formatDate = (dateStr: string) => {
    const date = new Date(dateStr);
    const now = new Date();
    const diff = now.getTime() - date.getTime();
    const mins = Math.floor(diff / 60000);
    const hours = Math.floor(diff / 3600000);
    const days = Math.floor(diff / 86400000);

    if (mins < 1) return "الآن";
    if (mins < 60) return `منذ ${mins} دقيقة`;
    if (hours < 24) return `منذ ${hours} ساعة`;
    if (days < 7) return `منذ ${days} يوم`;
    return date.toLocaleDateString("ar-SA");
  };

  return (
    <div>
      <PageHeader
        title="سجل النشاطات"
        subtitle={`${activityLogs.length} نشاط مسجل`}
        icon={<Activity size={26} />}
        action={
          <button onClick={handleClear} className="px-4 py-2.5 bg-red-50 text-red-600 rounded-xl text-sm font-bold hover:bg-red-100 flex items-center gap-2">
            <Trash2 size={16} />
            <span>مسح السجل</span>
          </button>
        }
      />

      {/* Filter */}
      <div className="bg-white rounded-2xl p-4 mb-6 border border-gray-100 flex items-center gap-2 overflow-x-auto">
        <Filter size={16} className="text-gray-400 shrink-0" />
        {[
          { value: "all", label: "الكل" },
          { value: "create", label: "إضافة" },
          { value: "update", label: "تعديل" },
          { value: "delete", label: "حذف" },
          { value: "login", label: "تسجيل دخول" },
        ].map((f) => (
          <button key={f.value} onClick={() => setFilter(f.value)} className={`px-4 py-1.5 text-xs font-bold rounded-lg transition-all whitespace-nowrap ${filter === f.value ? "bg-primary-500 text-white shadow-md" : "text-gray-600 hover:bg-gray-200"}`}>
            {f.label}
          </button>
        ))}
      </div>

      {/* Activity Log */}
      <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div className="divide-y divide-gray-100">
          {filtered.map((log) => (
            <div key={log.id} className="p-4 hover:bg-gray-50/50 transition-colors flex items-center gap-4">
              <div className="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center shrink-0">
                <User size={16} className="text-gray-500" />
              </div>
              <div className="flex-1 min-w-0">
                <p className="font-medium text-gray-800 text-sm">{log.action}</p>
                <div className="flex items-center gap-3 mt-1">
                  <span className={`text-xs px-2 py-0.5 rounded-full font-bold ${TYPE_CONFIG[log.type].color}`}>
                    {TYPE_CONFIG[log.type].label}
                  </span>
                  <span className="text-xs text-gray-400">بواسطة {log.user}</span>
                </div>
              </div>
              <div className="text-left shrink-0 flex items-center gap-1 text-xs text-gray-400">
                <Clock size={12} />
                <span>{formatDate(log.timestamp)}</span>
              </div>
            </div>
          ))}
        </div>

        {filtered.length === 0 && (
          <div className="py-16 text-center">
            <Activity size={48} className="text-gray-300 mx-auto mb-4" />
            <p className="text-gray-500">لا توجد نشاطات</p>
          </div>
        )}
      </div>
    </div>
  );
}
