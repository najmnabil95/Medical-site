import { useScrollReveal } from "../hooks/useScrollReveal";

interface SectionHeaderProps {
  badge: string;
  title: string;
  highlight: string;
  description?: string;
  light?: boolean;
}

export default function SectionHeader({ badge, title, highlight, description, light }: SectionHeaderProps) {
  const { ref, isVisible } = useScrollReveal();

  return (
    <div
      ref={ref}
      className={`text-center mb-16 transition-all duration-700 ${isVisible ? "opacity-100 translate-y-0" : "opacity-0 translate-y-8"}`}
    >
      <span className={`font-bold text-sm tracking-wider px-5 py-2 rounded-full inline-block ${
        light ? "text-accent-400 bg-accent-500/10" : "text-accent-600 bg-accent-500/10"
      }`}>
        {badge}
      </span>
      <h2 className={`text-3xl md:text-4xl lg:text-5xl font-black mt-5 leading-tight ${
        light ? "text-white" : "text-gray-900"
      }`}>
        {title}
        <span className={light ? " text-accent-400" : " text-primary-600"}> {highlight}</span>
      </h2>
      {description && (
        <p className={`mt-5 max-w-2xl mx-auto text-lg leading-relaxed ${
          light ? "text-white/60" : "text-gray-500"
        }`}>
          {description}
        </p>
      )}
      <div className="flex items-center justify-center gap-2 mt-6">
        <span className="w-12 h-1 bg-primary-500 rounded-full"></span>
        <span className="w-3 h-3 bg-accent-500 rounded-full"></span>
        <span className="w-12 h-1 bg-primary-500 rounded-full"></span>
      </div>
    </div>
  );
}
