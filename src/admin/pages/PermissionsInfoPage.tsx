import { Shield, Check, X } from "lucide-react";
import PageHeader from "../components/PageHeader";
import { ROLE_PERMISSIONS, Permission } from "../../utils/permissions";

export default function PermissionsInfoPage() {
  // تجميع الصلاحيات حسب الفئة
  const permissionCategories = [
    { name: '📊 لوحة التحكم', permissions: ['view_dashboard', 'view_analytics', 'view_activity_log'] },
    { name: '📅 الحجوزات والاستشارات', permissions: ['view_reservations', 'manage_reservations', 'view_telemedicine', 'manage_telemedicine', 'view_prescriptions', 'manage_prescriptions'] },
    { name: '💬 التواصل', permissions: ['view_messages', 'manage_messages', 'view_testimonials', 'manage_testimonials'] },
    { name: '🏥 المحتوى الطبي', permissions: ['view_departments', 'manage_departments', 'view_doctors', 'manage_doctors', 'view_services', 'manage_services', 'view_packages', 'manage_packages'] },
    { name: '📰 المحتوى', permissions: ['view_news', 'manage_news', 'view_faqs', 'manage_faqs', 'view_offers', 'manage_offers', 'view_media', 'manage_media'] },
    { name: '🛡️ الإعدادات', permissions: ['view_insurance', 'manage_insurance', 'view_partners', 'manage_partners', 'view_certifications', 'manage_certifications', 'view_settings', 'manage_settings', 'view_screens', 'manage_screens'] },
    { name: '👥 المستخدمون', permissions: ['view_users', 'manage_users'] },
  ];

  const hasPermission = (role: string, permission: Permission) => {
    const rolePerms = ROLE_PERMISSIONS.find(r => r.role === role);
    return rolePerms?.permissions.includes(permission) || false;
  };

  return (
    <div>
      <PageHeader
        title="جدول الصلاحيات"
        subtitle="عرض جميع الصلاحيات المتاحة لكل دور في النظام"
        icon={<Shield size={26} />}
      />

      {/* ملخص الأدوار */}
      <div className="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        {ROLE_PERMISSIONS.map((role) => (
          <div key={role.role} className="bg-white rounded-2xl border border-gray-100 p-5 hover:shadow-lg transition-all">
            <div className="flex items-center gap-3 mb-3">
              <div className={`w-12 h-12 bg-gradient-to-br ${
                role.role === 'admin' ? 'from-red-500 to-rose-600' :
                role.role === 'doctor' ? 'from-blue-500 to-indigo-600' :
                role.role === 'nurse' ? 'from-emerald-500 to-teal-600' :
                role.role === 'reception' ? 'from-purple-500 to-violet-600' :
                'from-amber-500 to-orange-600'
              } rounded-xl flex items-center justify-center text-white`}>
                <Shield size={22} />
              </div>
              <div>
                <h3 className="font-bold text-gray-800">{role.label}</h3>
                <p className="text-xs text-gray-500">{role.permissions.length} صلاحية</p>
              </div>
            </div>
            <p className="text-xs text-gray-600 leading-relaxed">{role.description}</p>
          </div>
        ))}
      </div>

      {/* جدول الصلاحيات */}
      <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div className="overflow-x-auto">
          <table className="w-full">
            <thead className="bg-gray-50 border-b border-gray-200">
              <tr>
                <th className="text-right px-4 py-3 text-xs font-bold text-gray-700 sticky right-0 bg-gray-50 min-w-[200px]">
                  الصلاحية
                </th>
                {ROLE_PERMISSIONS.map((role) => (
                  <th key={role.role} className="text-center px-3 py-3 text-xs font-bold text-gray-700 min-w-[100px]">
                    {role.label}
                  </th>
                ))}
              </tr>
            </thead>
            <tbody>
              {permissionCategories.map((category, catIdx) => (
                <>
                  <tr key={`cat-${catIdx}`} className="bg-primary-50">
                    <td colSpan={ROLE_PERMISSIONS.length + 1} className="px-4 py-2 text-sm font-bold text-primary-700">
                      {category.name}
                    </td>
                  </tr>
                  {category.permissions.map((perm, permIdx) => (
                    <tr key={`${catIdx}-${permIdx}`} className="border-b border-gray-100 hover:bg-gray-50">
                      <td className="px-4 py-3 text-sm text-gray-700 sticky right-0 bg-white font-medium">
                        {perm.replace(/_/g, ' ').replace('view', 'عرض').replace('manage', 'إدارة')}
                      </td>
                      {ROLE_PERMISSIONS.map((role) => {
                        const has = hasPermission(role.role, perm as Permission);
                        return (
                          <td key={role.role} className="text-center px-3 py-3">
                            {has ? (
                              <div className="inline-flex items-center justify-center w-8 h-8 bg-green-100 rounded-full">
                                <Check size={16} className="text-green-600" />
                              </div>
                            ) : (
                              <div className="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full">
                                <X size={16} className="text-gray-400" />
                              </div>
                            )}
                          </td>
                        );
                      })}
                    </tr>
                  ))}
                </>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      {/* دليل الاستخدام */}
      <div className="mt-8 bg-blue-50 border border-blue-200 rounded-2xl p-6">
        <h3 className="font-bold text-blue-800 mb-3 flex items-center gap-2">
          <Shield size={20} />
          <span>دليل الصلاحيات</span>
        </h3>
        <div className="grid md:grid-cols-2 gap-4 text-sm">
          <div>
            <p className="font-bold text-blue-700 mb-2">✅ عرض (View)</p>
            <p className="text-blue-600">القدرة على رؤية البيانات والمعلومات فقط</p>
          </div>
          <div>
            <p className="font-bold text-blue-700 mb-2">🔧 إدارة (Manage)</p>
            <p className="text-blue-600">القدرة على إضافة، تعديل، وحذف البيانات</p>
          </div>
        </div>
      </div>
    </div>
  );
}
