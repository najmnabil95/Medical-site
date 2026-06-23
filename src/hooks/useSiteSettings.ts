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
  const [settings, setSettings] = useState<GeneralSettings>(() => {
    const saved = localStorage.getItem("settings");
    if (saved) {
      try {
        const parsed = JSON.parse(saved);
        return { ...defaultSettings, ...parsed };
      } catch (e) {}
    }
    return defaultSettings;
  });

  useEffect(() => {
    const updateSettings = () => {
      const saved = localStorage.getItem("settings");
      if (saved) {
        try {
          const parsed = JSON.parse(saved);
          setSettings({ ...defaultSettings, ...parsed });
        } catch (e) {}
      }
    };

    updateSettings();

    // Listen to custom event for same-tab updates
    window.addEventListener("siteSettingsUpdated", updateSettings);
    // Listen to storage event for other-tab updates
    window.addEventListener("storage", (e) => {
      if (e.key === "settings") {
        updateSettings();
      }
    });

    // Update document title
    const saved = localStorage.getItem("settings");
    const savedSettings = saved ? JSON.parse(saved) : defaultSettings;
    document.title = savedSettings.siteName || defaultSettings.siteName;

    return () => {
      window.removeEventListener("siteSettingsUpdated", updateSettings);
    };
  }, []);

  return settings;
}

export default useSiteSettings;
