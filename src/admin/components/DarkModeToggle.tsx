import { Moon, Sun } from "lucide-react";
import { useApp } from "../../context/AppContext";

export default function DarkModeToggle() {
  const { darkMode, toggleDarkMode } = useApp();

  return (
    <button
      onClick={toggleDarkMode}
      className={`w-10 h-10 rounded-xl flex items-center justify-center transition-all ${
        darkMode
          ? "bg-yellow-400 text-gray-900 hover:bg-yellow-300"
          : "bg-gray-700 text-yellow-400 hover:bg-gray-600"
      }`}
      title={darkMode ? "الوضع الفاتح" : "الوضع الليلي"}
    >
      {darkMode ? <Sun size={20} /> : <Moon size={20} />}
    </button>
  );
}