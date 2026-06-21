import { createContext, useContext, useState, ReactNode } from "react";
import { CheckCircle, XCircle, Info, AlertTriangle, X } from "lucide-react";

export type ToastType = "success" | "error" | "info" | "warning";

interface Toast {
  id: string;
  type: ToastType;
  message: string;
}

interface ToastContextType {
  toast: (type: ToastType, message: string) => void;
}

const ToastContext = createContext<ToastContextType | null>(null);

export function ToastProvider({ children }: { children: ReactNode }) {
  const [toasts, setToasts] = useState<Toast[]>([]);

  const addToast = (type: ToastType, message: string) => {
    const id = Date.now().toString();
    setToasts((prev) => [...prev, { id, type, message }]);
    setTimeout(() => {
      setToasts((prev) => prev.filter((t) => t.id !== id));
    }, 3000);
  };

  const removeToast = (id: string) => {
    setToasts((prev) => prev.filter((t) => t.id !== id));
  };

  const icons = {
    success: { Icon: CheckCircle, bg: "bg-green-500", text: "text-green-500" },
    error: { Icon: XCircle, bg: "bg-red-500", text: "text-red-500" },
    info: { Icon: Info, bg: "bg-blue-500", text: "text-blue-500" },
    warning: { Icon: AlertTriangle, bg: "bg-yellow-500", text: "text-yellow-500" },
  };

  return (
    <ToastContext.Provider value={{ toast: addToast }}>
      {children}
      <div className="fixed top-20 left-4 z-[100] space-y-2">
        {toasts.map((t) => {
          const { Icon, bg } = icons[t.type];
          return (
            <div
              key={t.id}
              className="bg-white rounded-xl shadow-xl border border-gray-100 p-4 min-w-[300px] max-w-md flex items-center gap-3 animate-slide-in-left"
            >
              <div className={`${bg} w-8 h-8 rounded-lg flex items-center justify-center shrink-0`}>
                <Icon size={16} className="text-white" />
              </div>
              <p className="flex-1 text-sm text-gray-700 font-medium">{t.message}</p>
              <button onClick={() => removeToast(t.id)} className="text-gray-400 hover:text-gray-600">
                <X size={14} />
              </button>
            </div>
          );
        })}
      </div>
    </ToastContext.Provider>
  );
}

export function useToast() {
  const context = useContext(ToastContext);
  if (!context) throw new Error("useToast must be used within ToastProvider");
  return context;
}
