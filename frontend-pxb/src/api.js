import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:80/api', // URL к Laravel API
  withCredentials: true, // если используешь куки и sanctum
});

export default api;
