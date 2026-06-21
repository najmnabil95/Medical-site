import { ReactNode } from "react";

interface StatsCardProps {
  title: string;
  value: string | number;
  icon: ReactNode;
  trend?: { value: string; positive: boolean };
  color: string;
  onClick?: () => void;
}

export default function StatsCard({ title, value, icon, trend, color, onClick }: StatsCardProps) {
  return (
    <div
      onClick={onClick}
      className={`bg-white rounded-2xl p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 ${onClick ? "cursor-pointer hover:-translate-y-1" : ""}`}
    >
      <div className="flex items-start justify-between mb-4">
        <div className={`w-12 h-12 ${color} rounded-xl flex items-center justify-center text-white shadow-lg`}>
          {icon}
        </div>
        {trend && (
          <div className={`text-xs font-bold px-2 py-1 rounded-full ${
            trend.positive ? "bg-green-100 text-green-600" : "bg-red-100 text-red-600"
          }`}>
            {trend.value}
          </div>
        )}
      </div>
      <h3 className="text-3xl font-black text-gray-800 mb-1">{value}</h3>
      <p className="text-sm text-gray-500">{title}</p>
    </div>
  );
}
