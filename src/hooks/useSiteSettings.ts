import { useEffect, useState } from "react";

interface GeneralSettings {
  siteName: string;
  siteNameEn: string;
  description: string;
  phone: string;
  email: string;
  address: string;
  logo: string;
  favicon: string;
}

const defaultSettings: GeneralSettings = {
  siteName: "مستشفى الشفاء",
  siteNameEn: "Al-Shifa Hospital",
  description: "مستشفى الشفاء الدولي - رعاية طبية متميزة",
  phone: "+966 12 345 6789",
  email: "info@alshifa-hospital.com",
  address: "الرياض، المملكة العربية السعودية",
  logo: "🏥",
  favicon: "🏥",
};

export function useSiteSettings() {
  const [settings, setSettings] = useState<GeneralSettings>(defaultSettings);

  useEffect(() => {
    const saved = localStorage.getItem("generalSettings");
    if (saved) {
      setSettings(JSON.parse(saved));
    }

    // تحديث عنوان الصفحة
    const savedSettings = saved ? JSON.parse(saved) : defaultSettings;
    document.title = savedSettings.siteName;
  }, []);

  return settings;
}

export default useSiteSettings;
