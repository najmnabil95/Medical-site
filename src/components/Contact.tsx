import { MapPin, Phone, Mail, Clock, Send, CheckCircle } from "lucide-react";
import { FaWhatsapp } from "react-icons/fa";
import SectionHeader from "./SectionHeader";
import { useScrollReveal } from "../hooks/useScrollReveal";
import { useState } from "react";
import { useApp } from "../context/AppContext";
import { useToast } from "../admin/components/Toast";
import useSiteSettings from "../hooks/useSiteSettings";

export default function Contact() {
  const { ref, isVisible } = useScrollReveal();
  const { messages, setMessages } = useApp();
  const { toast } = useToast();
  const [sent, setSent] = useState(false);
  const [msgForm, setMsgForm] = useState({ name: "", email: "", subject: "", message: "" });
  const siteSettings = useSiteSettings();

  const contactInfo = [
    {
      icon: MapPin,
      title: "العنوان",
      details: [siteSettings.address],
      color: "from-blue-500 to-indigo-600",
    },
    {
      icon: Phone,
      title: "الهاتف",
      details: [siteSettings.phone],
      color: "from-emerald-500 to-teal-600",
    },
    {
      icon: Mail,
      title: "البريد الإلكتروني",
      details: [siteSettings.email],
      color: "from-purple-500 to-violet-600",
    },
    {
      icon: Clock,
      title: "ساعات العمل",
      details: ["السبت - الخميس: 8 ص - 10 م", "الطوارئ: 24 ساعة / 7 أيام"],
      color: "from-orange-500 to-amber-600",
    },
  ];

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const newMessage = {
      id: Date.now().toString(),
      ...msgForm,
      status: "new" as const,
      createdAt: new Date().toISOString(),
    };
    setMessages([newMessage, ...messages]);
    toast("success", "تم إرسال رسالتك بنجاح! سنرد عليك في أقرب وقت");
    setSent(true);
    setTimeout(() => {
      setSent(false);
      setMsgForm({ name: "", email: "", subject: "", message: "" });
    }, 3000);
  };

  return (
    <section id="contact" className="py-24 bg-gray-50 relative overflow-hidden">
      <div className="absolute top-0 right-0 w-80 h-80 bg-primary-100/30 rounded-full blur-3xl"></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <SectionHeader
          badge="تواصل معنا"
          title="نحن هنا"
          highlight="لمساعدتك"
          description="لا تتردد في التواصل معنا لأي استفسار أو للحصول على المساعدة"
        />

        {/* Contact Cards */}
        <div ref={ref} className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
          {contactInfo.map((info, index) => (
            <div
              key={index}
              className={`bg-white rounded-2xl p-7 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-500 hover:-translate-y-3 group text-center ${
                isVisible ? "animate-fade-in-up" : "opacity-0"
              }`}
              style={{ animationDelay: `${index * 100}ms` }}
            >
              <div
                className={`w-16 h-16 bg-gradient-to-br ${info.color} rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 group-hover:rotate-6 transition-all duration-300`}
              >
                <info.icon className="text-white" size={26} />
              </div>
              <h4 className="text-lg font-bold text-gray-900 mb-3">{info.title}</h4>
              {info.details.map((detail, i) => (
                <p key={i} className="text-gray-500 text-sm leading-relaxed">
                  {detail}
                </p>
              ))}
            </div>
          ))}
        </div>

        {/* Map and Form */}
        <div className="grid lg:grid-cols-2 gap-8">
          {/* Map */}
          <div className="bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 h-[550px] relative">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3624.6554095118836!2d46.6752957!3d24.7135517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f03890d489399%3A0xba974d1c98e79fd5!2z2KfZhNix2YrYp9i2!5e0!3m2!1sar!2ssa!4v1690000000000"
              width="100%"
              height="100%"
              style={{ border: 0 }}
              allowFullScreen
              loading="lazy"
              referrerPolicy="no-referrer-when-downgrade"
              title="موقع المستشفى"
            ></iframe>
             <div className="absolute bottom-6 right-6 bg-white rounded-2xl p-4 shadow-xl flex items-center gap-3">
              <div className="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center">
                <MapPin className="text-white" size={20} />
              </div>
              <div>
                <p className="font-bold text-gray-900 text-sm">{siteSettings.siteName}</p>
                <p className="text-gray-500 text-xs">{siteSettings.address}</p>
              </div>
            </div>
          </div>

          {/* Quick Contact Form */}
          <div className="bg-white rounded-3xl p-8 md:p-10 shadow-xl border border-gray-100">
            {sent ? (
              <div className="h-full flex flex-col items-center justify-center text-center space-y-4 py-16">
                <div className="w-20 h-20 bg-accent-100 rounded-full flex items-center justify-center animate-scale-in">
                  <CheckCircle className="text-accent-500" size={40} />
                </div>
                <h3 className="text-2xl font-bold text-gray-900">تم الإرسال بنجاح! 🎉</h3>
                <p className="text-gray-500">سنتواصل معك في أقرب وقت ممكن</p>
              </div>
            ) : (
              <>
                <h3 className="text-2xl font-bold text-gray-900 mb-2">أرسل لنا رسالة</h3>
                <p className="text-gray-500 mb-8">سنرد عليك في أقرب وقت ممكن</p>

                <form className="space-y-5" onSubmit={handleSubmit}>
                  <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <input
                      type="text"
                      value={msgForm.name}
                      onChange={(e) => setMsgForm({ ...msgForm, name: e.target.value })}
                      placeholder="الاسم الكامل"
                      required
                      className="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm"
                    />
                    <input
                      type="email"
                      value={msgForm.email}
                      onChange={(e) => setMsgForm({ ...msgForm, email: e.target.value })}
                      placeholder="البريد الإلكتروني"
                      required
                      className="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm"
                    />
                  </div>
                  <input
                    type="text"
                    value={msgForm.subject}
                    onChange={(e) => setMsgForm({ ...msgForm, subject: e.target.value })}
                    placeholder="الموضوع"
                    required
                    className="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm"
                  />
                  <textarea
                    value={msgForm.message}
                    onChange={(e) => setMsgForm({ ...msgForm, message: e.target.value })}
                    placeholder="رسالتك"
                    rows={5}
                    required
                    className="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20 focus:bg-white transition-all text-sm resize-none"
                  ></textarea>
                  <button
                    type="submit"
                    className="w-full bg-gradient-to-l from-primary-500 to-primary-700 text-white py-4.5 rounded-xl font-bold text-lg hover:shadow-xl hover:shadow-primary-500/30 transition-all hover:-translate-y-1 flex items-center justify-center gap-3"
                  >
                    <Send size={20} />
                    <span>إرسال الرسالة</span>
                  </button>
                </form>

                {/* WhatsApp */}
                <div className="mt-8 text-center">
                  <div className="flex items-center gap-3 mb-4">
                    <span className="flex-1 h-px bg-gray-200"></span>
                    <span className="text-gray-400 text-sm">أو تواصل معنا عبر</span>
                    <span className="flex-1 h-px bg-gray-200"></span>
                  </div>
                   <a
                    href={`https://wa.me/${siteSettings.phone.replace(/[^0-9]/g, "")}?text=مرحباً، أريد الاستفسار عن خدمات المستشفى`}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="inline-flex items-center gap-3 bg-green-500 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-green-600 transition-all hover:shadow-lg hover:shadow-green-500/30 hover:-translate-y-0.5"
                  >
                    <FaWhatsapp size={22} />
                    <span>تواصل عبر واتساب</span>
                  </a>
                </div>
              </>
            )}
          </div>
        </div>
      </div>
    </section>
  );
}
