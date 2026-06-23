import { useState } from "react";
import { Phone, Mail, MapPin, Heart } from "lucide-react";
import { FaFacebookF, FaTwitter, FaInstagram, FaYoutube, FaLinkedinIn, FaSnapchatGhost } from "react-icons/fa";
import LegalModal from "./LegalModal";
import { createScrollHandler } from "../utils/scroll";
import { useApp } from "../context/AppContext";
import useSiteSettings from "../hooks/useSiteSettings";

const handleScrollToDepartments = createScrollHandler("departments");

export default function Footer() {
  const { screens } = useApp();
  const [legalType, setLegalType] = useState<"privacy" | "terms" | null>(null);
  const siteSettings = useSiteSettings();

  // تصفية الروابط السريعة بناءً على الشاشات المفعلة
  const quickLinks = [
    { name: "الرئيسية", href: "#home", component: "Hero" },
    { name: "من نحن", href: "#about", component: "About" },
    { name: "الأقسام الطبية", href: "#departments", component: "Departments" },
    { name: "فريقنا الطبي", href: "#doctors", component: "Doctors" },
    { name: "خدماتنا", href: "#services", component: "Services" },
    { name: "حجز موعد", href: "#appointment", component: "Appointment" },
    { name: "تواصل معنا", href: "#contact", component: "Contact" },
  ].filter(link => {
    const screen = screens.find(s => s.component === link.component);
    return screen?.enabled !== false;
  });

  // التحقق من تفعيل قسم الأقسام الطبية
  const departmentsEnabled = screens.find(s => s.component === "Departments")?.enabled !== false;

  return (
    <footer className="bg-gray-900 text-white relative">
      {/* Pre Footer CTA */}
      <div className="bg-gradient-to-l from-primary-600 to-primary-800 relative overflow-hidden">
        <div className="absolute inset-0 opacity-10" style={{
          backgroundImage: `radial-gradient(circle, white 1px, transparent 1px)`,
          backgroundSize: '20px 20px'
        }}></div>
        <div className="max-w-7xl mx-auto px-4 py-14 relative">
          <div className="flex flex-col md:flex-row items-center justify-between gap-8">
            <div>
              <h3 className="text-2xl md:text-3xl font-black">هل تحتاج إلى استشارة طبية؟</h3>
              <p className="text-white/60 mt-3 text-lg">فريقنا الطبي جاهز لمساعدتك على مدار الساعة</p>
            </div>
            <div className="flex gap-4">
              <a
                href="#appointment"
                onClick={createScrollHandler("appointment")}
                className="bg-white text-primary-700 px-8 py-4 rounded-2xl font-bold hover:bg-gray-100 transition-all hover:-translate-y-1 shadow-lg text-lg cursor-pointer"
              >
                احجز موعدك
              </a>
              <a
                href="tel:920012345"
                className="bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-2xl font-bold hover:bg-white/20 transition-all border border-white/20 flex items-center gap-3 text-lg"
              >
                <Phone size={20} />
                <span>اتصل بنا</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      {/* Main Footer */}
      <div className="max-w-7xl mx-auto px-4 py-20">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
          {/* About */}
          <div className="lg:col-span-1">
            <div className="flex items-center gap-3 mb-6">
              <div className="w-[52px] h-[52px] bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg overflow-hidden">
                {siteSettings.logo.startsWith("data:") ? (
                  <img src={siteSettings.logo} alt="Logo" className="w-full h-full object-cover" />
                ) : (
                  <span className="text-white text-xl">{siteSettings.logo}</span>
                )}
              </div>
              <div>
                <h4 className="text-xl font-bold">{siteSettings.siteName}</h4>
                <p className="text-xs text-gray-500 tracking-wider uppercase">{siteSettings.siteNameEn}</p>
              </div>
            </div>
            <p className="text-gray-400 leading-relaxed text-sm mb-6">
              {siteSettings.description}
            </p>
            <div className="flex items-center gap-2">
              {[
                { icon: FaFacebookF, href: "#" },
                { icon: FaTwitter, href: "#" },
                { icon: FaInstagram, href: "#" },
                { icon: FaYoutube, href: "#" },
                { icon: FaLinkedinIn, href: "#" },
                { icon: FaSnapchatGhost, href: "#" },
              ].map((social, i) => (
                <a
                  key={i}
                  href={social.href}
                  className="w-10 h-10 bg-white/[0.05] rounded-xl flex items-center justify-center text-gray-400 hover:bg-primary-600 hover:text-white transition-all duration-300 hover:-translate-y-1"
                >
                  <social.icon size={15} />
                </a>
              ))}
            </div>
          </div>

          {/* Quick Links */}
          {quickLinks.length > 0 && (
            <div>
              <h4 className="text-lg font-bold mb-6 relative pb-3">
                روابط سريعة
                <span className="absolute bottom-0 right-0 w-12 h-1 bg-gradient-to-l from-primary-500 to-accent-500 rounded-full"></span>
              </h4>
              <ul className="space-y-3">
                {quickLinks.map((link, i) => (
                  <li key={i}>
                    <a
                      href={link.href}
                      onClick={createScrollHandler(link.href.replace('#', ''))}
                      className="text-gray-400 hover:text-accent-400 transition-colors text-sm flex items-center gap-2 group cursor-pointer"
                    >
                      <span className="w-1.5 h-1.5 bg-primary-600 rounded-full group-hover:bg-accent-400 transition-colors"></span>
                      {link.name}
                    </a>
                  </li>
                ))}
              </ul>
            </div>
          )}

          {/* Departments */}
          {departmentsEnabled && (
            <div>
              <h4 className="text-lg font-bold mb-6 relative pb-3">
                أقسامنا
                <span className="absolute bottom-0 right-0 w-12 h-1 bg-gradient-to-l from-primary-500 to-accent-500 rounded-full"></span>
              </h4>
              <ul className="space-y-3">
                {[
                  "أمراض القلب",
                  "جراحة المخ والأعصاب",
                  "جراحة العظام",
                  "طب الأطفال",
                  "طب العيون",
                  "الطب الباطني",
                  "الطوارئ والإسعاف",
                ].map((dept, i) => (
                  <li key={i}>
                    <a
                      href="#departments"
                      onClick={handleScrollToDepartments}
                      className="text-gray-400 hover:text-accent-400 transition-colors text-sm flex items-center gap-2 group cursor-pointer"
                    >
                      <span className="w-1.5 h-1.5 bg-accent-600 rounded-full group-hover:bg-accent-400 transition-colors"></span>
                      {dept}
                    </a>
                  </li>
                ))}
              </ul>
            </div>
          )}

          {/* Contact */}
          <div>
            <h4 className="text-lg font-bold mb-6 relative pb-3">
              معلومات التواصل
              <span className="absolute bottom-0 right-0 w-12 h-1 bg-gradient-to-l from-primary-500 to-accent-500 rounded-full"></span>
            </h4>
            <div className="space-y-4">
              <div className="flex items-start gap-3">
                <div className="w-10 h-10 bg-white/[0.05] rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                  <MapPin className="text-primary-400" size={18} />
                </div>
                <div>
                  <p className="text-gray-400 text-sm">{siteSettings.address}</p>
                </div>
              </div>
              <div className="flex items-center gap-3">
                <div className="w-10 h-10 bg-white/[0.05] rounded-lg flex items-center justify-center shrink-0">
                  <Phone className="text-primary-400" size={18} />
                </div>
                <a href={`tel:${siteSettings.phone}`} className="text-gray-400 text-sm hover:text-accent-400 transition-colors" dir="ltr">
                  {siteSettings.phone}
                </a>
              </div>
              <div className="flex items-center gap-3">
                <div className="w-10 h-10 bg-white/[0.05] rounded-lg flex items-center justify-center shrink-0">
                  <Mail className="text-primary-400" size={18} />
                </div>
                <a href={`mailto:${siteSettings.email}`} className="text-gray-400 text-sm hover:text-accent-400 transition-colors">
                  {siteSettings.email}
                </a>
              </div>
            </div>

            {/* Newsletter */}
            <div className="mt-8 bg-white/[0.03] rounded-2xl p-5 border border-white/[0.05]">
              <p className="text-sm font-bold mb-3">📧 اشترك في النشرة البريدية</p>
              <div className="flex gap-2">
                <input
                  type="email"
                  placeholder="بريدك الإلكتروني"
                  className="flex-1 px-4 py-3 bg-white/[0.05] border border-white/10 rounded-xl text-sm focus:outline-none focus:border-primary-500 transition-colors placeholder:text-gray-600"
                />
                <button className="bg-gradient-to-l from-primary-500 to-primary-600 text-white px-4 py-3 rounded-xl hover:shadow-lg hover:shadow-primary-500/30 transition-all">
                  <Mail size={18} />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Bottom Bar */}
      <div className="border-t border-white/[0.05]">
        <div className="max-w-7xl mx-auto px-4 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
          <p className="text-gray-500 text-sm flex items-center gap-1">
            © 2024 {siteSettings.siteName}. جميع الحقوق محفوظة. صنع بـ
            <Heart size={14} className="text-red-500 fill-red-500 mx-1" />
          </p>
          <div className="flex items-center gap-6 text-gray-500 text-sm">
            <button onClick={() => setLegalType("privacy")} className="hover:text-accent-400 transition-colors cursor-pointer">سياسة الخصوصية</button>
            <span className="w-1 h-1 bg-gray-700 rounded-full"></span>
            <button onClick={() => setLegalType("terms")} className="hover:text-accent-400 transition-colors cursor-pointer">الشروط والأحكام</button>
            <span className="w-1 h-1 bg-gray-700 rounded-full"></span>
            <a href="#/admin/login" className="hover:text-accent-400 transition-colors" onClick={(e) => { e.preventDefault(); window.location.hash = '#/admin/login'; }}>لوحة التحكم</a>
          </div>
        </div>
      </div>

      {legalType && (
        <LegalModal
          type={legalType}
          onClose={() => setLegalType(null)}
        />
      )}
    </footer>
  );
}
