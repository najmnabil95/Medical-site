import { Shield } from "lucide-react";
import { useData } from "../../context/DataContext";
import GenericCrud from "../components/GenericCrud";

export default function InsurancePage() {
  const { insurances, setInsurances } = useData();
  return (
    <GenericCrud
      title="شركات التأمين"
      subtitle={`إدارة {count} شركة تأمين معتمدة`}
      icon={<Shield size={26} />}
      items={insurances}
      setItems={setInsurances}
      searchFields={["name", "abbr"]}
      canToggle
      fields={[
        { name: "name", label: "اسم الشركة", type: "text", placeholder: "بوبا العربية" },
        { name: "abbr", label: "الاختصار", type: "text", placeholder: "BUPA" },
      ]}
    />
  );
}
