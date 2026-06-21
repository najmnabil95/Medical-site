// نظام الصلاحيات المتقدم

export type Permission = 
  // لوحة التحكم
  | 'view_dashboard'
  // إدارة المحتوى
  | 'view_departments' | 'manage_departments'
  | 'view_doctors' | 'manage_doctors'
  | 'view_services' | 'manage_services'
  | 'view_packages' | 'manage_packages'
  // الحجوزات والاستشارات
  | 'view_reservations' | 'manage_reservations'
  | 'view_telemedicine' | 'manage_telemedicine'
  | 'view_prescriptions' | 'manage_prescriptions'
  // التواصل
  | 'view_messages' | 'manage_messages'
  | 'view_testimonials' | 'manage_testimonials'
  // المحتوى
  | 'view_news' | 'manage_news'
  | 'view_faqs' | 'manage_faqs'
  | 'view_offers' | 'manage_offers'
  | 'view_media' | 'manage_media'
  // الإعدادات
  | 'view_insurance' | 'manage_insurance'
  | 'view_partners' | 'manage_partners'
  | 'view_certifications' | 'manage_certifications'
  | 'view_settings' | 'manage_settings'
  // المستخدمين
  | 'view_users' | 'manage_users'
  | 'view_screens' | 'manage_screens'
  // التقارير
  | 'view_analytics'
  | 'view_activity_log';

export interface RolePermissions {
  role: string;
  label: string;
  description: string;
  permissions: Permission[];
}

// تعريف الصلاحيات لكل دور
export const ROLE_PERMISSIONS: RolePermissions[] = [
  {
    role: 'admin',
    label: 'مدير النظام',
    description: 'صلاحيات كاملة على جميع أقسام النظام',
    permissions: [
      'view_dashboard',
      'view_departments', 'manage_departments',
      'view_doctors', 'manage_doctors',
      'view_services', 'manage_services',
      'view_packages', 'manage_packages',
      'view_reservations', 'manage_reservations',
      'view_telemedicine', 'manage_telemedicine',
      'view_prescriptions', 'manage_prescriptions',
      'view_messages', 'manage_messages',
      'view_testimonials', 'manage_testimonials',
      'view_news', 'manage_news',
      'view_faqs', 'manage_faqs',
      'view_offers', 'manage_offers',
      'view_media', 'manage_media',
      'view_insurance', 'manage_insurance',
      'view_partners', 'manage_partners',
      'view_certifications', 'manage_certifications',
      'view_settings', 'manage_settings',
      'view_users', 'manage_users',
      'view_screens', 'manage_screens',
      'view_analytics',
      'view_activity_log',
    ],
  },
  {
    role: 'doctor',
    label: 'طبيب',
    description: 'إدارة الحجوزات والوصفات الطبية الخاصة به',
    permissions: [
      'view_dashboard',
      'view_reservations', 'manage_reservations',
      'view_telemedicine', 'manage_telemedicine',
      'view_prescriptions', 'manage_prescriptions',
      'view_analytics',
    ],
  },
  {
    role: 'nurse',
    label: 'ممرض/ة',
    description: 'متابعة الحجوزات وإدارة السجلات الطبية',
    permissions: [
      'view_dashboard',
      'view_reservations',
      'view_telemedicine',
      'view_prescriptions',
    ],
  },
  {
    role: 'reception',
    label: 'موظف استقبال',
    description: 'إدارة الحجوزات والرسائل',
    permissions: [
      'view_dashboard',
      'view_reservations', 'manage_reservations',
      'view_telemedicine', 'manage_telemedicine',
      'view_messages', 'manage_messages',
    ],
  },
  {
    role: 'accountant',
    label: 'محاسب',
    description: 'عرض التقارير المالية والإحصائيات',
    permissions: [
      'view_dashboard',
      'view_reservations',
      'view_telemedicine',
      'view_analytics',
    ],
  },
];

// دوال مساعدة
export function hasPermission(userRole: string, permission: Permission): boolean {
  const rolePerms = ROLE_PERMISSIONS.find(r => r.role === userRole);
  if (!rolePerms) return false;
  return rolePerms.permissions.includes(permission);
}

export function canView(userRole: string, module: string): boolean {
  return hasPermission(userRole, `view_${module}` as Permission);
}

export function canManage(userRole: string, module: string): boolean {
  return hasPermission(userRole, `manage_${module}` as Permission);
}

export function getRolePermissions(userRole: string): Permission[] {
  const rolePerms = ROLE_PERMISSIONS.find(r => r.role === userRole);
  return rolePerms?.permissions || [];
}

// تعريف عناصر القائمة الجانبية مع صلاحياتها
export interface MenuItem {
  name: string;
  icon: string;
  path: string;
  viewPermission: Permission;
  managePermission?: Permission;
}

export const MENU_ITEMS: MenuItem[] = [
  { name: 'لوحة التحكم', icon: 'LayoutDashboard', path: '/admin', viewPermission: 'view_dashboard' },
  { name: 'الحجوزات', icon: 'CalendarCheck', path: '/admin/reservations', viewPermission: 'view_reservations', managePermission: 'manage_reservations' },
  { name: 'الاستشارات عن بُعد', icon: 'Video', path: '/admin/telemedicine', viewPermission: 'view_telemedicine', managePermission: 'manage_telemedicine' },
  { name: 'الرسائل', icon: 'Mail', path: '/admin/messages', viewPermission: 'view_messages', managePermission: 'manage_messages' },
  { name: 'التحليلات', icon: 'TrendingUp', path: '/admin/analytics', viewPermission: 'view_analytics' },
  { name: 'سجل النشاطات', icon: 'Activity', path: '/admin/activity', viewPermission: 'view_activity_log' },
  { name: 'المستخدمون', icon: 'Users', path: '/admin/users', viewPermission: 'view_users', managePermission: 'manage_users' },
  { name: 'الوصفات الطبية', icon: 'FileText', path: '/admin/prescriptions', viewPermission: 'view_prescriptions', managePermission: 'manage_prescriptions' },
  { name: 'التحكم في الشاشات', icon: 'Monitor', path: '/admin/screens', viewPermission: 'view_screens', managePermission: 'manage_screens' },
  { name: 'العروض والخصومات', icon: 'Tag', path: '/admin/offers', viewPermission: 'view_offers', managePermission: 'manage_offers' },
  { name: 'معرض الصور', icon: 'ImageIcon', path: '/admin/media', viewPermission: 'view_media', managePermission: 'manage_media' },
  { name: 'الأقسام الطبية', icon: 'Building2', path: '/admin/departments', viewPermission: 'view_departments', managePermission: 'manage_departments' },
  { name: 'الأطباء', icon: 'Users', path: '/admin/doctors', viewPermission: 'view_doctors', managePermission: 'manage_doctors' },
  { name: 'الخدمات', icon: 'Briefcase', path: '/admin/services', viewPermission: 'view_services', managePermission: 'manage_services' },
  { name: 'الباقات المميزة', icon: 'Package', path: '/admin/packages', viewPermission: 'view_packages', managePermission: 'manage_packages' },
  { name: 'آراء المرضى', icon: 'MessageSquare', path: '/admin/testimonials', viewPermission: 'view_testimonials', managePermission: 'manage_testimonials' },
  { name: 'الأخبار', icon: 'Newspaper', path: '/admin/news', viewPermission: 'view_news', managePermission: 'manage_news' },
  { name: 'الأسئلة الشائعة', icon: 'HelpCircle', path: '/admin/faqs', viewPermission: 'view_faqs', managePermission: 'manage_faqs' },
  { name: 'التأمين الطبي', icon: 'Shield', path: '/admin/insurance', viewPermission: 'view_insurance', managePermission: 'manage_insurance' },
  { name: 'الشركاء', icon: 'Handshake', path: '/admin/partners', viewPermission: 'view_partners', managePermission: 'manage_partners' },
  { name: 'الشهادات', icon: 'Award', path: '/admin/certifications', viewPermission: 'view_certifications', managePermission: 'manage_certifications' },
  { name: 'الإعدادات', icon: 'Settings', path: '/admin/settings', viewPermission: 'view_settings', managePermission: 'manage_settings' },
  { name: 'الملف الشخصي', icon: 'UserCircle', path: '/admin/profile', viewPermission: 'view_dashboard' },
];
