import { AlertTriangle, X } from "lucide-react";

interface ConfirmDialogProps {
  isOpen: boolean;
  onClose: () => void;
  onConfirm: () => void;
  title: string;
  message: string;
  confirmText?: string;
  variant?: "danger" | "warning" | "info";
}

export default function ConfirmDialog({
  isOpen,
  onClose,
  onConfirm,
  title,
  message,
  confirmText = "تأكيد",
  variant = "danger",
}: ConfirmDialogProps) {
  if (!isOpen) return null;

  const variantClasses = {
    danger: { bg: "bg-red-500 hover:bg-red-600", icon: "bg-red-100 text-red-500" },
    warning: { bg: "bg-amber-500 hover:bg-amber-600", icon: "bg-amber-100 text-amber-500" },
    info: { bg: "bg-blue-500 hover:bg-blue-600", icon: "bg-blue-100 text-blue-500" },
  };

  const colors = variantClasses[variant];

  return (
    <div className="fixed inset-0 z-[95] flex items-center justify-center p-4">
      <div className="fixed inset-0 bg-black/60 backdrop-blur-sm" onClick={onClose}></div>
      <div className="relative bg-white rounded-2xl shadow-2xl w-full max-w-md animate-scale-in">
        {/* Header */}
        <div className="px-6 pt-6 pb-4 flex items-start justify-between">
          <div className="flex items-start gap-4">
            <div className={`w-12 h-12 ${colors.icon} rounded-xl flex items-center justify-center shrink-0`}>
              <AlertTriangle size={22} />
            </div>
            <div>
              <h3 className="text-lg font-bold text-gray-800 mb-1">{title}</h3>
              <p className="text-sm text-gray-500 leading-relaxed">{message}</p>
            </div>
          </div>
          <button
            onClick={onClose}
            className="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg"
          >
            <X size={18} />
          </button>
        </div>

        {/* Actions */}
        <div className="px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-3 bg-gray-50 rounded-b-2xl">
          <button
            onClick={onClose}
            className="px-5 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
          >
            إلغاء
          </button>
          <button
            onClick={() => {
              onConfirm();
              onClose();
            }}
            className={`px-5 py-2 text-sm font-medium text-white ${colors.bg} rounded-lg transition-colors`}
          >
            {confirmText}
          </button>
        </div>
      </div>
    </div>
  );
}
