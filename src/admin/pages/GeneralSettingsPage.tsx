import { useState } from "react";
import { Settings, Save, RotateCcw, Upload, Globe, Phone, Mail, MapPin } from "lucide-react";
import PageHeader from "../components/PageHeader";
import { useToast } from "../components/Toast";

interface SiteSettings {
  siteName: string;
  siteNameEn: string;
  description: string;
  phone: string;
  email: string;
  address: string;
  logo: string;
  favicon: string;
}

const defaultSettings: SiteSettings = {
  siteName: "مستشفى الشفاء",
  siteNameEn: "Al-Shifa Hospital",
  description: "مستشفى الشفاء الدولي - رعاية طبية متميزة",
  phone: "+966 12 345 6789",
  email: "info@alshifa-hospital.com",
  address: "الرياض، المملكة العربية السعودية",
  logo: "🏥",
  favicon: "🏥",
};

export default function GeneralSettingsPage() {
  const { toast } = useToast();
  const [settings, setSettings] = useState<SiteSettings>(() => {
    const saved = localStorage.getItem("generalSettings");
    if (saved) return JSON.parse(saved);
    return defaultSettings;
  });

  const handleSave = () => {
    localStorage.setItem("generalSettings", JSON.stringify(settings));
    
    // تحديث عنوان الصفحة
    document.title = settings.siteName;
    
    toast("success", "تم حفظ الإعدادات بنجاح");
  };

  const handleReset = () => {
    if (confirm("هل أنت متأكد من إعادة تعيين الإعدادات؟")) {
      setSettings(defaultSettings);
      localStorage.removeItem("generalSettings");
      document.title = defaultSettings.siteName;
      toast("success", "تم إعادة تعيين الإعدادات");
    }
  };

  const handleLogoChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      const reader = new FileReader();
      reader.onloadend = () => {
        setSettings({ ...settings, logo: reader.result as string });
      };
      reader.readAsDataURL(file);
    }
  };

  return (
    <div>
      <PageHeader
        title="إعدادات الموقع"
        subtitle="إدارة اسم الموقع والشعار والمعلومات الأساسية"
        icon={<Settings size={26} />}
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
          <Settings size={20} className="text-blue-600" />
        </div>
        <div>
          <p className="font-bold text-blue-700 mb-1">معلومات مهمة</p>
          <ul className="text-sm text-blue-600 space-y-1">
            <li>• هذه الإعدادات تؤثر على الموقع الرئيسي</li>
            <li>• سيتم تحديث عنوان الصفحة تلقائياً</li>
            <li>• يمكنك رفع صورة للشعار أو استخدام إيموجي</li>
            <li>• لا تنسَ الضغط على "حفظ" بعد التعديل</li>
          </ul>
        </div>
      </div>

      <div className="space-y-6">
        {/* Site Identity */}
        <div className="bg-white rounded-xl border border-gray-200 overflow-hidden">
          <div className="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h3 className="font-bold text-gray-800 flex items-center gap-2">
              <Globe size={18} />
              <span>هوية الموقع</span>
            </h3>
          </div>
          <div className="p-6 space-y-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                اسم الموقع (عربي)
              </label>
              <input
                type="text"
                value={settings.siteName}
                onChange={(e) => setSettings({ ...settings, siteName: e.target.value })}
                className="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-primary-500"
                placeholder="مستشفى الشفاء"
              />
            </div>

            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                اسم الموقع (إنجليزي)
              </label>
              <input
                type="text"
                value={settings.siteNameEn}
                onChange={(e) => setSettings({ ...settings, siteNameEn: e.target.value })}
                className="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-primary-500"
                placeholder="Al-Shifa Hospital"
              />
            </div>

            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                وصف الموقع
              </label>
              <textarea
                value={settings.description}
                onChange={(e) => setSettings({ ...settings, description: e.target.value })}
                rows={3}
                className="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-primary-500 resize-none"
                placeholder="وصف مختصر للموقع"
              />
            </div>

            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                الشعار (Logo)
              </label>
              <div className="flex items-center gap-4">
                <div className="w-20 h-20 border-2 border-gray-300 rounded-xl flex items-center justify-center overflow-hidden">
                  {settings.logo.startsWith("data:") ? (
                    <img src={settings.logo} alt="Logo" className="w-full h-full object-cover" />
                  ) : (
                    <span className="text-4xl">{settings.logo}</span>
                  )}
                </div>
                <div className="flex-1 space-y-2">
                  <input
                    type="file"
                    accept="image/*"
                    onChange={handleLogoChange}
                    className="hidden"
                    id="logo-upload"
                  />
                  <label
                    htmlFor="logo-upload"
                    className="inline-flex items-center gap-2 px-4 py-2 bg-primary-50 text-primary-600 rounded-xl text-sm font-bold hover:bg-primary-100 transition-all cursor-pointer"
                  >
                    <Upload size={16} />
                    <span>رفع صورة</span>
                  </label>
                  <p className="text-xs text-gray-500">أو استخدم إيموجي: 🏥 🏨 ⚕️</p>
                  <div className="flex items-center gap-2">
                    <input
                      type="text"
                      value={settings.logo.startsWith("data:") ? "" : settings.logo}
                      onChange={(e) => setSettings({ ...settings, logo: e.target.value || "🏥" })}
                      className="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-primary-500"
                      placeholder="🏥"
                      maxLength={2}
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Contact Information */}
        <div className="bg-white rounded-xl border border-gray-200 overflow-hidden">
          <div className="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h3 className="font-bold text-gray-800 flex items-center gap-2">
              <Phone size={18} />
              <span>معلومات التواصل</span>
            </h3>
          </div>
          <div className="p-6 space-y-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                <Phone className="inline w-4 h-4 ml-1" />
                رقم الهاتف
              </label>
              <input
                type="tel"
                value={settings.phone}
                onChange={(e) => setSettings({ ...settings, phone: e.target.value })}
                className="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-primary-500"
                placeholder="+966 12 345 6789"
              />
            </div>

            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                <Mail className="inline w-4 h-4 ml-1" />
                البريد الإلكتروني
              </label>
              <input
                type="email"
                value={settings.email}
                onChange={(e) => setSettings({ ...settings, email: e.target.value })}
                className="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-primary-500"
                placeholder="info@hospital.com"
              />
            </div>

            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                <MapPin className="inline w-4 h-4 ml-1" />
                العنوان
              </label>
              <textarea
                value={settings.address}
                onChange={(e) => setSettings({ ...settings, address: e.target.value })}
                rows={2}
                className="w-full px-4 py-3 border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-primary-500 resize-none"
                placeholder="العنوان الكامل"
              />
            </div>
          </div>
        </div>

        {/* Preview */}
        <div className="bg-white rounded-xl border border-gray-200 overflow-hidden">
          <div className="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h3 className="font-bold text-gray-800">معاينة</h3>
          </div>
          <div className="p-6">
            <div className="bg-gray-50 rounded-xl p-6 space-y-4">
              <div className="flex items-center gap-3">
                <div className="w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center overflow-hidden">
                  {settings.logo.startsWith("data:") ? (
                    <img src={settings.logo} alt="Logo" className="w-full h-full object-cover" />
                  ) : (
                    <span className="text-2xl">{settings.logo}</span>
                  )}
                </div>
                <div>
                  <h4 className="font-bold text-gray-800">{settings.siteName}</h4>
                  <p className="text-xs text-gray-500">{settings.siteNameEn}</p>
                </div>
              </div>
              <p className="text-sm text-gray-600">{settings.description}</p>
              <div className="flex items-center gap-4 text-xs text-gray-500">
                <span className="flex items-center gap-1">
                  <Phone size={12} />
                  {settings.phone}
                </span>
                <span className="flex items-center gap-1">
                  <Mail size={12} />
                  {settings.email}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
