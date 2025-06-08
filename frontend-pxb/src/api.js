import axios from 'axios';

const api = axios.create({
  baseURL: 'http://profxbspuadmin.ssollnncce.ru/api', // URL к Laravel API
  withCredentials: true, // если используешь куки и sanctum
});

const web = axios.create({
  baseURL: 'http://profxbspuadmin.ssollnncce.ru', // URL к Laravel API
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

export { web };
export default api;
