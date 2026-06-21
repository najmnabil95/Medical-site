import { Handshake } from "lucide-react";
import { useData } from "../../context/DataContext";
import GenericCrud from "../components/GenericCrud";

export default function PartnersPage() {
  const { partners, setPartners } = useData();
  return (
    <GenericCrud
      title="الشركاء والاعتمادات"
      subtitle={`إدارة {count} شريك/اعتماد`}
      icon={<Handshake size={26} />}
      items={partners}
      setItems={setPartners}
      searchFields={["name", "sub"]}
      fields={[
        { name: "name", label: "الاسم", type: "text", placeholder: "JCI" },
        { name: "sub", label: "الوصف المختصر", type: "text", placeholder: "الاعتماد الدولي" },
        { name: "emoji", label: "الإيموجي", type: "text", placeholder: "🏆" },
      ]}
    />
  );
}
