import { useState } from "react";
import { Bell, MessageSquare, Mail, Send, Settings as SettingsIcon, CheckCircle, XCircle, AlertCircle, Trash2, RefreshCw } from "lucide-react";
import { useNotifications } from "../../context/NotificationContext";
import PageHeader from "../components/PageHeader";
import { useToast } from "../components/Toast";

export default function NotificationSettingsPage() {
  const { notifications, settings, updateSettings, deleteNotification, sendNotification } = useNotifications();
  const { toast } = useToast();
  const [activeTab, setActiveTab] = useState<"settings" | "history" | "test">("settings");
  const [testForm, setTestForm] = useState({
    type: "sms" as "sms" | "whatsapp" | "email",
    recipient: "",
    message: "هذه رسالة اختبار من مستشفى الشفاء",
  });

  const handleTestSend = async () => {
    if (!testForm.recipient) {
      toast("error", "الرجاء إدخال رقم الهاتف أو البريد");
      return;
    }

    const success = await sendNotification({
      type: testForm.type,
      recipient: testForm.recipient,
      message: testForm.message,
    });

    if (success) {
      toast("success", `تم إرسال ${testForm.type === "sms" ? "رسالة SMS" : testForm.type === "whatsapp" ? "رسالة واتساب" : "بريد إلكتروني"} بنجاح`);
    } else {
      toast("error", "فشل إرسال الرسالة");
    }
  };

  const getStatusIcon = (status: string) => {
    switch (status) {
      case "delivered": return <CheckCircle size={16} className="text-green-500" />;
      case "failed": return <XCircle size={16} className="text-red-500" />;
      case "pending": return <RefreshCw size={16} className="text-yellow-500 animate-spin" />;
      default: return <AlertCircle size={16} className="text-gray-400" />;
    }
  };

  const getTypeIcon = (type: string) => {
    switch (type) {
      case "sms": return <MessageSquare size={16} className="text-blue-500" />;
      case "whatsapp": return <MessageSquare size={16} className="text-green-500" />;
      case "email": return <Mail size={16} className="text-purple-500" />;
      default: return <Bell size={16} className="text-gray-500" />;
    }
  };

  return (
    <div>
      <PageHeader
        title="إعدادات الإشعارات"
        subtitle="إدارة إشعارات الحجوزات والاستشارات"
        icon={<Bell size={26} />}
      />

      {/* Tabs */}
      <div className="bg-white rounded-2xl border border-gray-100 mb-6">
        <div className="flex border-b border-gray-100">
          <button
            onClick={() => setActiveTab("settings")}
            className={`flex-1 px-6 py-4 font-bold text-sm transition-all ${
              activeTab === "settings"
                ? "text-primary-600 border-b-2 border-primary-600 bg-primary-50/50"
                : "text-gray-600 hover:bg-gray-50"
            }`}
          >
            <SettingsIcon size={18} className="inline ml-2" />
            الإعدادات
          </button>
          <button
            onClick={() => setActiveTab("history")}
            className={`flex-1 px-6 py-4 font-bold text-sm transition-all ${
              activeTab === "history"
                ? "text-primary-600 border-b-2 border-primary-600 bg-primary-50/50"
                : "text-gray-600 hover:bg-gray-50"
            }`}
          >
            <Bell size={18} className="inline ml-2" />
            سجل الإشعارات ({notifications.length})
          </button>
          <button
            onClick={() => setActiveTab("test")}
            className={`flex-1 px-6 py-4 font-bold text-sm transition-all ${
              activeTab === "test"
                ? "text-primary-600 border-b-2 border-primary-600 bg-primary-50/50"
                : "text-gray-600 hover:bg-gray-50"
            }`}
          >
            <Send size={18} className="inline ml-2" />
            اختبار الإرسال
          </button>
        </div>
      </div>

      {/* Settings Tab */}
      {activeTab === "settings" && (
        <div className="space-y-6">
          {/* Notification Channels */}
          <div className="bg-white rounded-2xl border border-gray-100 p-6">
            <h3 className="text-lg font-bold text-gray-800 mb-4">قنوات الإشعارات</h3>
            <div className="space-y-4">
              <div className="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div className="flex items-center gap-3">
                  <MessageSquare size={24} className="text-blue-500" />
                  <div>
                    <p className="font-bold text-gray-800">رسائل SMS</p>
                    <p className="text-sm text-gray-500">إرسال رسائل نصية قصيرة</p>
                  </div>
                </div>
                <label className="relative inline-flex items-center cursor-pointer">
                  <input
                    type="checkbox"
                    checked={settings.enableSMS}
                    onChange={(e) => updateSettings({ enableSMS: e.target.checked })}
                    className="sr-only peer"
                  />
                  <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                </label>
              </div>

              <div className="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div className="flex items-center gap-3">
                  <MessageSquare size={24} className="text-green-500" />
                  <div>
                    <p className="font-bold text-gray-800">واتساب</p>
                    <p className="text-sm text-gray-500">إرسال رسائل عبر واتساب</p>
                  </div>
                </div>
                <label className="relative inline-flex items-center cursor-pointer">
                  <input
                    type="checkbox"
                    checked={settings.enableWhatsApp}
                    onChange={(e) => updateSettings({ enableWhatsApp: e.target.checked })}
                    className="sr-only peer"
                  />
                  <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                </label>
              </div>

              <div className="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div className="flex items-center gap-3">
                  <Mail size={24} className="text-purple-500" />
                  <div>
                    <p className="font-bold text-gray-800">البريد الإلكتروني</p>
                    <p className="text-sm text-gray-500">إرسال رسائل بريد إلكتروني</p>
                  </div>
                </div>
                <label className="relative inline-flex items-center cursor-pointer">
                  <input
                    type="checkbox"
                    checked={settings.enableEmail}
                    onChange={(e) => updateSettings({ enableEmail: e.target.checked })}
                    className="sr-only peer"
                  />
                  <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                </label>
              </div>

              <div className="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div className="flex items-center gap-3">
                  <Bell size={24} className="text-orange-500" />
                  <div>
                    <p className="font-bold text-gray-800">إشعارات داخلية</p>
                    <p className="text-sm text-gray-500">إشعارات داخل لوحة التحكم</p>
                  </div>
                </div>
                <label className="relative inline-flex items-center cursor-pointer">
                  <input
                    type="checkbox"
                    checked={settings.enableInternal}
                    onChange={(e) => updateSettings({ enableInternal: e.target.checked })}
                    className="sr-only peer"
                  />
                  <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-600"></div>
                </label>
              </div>
            </div>
          </div>

          {/* Info Box */}
          <div className="bg-blue-50 border border-blue-200 rounded-2xl p-6">
            <h4 className="font-bold text-blue-800 mb-2 flex items-center gap-2">
              <AlertCircle size={20} />
              <span>معلومات مهمة</span>
            </h4>
            <ul className="text-sm text-blue-700 space-y-2">
              <li>• عند تأكيد الحجز، سيتم إرسال إشعار تلقائياً للمريض</li>
              <li>• إذا لم يكن واتساب متاحاً، سيتم إرسال SMS تلقائياً</li>
              <li>• إذا فشل كلاهما، سيتم تسجيل الإشعار كإشعار داخلي</li>
              <li>• يمكنك اختبار الإرسال من تبويب "اختبار الإرسال"</li>
            </ul>
          </div>
        </div>
      )}

      {/* History Tab */}
      {activeTab === "history" && (
        <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
          {notifications.length === 0 ? (
            <div className="p-16 text-center">
              <Bell size={48} className="text-gray-300 mx-auto mb-4" />
              <p className="text-gray-500">لا توجد إشعارات مرسلة</p>
            </div>
          ) : (
            <div className="divide-y divide-gray-100">
              {notifications.map((notif) => (
                <div key={notif.id} className="p-4 hover:bg-gray-50 transition-colors">
                  <div className="flex items-start gap-3">
                    <div className="mt-1">{getTypeIcon(notif.type)}</div>
                    <div className="flex-1 min-w-0">
                      <div className="flex items-center gap-2 mb-1">
                        <p className="font-bold text-gray-800 text-sm">
                          {notif.type === "sms" ? "رسالة SMS" : 
                           notif.type === "whatsapp" ? "رسالة واتساب" :
                           notif.type === "email" ? "بريد إلكتروني" : "إشعار داخلي"}
                        </p>
                        {getStatusIcon(notif.status)}
                        <span className={`text-xs px-2 py-0.5 rounded-full ${
                          notif.status === "delivered" ? "bg-green-100 text-green-700" :
                          notif.status === "failed" ? "bg-red-100 text-red-700" :
                          "bg-yellow-100 text-yellow-700"
                        }`}>
                          {notif.status === "delivered" ? "تم التسليم" :
                           notif.status === "failed" ? "فشل" : "قيد الإرسال"}
                        </span>
                      </div>
                      <p className="text-sm text-gray-600 mb-1">إلى: {notif.recipient}</p>
                      <p className="text-sm text-gray-500 line-clamp-2">{notif.message}</p>
                      <p className="text-xs text-gray-400 mt-2">
                        {new Date(notif.createdAt).toLocaleString("ar-SA")}
                      </p>
                      {notif.errorMessage && (
                        <p className="text-xs text-red-500 mt-1">❌ {notif.errorMessage}</p>
                      )}
                    </div>
                    <button
                      onClick={() => deleteNotification(notif.id)}
                      className="text-red-500 hover:bg-red-50 p-2 rounded-lg transition-colors"
                      title="حذف"
                    >
                      <Trash2 size={16} />
                    </button>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
      )}

      {/* Test Tab */}
      {activeTab === "test" && (
        <div className="bg-white rounded-2xl border border-gray-100 p-6">
          <h3 className="text-lg font-bold text-gray-800 mb-4">اختبار إرسال إشعار</h3>
          
          <div className="space-y-4">
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">نوع الإشعار</label>
              <select
                value={testForm.type}
                onChange={(e) => setTestForm({ ...testForm, type: e.target.value as any })}
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
              >
                <option value="sms">رسالة SMS</option>
                <option value="whatsapp">رسالة واتساب</option>
                <option value="email">بريد إلكتروني</option>
              </select>
            </div>

            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">
                {testForm.type === "email" ? "البريد الإلكتروني" : "رقم الهاتف"}
              </label>
              <input
                type={testForm.type === "email" ? "email" : "tel"}
                value={testForm.recipient}
                onChange={(e) => setTestForm({ ...testForm, recipient: e.target.value })}
                placeholder={testForm.type === "email" ? "example@email.com" : "05xxxxxxxx"}
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500"
              />
            </div>

            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">نص الرسالة</label>
              <textarea
                value={testForm.message}
                onChange={(e) => setTestForm({ ...testForm, message: e.target.value })}
                rows={4}
                className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 resize-none"
              />
            </div>

            <button
              onClick={handleTestSend}
              className="w-full bg-gradient-to-l from-primary-500 to-primary-700 text-white py-3 rounded-xl font-bold hover:shadow-lg transition-all flex items-center justify-center gap-2"
            >
              <Send size={18} />
              <span>إرسال رسالة اختبار</span>
            </button>
          </div>
        </div>
      )}
    </div>
  );
}
