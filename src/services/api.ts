/**
 * API Service Layer
 * 
 * هذا الملف يحاكي Backend API
 * في الإنتاج، استبدل هذا بـ API calls حقيقية
 * 
 * للانتقال إلى Backend حقيقي:
 * 1. قم بإنشاء Backend باستخدام Laravel/Node.js
 * 2. استبدل localStorage بـ API calls
 * 3. استخدم axios أو fetch للاتصال بالـ Backend
 */

// Base URL للـ Backend
const API_BASE_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api';

// Helper functions
async function handleResponse(response: Response) {
  if (!response.ok) {
    const error = await response.json();
    throw new Error(error.message || 'حدث خطأ في السيرفر');
  }
  return response.json();
}

// دالة API Request - سيتم استخدامها عند الانتقال إلى Backend حقيقي
// eslint-disable-next-line @typescript-eslint/no-unused-vars
async function apiRequest(endpoint: string, options: RequestInit = {}) {
  const token = localStorage.getItem('authToken');
  
  const headers = {
    'Content-Type': 'application/json',
    ...(token && { 'Authorization': `Bearer ${token}` }),
    ...options.headers,
  };

  try {
    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
      ...options,
      headers,
    });
    return handleResponse(response);
  } catch (error) {
    console.error('API Error:', error);
    throw error;
  }
}

// Auth API
export const AuthAPI = {
  login: async (username: string, password: string) => {
    // حالياً: محاكاة باستخدام localStorage
    // عند الانتقال إلى Backend حقيقي، استخدم:
    // return apiRequest('/auth/login', {
    //   method: 'POST',
    //   body: JSON.stringify({ username, password }),
    // });
    
    const users = JSON.parse(localStorage.getItem('users') || '[]');
    const user = users.find((u: any) => u.username === username && u.password === password);
    
    if (user) {
      const token = btoa(JSON.stringify({ userId: user.id, role: user.role }));
      localStorage.setItem('authToken', token);
      localStorage.setItem('currentUser', JSON.stringify(user));
      return { user, token };
    }
    
    throw new Error('اسم المستخدم أو كلمة المرور غير صحيحة');
  },

  logout: () => {
    localStorage.removeItem('authToken');
    localStorage.removeItem('currentUser');
  },

  getCurrentUser: () => {
    const user = localStorage.getItem('currentUser');
    return user ? JSON.parse(user) : null;
  },

  isAuthenticated: () => {
    return !!localStorage.getItem('authToken');
  },
};

// Users API
export const UsersAPI = {
  getAll: async () => {
    // حالياً: محاكاة باستخدام localStorage
    // عند الانتقال إلى Backend حقيقي، استخدم:
    // return apiRequest('/users');
    
    const users = JSON.parse(localStorage.getItem('users') || '[]');
    return users;
  },

  getById: async (id: string) => {
    // TODO: استبدل بـ API call
    // return apiRequest(`/users/${id}`);
    
    const users = JSON.parse(localStorage.getItem('users') || '[]');
    return users.find((u: any) => u.id === id);
  },

  create: async (userData: any) => {
    // حالياً: محاكاة باستخدام localStorage
    // عند الانتقال إلى Backend حقيقي، استخدم:
    const response = await apiRequest('/users', {
      method: 'POST',
      body: JSON.stringify(userData),
    });
    return response;
    
    // const users = JSON.parse(localStorage.getItem('users') || '[]');
    // const newUser = { ...userData, id: Date.now().toString() };
    // users.push(newUser);
    // localStorage.setItem('users', JSON.stringify(users));
    // return newUser;
  },

  update: async (id: string, userData: any) => {
    // TODO: استبدل بـ API call
    // return apiRequest(`/users/${id}`, {
    //   method: 'PUT',
    //   body: JSON.stringify(userData),
    // });
    
    const users = JSON.parse(localStorage.getItem('users') || '[]');
    const index = users.findIndex((u: any) => u.id === id);
    if (index !== -1) {
      users[index] = { ...users[index], ...userData };
      localStorage.setItem('users', JSON.stringify(users));
      return users[index];
    }
    throw new Error('المستخدم غير موجود');
  },

  delete: async (id: string) => {
    // TODO: استبدل بـ API call
    // return apiRequest(`/users/${id}`, { method: 'DELETE' });
    
    const users = JSON.parse(localStorage.getItem('users') || '[]');
    const filtered = users.filter((u: any) => u.id !== id);
    localStorage.setItem('users', JSON.stringify(filtered));
    return { success: true };
  },
};

// Appointments API
export const AppointmentsAPI = {
  getAll: async () => {
    const appointments = JSON.parse(localStorage.getItem('reservations') || '[]');
    return appointments;
  },

  create: async (appointmentData: any) => {
    const appointments = JSON.parse(localStorage.getItem('reservations') || '[]');
    const newAppointment = { 
      ...appointmentData, 
      id: Date.now().toString(),
      createdAt: new Date().toISOString(),
      status: 'pending'
    };
    appointments.push(newAppointment);
    localStorage.setItem('reservations', JSON.stringify(appointments));
    return newAppointment;
  },

  update: async (id: string, appointmentData: any) => {
    const appointments = JSON.parse(localStorage.getItem('reservations') || '[]');
    const index = appointments.findIndex((a: any) => a.id === id);
    if (index !== -1) {
      appointments[index] = { ...appointments[index], ...appointmentData };
      localStorage.setItem('reservations', JSON.stringify(appointments));
      return appointments[index];
    }
    throw new Error('الحجز غير موجود');
  },

  delete: async (id: string) => {
    const appointments = JSON.parse(localStorage.getItem('reservations') || '[]');
    const filtered = appointments.filter((a: any) => a.id !== id);
    localStorage.setItem('reservations', JSON.stringify(filtered));
    return { success: true };
  },
};

// Notifications API
export const NotificationsAPI = {
  getAll: async () => {
    const notifications = JSON.parse(localStorage.getItem('notifications') || '[]');
    return notifications;
  },

  create: async (notificationData: any) => {
    const notifications = JSON.parse(localStorage.getItem('notifications') || '[]');
    const newNotification = { 
      ...notificationData, 
      id: Date.now().toString(),
      createdAt: new Date().toISOString(),
      status: 'pending'
    };
    notifications.push(newNotification);
    localStorage.setItem('notifications', JSON.stringify(notifications));
    
    // محاكاة إرسال notification
    setTimeout(() => {
      const updated = JSON.parse(localStorage.getItem('notifications') || '[]');
      const index = updated.findIndex((n: any) => n.id === newNotification.id);
      if (index !== -1) {
        updated[index].status = 'sent';
        localStorage.setItem('notifications', JSON.stringify(updated));
      }
    }, 1000);
    
    return newNotification;
  },
};

// Upload API
export const UploadAPI = {
  uploadImage: async (file: File) => {
    // TODO: استبدل بـ API call حقيقي
    // const formData = new FormData();
    // formData.append('image', file);
    // return apiRequest('/upload/image', {
    //   method: 'POST',
    //   body: formData,
    //   headers: {}, // لا ترسل Content-Type للـ FormData
    // });
    
    // محاكاة حالياً - تحويل الصورة إلى base64
    return new Promise((resolve) => {
      const reader = new FileReader();
      reader.onloadend = () => {
        resolve({ url: reader.result });
      };
      reader.readAsDataURL(file);
    });
  },
};

// Settings API
export const SettingsAPI = {
  get: async () => {
    const settings = localStorage.getItem('generalSettings');
    return settings ? JSON.parse(settings) : null;
  },

  update: async (settings: any) => {
    localStorage.setItem('generalSettings', JSON.stringify(settings));
    return settings;
  },
};

// Content API
export const ContentAPI = {
  get: async () => {
    const content = localStorage.getItem('siteContent');
    return content ? JSON.parse(content) : [];
  },

  update: async (content: any) => {
    localStorage.setItem('siteContent', JSON.stringify(content));
    return content;
  },
};

// Screens API
export const ScreensAPI = {
  get: async () => {
    const screens = localStorage.getItem('screens');
    return screens ? JSON.parse(screens) : [];
  },

  update: async (screens: any) => {
    localStorage.setItem('screens', JSON.stringify(screens));
    return screens;
  },
};
