import { useState } from "react";
import { X, Search, Star, Calendar, Award, Users } from "lucide-react";
import AppointmentModal from "./AppointmentModal";
import { useData } from "../context/DataContext";

interface AllDoctorsModalProps {
  isOpen: boolean;
  onClose: () => void;
}

export default function AllDoctorsModal({ isOpen, onClose }: AllDoctorsModalProps) {
  const { doctors } = useData();
  const [search, setSearch] = useState("");
  const [appointmentOpen, setAppointmentOpen] = useState(false);
  const [selectedDoctor, setSelectedDoctor] = useState("");

  const filtered = doctors.filter(d =>
    d.name.includes(search) || d.specialty.includes(search)
  );

  const [selectedDept, setSelectedDept] = useState("");

  const openAppointment = (name: string, dept: string) => {
    setSelectedDoctor(name);
    setSelectedDept(dept);
    setAppointmentOpen(true);
  };

  if (!isOpen) return null;

  return (
    <>
      <div className="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div className="fixed inset-0 bg-black/70 backdrop-blur-sm" onClick={onClose}></div>
        <div className="relative bg-white rounded-3xl shadow-2xl w-full max-w-6xl max-h-[90vh] overflow-hidden animate-scale-in">
          {/* Header */}
          <div className="sticky top-0 bg-gradient-to-l from-primary-600 to-primary-800 text-white px-6 py-5 z-10">
            <button
              onClick={onClose}
              className="absolute top-4 left-4 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-white hover:bg-white/30"
            >
              <X size={20} />
            </button>
            <div className="flex items-center gap-3">
              <div className="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <Users size={24} />
              </div>
              <div>
                <h3 className="text-2xl font-bold">جميع أطبائنا المتميزين</h3>
                <p className="text-sm text-white/70">{filtered.length} طبيب واستشاري</p>
              </div>
            </div>
          </div>

          {/* Search */}
          <div className="p-6 border-b border-gray-100 bg-gray-50">
            <div className="flex items-center gap-2 bg-white px-4 py-3 rounded-xl border border-gray-200 max-w-md">
              <Search size={18} className="text-gray-400" />
              <input
                type="text"
                placeholder="ابحث بالاسم أو التخصص..."
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                className="bg-transparent outline-none flex-1 text-sm"
              />
            </div>
          </div>

          {/* Grid */}
          <div className="p-6 overflow-y-auto max-h-[60vh]">
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
              {filtered.map((doctor, index) => (
                <div
                  key={index}
                  className="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl transition-all hover:-translate-y-1"
                >
                  <div className="relative h-48 overflow-hidden">
                    <img
                      src={doctor.image}
                      alt={doctor.name}
                      className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                    />
                    <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div className={`absolute inset-0 bg-gradient-to-t ${doctor.gradient} opacity-0 group-hover:opacity-40 transition-opacity`}></div>
                    <div className="absolute bottom-3 right-3 bg-white/95 backdrop-blur-sm rounded-full px-2.5 py-1 flex items-center gap-1">
                      <Star size={12} className="text-yellow-500 fill-yellow-500" />
                      <span className="text-xs font-bold text-gray-800">{doctor.rating}</span>
                    </div>
                  </div>
                  <div className="p-4">
                    <h4 className="font-bold text-gray-900 mb-1">{doctor.name}</h4>
                    <p className="text-xs text-primary-600 font-medium mb-3 line-clamp-2">{doctor.specialty}</p>
                    <div className="flex items-center justify-between text-xs text-gray-500 mb-3">
                      <span className="flex items-center gap-1">
                        <Award size={12} />
                        {doctor.experience}
                      </span>
                      <span className="flex items-center gap-1">
                        <Users size={12} />
                        {doctor.patients} مريض
                      </span>
                    </div>
                    <button
                      onClick={() => openAppointment(doctor.name, doctor.department)}
                      className={`w-full bg-gradient-to-l ${doctor.gradient} text-white py-2 rounded-lg text-xs font-bold hover:shadow-lg transition-all flex items-center justify-center gap-1`}
                    >
                      <Calendar size={14} />
                      <span>احجز موعد</span>
                    </button>
                  </div>
                </div>
              ))}
            </div>

            {filtered.length === 0 && (
              <div className="py-16 text-center">
                <Users size={48} className="text-gray-300 mx-auto mb-4" />
                <p className="text-gray-500">لا يوجد أطباء مطابقون للبحث</p>
              </div>
            )}
          </div>
        </div>
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
    </>
  );
}
