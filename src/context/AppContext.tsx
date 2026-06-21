import { createContext, useContext, useState, useEffect, ReactNode } from "react";

export interface Reservation {
  id: string;
  patientName: string;
  phone: string;
  department: string;
  doctor?: string;
  date: string;
  time: string;
  status: "pending" | "confirmed" | "completed" | "cancelled";
  type?: "normal" | "offer" | "consultation"; // نوع الحجز
  offerId?: string;       // معرف العرض (إذا كان حجز عرض)
  notes?: string;
  createdAt: string;
}

export interface Message {
  id: string;
  name: string;
  email: string;
  subject: string;
  message: string;
  status: "new" | "read" | "replied";
  createdAt: string;
  reply?: string;
}

export interface ActivityLog {
  id: string;
  action: string;
  type: "create" | "update" | "delete" | "login" | "logout";
  user: string;
  timestamp: string;
}

export interface Screen {
  id: string;
  name: string;
  component: string;
  enabled: boolean;
  order: number;
  icon: string;
}

interface AppContextType {
  // Theme
  darkMode: boolean;
  toggleDarkMode: () => void;
  
  // Public Site Theme (الوضع الليلي للموقع الرئيسي)
  publicSiteDarkMode: boolean;
  togglePublicSiteDarkMode: () => void;

  // Reservations
  reservations: Reservation[];
  setReservations: (r: Reservation[]) => void;

  // Messages
  messages: Message[];
  setMessages: (m: Message[]) => void;

  // Activity Logs
  activityLogs: ActivityLog[];
  addLog: (action: string, type: ActivityLog["type"]) => void;
  clearLogs: () => void;

  // Notifications
  notifications: { id: string; message: string; type: "info" | "success" | "warning"; read: boolean; time: string }[];
  addNotification: (message: string, type: "info" | "success" | "warning") => void;
  markAllRead: () => void;
  clearNotifications: () => void;

  // Screens Control
  screens: Screen[];
  setScreens: (s: Screen[]) => void;
  toggleScreen: (id: string) => void;
  updateScreenOrder: (id: string, newOrder: number) => void;
}

const AppContext = createContext<AppContextType | null>(null);

function load<T>(key: string, defaultValue: T): T {
  try {
    const stored = localStorage.getItem(key);
    if (stored) return JSON.parse(stored);
  } catch (e) {}
  return defaultValue;
}

function save<T>(key: string, value: T) {
  try {
    localStorage.setItem(key, JSON.stringify(value));
  } catch (e) {}
}

const defaultReservations: Reservation[] = [
  { id: "1", patientName: "أحمد محمد", phone: "0501234567", department: "أمراض القلب", doctor: "د. أحمد الراشد", date: "2024-01-20", time: "10:00", status: "confirmed", createdAt: "2024-01-15T10:00:00Z" },
  { id: "2", patientName: "فاطمة العلي", phone: "0557654321", department: "طب العيون", doctor: "د. نورة الحربي", date: "2024-01-21", time: "11:30", status: "pending", createdAt: "2024-01-16T14:00:00Z" },
  { id: "3", patientName: "خالد السعيد", phone: "0549876543", department: "جراحة العظام", date: "2024-01-18", time: "09:00", status: "completed", createdAt: "2024-01-10T09:00:00Z" },
  { id: "4", patientName: "سارة الأحمد", phone: "0561112222", department: "طب الأطفال", doctor: "د. سارة المنصور", date: "2024-01-22", time: "14:00", status: "pending", createdAt: "2024-01-17T11:00:00Z" },
  { id: "5", patientName: "عبدالله المنصور", phone: "0523334444", department: "جراحة المخ والأعصاب", doctor: "د. خالد العمري", date: "2024-01-19", time: "16:00", status: "cancelled", createdAt: "2024-01-12T16:00:00Z" },
];

const defaultMessages: Message[] = [
  { id: "1", name: "محمد الحربي", email: "mohammed@example.com", subject: "استفسار عن خدماتكم", message: "مرحباً، أريد الاستفسار عن خدمات جراحة القلب لديكم", status: "new", createdAt: "2024-01-18T10:00:00Z" },
  { id: "2", name: "نورة القحطاني", email: "noura@example.com", subject: "شكر وتقدير", message: "أشكركم جزيل الشكر على الخدمة الممتازة", status: "replied", createdAt: "2024-01-17T15:30:00Z", reply: "شكراً لك على كلماتك الطيبة" },
  { id: "3", name: "فهد العتيبي", email: "fahad@example.com", subject: "طلب موعد", message: "أرغب في حجز موعد مع طبيب عيون", status: "read", createdAt: "2024-01-16T09:00:00Z" },
];

const defaultLogs: ActivityLog[] = [
  { id: "1", action: "تسجيل الدخول إلى لوحة التحكم", type: "login", user: "admin", timestamp: new Date().toISOString() },
];

const defaultScreens: Screen[] = [
  { id: "1", name: "الرئيسية", component: "Hero", enabled: true, order: 1, icon: "🏠" },
  { id: "2", name: "من نحن", component: "About", enabled: true, order: 2, icon: "📖" },
  { id: "3", name: "لماذا تختارنا", component: "WhyChooseUs", enabled: true, order: 3, icon: "⭐" },
  { id: "4", name: "الإحصائيات", component: "Stats", enabled: true, order: 4, icon: "📊" },
  { id: "5", name: "الأقسام الطبية", component: "Departments", enabled: true, order: 5, icon: "🏥" },
  { id: "6", name: "الأطباء", component: "Doctors", enabled: true, order: 6, icon: "👨‍⚕️" },
  { id: "7", name: "الخدمات", component: "Services", enabled: true, order: 7, icon: "💼" },
  { id: "8", name: "الاستشارات عن بُعد", component: "Telemedicine", enabled: true, order: 8, icon: "📹" },
  { id: "9", name: "الفيديو التعريفي", component: "VideoSection", enabled: true, order: 9, icon: "🎬" },
  { id: "10", name: "معرض الصور", component: "Gallery", enabled: true, order: 10, icon: "🖼️" },
  { id: "11", name: "آراء المرضى", component: "Testimonials", enabled: true, order: 11, icon: "💬" },
  { id: "12", name: "العروض والخصومات", component: "Offers", enabled: true, order: 12, icon: "🎁" },
  { id: "13", name: "الباقات المميزة", component: "PremiumPackages", enabled: true, order: 13, icon: "💎" },
  { id: "14", name: "حاسبة التكلفة", component: "CostCalculator", enabled: true, order: 14, icon: "🧮" },
  { id: "15", name: "الرعاية المنزلية", component: "HomeCare", enabled: true, order: 15, icon: "🏠" },
  { id: "16", name: "السياحة العلاجية", component: "MedicalTourism", enabled: true, order: 16, icon: "✈️" },
  { id: "17", name: "حجز موعد", component: "Appointment", enabled: true, order: 17, icon: "📅" },
  { id: "18", name: "المسيرة الزمنية", component: "Timeline", enabled: true, order: 18, icon: "⏳" },
  { id: "19", name: "الشهادات والاعتمادات", component: "Certifications", enabled: true, order: 19, icon: "🏆" },
  { id: "20", name: "التأمين الطبي", component: "Insurance", enabled: true, order: 20, icon: "🛡️" },
  { id: "21", name: "تطبيق الجوال", component: "MobileApp", enabled: true, order: 21, icon: "📱" },
  { id: "22", name: "الأخبار", component: "News", enabled: true, order: 22, icon: "📰" },
  { id: "23", name: "الأسئلة الشائعة", component: "FAQ", enabled: true, order: 23, icon: "❓" },
  { id: "24", name: "الشركاء", component: "Partners", enabled: true, order: 24, icon: "🤝" },
  { id: "25", name: "تواصل معنا", component: "Contact", enabled: true, order: 25, icon: "📞" },
];

export function AppProvider({ children }: { children: ReactNode }) {
  const [darkMode, setDarkMode] = useState<boolean>(() => load("darkMode", false));
  const [publicSiteDarkMode, setPublicSiteDarkMode] = useState<boolean>(() => load("publicSiteDarkMode", false));
  const [reservations, setReservationsState] = useState<Reservation[]>(() => load("reservations", defaultReservations));
  const [messages, setMessagesState] = useState<Message[]>(() => load("messages", defaultMessages));
  const [activityLogs, setActivityLogsState] = useState<ActivityLog[]>(() => load("activityLogs", defaultLogs));
  const [notifications, setNotifications] = useState<any[]>(() => load("notifications", []));
  const [screens, setScreensState] = useState<Screen[]>(() => load("screens", defaultScreens));

  useEffect(() => { save("darkMode", darkMode); }, [darkMode]);
  useEffect(() => { save("publicSiteDarkMode", publicSiteDarkMode); }, [publicSiteDarkMode]);
  useEffect(() => { save("reservations", reservations); }, [reservations]);
  useEffect(() => { save("messages", messages); }, [messages]);
  useEffect(() => { save("activityLogs", activityLogs); }, [activityLogs]);
  useEffect(() => { save("notifications", notifications); }, [notifications]);
  useEffect(() => { save("screens", screens); }, [screens]);

  const toggleDarkMode = () => setDarkMode(!darkMode);
  const togglePublicSiteDarkMode = () => setPublicSiteDarkMode(!publicSiteDarkMode);

  const setReservations = (r: Reservation[]) => setReservationsState(r);
  const setMessages = (m: Message[]) => setMessagesState(m);
  const setScreens = (s: Screen[]) => setScreensState(s);

  const toggleScreen = (id: string) => {
    setScreensState(prev => 
      prev.map(s => s.id === id ? { ...s, enabled: !s.enabled } : s)
    );
  };

  const updateScreenOrder = (id: string, newOrder: number) => {
    setScreensState(prev => {
      const updated = prev.map(s => s.id === id ? { ...s, order: newOrder } : s);
      return updated.sort((a, b) => a.order - b.order);
    });
  };

  const addLog = (action: string, type: ActivityLog["type"]) => {
    const newLog: ActivityLog = {
      id: Date.now().toString(),
      action,
      type,
      user: "admin",
      timestamp: new Date().toISOString(),
    };
    setActivityLogsState(prev => [newLog, ...prev].slice(0, 100));
  };

  const clearLogs = () => setActivityLogsState([]);

  const addNotification = (message: string, type: "info" | "success" | "warning") => {
    const notif = {
      id: Date.now().toString(),
      message,
      type,
      read: false,
      time: new Date().toISOString(),
    };
    setNotifications(prev => [notif, ...prev]);
  };

  const markAllRead = () => {
    setNotifications(prev => prev.map(n => ({ ...n, read: true })));
  };

  const clearNotifications = () => setNotifications([]);

  return (
    <AppContext.Provider value={{
      darkMode, toggleDarkMode,
      publicSiteDarkMode, togglePublicSiteDarkMode,
      reservations, setReservations,
      messages, setMessages,
      activityLogs, addLog, clearLogs,
      notifications, addNotification, markAllRead, clearNotifications,
      screens, setScreens, toggleScreen, updateScreenOrder,
    }}>
      {children}
    </AppContext.Provider>
  );
}

export function useApp() {
  const context = useContext(AppContext);
  if (!context) throw new Error("useApp must be used within AppProvider");
  return context;
}
