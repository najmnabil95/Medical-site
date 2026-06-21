import { useState } from "react";
import { Star, Calendar } from "lucide-react";
import { FaLinkedinIn, FaTwitter } from "react-icons/fa";
import SectionHeader from "./SectionHeader";
import { useScrollReveal } from "../hooks/useScrollReveal";
import AppointmentModal from "./AppointmentModal";
import AllDoctorsModal from "./AllDoctorsModal";

const doctors = [
  {
    id: "1",
    name: "د. أحمد الراشد",
    specialty: "استشاري جراحة القلب والأوعية الدموية",
    department: "أمراض القلب",
    image: "https://images.pexels.com/photos/5452224/pexels-photo-5452224.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400",
    rating: 4.9,
    experience: "20 سنة",
    patients: "+5000",
    gradient: "from-red-500 to-rose-600",
  },
  {
    id: "2",
    name: "د. سارة المنصور",
    specialty: "استشارية طب الأطفال وحديثي الولادة",
    department: "طب الأطفال",
    image: "https://images.pexels.com/photos/33032998/pexels-photo-33032998.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400",
    rating: 4.8,
    experience: "15 سنة",
    patients: "+3500",
    gradient: "from-pink-500 to-rose-600",
  },
  {
    id: "3",
    name: "د. خالد العمري",
    specialty: "استشاري جراحة المخ والأعصاب",
    department: "جراحة المخ والأعصاب",
    image: "https://images.pexels.com/photos/14438786/pexels-photo-14438786.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400",
    rating: 4.9,
    experience: "18 سنة",
    patients: "+4200",
    gradient: "from-purple-500 to-violet-600",
  },
  {
    id: "4",
    name: "د. نورة الحربي",
    specialty: "استشارية طب العيون وجراحة الليزر",
    department: "طب العيون",
    image: "https://images.pexels.com/photos/19260195/pexels-photo-19260195.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=400",
    rating: 4.7,
    experience: "12 سنة",
    patients: "+2800",
    gradient: "from-cyan-500 to-teal-600",
  },
];

export default function Doctors() {
  const { ref, isVisible } = useScrollReveal();
  const [appointmentOpen, setAppointmentOpen] = useState(false);
  const [selectedDoctor, setSelectedDoctor] = useState<string>("");
  const [selectedDept, setSelectedDept] = useState<string>("");
  const [allDoctorsOpen, setAllDoctorsOpen] = useState(false);

  const openAppointment = (doctorName: string, deptName?: string) => {
    setSelectedDoctor(doctorName);
    setSelectedDept(deptName || "");
    setAppointmentOpen(true);
  };

  return (
    <section id="doctors" className="py-24 bg-white relative overflow-hidden">
      <div className="absolute top-0 right-0 w-72 h-72 bg-accent-100/30 rounded-full blur-3xl"></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <SectionHeader
          badge="فريقنا الطبي"
          title="نخبة من"
          highlight="أفضل الأطباء"
          description="يضم المستشفى فريقاً طبياً متميزاً من أفضل الاستشاريين والأطباء المتخصصين"
        />

        <div ref={ref} className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
          {doctors.map((doctor, index) => (
            <div
              key={doctor.id || index}
              className={`group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-4 border border-gray-100 ${
                isVisible ? "animate-fade-in-up" : "opacity-0"
              }`}
              style={{ animationDelay: `${index * 150}ms` }}
            >
              {/* Image */}
              <div className="relative overflow-hidden h-72">
                <img
                  src={doctor.image}
                  alt={doctor.name}
                  className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                {/* Gradient Overlay on hover */}
                <div className={`absolute inset-0 bg-gradient-to-t ${doctor.gradient} opacity-0 group-hover:opacity-40 transition-opacity duration-500`}></div>

                {/* Social Links */}
                <div className="absolute top-5 left-5 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 -translate-y-4 group-hover:translate-y-0">
                  <a href="#" target="_blank" rel="noopener noreferrer" onClick={(e) => { e.preventDefault(); e.stopPropagation(); }} className="w-9 h-9 bg-white/90 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-600 hover:text-white transition-colors shadow-lg" title="LinkedIn">
                    <FaLinkedinIn size={14} />
                  </a>
                  <a href="#" target="_blank" rel="noopener noreferrer" onClick={(e) => { e.preventDefault(); e.stopPropagation(); }} className="w-9 h-9 bg-white/90 rounded-full flex items-center justify-center text-primary-600 hover:bg-primary-600 hover:text-white transition-colors shadow-lg" title="Twitter">
                    <FaTwitter size={14} />
                  </a>
                </div>

                {/* Rating */}
                <div className="absolute bottom-5 right-5 bg-white/95 backdrop-blur-sm rounded-full px-3 py-1.5 flex items-center gap-1 shadow-lg">
                  <Star size={14} className="text-yellow-500 fill-yellow-500" />
                  <span className="text-sm font-bold text-gray-800">{doctor.rating}</span>
                </div>
              </div>

              {/* Info */}
              <div className="p-6">
                <h3 className="text-xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors">
                  {doctor.name}
                </h3>
                <p className="text-primary-600 text-sm font-medium mt-1.5">{doctor.specialty}</p>

                <div className="flex items-center justify-between mt-5 pt-5 border-t border-gray-100">
                  <div className="text-center">
                    <div className="text-sm font-bold text-gray-800">{doctor.experience}</div>
                    <div className="text-xs text-gray-400 mt-0.5">خبرة</div>
                  </div>
                  <div className="h-8 w-px bg-gray-200"></div>
                  <div className="text-center">
                    <div className="text-sm font-bold text-gray-800">{doctor.patients}</div>
                    <div className="text-xs text-gray-400 mt-0.5">مريض</div>
                  </div>
                </div>

                <button
                  onClick={(e) => {
                    e.stopPropagation();
                    openAppointment(doctor.name, doctor.department);
                  }}
                  className={`mt-5 w-full bg-gradient-to-l ${doctor.gradient} text-white py-3 rounded-xl font-bold text-sm hover:shadow-lg transition-all flex items-center justify-center gap-2 opacity-90 hover:opacity-100`}
                >
                  <Calendar size={16} />
                  <span>احجز موعد</span>
                </button>
              </div>
            </div>
          ))}
        </div>

        <AppointmentModal
          isOpen={appointmentOpen}
          onClose={() => setAppointmentOpen(false)}
          prefill={{ 
            doctor: selectedDoctor, 
            department: selectedDept,
            locked: true,
          }}
        />

        <AllDoctorsModal
          isOpen={allDoctorsOpen}
          onClose={() => setAllDoctorsOpen(false)}
        />

        <div className="text-center mt-12 flex flex-wrap gap-4 justify-center">
          <a
            href="#/doctors"
            onClick={(e) => {
              e.preventDefault();
              window.location.hash = '#/doctors';
            }}
            className="inline-flex items-center gap-2 bg-gradient-to-l from-primary-500 to-primary-700 text-white px-8 py-3.5 rounded-2xl font-bold hover:shadow-lg hover:shadow-primary-500/30 transition-all hover:-translate-y-0.5"
          >
            <span>عرض جميع الأطباء</span>
            <span>←</span>
          </a>
        </div>
      </div>
    </section>
  );
}
