import { Reservation } from "../context/AppContext";
import { NotificationType } from "../context/NotificationContext";

// إنشاء رسالة تأكيد الحجز
export function createReservationConfirmationMessage(reservation: Reservation): string {
  return `
مرحباً ${reservation.patientName}،

تم تأكيد حجزك بنجاح في مستشفى الشفاء الدولي.

📅 التفاصيل:
• القسم: ${reservation.department}
${reservation.doctor ? `• الطبيب: ${reservation.doctor}` : ""}
• التاريخ: ${reservation.date}
• الوقت: ${reservation.time}

📍 الموقع:
طريق الملك فهد، الرياض

📞 للاستفسار: 920012345

نتطلع لخدمتكم!
مستشفى الشفاء الدولي
  `.trim();
}

// إنشاء رسالة تأكيد الاستشارة
export function createConsultationConfirmationMessage(reservation: Reservation): string {
  return `
مرحباً ${reservation.patientName}،

تم تأكيد حجز استشارتك عن بُعد بنجاح.

📅 التفاصيل:
• نوع الاستشارة: ${reservation.department}
• التاريخ: ${reservation.date}
• الوقت: ${reservation.time}

💻 رابط الاستشارة:
سيتم إرساله قبل الموعد بـ 30 دقيقة

📞 للدعم الفني: 920012345

نتطلع لخدمتكم!
مستشفى الشفاء الدولي
  `.trim();
}

// تحديد نوع الإشعار المناسب
export function determineNotificationType(phone: string): NotificationType {
  // إذا كان الرقم يبدأ بـ 966 أو 05، فهو واتساب
  if (phone.startsWith("966") || phone.startsWith("05")) {
    return "whatsapp";
  }
  // وإلا SMS
  return "sms";
}

// تنسيق رقم الهاتف
export function formatPhoneNumber(phone: string): string {
  // إزالة جميع المسافات والرموز
  let cleaned = phone.replace(/\D/g, "");
  
  // إذا كان يبدأ بـ 0، استبدله بـ 966
  if (cleaned.startsWith("0")) {
    cleaned = "966" + cleaned.substring(1);
  }
  
  // إذا كان يبدأ بـ 966، تأكد من صحته
  if (!cleaned.startsWith("966")) {
    cleaned = "966" + cleaned;
  }
  
  return cleaned;
}
