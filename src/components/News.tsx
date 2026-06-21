import { useState } from "react";
import { Calendar, ArrowLeft, User, Clock } from "lucide-react";
import SectionHeader from "./SectionHeader";
import { useScrollReveal } from "../hooks/useScrollReveal";
import NewsDetailModal from "./NewsDetailModal";

const articles = [
  {
    image: "https://images.pexels.com/photos/24193873/pexels-photo-24193873.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=350&w=550",
    category: "أخبار المستشفى",
    title: "مستشفى الشفاء يحصل على اعتماد JCI الدولي للمرة الثالثة على التوالي",
    excerpt: "حصل المستشفى على تجديد الاعتماد الدولي من الهيئة الدولية لاعتماد المؤسسات الصحية JCI مؤكداً التزامه بأعلى معايير الجودة",
    date: "15 يناير 2024",
    author: "إدارة المستشفى",
    readTime: "5 دقائق",
    categoryColor: "bg-primary-100 text-primary-700",
    featured: true,
  },
  {
    image: "https://images.pexels.com/photos/18112241/pexels-photo-18112241.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=350&w=550",
    category: "تقنية طبية",
    title: "إطلاق أحدث جهاز للتصوير بالرنين المغناطيسي في المنطقة",
    excerpt: "دشن المستشفى أحدث جهاز تصوير بالرنين المغناطيسي 3 تسلا لتشخيص أدق وأسرع",
    date: "8 يناير 2024",
    author: "القسم التقني",
    readTime: "3 دقائق",
    categoryColor: "bg-purple-100 text-purple-700",
    featured: false,
  },
  {
    image: "https://images.pexels.com/photos/15238817/pexels-photo-15238817.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=350&w=550",
    category: "صحة ووقاية",
    title: "نصائح طبية هامة للوقاية من أمراض القلب والشرايين",
    excerpt: "يقدم أطباؤنا مجموعة من النصائح المهمة للحفاظ على صحة القلب والأوعية الدموية",
    date: "3 يناير 2024",
    author: "د. أحمد الراشد",
    readTime: "4 دقائق",
    categoryColor: "bg-accent-100 text-accent-700",
    featured: false,
  },
];

export default function News() {
  const { ref, isVisible } = useScrollReveal();
  const [selectedArticle, setSelectedArticle] = useState<any>(null);

  return (
    <section className="py-24 bg-white relative overflow-hidden">
      <div className="absolute bottom-0 left-0 w-72 h-72 bg-primary-50 rounded-full blur-3xl opacity-50"></div>

      <div className="max-w-7xl mx-auto px-4 relative">
        <SectionHeader
          badge="آخر الأخبار"
          title="أخبار ومقالات"
          highlight="طبية"
          description="تابع آخر أخبار المستشفى والمقالات الطبية التثقيفية"
        />

        <div ref={ref} className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* Featured Article */}
          <div
            className={`lg:row-span-2 group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-gray-100 ${
              isVisible ? "animate-fade-in-up" : "opacity-0"
            }`}
          >
            <div className="relative overflow-hidden h-72 lg:h-80">
              <img
                src={articles[0].image}
                alt={articles[0].title}
                className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
              <div className="absolute top-4 right-4">
                <span className={`${articles[0].categoryColor} text-xs font-bold px-4 py-2 rounded-full`}>
                  {articles[0].category}
                </span>
              </div>
              <div className="absolute bottom-5 right-5 left-5">
                <h3 className="text-white font-bold text-xl leading-relaxed">
                  {articles[0].title}
                </h3>
              </div>
            </div>
            <div className="p-7">
              <div className="flex items-center gap-4 text-gray-400 text-xs mb-4">
                <div className="flex items-center gap-1">
                  <Calendar size={12} />
                  <span>{articles[0].date}</span>
                </div>
                <div className="flex items-center gap-1">
                  <User size={12} />
                  <span>{articles[0].author}</span>
                </div>
                <div className="flex items-center gap-1">
                  <Clock size={12} />
                  <span>{articles[0].readTime}</span>
                </div>
              </div>
              <p className="text-gray-500 text-sm leading-relaxed mb-5">
                {articles[0].excerpt}
              </p>
              <button
                onClick={() => setSelectedArticle(articles[0])}
                className="inline-flex items-center gap-2 text-primary-600 font-bold text-sm hover:gap-4 transition-all group/link"
              >
                <span>اقرأ المقال كاملاً</span>
                <ArrowLeft size={16} className="group-hover/link:-translate-x-1 transition-transform" />
              </button>
            </div>
          </div>

          {/* Other Articles */}
          {articles.slice(1).map((article, index) => (
            <article
              key={index}
              className={`group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-gray-100 flex flex-col ${
                isVisible ? "animate-fade-in-up" : "opacity-0"
              }`}
              style={{ animationDelay: `${(index + 1) * 150}ms` }}
            >
              <div className="relative overflow-hidden h-48">
                <img
                  src={article.image}
                  alt={article.title}
                  className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                />
                <div className="absolute top-4 right-4">
                  <span className={`${article.categoryColor} text-xs font-bold px-3 py-1.5 rounded-full`}>
                    {article.category}
                  </span>
                </div>
              </div>
              <div className="p-6 flex-1 flex flex-col">
                <div className="flex items-center gap-4 text-gray-400 text-xs mb-3">
                  <div className="flex items-center gap-1">
                    <Calendar size={12} />
                    <span>{article.date}</span>
                  </div>
                  <div className="flex items-center gap-1">
                    <Clock size={12} />
                    <span>{article.readTime}</span>
                  </div>
                </div>
                <h3 className="text-lg font-bold text-gray-900 mb-3 group-hover:text-primary-600 transition-colors leading-relaxed line-clamp-2 flex-1">
                  {article.title}
                </h3>
                <button
                  onClick={() => setSelectedArticle(article)}
                  className="inline-flex items-center gap-2 text-primary-600 font-bold text-sm hover:gap-3 transition-all"
                >
                  <span>اقرأ المزيد</span>
                  <ArrowLeft size={16} />
                </button>
              </div>
            </article>
          ))}
        </div>
      </div>

      <NewsDetailModal
        article={selectedArticle}
        onClose={() => setSelectedArticle(null)}
      />
    </section>
  );
}
