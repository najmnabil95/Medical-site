import { Briefcase } from "lucide-react";
import { useData } from "../../context/DataContext";
import GenericCrud from "../components/GenericCrud";

export default function ServicesPage() {
  const { services, setServices } = useData();
  return (
    <GenericCrud
      title="الخدمات"
      subtitle={`إدارة {count} خدمة`}
      icon={<Briefcase size={26} />}
      items={services}
      setItems={setServices}
      searchFields={["title", "desc"]}
      canToggle
      fields={[
        { name: "title", label: "العنوان", type: "text", placeholder: "خدمة الإسعاف" },
        { name: "desc", label: "الوصف", type: "textarea", placeholder: "وصف الخدمة..." },
        { name: "icon", label: "الأيقونة (Lucide)", type: "text", placeholder: "Ambulance" },
        { name: "color", label: "التدرج اللوني", type: "text", placeholder: "from-red-500 to-rose-600" },
      ]}
    />
  );
}
