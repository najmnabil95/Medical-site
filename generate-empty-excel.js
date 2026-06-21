import * as XLSX from "xlsx";

// إنشاء ملف Excel فارغ
const createEmptyTemplate = () => {
  // بيانات فارغة مع العناوين فقط
  const emptyData = [
    {
      "اسم الخدمة": "",
      "التصنيف": "",
      "السعر": "",
      "السعر إلى": "",
      "العملة": "ر.س",
      "المدة": "",
      "الوصف": "",
    },
  ];

  const worksheet = XLSX.utils.json_to_sheet(emptyData);
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, worksheet, "الأسعار");

  // تعيين عرض الأعمدة
  worksheet["!cols"] = [
    { wch: 30 }, // اسم الخدمة
    { wch: 15 }, // التصنيف
    { wch: 10 }, // السعر
    { wch: 10 }, // السعر إلى
    { wch: 8 },  // العملة
    { wch: 15 }, // المدة
    { wch: 40 }, // الوصف
  ];

  // حفظ الملف
  XLSX.writeFile(workbook, "قالب_الأسعار_فارغ.xlsx");
  
  console.log("✅ تم إنشاء الملف بنجاح: قالب_الأسعار_فارغ.xlsx");
};

// تشغيل الدالة
createEmptyTemplate();
