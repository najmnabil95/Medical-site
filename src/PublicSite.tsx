import { useApp } from "./context/AppContext";
import Navbar from "./components/Navbar";
import NewsTicker from "./components/NewsTicker";
import Hero from "./components/Hero";
import About from "./components/About";
import WhyChooseUs from "./components/WhyChooseUs";
import Stats from "./components/Stats";
import Departments from "./components/Departments";
import Doctors from "./components/Doctors";
import Services from "./components/Services";
import Telemedicine from "./components/Telemedicine";
import VideoSection from "./components/VideoSection";
import Gallery from "./components/Gallery";
import Testimonials from "./components/Testimonials";
import Offers from "./components/Offers";
import HomeCare from "./components/HomeCare";
import CostCalculator from "./components/CostCalculator";
import MedicalTourism from "./components/MedicalTourism";
import CTASection from "./components/CTASection";
import CookieBanner from "./components/CookieBanner";
import PremiumPackages from "./components/PremiumPackages";
import Appointment from "./components/Appointment";
import Timeline from "./components/Timeline";
import Certifications from "./components/Certifications";
import Insurance from "./components/Insurance";
import MobileApp from "./components/MobileApp";
import News from "./components/News";
import FAQ from "./components/FAQ";
import Partners from "./components/Partners";
import Contact from "./components/Contact";
import Footer from "./components/Footer";
import WhatsAppFloat from "./components/WhatsAppFloat";
import ScrollProgress from "./components/ScrollProgress";

// خريطة المكونات حسب اسم المكون
const componentMap: Record<string, React.ComponentType> = {
  Hero,
  About,
  WhyChooseUs,
  Stats,
  Departments,
  Doctors,
  Services,
  Telemedicine,
  VideoSection,
  Gallery,
  Testimonials,
  Offers,
  HomeCare,
  CostCalculator,
  MedicalTourism,
  CTASection,
  PremiumPackages,
  Appointment,
  Timeline,
  Certifications,
  Insurance,
  MobileApp,
  News,
  FAQ,
  Partners,
  Contact,
};

export default function PublicSite() {
  const { screens } = useApp();

  // ترتيب الشاشات المفعلة حسب الترتيب
  const enabledScreens = screens
    .filter(screen => screen.enabled)
    .sort((a, b) => a.order - b.order);

  return (
    <div className="min-h-screen bg-white font-tajawal" dir="rtl">
      <ScrollProgress />
      <Navbar />
      <NewsTicker />

      {/* عرض الشاشات المفعلة حسب الترتيب */}
      {enabledScreens.map(screen => {
        const Component = componentMap[screen.component];
        if (!Component) return null;
        return <Component key={screen.id} />;
      })}

      <Footer />
      <WhatsAppFloat />
      <CookieBanner />
    </div>
  );
}
