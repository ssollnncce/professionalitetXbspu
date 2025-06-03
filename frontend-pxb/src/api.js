import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:80/api', // URL к Laravel API
  withCredentials: true, // если используешь куки и sanctum
});

api.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
}, (error) => {
  return Promise.reject(error);
});

export default api;
