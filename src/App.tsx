import { HashRouter, Routes, Route } from "react-router-dom";
import { DataProvider } from "./context/DataContext";
import { AppProvider } from "./context/AppContext";
import { PrescriptionProvider } from "./context/PrescriptionContext";
import { NotificationProvider } from "./context/NotificationContext";
import { ToastProvider } from "./admin/components/Toast";
import AdminRoutes from "./admin/AdminRoutes";
import PublicSite from "./PublicSite";
import NotFound from "./admin/pages/NotFound";
import AllDoctors from "./pages/AllDoctors";
import DoctorDetails from "./pages/DoctorDetails";
import AllDepartments from "./pages/AllDepartments";
import DepartmentDetails from "./pages/DepartmentDetails";

export default function App() {
  return (
    <DataProvider>
      <AppProvider>
        <PrescriptionProvider>
          <NotificationProvider>
            <ToastProvider>
              <HashRouter>
                <Routes>
                  {/* Admin Routes */}
                  <Route path="/admin/*" element={<AdminRoutes />} />

                  {/* Public Site - Doctors Pages */}
                  <Route path="/doctors" element={<AllDoctors />} />
                  <Route path="/doctor/:id" element={<DoctorDetails />} />

                  {/* Public Site - Departments Pages */}
                  <Route path="/departments" element={<AllDepartments />} />
                  <Route path="/department/:id" element={<DepartmentDetails />} />

                  {/* Public Site - Home */}
                  <Route path="/" element={<PublicSite />} />

                  {/* 404 */}
                  <Route path="*" element={<NotFound />} />
                </Routes>
              </HashRouter>
            </ToastProvider>
          </NotificationProvider>
        </PrescriptionProvider>
      </AppProvider>
    </DataProvider>
  );
}
