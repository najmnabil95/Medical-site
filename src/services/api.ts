const API_BASE_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api';

async function handleResponse(response: Response) {
  if (!response.ok) {
    const error = await response.json();
    throw new Error(error.message || 'حدث خطأ في السيرفر');
  }
  return response.json();
}

async function apiRequest(endpoint: string, options: RequestInit = {}) {
  const token = localStorage.getItem('authToken');
  const headers: Record<string, string> = {
    'Content-Type': 'application/json',
    Accept: 'application/json',
    ...(token && { Authorization: `Bearer ${token}` }),
    ...(options.headers as Record<string, string>),
  };

  try {
    const response = await fetch(`${API_BASE_URL}${endpoint}`, {
      ...options,
      headers,
      credentials: 'include',
    });
    return handleResponse(response);
  } catch (error) {
    console.error('API Error:', error);
    throw error;
  }
}

export const AuthAPI = {
  login: async (username: string, password: string) => {
    const response = await apiRequest('/auth/login', {
      method: 'POST',
      body: JSON.stringify({ username, password }),
    });
    localStorage.setItem('authToken', response.token);
    localStorage.setItem('currentUser', JSON.stringify(response.user));
    return response;
  },

  logout: async () => {
    try {
      await apiRequest('/auth/logout', { method: 'POST' });
    } finally {
      localStorage.removeItem('authToken');
      localStorage.removeItem('currentUser');
    }
  },

  getCurrentUser: () => {
    const user = localStorage.getItem('currentUser');
    return user ? JSON.parse(user) : null;
  },

  isAuthenticated: () => {
    return !!localStorage.getItem('authToken');
  },
};

export const UsersAPI = {
  getAll: async () => apiRequest('/users'),
  getById: async (id: string) => apiRequest(`/users/${id}`),
  create: async (userData: Record<string, unknown>) =>
    apiRequest('/users', { method: 'POST', body: JSON.stringify(userData) }),
  update: async (id: string, userData: Record<string, unknown>) =>
    apiRequest(`/users/${id}`, { method: 'PUT', body: JSON.stringify(userData) }),
  delete: async (id: string) =>
    apiRequest(`/users/${id}`, { method: 'DELETE' }),
};

export const AppointmentsAPI = {
  getAll: async () => apiRequest('/appointments'),
  getById: async (id: string) => apiRequest(`/appointments/${id}`),
  create: async (data: Record<string, unknown>) =>
    apiRequest('/appointments', { method: 'POST', body: JSON.stringify(data) }),
  update: async (id: string, data: Record<string, unknown>) =>
    apiRequest(`/appointments/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  delete: async (id: string) =>
    apiRequest(`/appointments/${id}`, { method: 'DELETE' }),
};

export const DoctorsAPI = {
  getAll: async () => apiRequest('/doctors'),
  getById: async (id: string) => apiRequest(`/doctors/${id}`),
  create: async (data: Record<string, unknown>) =>
    apiRequest('/doctors', { method: 'POST', body: JSON.stringify(data) }),
  update: async (id: string, data: Record<string, unknown>) =>
    apiRequest(`/doctors/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  delete: async (id: string) =>
    apiRequest(`/doctors/${id}`, { method: 'DELETE' }),
};

export const DepartmentsAPI = {
  getAll: async () => apiRequest('/departments'),
  getById: async (id: string) => apiRequest(`/departments/${id}`),
  create: async (data: Record<string, unknown>) =>
    apiRequest('/departments', { method: 'POST', body: JSON.stringify(data) }),
  update: async (id: string, data: Record<string, unknown>) =>
    apiRequest(`/departments/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  delete: async (id: string) =>
    apiRequest(`/departments/${id}`, { method: 'DELETE' }),
};

export const ServicesAPI = {
  getAll: async () => apiRequest('/services'),
  create: async (data: Record<string, unknown>) =>
    apiRequest('/services', { method: 'POST', body: JSON.stringify(data) }),
  update: async (id: string, data: Record<string, unknown>) =>
    apiRequest(`/services/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  delete: async (id: string) =>
    apiRequest(`/services/${id}`, { method: 'DELETE' }),
};

export const PackagesAPI = {
  getAll: async () => apiRequest('/packages'),
  create: async (data: Record<string, unknown>) =>
    apiRequest('/packages', { method: 'POST', body: JSON.stringify(data) }),
  update: async (id: string, data: Record<string, unknown>) =>
    apiRequest(`/packages/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  delete: async (id: string) =>
    apiRequest(`/packages/${id}`, { method: 'DELETE' }),
};

export const TestimonialsAPI = {
  getAll: async () => apiRequest('/testimonials'),
  create: async (data: Record<string, unknown>) =>
    apiRequest('/testimonials', { method: 'POST', body: JSON.stringify(data) }),
  update: async (id: string, data: Record<string, unknown>) =>
    apiRequest(`/testimonials/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  delete: async (id: string) =>
    apiRequest(`/testimonials/${id}`, { method: 'DELETE' }),
};

export const NewsAPI = {
  getAll: async () => apiRequest('/news'),
  getById: async (id: string) => apiRequest(`/news/${id}`),
  create: async (data: Record<string, unknown>) =>
    apiRequest('/news', { method: 'POST', body: JSON.stringify(data) }),
  update: async (id: string, data: Record<string, unknown>) =>
    apiRequest(`/news/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  delete: async (id: string) =>
    apiRequest(`/news/${id}`, { method: 'DELETE' }),
};

export const FaqsAPI = {
  getAll: async () => apiRequest('/faqs'),
  create: async (data: Record<string, unknown>) =>
    apiRequest('/faqs', { method: 'POST', body: JSON.stringify(data) }),
  update: async (id: string, data: Record<string, unknown>) =>
    apiRequest(`/faqs/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  delete: async (id: string) =>
    apiRequest(`/faqs/${id}`, { method: 'DELETE' }),
};

export const InsurancesAPI = {
  getAll: async () => apiRequest('/insurances'),
  create: async (data: Record<string, unknown>) =>
    apiRequest('/insurances', { method: 'POST', body: JSON.stringify(data) }),
  update: async (id: string, data: Record<string, unknown>) =>
    apiRequest(`/insurances/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  delete: async (id: string) =>
    apiRequest(`/insurances/${id}`, { method: 'DELETE' }),
};

export const PartnersAPI = {
  getAll: async () => apiRequest('/partners'),
  create: async (data: Record<string, unknown>) =>
    apiRequest('/partners', { method: 'POST', body: JSON.stringify(data) }),
  update: async (id: string, data: Record<string, unknown>) =>
    apiRequest(`/partners/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  delete: async (id: string) =>
    apiRequest(`/partners/${id}`, { method: 'DELETE' }),
};

export const CertificationsAPI = {
  getAll: async () => apiRequest('/certifications'),
  create: async (data: Record<string, unknown>) =>
    apiRequest('/certifications', { method: 'POST', body: JSON.stringify(data) }),
  update: async (id: string, data: Record<string, unknown>) =>
    apiRequest(`/certifications/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  delete: async (id: string) =>
    apiRequest(`/certifications/${id}`, { method: 'DELETE' }),
};

export const PricesAPI = {
  getAll: async () => apiRequest('/prices'),
  create: async (data: Record<string, unknown>) =>
    apiRequest('/prices', { method: 'POST', body: JSON.stringify(data) }),
  update: async (id: string, data: Record<string, unknown>) =>
    apiRequest(`/prices/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  delete: async (id: string) =>
    apiRequest(`/prices/${id}`, { method: 'DELETE' }),
};

export const MessagesAPI = {
  create: async (data: Record<string, unknown>) =>
    apiRequest('/messages', { method: 'POST', body: JSON.stringify(data) }),
  getAll: async () => apiRequest('/messages'),
  getById: async (id: string) => apiRequest(`/messages/${id}`),
  update: async (id: string, data: Record<string, unknown>) =>
    apiRequest(`/messages/${id}`, { method: 'PUT', body: JSON.stringify(data) }),
  delete: async (id: string) =>
    apiRequest(`/messages/${id}`, { method: 'DELETE' }),
};

export const NotificationsAPI = {
  getAll: async () => apiRequest('/notifications'),
  create: async (data: Record<string, unknown>) =>
    apiRequest('/notifications', { method: 'POST', body: JSON.stringify(data) }),
};

export const SettingsAPI = {
  get: async () => apiRequest('/settings'),
  update: async (settings: Record<string, unknown>) =>
    apiRequest('/settings', { method: 'PUT', body: JSON.stringify(settings) }),
};

export const DashboardAPI = {
  stats: async () => apiRequest('/dashboard/stats'),
};

export const UploadAPI = {
  uploadImage: async (file: File) => {
    return new Promise((resolve) => {
      const reader = new FileReader();
      reader.onloadend = () => {
        resolve({ url: reader.result });
      };
      reader.readAsDataURL(file);
    });
  },
};
