import axios from 'axios';
import Cookies from 'js-cookie';

const api = axios.create({
  baseURL: 'http://profxbspuadmin.ssollnncce.ru/api', // URL к Laravel API
  withCredentials: true, // если используешь куки и sanctum
});

const web = axios.create({
  baseURL: 'http://profxbspuadmin.ssollnncce.ru', // URL к Laravel API
  withCredentials: true, // если используешь куки и sanctum
});

api.interceptors.request.use((config) => {
  // получаем токен из cookie
  const csrfToken = Cookies.get('professionalitet_x_bspu_session');
  const token = localStorage.getItem('auth_token');

  if (csrfToken) {
    config.headers['X-XSRF-TOKEN'] = csrfToken;
  }

  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }

  return config;
}, (error) => {
  return Promise.reject(error);
});

export { web };
export default api;
