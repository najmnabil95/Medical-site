import { useState } from "react";
import { Mail, Search, Eye, Trash2, Reply, CheckCircle, Inbox, Filter } from "lucide-react";
import { useApp, Message } from "../../context/AppContext";
import PageHeader from "../components/PageHeader";
import Modal from "../components/Modal";
import ConfirmDialog from "../components/ConfirmDialog";
import { useToast } from "../components/Toast";

const STATUS_CONFIG = {
  new: { label: "جديد", color: "bg-blue-100 text-blue-700" },
  read: { label: "مقروء", color: "bg-gray-100 text-gray-700" },
  replied: { label: "تم الرد", color: "bg-green-100 text-green-700" },
};

export default function MessagesPage() {
  const { messages, setMessages } = useApp();
  const { toast } = useToast();
  const [search, setSearch] = useState("");
  const [statusFilter, setStatusFilter] = useState<string>("all");
  const [viewModalOpen, setViewModalOpen] = useState(false);
  const [replyModalOpen, setReplyModalOpen] = useState(false);
  const [viewingItem, setViewingItem] = useState<Message | null>(null);
  const [deleteId, setDeleteId] = useState<string | null>(null);
  const [replyText, setReplyText] = useState("");

  const filtered = messages.filter((m) => {
    const matchesSearch = m.name.includes(search) || m.email.includes(search) || m.subject.includes(search);
    const matchesStatus = statusFilter === "all" || m.status === statusFilter;
    return matchesSearch && matchesStatus;
  });

  const stats = {
    total: messages.length,
    new: messages.filter(m => m.status === "new").length,
    read: messages.filter(m => m.status === "read").length,
    replied: messages.filter(m => m.status === "replied").length,
  };

  const openView = (msg: Message) => {
    setViewingItem(msg);
    setViewModalOpen(true);
    if (msg.status === "new") {
      setMessages(messages.map((m) => m.id === msg.id ? { ...m, status: "read" } : m));
    }
  };

  const openReply = (msg: Message) => {
    setViewingItem(msg);
    setReplyText(msg.reply || "");
    setReplyModalOpen(true);
  };

  const handleSubmitReply = (e: React.FormEvent) => {
    e.preventDefault();
    if (viewingItem) {
      setMessages(messages.map((m) => m.id === viewingItem.id ? { ...m, reply: replyText, status: "replied" } : m));
      toast("success", "تم إرسال الرد بنجاح");
      setReplyModalOpen(false);
    }
  };

  const handleDelete = () => {
    if (deleteId) {
      setMessages(messages.filter((m) => m.id !== deleteId));
      toast("success", "تم حذف الرسالة بنجاح");
      setDeleteId(null);
    }
  };

  const updateStatus = (id: string, status: Message["status"]) => {
    setMessages(messages.map((m) => m.id === id ? { ...m, status } : m));
    toast("success", "تم تحديث حالة الرسالة");
  };

  return (
    <div>
      <PageHeader
        title="الرسائل والاستفسارات"
        subtitle={`${stats.total} رسالة | ${stats.new} جديد`}
        icon={<Mail size={26} />}
      />

      {/* Stats */}
      <div className="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div className="bg-white rounded-xl p-4 border border-gray-100">
          <p className="text-xs text-gray-500 mb-1">الإجمالي</p>
          <p className="text-2xl font-black text-gray-800">{stats.total}</p>
        </div>
        <div className="bg-blue-50 rounded-xl p-4 border border-blue-100">
          <p className="text-xs text-blue-600 mb-1">جديدة</p>
          <p className="text-2xl font-black text-blue-700">{stats.new}</p>
        </div>
        <div className="bg-gray-50 rounded-xl p-4 border border-gray-200">
          <p className="text-xs text-gray-600 mb-1">مقروءة</p>
          <p className="text-2xl font-black text-gray-700">{stats.read}</p>
        </div>
        <div className="bg-green-50 rounded-xl p-4 border border-green-100">
          <p className="text-xs text-green-600 mb-1">تم الرد</p>
          <p className="text-2xl font-black text-green-700">{stats.replied}</p>
        </div>
      </div>

      {/* Filters */}
      <div className="bg-white rounded-2xl p-4 mb-6 border border-gray-100 flex flex-col md:flex-row gap-3">
        <div className="flex-1 flex items-center gap-2 bg-gray-50 px-4 py-2.5 rounded-xl border border-gray-100">
          <Search size={16} className="text-gray-400" />
          <input type="text" placeholder="بحث..." value={search} onChange={(e) => setSearch(e.target.value)} className="bg-transparent outline-none flex-1 text-sm" />
        </div>
        <div className="flex items-center gap-2 bg-gray-50 rounded-xl p-1 border border-gray-100">
          <Filter size={16} className="text-gray-400 mr-2" />
          {[
            { value: "all", label: "الكل" },
            { value: "new", label: "جديد" },
            { value: "read", label: "مقروء" },
            { value: "replied", label: "تم الرد" },
          ].map((f) => (
            <button key={f.value} onClick={() => setStatusFilter(f.value)} className={`px-3 py-1.5 text-xs font-bold rounded-lg transition-all ${statusFilter === f.value ? "bg-primary-500 text-white shadow-md" : "text-gray-600 hover:bg-gray-200"}`}>
              {f.label}
            </button>
          ))}
        </div>
      </div>

      {/* Messages List */}
      <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden divide-y divide-gray-100">
        {filtered.map((msg) => (
          <div key={msg.id} className={`p-5 hover:bg-gray-50/50 transition-colors ${msg.status === "new" ? "bg-blue-50/30" : ""}`}>
            <div className="flex items-start gap-4">
              <div className={`w-10 h-10 rounded-xl flex items-center justify-center shrink-0 ${
                msg.status === "new" ? "bg-blue-500 text-white" : "bg-gray-200 text-gray-600"
              }`}>
                {msg.status === "new" ? <Inbox size={18} /> : <Mail size={18} />}
              </div>
              <div className="flex-1 min-w-0">
                <div className="flex items-start justify-between gap-4 mb-2">
                  <div>
                    <h4 className="font-bold text-gray-800">{msg.subject}</h4>
                    <p className="text-sm text-gray-500 mt-0.5">
                      من: <span className="font-medium text-gray-700">{msg.name}</span> ({msg.email})
                    </p>
                  </div>
                  <span className={`px-2.5 py-0.5 rounded-full text-xs font-bold whitespace-nowrap ${STATUS_CONFIG[msg.status].color}`}>
                    {STATUS_CONFIG[msg.status].label}
                  </span>
                </div>
                <p className="text-sm text-gray-600 line-clamp-2 mb-3">{msg.message}</p>
                <div className="flex items-center gap-2">
                  <button onClick={() => openView(msg)} className="px-3 py-1.5 bg-gray-100 text-gray-600 rounded-lg text-xs font-bold hover:bg-gray-200 flex items-center gap-1">
                    <Eye size={12} /> عرض
                  </button>
                  <button onClick={() => openReply(msg)} className="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 flex items-center gap-1">
                    <Reply size={12} /> رد
                  </button>
                  {msg.status === "new" && (
                    <button onClick={() => updateStatus(msg.id, "read")} className="px-3 py-1.5 bg-green-50 text-green-600 rounded-lg text-xs font-bold hover:bg-green-100 flex items-center gap-1">
                      <CheckCircle size={12} /> تحديد كمقروء
                    </button>
                  )}
                  <button onClick={() => setDeleteId(msg.id)} className="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 flex items-center gap-1">
                    <Trash2 size={12} /> حذف
                  </button>
                </div>
              </div>
            </div>
          </div>
        ))}

        {filtered.length === 0 && (
          <div className="py-16 text-center">
            <Mail size={48} className="text-gray-300 mx-auto mb-4" />
            <p className="text-gray-500">لا توجد رسائل</p>
          </div>
        )}
      </div>

      {/* View Modal */}
      <Modal isOpen={viewModalOpen} onClose={() => setViewModalOpen(false)} title="تفاصيل الرسالة" size="md">
        {viewingItem && (
          <div className="space-y-4">
            <div className="bg-gray-50 rounded-xl p-5">
              <div className="mb-4">
                <p className="text-xs text-gray-500 mb-1">الموضوع</p>
                <p className="font-bold text-gray-800 text-lg">{viewingItem.subject}</p>
              </div>
              <div className="grid grid-cols-2 gap-3 mb-4">
                <div>
                  <p className="text-xs text-gray-500 mb-1">الاسم</p>
                  <p className="font-bold text-gray-800">{viewingItem.name}</p>
                </div>
                <div>
                  <p className="text-xs text-gray-500 mb-1">البريد</p>
                  <p className="font-bold text-gray-800" dir="ltr">{viewingItem.email}</p>
                </div>
              </div>
              <div>
                <p className="text-xs text-gray-500 mb-1">الرسالة</p>
                <p className="text-gray-700 leading-relaxed">{viewingItem.message}</p>
              </div>
              {viewingItem.reply && (
                <div className="mt-4 pt-4 border-t border-gray-200">
                  <p className="text-xs text-gray-500 mb-1">الرد</p>
                  <p className="text-green-700 leading-relaxed bg-green-50 p-3 rounded-lg">{viewingItem.reply}</p>
                </div>
              )}
            </div>
            <div className="flex items-center gap-2">
              <button onClick={() => { setViewModalOpen(false); openReply(viewingItem); }} className="flex-1 py-2.5 bg-blue-500 text-white rounded-xl text-sm font-bold hover:bg-blue-600 flex items-center justify-center gap-2">
                <Reply size={16} /> الرد على الرسالة
              </button>
              <button onClick={() => setViewModalOpen(false)} className="flex-1 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-200">إغلاق</button>
            </div>
          </div>
        )}
      </Modal>

      {/* Reply Modal */}
      <Modal isOpen={replyModalOpen} onClose={() => setReplyModalOpen(false)} title="الرد على الرسالة" size="md">
        {viewingItem && (
          <form onSubmit={handleSubmitReply} className="space-y-4">
            <div className="bg-gray-50 rounded-xl p-4">
              <p className="text-xs text-gray-500 mb-1">إلى:</p>
              <p className="font-bold text-gray-800">{viewingItem.name} ({viewingItem.email})</p>
              <p className="text-xs text-gray-500 mt-2 mb-1">الموضوع:</p>
              <p className="font-bold text-gray-800">{viewingItem.subject}</p>
            </div>
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-2">نص الرد</label>
              <textarea value={replyText} onChange={(e) => setReplyText(e.target.value)} required rows={6} className="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary-500 resize-none" placeholder="اكتب ردك هنا..." />
            </div>
            <div className="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
              <button type="button" onClick={() => setReplyModalOpen(false)} className="px-6 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-xl">إلغاء</button>
              <button type="submit" className="px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-l from-primary-500 to-primary-700 rounded-xl">إرسال الرد</button>
            </div>
          </form>
        )}
      </Modal>

      <ConfirmDialog isOpen={!!deleteId} onClose={() => setDeleteId(null)} onConfirm={handleDelete} title="حذف الرسالة" message="هل أنت متأكد من حذف هذه الرسالة؟" confirmText="نعم، احذف" />
    </div>
  );
}
