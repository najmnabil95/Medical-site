import { Routes, Route, Navigate } from "react-router-dom";
import { useData } from "../context/DataContext";
import AdminLayout from "./AdminLayout";
import Login from "./pages/Login";
import Dashboard from "./pages/Dashboard";
import DepartmentsPage from "./pages/DepartmentsPage";
import DoctorsPage from "./pages/DoctorsPage";
import ServicesPage from "./pages/ServicesPage";
import PackagesPage from "./pages/PackagesPage";
import TestimonialsPage from "./pages/TestimonialsPage";
import NewsPage from "./pages/NewsPage";
import FaqsPage from "./pages/FaqsPage";
import InsurancePage from "./pages/InsurancePage";
import PartnersPage from "./pages/PartnersPage";
import CertificationsPage from "./pages/CertificationsPage";
import SettingsPage from "./pages/SettingsPage";
import ReservationsPage from "./pages/ReservationsPage";
import MessagesPage from "./pages/MessagesPage";
import AnalyticsPage from "./pages/AnalyticsPage";
import ActivityLogPage from "./pages/ActivityLogPage";
import OffersPage from "./pages/OffersPage";
import MediaPage from "./pages/MediaPage";
import ProfilePage from "./pages/ProfilePage";
import UsersPage from "./pages/UsersPage";
import DoctorDetailPage from "./pages/DoctorDetailPage";
import PrescriptionsPage from "./pages/PrescriptionsPage";
import TelemedicinePage from "./pages/TelemedicinePage";
import ScreensControlPage from "./pages/ScreensControlPage";
import ContentManagementPage from "./pages/ContentManagementPage";
import GeneralSettingsPage from "./pages/GeneralSettingsPage";
import PermissionsInfoPage from "./pages/PermissionsInfoPage";
import PricesPage from "./pages/PricesPage";
import NotificationSettingsPage from "./pages/NotificationSettingsPage";

function ProtectedRoute({ children }: { children: React.ReactNode }) {
  const { isAuthenticated } = useData();
  if (!isAuthenticated) return <Navigate to="/admin/login" replace />;
  return <>{children}</>;
}

export default function AdminRoutes() {
  return (
    <Routes>
      <Route path="login" element={<Login />} />
      <Route
        path="/*"
        element={
          <ProtectedRoute>
            <AdminLayout />
          </ProtectedRoute>
        }
      >
        <Route index element={<Dashboard />} />
        <Route path="reservations" element={<ReservationsPage />} />
        <Route path="messages" element={<MessagesPage />} />
        <Route path="analytics" element={<AnalyticsPage />} />
        <Route path="activity" element={<ActivityLogPage />} />
        <Route path="offers" element={<OffersPage />} />
        <Route path="media" element={<MediaPage />} />
        <Route path="profile" element={<ProfilePage />} />
        <Route path="users" element={<UsersPage />} />
        <Route path="departments" element={<DepartmentsPage />} />
        <Route path="doctors" element={<DoctorsPage />} />
        <Route path="services" element={<ServicesPage />} />
        <Route path="packages" element={<PackagesPage />} />
        <Route path="testimonials" element={<TestimonialsPage />} />
        <Route path="news" element={<NewsPage />} />
        <Route path="faqs" element={<FaqsPage />} />
        <Route path="insurance" element={<InsurancePage />} />
        <Route path="partners" element={<PartnersPage />} />
        <Route path="certifications" element={<CertificationsPage />} />
        <Route path="settings" element={<SettingsPage />} />
        <Route path="doctors/:id" element={<DoctorDetailPage />} />
        <Route path="prescriptions" element={<PrescriptionsPage />} />
        <Route path="telemedicine" element={<TelemedicinePage />} />
        <Route path="screens" element={<ScreensControlPage />} />
        <Route path="content" element={<ContentManagementPage />} />
        <Route path="general-settings" element={<GeneralSettingsPage />} />
        <Route path="permissions" element={<PermissionsInfoPage />} />
        <Route path="prices" element={<PricesPage />} />
        <Route path="notification-settings" element={<NotificationSettingsPage />} />
      </Route>
    </Routes>
  );
}
