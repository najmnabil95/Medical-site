import { Award } from "lucide-react";
import { useData } from "../../context/DataContext";
import GenericCrud from "../components/GenericCrud";

export default function CertificationsPage() {
  const { certifications, setCertifications } = useData();
  return (
    <GenericCrud
      title="الشهادات والاعتمادات"
      subtitle={`إدارة {count} شهادة/اعتماد`}
      icon={<Award size={26} />}
      items={certifications}
      setItems={setCertifications}
      searchFields={["name", "fullName"]}
      fields={[
        { name: "name", label: "الاسم المختصر", type: "text", placeholder: "JCI" },
        { name: "fullName", label: "الاسم الكامل", type: "text", placeholder: "الاعتماد الدولي" },
        { name: "desc", label: "الوصف", type: "textarea", placeholder: "وصف الشهادة..." },
        { name: "year", label: "السنة", type: "text", placeholder: "2024" },
        { name: "icon", label: "الإيموجي", type: "text", placeholder: "🏆" },
        { name: "color", label: "اللون", type: "text", placeholder: "from-amber-500 to-yellow-600" },
      ]}
    />
  );
}
