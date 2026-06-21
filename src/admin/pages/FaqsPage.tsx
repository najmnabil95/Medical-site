import { HelpCircle } from "lucide-react";
import { useData } from "../../context/DataContext";
import GenericCrud from "../components/GenericCrud";

export default function FaqsPage() {
  const { faqs, setFaqs } = useData();
  return (
    <GenericCrud
      title="الأسئلة الشائعة"
      subtitle={`إدارة {count} سؤال شائع`}
      icon={<HelpCircle size={26} />}
      items={faqs}
      setItems={setFaqs}
      searchFields={["question", "answer"]}
      fields={[
        { name: "question", label: "السؤال", type: "text", placeholder: "ما هي ساعات العمل؟" },
        { name: "answer", label: "الإجابة", type: "textarea", placeholder: "إجابة مفصلة..." },
      ]}
    />
  );
}
