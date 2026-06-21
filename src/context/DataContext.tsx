import { createContext, useContext, useState, useEffect, ReactNode } from "react";

// Types
export interface Department {
  id: string;
  icon: string;
  name: string;
  desc: string;
  color: string;
  active: boolean;
}

export interface Doctor {
  id: string;
  name: string;
  specialty: string;
  image: string;
  rating: number;
  experience: string;
  patients: string;
  gradient: string;
  active: boolean;
}

export interface PriceItem {
  id: string;
  service: string; // اسم الخدمة
  category: string; // التصنيف (استشارة، عملية، تحليل، أشعة...)
  price: number; // السعر الأدنى
  priceTo?: number; // السعر الأعلى (اختياري)
  currency: string; // العملة (ر.س)
  duration?: string; // المدة (اختياري)
  description?: string; // الوصف (اختياري)
  active: boolean;
}

export interface Service {
  id: string;
  icon: string;
  title: string;
  desc: string;
  color: string;
  number: string;
  active: boolean;
}

export interface Package {
  id: string;
  name: string;
  nameEn: string;
  price: string;
  period: string;
  icon: string;
  popular: boolean;
  gradient: string;
  features: string[];
  active: boolean;
}

export interface Testimonial {
  id: string;
  name: string;
  role: string;
  text: string;
  rating: number;
  avatar: string;
  color: string;
}

export interface News {
  id: string;
  image: string;
  category: string;
  title: string;
  excerpt: string;
  date: string;
  author: string;
  readTime: string;
  categoryColor: string;
  featured: boolean;
}

export interface FAQ {
  id: string;
  question: string;
  answer: string;
}

export interface Insurance {
  id: string;
  name: string;
  abbr: string;
  active: boolean;
}

export interface Partner {
  id: string;
  name: string;
  sub: string;
  emoji: string;
}

export interface Certification {
  id: string;
  icon: string;
  name: string;
  fullName: string;
  desc: string;
  year: string;
  color: string;
  border: string;
  bg: string;
}

export interface SiteSettings {
  siteName: string;
  siteNameEn: string;
  phone: string;
  phoneEn: string;
  email: string;
  address: string;
  city: string;
  emergency: string;
  whatsapp: string;
  facebook: string;
  twitter: string;
  instagram: string;
  youtube: string;
  linkedin: string;
  snapchat: string;
}

import { User } from "../utils/roles";

interface DataContextType {
  // Data
  departments: Department[];
  doctors: Doctor[];
  services: Service[];
  packages: Package[];
  testimonials: Testimonial[];
  news: News[];
  faqs: FAQ[];
  insurances: Insurance[];
  partners: Partner[];
  certifications: Certification[];
  settings: SiteSettings;
  users: User[];
  currentUser: User | null;
  prices: PriceItem[];

  // Actions
  setDepartments: (d: Department[]) => void;
  setDoctors: (d: Doctor[]) => void;
  setServices: (d: Service[]) => void;
  setPackages: (d: Package[]) => void;
  setTestimonials: (d: Testimonial[]) => void;
  setNews: (d: News[]) => void;
  setFaqs: (d: FAQ[]) => void;
  setInsurances: (d: Insurance[]) => void;
  setPartners: (d: Partner[]) => void;
  setCertifications: (d: Certification[]) => void;
  setSettings: (d: SiteSettings) => void;
  setUsers: (u: User[]) => void;
  setPrices: (p: PriceItem[]) => void;

  // Auth
  isAuthenticated: boolean;
  login: (username: string, password: string) => boolean;
  logout: () => void;
}

const DataContext = createContext<DataContextType | null>(null);

// Default Data
const defaultDepartments: Department[] = [
  { id: "1", icon: "Heart", name: "أمراض القلب", desc: "تشخيص وعلاج أمراض القلب والأوعية الدموية بأحدث التقنيات وقسطرة القلب", color: "from-red-500 to-rose-600", active: true },
  { id: "2", icon: "Brain", name: "جراحة المخ والأعصاب", desc: "علاج أمراض الدماغ والجهاز العصبي المركزي والطرفي بدقة متناهية", color: "from-purple-500 to-violet-600", active: true },
  { id: "3", icon: "Bone", name: "جراحة العظام", desc: "علاج الإصابات والكسور وتبديل المفاصل وجراحات العمود الفقري", color: "from-amber-500 to-orange-600", active: true },
  { id: "4", icon: "Baby", name: "طب الأطفال", desc: "رعاية صحية متكاملة للأطفال وحديثي الولادة والخدج بأحدث الحضانات", color: "from-pink-500 to-rose-600", active: true },
  { id: "5", icon: "Eye", name: "طب العيون", desc: "تصحيح النظر بالليزك وعلاج أمراض العيون وزراعة القرنية", color: "from-cyan-500 to-teal-600", active: true },
  { id: "6", icon: "Stethoscope", name: "الطب الباطني", desc: "تشخيص وعلاج أمراض الجهاز الهضمي والكبد والغدد الصماء", color: "from-blue-500 to-indigo-600", active: true },
];

export interface Doctor {
  id: string;
  name: string;
  specialty: string;
  department: string;
  image: string;
  rating: number;
  experience: string;
  patients: string;
  gradient: string;
  active: boolean;
}

const defaultDoctors: Doctor[] = [
  { id: "1", name: "د. أحمد الراشد", specialty: "استشاري جراحة القلب والأوعية الدموية", department: "أمراض القلب", image: "https://images.pexels.com/photos/5452224/pexels-photo-5452224.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400", rating: 4.9, experience: "20 سنة", patients: "+5000", gradient: "from-red-500 to-rose-600", active: true },
  { id: "2", name: "د. سارة المنصور", specialty: "استشارية طب الأطفال وحديثي الولادة", department: "طب الأطفال", image: "https://images.pexels.com/photos/33032998/pexels-photo-33032998.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400", rating: 4.8, experience: "15 سنة", patients: "+3500", gradient: "from-pink-500 to-rose-600", active: true },
  { id: "3", name: "د. خالد العمري", specialty: "استشاري جراحة المخ والأعصاب", department: "جراحة المخ والأعصاب", image: "https://images.pexels.com/photos/14438786/pexels-photo-14438786.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400", rating: 4.9, experience: "18 سنة", patients: "+4200", gradient: "from-purple-500 to-violet-600", active: true },
  { id: "4", name: "د. نورة الحربي", specialty: "استشارية طب العيون وجراحة الليزر", department: "طب العيون", image: "https://images.pexels.com/photos/19260195/pexels-photo-19260195.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400", rating: 4.7, experience: "12 سنة", patients: "+2800", gradient: "from-cyan-500 to-teal-600", active: true },
];

const defaultServices: Service[] = [
  { id: "1", icon: "Ambulance", title: "خدمة الإسعاف", desc: "سيارات إسعاف مجهزة بأحدث المعدات الطبية للنقل الآمن والسريع", color: "from-red-500 to-rose-600", number: "01", active: true },
  { id: "2", icon: "Clock", title: "طوارئ 24/7", desc: "قسم طوارئ يعمل على مدار الساعة بفريق طبي متخصص ومؤهل", color: "from-orange-500 to-amber-600", number: "02", active: true },
  { id: "3", icon: "FlaskConical", title: "مختبرات متقدمة", desc: "تحاليل طبية شاملة بأحدث الأجهزة ونتائج دقيقة وسريعة", color: "from-blue-500 to-indigo-600", number: "03", active: true },
  { id: "4", icon: "Scan", title: "الأشعة والتصوير", desc: "أجهزة تصوير متطورة تشمل الرنين المغناطيسي والأشعة المقطعية", color: "from-purple-500 to-violet-600", number: "04", active: true },
];

const defaultPackages: Package[] = [
  { id: "1", name: "الباقة الأساسية", nameEn: "Basic", price: "500", period: "سنوياً", icon: "🩺", popular: false, gradient: "from-gray-600 to-gray-800", features: ["كشف طبي شامل سنوي", "تحاليل دم أساسية", "أشعة صدر"], active: true },
  { id: "2", name: "الباقة الذهبية", nameEn: "Gold", price: "1,500", period: "سنوياً", icon: "👑", popular: true, gradient: "from-amber-500 to-yellow-600", features: ["كشف طبي شامل مرتين سنوياً", "تحاليل دم شاملة", "خصم 25%"], active: true },
  { id: "3", name: "الباقة البلاتينية", nameEn: "Platinum", price: "3,000", period: "سنوياً", icon: "💎", popular: false, gradient: "from-violet-600 to-purple-800", features: ["كشف طبي شامل 4 مرات", "جميع التحاليل", "خصم 40%"], active: true },
];

const defaultTestimonials: Testimonial[] = [
  { id: "1", name: "محمد بن عبدالله", role: "مريض - جراحة القلب", text: "تجربة رائعة في مستشفى الشفاء. الفريق الطبي كان محترفاً للغاية.", rating: 5, avatar: "م", color: "from-primary-500 to-primary-600" },
  { id: "2", name: "فاطمة الزهراء", role: "مريضة - طب العيون", text: "أجريت عملية تصحيح النظر بالليزر وكانت النتائج مذهلة.", rating: 5, avatar: "ف", color: "from-accent-500 to-accent-600" },
  { id: "3", name: "عبدالرحمن السعيد", role: "مريض - جراحة العظام", text: "الفريق الطبي في مستشفى الشفاء أعاد لي الثقة وتعافيت بشكل كامل.", rating: 5, avatar: "ع", color: "from-purple-500 to-violet-600" },
];

const defaultNews: News[] = [
  { id: "1", image: "https://images.pexels.com/photos/24193873/pexels-photo-24193873.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=350&w=550", category: "أخبار المستشفى", title: "مستشفى الشفاء يحصل على اعتماد JCI الدولي", excerpt: "حصل المستشفى على تجديد الاعتماد الدولي", date: "15 يناير 2024", author: "إدارة المستشفى", readTime: "5 دقائق", categoryColor: "bg-primary-100 text-primary-700", featured: true },
  { id: "2", image: "https://images.pexels.com/photos/18112241/pexels-photo-18112241.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=350&w=550", category: "تقنية طبية", title: "إطلاق أحدث جهاز للتصوير بالرنين المغناطيسي", excerpt: "دشن المستشفى أحدث جهاز تصوير بالرنين", date: "8 يناير 2024", author: "القسم التقني", readTime: "3 دقائق", categoryColor: "bg-purple-100 text-purple-700", featured: false },
];

const defaultFaqs: FAQ[] = [
  { id: "1", question: "ما هي ساعات عمل المستشفى؟", answer: "يعمل المستشفى من السبت إلى الخميس من الساعة 8 صباحاً حتى 10 مساءً." },
  { id: "2", question: "كيف يمكنني حجز موعد مع طبيب؟", answer: "يمكنك حجز موعد عبر النموذج الإلكتروني أو الاتصال بنا على الرقم 920012345." },
  { id: "3", question: "هل يقبل المستشفى جميع شركات التأمين؟", answer: "نتعامل مع أكثر من 25 شركة تأمين طبي معتمدة." },
];

const defaultInsurances: Insurance[] = [
  { id: "1", name: "بوبا العربية", abbr: "BUPA", active: true },
  { id: "2", name: "التعاونية", abbr: "TAWU", active: true },
  { id: "3", name: "ميدغلف", abbr: "MEDG", active: true },
  { id: "4", name: "الراجحي تكافل", abbr: "RAJH", active: true },
];

const defaultPartners: Partner[] = [
  { id: "1", name: "JCI", sub: "الاعتماد الدولي", emoji: "🏆" },
  { id: "2", name: "WHO", sub: "منظمة الصحة العالمية", emoji: "🌍" },
  { id: "3", name: "CBAHI", sub: "المجلس المركزي", emoji: "🏛️" },
];

const defaultCertifications: Certification[] = [
  { id: "1", icon: "🏆", name: "JCI", fullName: "الاعتماد الدولي", desc: "حاصلون على اعتماد الهيئة الدولية", year: "2024", color: "from-amber-500 to-yellow-600", border: "border-amber-200", bg: "bg-amber-50" },
  { id: "2", icon: "🌟", name: "CBAHI", fullName: "المجلس المركزي", desc: "اعتماد المجلس المركزي", year: "2024", color: "from-blue-500 to-indigo-600", border: "border-blue-200", bg: "bg-blue-50" },
];

const defaultSettings: SiteSettings = {
  siteName: "مستشفى الشفاء",
  siteNameEn: "AL-SHIFA INTERNATIONAL HOSPITAL",
  phone: "+966 12 345 6789",
  phoneEn: "920012345",
  email: "info@alshifa-hospital.com",
  address: "طريق الملك فهد",
  city: "الرياض، المملكة العربية السعودية",
  emergency: "920012345",
  whatsapp: "966123456789",
  facebook: "#",
  twitter: "#",
  instagram: "#",
  youtube: "#",
  linkedin: "#",
  snapchat: "#",
};

// Helper: Load from localStorage
function load<T>(key: string, defaultValue: T): T {
  try {
    const stored = localStorage.getItem(key);
    if (stored) return JSON.parse(stored);
  } catch (e) {
    console.error(`Error loading ${key}:`, e);
  }
  return defaultValue;
}

// Helper: Save to localStorage
function save<T>(key: string, value: T) {
  try {
    localStorage.setItem(key, JSON.stringify(value));
  } catch (e) {
    console.error(`Error saving ${key}:`, e);
  }
}

const defaultUsers: User[] = [
  // المدير
  { id: "1", username: "admin", password: "admin123", role: "admin", name: "مدير النظام", email: "admin@alshifa-hospital.com", phone: "+966 50 123 4567", active: true, createdAt: new Date().toISOString() },
  
  // الأطباء
  { id: "2", username: "ahmed.rashed", password: "doctor123", role: "doctor", name: "د. أحمد الراشد", email: "ahmed.rashed@alshifa-hospital.com", phone: "+966 50 111 2222", active: true, assignedDepartments: ["أمراض القلب"], createdAt: new Date().toISOString() },
  { id: "3", username: "sara.mansour", password: "doctor123", role: "doctor", name: "د. سارة المنصور", email: "sara.mansour@alshifa-hospital.com", phone: "+966 50 222 3333", active: true, assignedDepartments: ["طب الأطفال"], createdAt: new Date().toISOString() },
  { id: "4", username: "khalid.omari", password: "doctor123", role: "doctor", name: "د. خالد العمري", email: "khalid.omari@alshifa-hospital.com", phone: "+966 50 333 4444", active: true, assignedDepartments: ["جراحة المخ والأعصاب"], createdAt: new Date().toISOString() },
  
  // الممرضون
  { id: "5", username: "nurse.fatima", password: "nurse123", role: "nurse", name: "فاطمة الزهراء", email: "fatima@alshifa-hospital.com", phone: "+966 50 444 5555", active: true, assignedDepartments: ["أمراض القلب", "طب الأطفال"], assignedDoctors: ["د. أحمد الراشد", "د. سارة المنصور"], createdAt: new Date().toISOString() },
  { id: "6", username: "nurse.mohammed", password: "nurse123", role: "nurse", name: "محمد السعيد", email: "mohammed@alshifa-hospital.com", phone: "+966 50 555 6666", active: true, assignedDepartments: ["جراحة المخ والأعصاب"], assignedDoctors: ["د. خالد العمري"], createdAt: new Date().toISOString() },
  
  // موظفو الاستقبال
  { id: "7", username: "reception.noura", password: "reception123", role: "reception", name: "نورة القحطاني", email: "noura@alshifa-hospital.com", phone: "+966 50 666 7777", active: true, createdAt: new Date().toISOString() },
  
  // المحاسبون
  { id: "8", username: "accountant.fahad", password: "accountant123", role: "accountant", name: "فهد العتيبي", email: "fahad@alshifa-hospital.com", phone: "+966 50 777 8888", active: true, createdAt: new Date().toISOString() },
];

const defaultPrices: PriceItem[] = [
  { id: "1", service: "استشارة عامة", category: "استشارة", price: 100, currency: "ر.س", duration: "30 دقيقة", active: true },
  { id: "2", service: "استشارة متخصصة", category: "استشارة", price: 200, currency: "ر.س", duration: "30 دقيقة", active: true },
  { id: "3", service: "استشارة استشاري", category: "استشارة", price: 300, currency: "ر.س", duration: "45 دقيقة", active: true },
  { id: "4", service: "فحص دم شامل", category: "تحليل", price: 150, currency: "ر.س", active: true },
  { id: "5", service: "تحليل سكر تراكمي", category: "تحليل", price: 80, currency: "ر.س", active: true },
  { id: "6", service: "أشعة سينية", category: "أشعة", price: 120, currency: "ر.س", active: true },
  { id: "7", service: "أشعة مقطعية", category: "أشعة", price: 800, currency: "ر.س", duration: "20 دقيقة", active: true },
  { id: "8", service: "رنين مغناطيسي", category: "أشعة", price: 1500, currency: "ر.س", duration: "45 دقيقة", active: true },
  { id: "9", service: "عملية جراحية بسيطة", category: "جراحة", price: 5000, currency: "ر.س", active: true },
  { id: "10", service: "عملية جراحية معقدة", category: "جراحة", price: 15000, currency: "ر.س", active: true },
];

export function DataProvider({ children }: { children: ReactNode }) {
  const [departments, setDepartmentsState] = useState<Department[]>(() => load("departments", defaultDepartments));
  const [doctors, setDoctorsState] = useState<Doctor[]>(() => load("doctors", defaultDoctors));
  const [services, setServicesState] = useState<Service[]>(() => load("services", defaultServices));
  const [packages, setPackagesState] = useState<Package[]>(() => load("packages", defaultPackages));
  const [testimonials, setTestimonialsState] = useState<Testimonial[]>(() => load("testimonials", defaultTestimonials));
  const [news, setNewsState] = useState<News[]>(() => load("news", defaultNews));
  const [faqs, setFaqsState] = useState<FAQ[]>(() => load("faqs", defaultFaqs));
  const [insurances, setInsurancesState] = useState<Insurance[]>(() => load("insurances", defaultInsurances));
  const [partners, setPartnersState] = useState<Partner[]>(() => load("partners", defaultPartners));
  const [certifications, setCertificationsState] = useState<Certification[]>(() => load("certifications", defaultCertifications));
  const [settings, setSettingsState] = useState<SiteSettings>(() => load("settings", defaultSettings));
  const [users, setUsersState] = useState<User[]>(() => load("users", defaultUsers));
  const [currentUser, setCurrentUser] = useState<User | null>(() => load("currentUser", null));
  const [isAuthenticated, setIsAuthenticated] = useState<boolean>(() => load("isAuthenticated", false));
  const [prices, setPricesState] = useState<PriceItem[]>(() => load("prices", defaultPrices));

  // Auto-save to localStorage
  useEffect(() => { save("departments", departments); }, [departments]);
  useEffect(() => { save("doctors", doctors); }, [doctors]);
  useEffect(() => { save("services", services); }, [services]);
  useEffect(() => { save("packages", packages); }, [packages]);
  useEffect(() => { save("testimonials", testimonials); }, [testimonials]);
  useEffect(() => { save("news", news); }, [news]);
  useEffect(() => { save("faqs", faqs); }, [faqs]);
  useEffect(() => { save("insurances", insurances); }, [insurances]);
  useEffect(() => { save("partners", partners); }, [partners]);
  useEffect(() => { save("certifications", certifications); }, [certifications]);
  useEffect(() => { save("settings", settings); }, [settings]);
  useEffect(() => { save("users", users); }, [users]);
  useEffect(() => { save("isAuthenticated", isAuthenticated); }, [isAuthenticated]);
  useEffect(() => { save("currentUser", currentUser); }, [currentUser]);
  useEffect(() => { save("prices", prices); }, [prices]);

  const login = (username: string, password: string): boolean => {
    const user = users.find((u: User) => 
      u.username === username && 
      u.password === password && 
      u.active !== false
    );
    
    if (user) {
      setCurrentUser(user);
      setIsAuthenticated(true);
      return true;
    }
    return false;
  };

  const logout = () => {
    setIsAuthenticated(false);
    setCurrentUser(null);
  };

  return (
    <DataContext.Provider
      value={{
        departments,
        doctors,
        services,
        packages,
        testimonials,
        news,
        faqs,
        insurances,
        partners,
        certifications,
        settings,
        users,
        currentUser,
        prices,
        setDepartments: setDepartmentsState,
        setDoctors: setDoctorsState,
        setServices: setServicesState,
        setPackages: setPackagesState,
        setTestimonials: setTestimonialsState,
        setNews: setNewsState,
        setFaqs: setFaqsState,
        setInsurances: setInsurancesState,
        setPartners: setPartnersState,
        setCertifications: setCertificationsState,
        setSettings: setSettingsState,
        setUsers: setUsersState,
        setPrices: setPricesState,
        isAuthenticated,
        login,
        logout,
      }}
    >
      {children}
    </DataContext.Provider>
  );
}

export function useData() {
  const context = useContext(DataContext);
  if (!context) throw new Error("useData must be used within DataProvider");
  return context;
}
