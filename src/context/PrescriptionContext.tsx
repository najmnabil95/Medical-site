import { createContext, useContext, useState, useEffect, ReactNode } from "react";

export interface PrescriptionMedication {
  name: string;
  dosage: string;
  frequency: string;
  duration: string;
  notes?: string;
}

export interface Prescription {
  id: string;
  patientName: string;
  patientPhone: string;
  patientAge: string;
  doctorName: string;
  doctorSpecialty: string;
  diagnosis: string;
  medications: PrescriptionMedication[];
  notes: string;
  createdAt: string;
  status: 'active' | 'completed' | 'cancelled';
}

interface PrescriptionContextType {
  prescriptions: Prescription[];
  setPrescriptions: (p: Prescription[]) => void;
}

const PrescriptionContext = createContext<PrescriptionContextType | null>(null);

const defaultPrescriptions: Prescription[] = [
  {
    id: "1",
    patientName: "أحمد محمد",
    patientPhone: "0501234567",
    patientAge: "35",
    doctorName: "د. أحمد الراشد",
    doctorSpecialty: "استشاري أمراض القلب",
    diagnosis: "ارتفاع ضغط الدم",
    medications: [
      { name: "Amlodipine", dosage: "5mg", frequency: "مرة يومياً", duration: "30 يوم", notes: "بعد الفطور" },
      { name: "Aspirin", dosage: "81mg", frequency: "مرة يومياً", duration: "30 يوم", notes: "قبل النوم" },
    ],
    notes: "مراجعة بعد أسبوعين مع تحليل ضغط الدم",
    createdAt: new Date().toISOString(),
    status: 'active',
  },
];

function load<T>(key: string, defaultValue: T): T {
  try {
    const stored = localStorage.getItem(key);
    if (stored) return JSON.parse(stored);
  } catch (e) {}
  return defaultValue;
}

function save<T>(key: string, value: T) {
  try {
    localStorage.setItem(key, JSON.stringify(value));
  } catch (e) {}
}

export function PrescriptionProvider({ children }: { children: ReactNode }) {
  const [prescriptions, setPrescriptionsState] = useState<Prescription[]>(() =>
    load("prescriptions", defaultPrescriptions)
  );

  useEffect(() => {
    save("prescriptions", prescriptions);
  }, [prescriptions]);

  return (
    <PrescriptionContext.Provider value={{
      prescriptions,
      setPrescriptions: setPrescriptionsState,
    }}>
      {children}
    </PrescriptionContext.Provider>
  );
}

export function usePrescriptions() {
  const context = useContext(PrescriptionContext);
  if (!context) throw new Error("usePrescriptions must be used within PrescriptionProvider");
  return context;
}
