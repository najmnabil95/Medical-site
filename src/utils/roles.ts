// نظام الأدوار والصلاحيات
export type UserRole = 'admin' | 'doctor' | 'nurse' | 'reception' | 'accountant';

export interface User {
  id: string;
  username: string;
  password: string;
  role: UserRole;
  name: string;
  email: string;
  phone: string;
  active: boolean;
  createdAt: string;
  lastLogin?: string;
  // للممرض فقط: الأقسام والأطباء المرتبط بهم
  assignedDepartments?: string[];
  assignedDoctors?: string[];
}

export const ROLE_PERMISSIONS: Record<UserRole, string[]> = {
  admin: [
    'view_dashboard',
    'manage_users',
    'manage_departments',
    'manage_doctors',
    'manage_services',
    'manage_packages',
    'manage_testimonials',
    'manage_news',
    'manage_faqs',
    'manage_insurance',
    'manage_partners',
    'manage_certifications',
    'manage_offers',
    'manage_media',
    'view_reservations',
    'manage_reservations',
    'view_messages',
    'manage_messages',
    'view_prescriptions',
    'manage_prescriptions',
    'view_analytics',
    'view_activity_log',
    'manage_settings',
    'manage_profile',
  ],
  doctor: [
    'view_dashboard',
    'view_reservations',
    'manage_reservations',
    'view_prescriptions',
    'manage_prescriptions',
    'view_messages',
    'view_analytics',
    'manage_profile',
  ],
  nurse: [
    'view_dashboard',
    'view_reservations',
    'view_prescriptions',
    'view_messages',
    'manage_profile',
  ],
  reception: [
    'view_dashboard',
    'view_reservations',
    'manage_reservations',
    'view_messages',
    'manage_messages',
    'manage_profile',
  ],
  accountant: [
    'view_dashboard',
    'view_reservations',
    'view_analytics',
    'manage_profile',
  ],
};

export const ROLE_LABELS: Record<UserRole, string> = {
  admin: 'مدير النظام',
  doctor: 'طبيب',
  nurse: 'ممرض',
  reception: 'موظف استقبال',
  accountant: 'محاسب',
};

export const ROLE_COLORS: Record<UserRole, string> = {
  admin: 'from-red-500 to-rose-600',
  doctor: 'from-blue-500 to-indigo-600',
  nurse: 'from-emerald-500 to-teal-600',
  reception: 'from-purple-500 to-violet-600',
  accountant: 'from-amber-500 to-orange-600',
};

export function hasPermission(user: User, permission: string): boolean {
  const permissions = ROLE_PERMISSIONS[user.role];
  return permissions.includes(permission);
}

export function getRoleLabel(role: UserRole): string {
  return ROLE_LABELS[role];
}

export function getRoleColor(role: UserRole): string {
  return ROLE_COLORS[role];
}
