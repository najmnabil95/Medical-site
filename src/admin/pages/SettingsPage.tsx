import { useState } from "react";
import { Settings as SettingsIcon, Save, RotateCcw, Info } from "lucide-react";
import { useData } from "../../context/DataContext";
import PageHeader from "../components/PageHeader";
import { useToast } from "../components/Toast";

export default function SettingsPage() {
  const { settings, setSettings } = useData();
  const { toast } = useToast();
  const [form, setForm] = useState({ ...settings });
  const [saved, setSaved] = useState(false);

  const exportAllData = () => {
    const allData = {
      settings,
      departments: localStorage.getItem("departments"),
      doctors: localStorage.getItem("doctors"),
      services: localStorage.getItem("services"),
      packages: localStorage.getItem("packages"),
      testimonials: localStorage.getItem("testimonials"),
      news: localStorage.getItem("news"),
      faqs: localStorage.getItem("faqs"),
      insurances: localStorage.getItem("insurances"),
      partners: localStorage.getItem("partners"),
      certifications: localStorage.getItem("certifications"),
      reservations: localStorage.getItem("reservations"),
      messages: localStorage.getItem("messages"),
    };
    const blob = new Blob([JSON.stringify(allData, null, 2)], { type: "application/json" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = `alshifa-backup-${new Date().toISOString().split("T")[0]}.json`;
    a.click();
    toast("success", "تم تصدير جميع البيانات بنجاح");
  };

  const importData = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (event) => {
      try {
        const data = JSON.parse(event.target?.result as string);
        Object.entries(data).forEach(([key, value]) => {
          if (value && key !== "settings") {
            localStorage.setItem(key, value as string);
          }
        });
        if (data.settings) {
          setSettings(data.settings);
        }
        toast("success", "تم استيراد البيانات بنجاح. سيتم تحديث الصفحة...");
        setTimeout(() => window.location.reload(), 1500);
      } catch (err) {
        toast("error", "خطأ في قراءة الملف. تأكد من صحة الملف.");
      }
    };
    reader.readAsText(file);
  };

  const handleSave = (e: React.FormEvent) => {
     e.preventDefault();
     setSettings(form);
     window.dispatchEvent(new Event("siteSettingsUpdated"));
     toast("success", "تم حفظ الإعدادات بنجاح");
     setSaved(true);
     setTimeout(() => setSaved(false), 2000);
   };

  const handleReset = () => {
    if (confirm("هل أنت متأكد من إعادة تعيين جميع البيانات؟ سيتم حذف جميع التعديلات!")) {
      localStorage.clear();
      window.location.reload();
    }
  };

  const inputClass = "w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 transition-all";
  const labelClass = "block text-sm font-bold text-gray-700 mb-2";

  return (
    <div>
      <PageHeader
        title="إعدادات الموقع"
        subtitle="إدارة المعلومات العامة للموقع"
        icon={<SettingsIcon size={26} />}
        action={
          <div className="flex items-center gap-2">
            <button onClick={handleReset} className="px-4 py-2.5 bg-red-50 text-red-600 rounded-xl text-sm font-bold hover:bg-red-100 flex items-center gap-2 transition-all">
              <RotateCcw size={16} />
              <span>إعادة تعيين</span>
            </button>
          </div>
        }
      />

      {/* Info */}
      <div className="bg-blue-50 border border-blue-200 rounded-2xl p-5 mb-6 flex items-start gap-3">
        <Info size={20} className="text-blue-500 shrink-0 mt-0.5" />
        <div>
          <p className="text-sm font-bold text-blue-700 mb-1">ملاحظة</p>
          <p className="text-sm text-blue-600 leading-relaxed">
            هذه الإعدادات ستظهر على الموقع الرئيسي. احفظ التغييرات لتفعيلها.
          </p>
        </div>
      </div>

      <form onSubmit={handleSave} className="space-y-6">
        {/* General Info */}
        <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
          <div className="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 className="font-bold text-gray-800">المعلومات العامة</h3>
          </div>
          <div className="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label className={labelClass}>اسم المستشفى</label>
              <input type="text" value={form.siteName} onChange={(e) => setForm({ ...form, siteName: e.target.value })} className={inputClass} />
            </div>
            <div>
              <label className={labelClass}>الاسم بالإنجليزية</label>
              <input type="text" value={form.siteNameEn} onChange={(e) => setForm({ ...form, siteNameEn: e.target.value })} className={inputClass} />
            </div>
            <div>
              <label className={labelClass}>رقم الهاتف</label>
              <input type="text" value={form.phone} onChange={(e) => setForm({ ...form, phone: e.target.value })} className={inputClass} />
            </div>
            <div>
              <label className={labelClass}>رقم الطوارئ</label>
              <input type="text" value={form.emergency} onChange={(e) => setForm({ ...form, emergency: e.target.value })} className={inputClass} />
            </div>
            <div>
              <label className={labelClass}>البريد الإلكتروني</label>
              <input type="email" value={form.email} onChange={(e) => setForm({ ...form, email: e.target.value })} className={inputClass} />
            </div>
            <div>
              <label className={labelClass}>رقم الواتساب</label>
              <input type="text" value={form.whatsapp} onChange={(e) => setForm({ ...form, whatsapp: e.target.value })} className={inputClass} placeholder="966123456789" />
            </div>
            <div className="md:col-span-2">
              <label className={labelClass}>العنوان</label>
              <input type="text" value={form.address} onChange={(e) => setForm({ ...form, address: e.target.value })} className={inputClass} />
            </div>
            <div className="md:col-span-2">
              <label className={labelClass}>المدينة / البلد</label>
              <input type="text" value={form.city} onChange={(e) => setForm({ ...form, city: e.target.value })} className={inputClass} />
            </div>
          </div>
        </div>

        {/* Social Media */}
        <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
          <div className="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 className="font-bold text-gray-800">روابط التواصل الاجتماعي</h3>
          </div>
          <div className="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label className={labelClass}>📘 Facebook</label>
              <input type="text" value={form.facebook} onChange={(e) => setForm({ ...form, facebook: e.target.value })} className={inputClass} placeholder="https://facebook.com/..." />
            </div>
            <div>
              <label className={labelClass}>🐦 Twitter / X</label>
              <input type="text" value={form.twitter} onChange={(e) => setForm({ ...form, twitter: e.target.value })} className={inputClass} placeholder="https://twitter.com/..." />
            </div>
            <div>
              <label className={labelClass}>📷 Instagram</label>
              <input type="text" value={form.instagram} onChange={(e) => setForm({ ...form, instagram: e.target.value })} className={inputClass} placeholder="https://instagram.com/..." />
            </div>
            <div>
              <label className={labelClass}>▶️ YouTube</label>
              <input type="text" value={form.youtube} onChange={(e) => setForm({ ...form, youtube: e.target.value })} className={inputClass} placeholder="https://youtube.com/..." />
            </div>
            <div>
              <label className={labelClass}>💼 LinkedIn</label>
              <input type="text" value={form.linkedin} onChange={(e) => setForm({ ...form, linkedin: e.target.value })} className={inputClass} placeholder="https://linkedin.com/..." />
            </div>
            <div>
              <label className={labelClass}>👻 Snapchat</label>
              <input type="text" value={form.snapchat} onChange={(e) => setForm({ ...form, snapchat: e.target.value })} className={inputClass} placeholder="https://snapchat.com/..." />
            </div>
          </div>
        </div>

        {/* Save Button */}
        <div className="sticky bottom-4 flex items-center justify-end gap-3 bg-white rounded-2xl p-5 shadow-xl border border-gray-100">
          <p className="text-sm text-gray-500 flex-1">
            {saved ? "✅ تم الحفظ!" : "لا تنسَ حفظ التغييرات قبل المغادرة"}
          </p>
          <label className="px-5 py-3 text-sm font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-xl cursor-pointer flex items-center gap-2">
            <input type="file" accept=".json" onChange={importData} className="hidden" />
            📥 استيراد
          </label>
          <button
            type="button"
            onClick={exportAllData}
            className="px-5 py-3 text-sm font-bold text-green-600 bg-green-50 hover:bg-green-100 rounded-xl flex items-center gap-2"
          >
            📤 تصدير
          </button>
          <button
            type="button"
            onClick={() => setForm({ ...settings })}
            className="px-5 py-3 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl"
          >
            إلغاء
          </button>
          <button
            type="submit"
            className="px-8 py-3 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl hover:shadow-lg hover:shadow-primary-500/30 transition-all flex items-center gap-2"
          >
            <Save size={16} />
            <span>حفظ الإعدادات</span>
          </button>
        </div>
      </form>
    </div>
  );
}
