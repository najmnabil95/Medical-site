import { createContext, useContext, useState, useEffect, ReactNode } from "react";

export type NotificationType = "sms" | "whatsapp" | "email" | "internal";
export type NotificationStatus = "pending" | "sent" | "failed" | "delivered";

export interface Notification {
  id: string;
  type: NotificationType;
  recipient: string; // رقم الهاتف أو البريد
  message: string;
  status: NotificationStatus;
  reservationId?: string;
  patientName?: string;
  createdAt: string;
  sentAt?: string;
  errorMessage?: string;
}

export interface NotificationSettings {
  enableSMS: boolean;
  enableWhatsApp: boolean;
  enableEmail: boolean;
  enableInternal: boolean;
  smsProvider: string;
  whatsappProvider: string;
  smsApiKey: string;
  whatsappApiKey: string;
}

interface NotificationContextType {
  notifications: Notification[];
  settings: NotificationSettings;
  addNotification: (notification: Omit<Notification, "id" | "createdAt" | "status">) => void;
  sendNotification: (notification: Omit<Notification, "id" | "createdAt" | "status">) => Promise<boolean>;
  updateSettings: (settings: Partial<NotificationSettings>) => void;
  markAsDelivered: (id: string) => void;
  markAsFailed: (id: string, error: string) => void;
  deleteNotification: (id: string) => void;
}

const NotificationContext = createContext<NotificationContextType | null>(null);

const defaultSettings: NotificationSettings = {
  enableSMS: true,
  enableWhatsApp: true,
  enableEmail: false,
  enableInternal: true,
  smsProvider: "twilio",
  whatsappProvider: "twilio",
  smsApiKey: "",
  whatsappApiKey: "",
};

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

export function NotificationProvider({ children }: { children: ReactNode }) {
  const [notifications, setNotifications] = useState<Notification[]>(() => load("notifications", []));
  const [settings, setSettings] = useState<NotificationSettings>(() => load("notificationSettings", defaultSettings));

  useEffect(() => { save("notifications", notifications); }, [notifications]);
  useEffect(() => { save("notificationSettings", settings); }, [settings]);

  const addNotification = (notification: Omit<Notification, "id" | "createdAt" | "status">) => {
    const newNotification: Notification = {
      ...notification,
      id: Date.now().toString(),
      createdAt: new Date().toISOString(),
      status: "pending",
    };
    setNotifications(prev => [newNotification, ...prev]);
  };

  // محاكاة إرسال الإشعار
  const sendNotification = async (notification: Omit<Notification, "id" | "createdAt" | "status">): Promise<boolean> => {
    const newNotification: Notification = {
      ...notification,
      id: Date.now().toString(),
      createdAt: new Date().toISOString(),
      status: "pending",
    };
    
    setNotifications(prev => [newNotification, ...prev]);

    // محاكاة التأخير في الإرسال
    await new Promise(resolve => setTimeout(resolve, 1500));

    // محاكاة النجاح (90% نسبة نجاح)
    const success = Math.random() > 0.1;
    
    if (success) {
      setNotifications(prev => prev.map(n => 
        n.id === newNotification.id 
          ? { ...n, status: "delivered", sentAt: new Date().toISOString() }
          : n
      ));
      return true;
    } else {
      setNotifications(prev => prev.map(n => 
        n.id === newNotification.id 
          ? { ...n, status: "failed", errorMessage: "فشل إرسال الإشعار. يرجى المحاولة مرة أخرى." }
          : n
      ));
      return false;
    }
  };

  const updateSettings = (newSettings: Partial<NotificationSettings>) => {
    setSettings(prev => ({ ...prev, ...newSettings }));
  };

  const markAsDelivered = (id: string) => {
    setNotifications(prev => prev.map(n => 
      n.id === id ? { ...n, status: "delivered", sentAt: new Date().toISOString() } : n
    ));
  };

  const markAsFailed = (id: string, error: string) => {
    setNotifications(prev => prev.map(n => 
      n.id === id ? { ...n, status: "failed", errorMessage: error } : n
    ));
  };

  const deleteNotification = (id: string) => {
    setNotifications(prev => prev.filter(n => n.id !== id));
  };

  return (
    <NotificationContext.Provider value={{
      notifications,
      settings,
      addNotification,
      sendNotification,
      updateSettings,
      markAsDelivered,
      markAsFailed,
      deleteNotification,
    }}>
      {children}
    </NotificationContext.Provider>
  );
}

export function useNotifications() {
  const context = useContext(NotificationContext);
  if (!context) throw new Error("useNotifications must be used within NotificationProvider");
  return context;
}
