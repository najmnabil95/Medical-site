import { useState } from "react";
import { X, ZoomIn, ChevronLeft, ChevronRight } from "lucide-react";
import SectionHeader from "./SectionHeader";
import { useScrollReveal } from "../hooks/useScrollReveal";

const galleryImages = [
  {
    src: "https://images.pexels.com/photos/18112241/pexels-photo-18112241.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700",
    title: "غرفة العمليات",
    category: "المرافق",
  },
  {
    src: "https://images.pexels.com/photos/33216715/pexels-photo-33216715.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700",
    title: "قسم الأشعة",
    category: "الأجهزة",
  },
  {
    src: "https://images.pexels.com/photos/20081928/pexels-photo-20081928.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700",
    title: "فريق الجراحة",
    category: "الفريق الطبي",
  },
  {
    src: "https://images.pexels.com/photos/33216690/pexels-photo-33216690.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700",
    title: "غرف العلاج",
    category: "المرافق",
  },
  {
    src: "https://images.pexels.com/photos/4769133/pexels-photo-4769133.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700",
    title: "أثناء العملية",
    category: "الفريق الطبي",
  },
  {
    src: "https://images.pexels.com/photos/24193873/pexels-photo-24193873.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700",
    title: "الأدوات الجراحية",
    category: "الأجهزة",
  },
  {
    src: "https://images.pexels.com/photos/31836902/pexels-photo-31836902.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700",
    title: "مبنى المستشفى",
    category: "المرافق",
  },
  {
    src: "https://images.pexels.com/photos/15238817/pexels-photo-15238817.jpeg?auto=compress&cs=tinysrgb&fit=crop&h=500&w=700",
    title: "الطاقم الطبي",
    category: "الفريق الطبي",
  },
];

const categories = ["الكل", "المرافق", "الأجهزة", "الفريق الطبي"];

export default function Gallery() {
  const [filter, setFilter] = useState("الكل");
  const [lightbox, setLightbox] = useState<number | null>(null);
  const { ref, isVisible } = useScrollReveal();

  const filtered = filter === "الكل" ? galleryImages : galleryImages.filter(img => img.category === filter);

  const openLightbox = (index: number) => setLightbox(index);
  const closeLightbox = () => setLightbox(null);
  const nextImage = () => {
    if (lightbox !== null) setLightbox((lightbox + 1) % filtered.length);
  };
  const prevImage = () => {
    if (lightbox !== null) setLightbox((lightbox - 1 + filtered.length) % filtered.length);
  };

  return (
    <section className="py-24 bg-white relative">
      <div className="max-w-7xl mx-auto px-4">
        <SectionHeader
          badge="معرض الصور"
          title="جولة داخل"
          highlight="مستشفانا"
          description="اطلع على مرافقنا المتطورة وتجهيزاتنا الحديثة"
        />

        {/* Filter Buttons */}
        <div ref={ref} className="flex items-center justify-center gap-3 mb-12 flex-wrap">
          {categories.map((cat) => (
            <button
              key={cat}
              onClick={() => setFilter(cat)}
              className={`px-6 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 ${
                filter === cat
                  ? "bg-primary-600 text-white shadow-lg shadow-primary-500/30"
                  : "bg-gray-100 text-gray-600 hover:bg-gray-200"
              }`}
            >
              {cat}
            </button>
          ))}
        </div>

        {/* Gallery Grid */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
          {filtered.map((image, index) => (
            <div
              key={`${filter}-${index}`}
              className={`group relative rounded-2xl overflow-hidden cursor-pointer h-64 ${
                isVisible ? "animate-scale-in" : "opacity-0"
              }`}
              style={{ animationDelay: `${index * 100}ms` }}
              onClick={() => openLightbox(index)}
            >
              <img
                src={image.src}
                alt={image.title}
                className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5">
                <span className="text-accent-400 text-xs font-bold mb-1">{image.category}</span>
                <h4 className="text-white font-bold text-lg">{image.title}</h4>
              </div>
              <div className="absolute top-5 left-5 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 group-hover:scale-100 scale-50">
                <ZoomIn className="text-white" size={18} />
              </div>
            </div>
          ))}
        </div>
      </div>

      {/* Lightbox */}
      {lightbox !== null && (
        <div className="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center p-4" onClick={closeLightbox}>
          <button
            onClick={closeLightbox}
            className="absolute top-6 left-6 w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all z-10"
          >
            <X size={24} />
          </button>
          <button
            onClick={(e) => { e.stopPropagation(); prevImage(); }}
            className="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all z-10"
          >
            <ChevronRight size={24} />
          </button>
          <button
            onClick={(e) => { e.stopPropagation(); nextImage(); }}
            className="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 rounded-full flex items-center justify-center text-white hover:bg-white/20 transition-all z-10"
          >
            <ChevronLeft size={24} />
          </button>
          <div onClick={(e) => e.stopPropagation()} className="max-w-5xl w-full">
            <img
              src={filtered[lightbox].src}
              alt={filtered[lightbox].title}
              className="w-full max-h-[80vh] object-contain rounded-2xl"
            />
            <div className="text-center mt-4">
              <h4 className="text-white font-bold text-xl">{filtered[lightbox].title}</h4>
              <p className="text-white/50 text-sm mt-1">{filtered[lightbox].category}</p>
            </div>
          </div>
        </div>
      )}
    </section>
  );
}
