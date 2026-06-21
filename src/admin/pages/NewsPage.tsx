import { Newspaper } from "lucide-react";
import { useData } from "../../context/DataContext";
import GenericCrud from "../components/GenericCrud";

export default function NewsPage() {
  const { news, setNews } = useData();
  return (
    <GenericCrud
      title="الأخبار والمقالات"
      subtitle={`إدارة {count} خبر ومقال`}
      icon={<Newspaper size={26} />}
      items={news}
      setItems={setNews}
      searchFields={["title", "category", "author"]}
      fields={[
        { name: "title", label: "العنوان", type: "text", placeholder: "عنوان الخبر" },
        { name: "category", label: "التصنيف", type: "text", placeholder: "أخبار المستشفى" },
        { name: "excerpt", label: "المقتطف", type: "textarea", placeholder: "مقتطف مختصر..." },
        { name: "image", label: "رابط الصورة", type: "url", placeholder: "https://..." },
        { name: "author", label: "الكاتب", type: "text", placeholder: "اسم الكاتب" },
        { name: "date", label: "التاريخ", type: "text", placeholder: "15 يناير 2024" },
        { name: "readTime", label: "وقت القراءة", type: "text", placeholder: "5 دقائق" },
      ]}
    />
  );
}
