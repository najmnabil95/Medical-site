import { useState, useEffect } from "react";
import {
  Phone,
  Mail,
  Clock,
  MapPin,
  Menu,
  X,
  Calendar,
  Moon,
  Sun,
  Bell,
} from "lucide-react";
import { FaFacebookF, FaTwitter, FaInstagram, FaYoutube } from "react-icons/fa";
import { useApp } from "../context/AppContext";
import { useData } from "../context/DataContext";

export default function Navbar() {
  const { screens, publicSiteDarkMode, togglePublicSiteDarkMode, notifications } = useApp();
  const { settings: siteSettings } = useData();
  const [isOpen, setIsOpen] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const [activeSection, setActiveSection] = useState("home");
  const [showNotifications, setShowNotifications] = useState(false);
  
  const unreadNotifications = notifications.filter(n => !n.read).length;

  // تطبيق الوضع الداكن على body
  useEffect(() => {
    if (publicSiteDarkMode) {
      document.body.classList.add("dark-mode");
    } else {
      document.body.classList.remove("dark-mode");
    }
  }, [publicSiteDarkMode]);

  useEffect(() => {
    const handleScroll = () => {
      setScrolled(window.scrollY > 50);

      // Active section detection
      const sections = document.querySelectorAll("section[id]");
      let currentSection = "home";
      sections.forEach((section) => {
        const sectionTop = (section as HTMLElement).offsetTop - 120;
        if (window.scrollY >= sectionTop) {
          currentSection = section.getAttribute("id") || "home";
        }
      });
      setActiveSection(currentSection);
    };
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  // تصفية الروابط بناءً على الشاشات المفعلة
  const navLinks = [
    { name: "الرئيسية", href: "#home", id: "home", component: "Hero" },
    { name: "من نحن", href: "#about", id: "about", component: "About" },
    { name: "الأقسام", href: "#departments", id: "departments", component: "Departments" },
    { name: "أطباؤنا", href: "#doctors", id: "doctors", component: "Doctors" },
    { name: "خدماتنا", href: "#services", id: "services", component: "Services" },
    { name: "آراء المرضى", href: "#testimonials", id: "testimonials", component: "Testimonials" },
    { name: "تواصل معنا", href: "#contact", id: "contact", component: "Contact" },
  ].filter(link => {
    const screen = screens.find(s => s.component === link.component);
    return screen?.enabled !== false; // عرض إذا لم يكن موجوداً أو إذا كان مفعلاً
  });

  const scrollToSection = (e: React.MouseEvent<HTMLAnchorElement>, id: string) => {
    e.preventDefault();
    const element = document.getElementById(id);
    if (element) {
      const offset = 80; // Navbar height
      const elementPosition = element.getBoundingClientRect().top;
      const offsetPosition = elementPosition + window.pageYOffset - offset;
      window.scrollTo({
        top: offsetPosition,
        behavior: "smooth",
      });
    }
    // Close mobile menu if open
    if (isOpen) setIsOpen(false);
  };

  return (
    <>
      {/* Top Bar */}
      <div className="bg-gradient-to-l from-primary-800 to-primary-900 text-white text-sm hidden lg:block">
        <div className="max-w-7xl mx-auto px-4 py-2.5 flex items-center justify-between">
          <div className="flex items-center gap-6">
            <a href="tel:+966123456789" className="flex items-center gap-2 hover:text-accent-400 transition-colors">
              <Phone size={13} />
              <span className="text-xs font-medium">+966 12 345 6789</span>
            </a>
            <div className="w-px h-4 bg-white/20"></div>
            <a href="mailto:info@alshifa-hospital.com" className="flex items-center gap-2 hover:text-accent-400 transition-colors">
              <Mail size={13} />
              <span className="text-xs font-medium">info@alshifa-hospital.com</span>
            </a>
            <div className="w-px h-4 bg-white/20"></div>
            <div className="flex items-center gap-2">
              <Clock size={13} />
              <span className="text-xs font-medium">الطوارئ: 24 ساعة / 7 أيام</span>
            </div>
          </div>
          <div className="flex items-center gap-4">
            <div className="flex items-center gap-2">
              <MapPin size={13} />
              <span className="text-xs font-medium">الرياض، المملكة العربية السعودية</span>
            </div>
            <div className="h-4 w-px bg-white/20"></div>
            <div className="flex items-center gap-2.5">
              {[
                { icon: FaFacebookF, href: "#" },
                { icon: FaTwitter, href: "#" },
                { icon: FaInstagram, href: "#" },
                { icon: FaYoutube, href: "#" },
              ].map((social, i) => (
                <a key={i} href={social.href} className="w-6 h-6 bg-white/10 rounded-md flex items-center justify-center hover:bg-accent-500 transition-all hover:scale-110">
                  <social.icon size={10} />
                </a>
              ))}
            </div>
          </div>
        </div>
      </div>

      {/* Main Navbar */}
      <nav
        className={`sticky top-0 z-50 transition-all duration-500 ${
          scrolled
            ? "bg-white/95 backdrop-blur-xl shadow-lg shadow-black/[0.05] py-0"
            : "bg-white shadow-sm py-0"
        }`}
      >
        <div className="max-w-7xl mx-auto px-4">
          <div className="flex items-center justify-between h-[72px]">
            {/* Logo */}
                <a href="#/" onClick={(e) => { e.preventDefault(); window.location.hash = '#/'; window.location.reload(); }} className="flex items-center gap-3 group cursor-pointer">
                  <div className="w-12 h-12 bg-primary-500 rounded-xl flex items-center justify-center overflow-hidden shadow-lg shadow-primary-500/20 group-hover:shadow-primary-500/40 transition-all group-hover:scale-105">
                    {(siteSettings.logo || "🏥").startsWith("data:") ? (
                      <img src={siteSettings.logo} alt="Logo" className="w-full h-full object-cover" />
                    ) : (
                      <span className="text-2xl">{siteSettings.logo || "🏥"}</span>
                    )}
                  </div>
                  <div>
                    <h1 className="text-lg font-bold text-primary-700 leading-tight group-hover:text-primary-600 transition-colors">{siteSettings.siteName}</h1>
                    <p className="text-[9px] text-gray-400 tracking-[0.15em] font-medium">{siteSettings.siteNameEn}</p>
                  </div>
                </a>

            {/* Desktop Links */}
            <div className="hidden lg:flex items-center gap-0.5">
              {navLinks.map((link) => (
                <a
                  key={link.name}
                  href={link.href}
                  onClick={(e) => scrollToSection(e, link.id)}
                  className={`relative px-3.5 py-2 text-sm font-medium rounded-lg transition-all duration-300 cursor-pointer ${
                    activeSection === link.id
                      ? "text-primary-600 bg-primary-50"
                      : "text-gray-600 hover:text-primary-600 hover:bg-gray-50"
                  }`}
                >
                  {link.name}
                  {activeSection === link.id && (
                    <span className="absolute bottom-0 right-1/2 translate-x-1/2 w-5 h-0.5 bg-primary-500 rounded-full"></span>
                  )}
                </a>
              ))}
            </div>

            {/* CTA */}
            <div className="hidden lg:flex items-center gap-2.5">
              {/* Notifications */}
              <div className="relative">
                <button
                  onClick={() => setShowNotifications(!showNotifications)}
                  className="relative flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50 rounded-lg transition-all"
                  title="الإشعارات"
                >
                  <Bell size={18} />
                  {unreadNotifications > 0 && (
                    <span className="absolute top-1 left-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">
                      {unreadNotifications > 9 ? '9+' : unreadNotifications}
                    </span>
                  )}
                </button>

                {/* Notifications Dropdown */}
                {showNotifications && (
                  <>
                    <div 
                      className="fixed inset-0 z-40" 
                      onClick={() => setShowNotifications(false)}
                    />
                    <div className="absolute left-0 top-full mt-2 w-80 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                      <div className="bg-gradient-to-l from-primary-500 to-primary-600 text-white px-4 py-3">
                        <h3 className="font-bold">الإشعارات</h3>
                        <p className="text-xs text-white/70">{unreadNotifications} إشعار غير مقروء</p>
                      </div>
                      <div className="max-h-96 overflow-y-auto">
                        {notifications.length === 0 ? (
                          <div className="p-8 text-center text-gray-400">
                            <Bell size={48} className="mx-auto mb-2 opacity-30" />
                            <p>لا توجد إشعارات</p>
                          </div>
                        ) : (
                          notifications.slice(0, 10).map((notif) => (
                            <div
                              key={notif.id}
                              className={`p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors ${
                                !notif.read ? 'bg-blue-50/50' : ''
                              }`}
                            >
                              <div className="flex items-start gap-3">
                                <div className={`w-8 h-8 rounded-full flex items-center justify-center shrink-0 ${
                                  notif.type === 'success' ? 'bg-green-100 text-green-600' :
                                  notif.type === 'warning' ? 'bg-yellow-100 text-yellow-600' :
                                  'bg-blue-100 text-blue-600'
                                }`}>
                                  {notif.type === 'success' ? '✓' : notif.type === 'warning' ? '⚠' : 'ℹ'}
                                </div>
                                <div className="flex-1 min-w-0">
                                  <p className="text-sm font-medium text-gray-800 line-clamp-2">{notif.message}</p>
                                  <p className="text-xs text-gray-400 mt-1">
                                    {new Date(notif.time).toLocaleDateString('ar-SA')}
                                  </p>
                                </div>
                                {!notif.read && (
                                  <div className="w-2 h-2 bg-blue-500 rounded-full shrink-0 mt-2" />
                                )}
                              </div>
                            </div>
                          ))
                        )}
                      </div>
                    </div>
                  </>
                )}
              </div>

              {/* Dark Mode Toggle */}
              <button
                onClick={togglePublicSiteDarkMode}
                className="flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50 rounded-lg transition-all"
                title={publicSiteDarkMode ? "الوضع النهاري" : "الوضع الليلي"}
              >
                {publicSiteDarkMode ? <Sun size={18} /> : <Moon size={18} />}
              </button>
              
              <a
                href="#/admin/login"
                className="flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-600 hover:text-primary-600 hover:bg-gray-50 rounded-lg transition-colors"
                title="لوحة التحكم"
                onClick={(e) => {
                  e.preventDefault();
                  window.location.hash = '#/admin/login';
                }}
              >
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                  <rect x="3" y="3" width="7" height="9" />
                  <rect x="14" y="3" width="7" height="5" />
                  <rect x="14" y="12" width="7" height="9" />
                  <rect x="3" y="16" width="7" height="5" />
                </svg>
                <span>لوحة التحكم</span>
              </a>
              <a
                href="#appointment"
                onClick={(e) => scrollToSection(e, "appointment")}
                className="group bg-gradient-to-l from-primary-500 to-primary-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:shadow-lg hover:shadow-primary-500/25 transition-all duration-300 hover:-translate-y-0.5 flex items-center gap-2 cursor-pointer"
              >
                <Calendar size={15} />
                <span>احجز موعدك</span>
              </a>
              <a
                href="tel:920012345"
                className="relative bg-red-500 text-white px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-red-600 transition-all flex items-center gap-2 group"
              >
                <Phone size={15} className="animate-bounce-gentle" />
                <span>الطوارئ</span>
                {/* Pulse Ring */}
                <span className="absolute -top-1 -left-1 w-3 h-3">
                  <span className="absolute inset-0 bg-red-400 rounded-full animate-ping opacity-50"></span>
                  <span className="absolute inset-0.5 bg-red-500 rounded-full"></span>
                </span>
              </a>
            </div>

            {/* Mobile Menu Button */}
            <button
              onClick={() => setIsOpen(!isOpen)}
              className="lg:hidden w-10 h-10 flex items-center justify-center text-gray-700 hover:bg-gray-100 rounded-xl transition-colors"
            >
              {isOpen ? <X size={22} /> : <Menu size={22} />}
            </button>
          </div>
        </div>

        {/* Mobile Menu */}
        <div
          className={`lg:hidden transition-all duration-400 ${
            isOpen ? "max-h-[600px] opacity-100" : "max-h-0 opacity-0"
          } overflow-hidden`}
        >
          <div className="px-4 py-5 bg-white border-t border-gray-100 space-y-1 shadow-xl">
            {navLinks.map((link) => (
              <a
                key={link.name}
                href={link.href}
                onClick={(e) => scrollToSection(e, link.id)}
                className={`block px-4 py-3 rounded-xl transition-all font-medium text-sm cursor-pointer ${
                  activeSection === link.id
                    ? "text-primary-600 bg-primary-50 font-bold"
                    : "text-gray-600 hover:text-primary-600 hover:bg-gray-50"
                }`}
              >
                {link.name}
              </a>
            ))}
            <div className="pt-4 grid grid-cols-2 gap-3">
              <a
                href="#appointment"
                onClick={(e) => scrollToSection(e, "appointment")}
                className="bg-gradient-to-l from-primary-500 to-primary-700 text-white py-3 rounded-xl text-center font-bold text-sm flex items-center justify-center gap-2 cursor-pointer"
              >
                <Calendar size={16} />
                <span>احجز موعدك</span>
              </a>
              <a
                href="tel:920012345"
                className="bg-red-500 text-white py-3 rounded-xl text-center font-bold text-sm flex items-center justify-center gap-2"
              >
                <Phone size={16} />
                <span>الطوارئ</span>
              </a>
            </div>
          </div>
        </div>
      </nav>
    </>
  );
}
