<script>
import { RouterLink } from 'vue-router';
import api from '@/api';
// Установка Bootstrap / Install Bootstrap
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js';

export default {
  name: 'Header',
  data() {
    return {
      user: [],
      isAuthenticated: false,
    }
  },
  mounted() {
    const token = localStorage.getItem('auth_token');
    this.isAuthenticated = !!token;
  },
  created() {
    this.getUser();
  },
  methods: {
    async getUser() {
      try {
        const response = await api.get('/account/profile');
        this.user = response.data.data;
      } catch (error) {
        console.error('Возникли ошибки при получении данных', error);
      }
    },
  }
}


</script>

<template>
  <nav class="navbar fixed-top navbar-expand-lg">
    <div class="container-fluid custom-header">
      <RouterLink to="/" class="navbar-brand">
        <img class="logo-image" src="../assets/logo.svg" />
      </RouterLink>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <RouterLink to="/" class="nav-link">Главная</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink to="/courses" class="nav-link">Курсы</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink to="/teachers" class="nav-link">Преподаватели</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink to="/contacts" class="nav-link">О нас</RouterLink>
          </li>
        </ul>
      </div>
      <div class="d-flex">
        <div v-if="isAuthenticated" class="dropdown">
          <button class="btn dropdown-toggle user-menu-btn" type="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false">
            {{user.first_name}} {{user.last_name}}
          </button>
          <ul class="dropdown-menu dropdown-end">
            <li>
              <RouterLink to="/profile/info" class="dropdown-item">Личная информация</RouterLink>
            </li>
            <li>
              <RouterLink to="/profile/courses" class="dropdown-item">Мои курсы</RouterLink>
            </li>
          </ul>
        </div>
        <RouterLink v-else to="/login" class="login-link">Войти / Зарегестрироваться</RouterLink>
      </div>
    </div>
  </nav>
</template>

<style scoped>
.navbar {
  padding: 0;
}

.custom-header {
  background-color: #0040C1;
  padding: 1rem 1rem; /* Уменьшите отступы для мобильных устройств */
  min-height: 100%;
  display: flex; /* Используйте Flexbox */
  flex-direction: row; /* Расположите элементы в строку */
  align-items: center; /* Центрируйте элементы по вертикали */
}

.navbar-nav .nav-item a {
  padding: 0.5rem;
  color: #fff;
}

.navbar-nav .nav-item a.router-link-active {
  background-color: #3367CC;
  border-radius: 0.5rem;
}

.login-link {
  color: white;
}

.user-menu-btn {
  border: none;
  color: white;
}

/* Добавьте медиа-запрос для мобильных устройств */
@media (max-width: 768px) {
  .navbar-nav {
    flex-direction: row; /* Расположите навигацию в строку */
    justify-content: center; /* Центрируйте навигацию */
    width: 100%; /* Задайте ширину 100% для навигации */
  }

  .navbar-nav .nav-item {
    margin: 0 10px; /* Добавьте отступы между элементами навигации */
  }

  .custom-header {
    flex-wrap: wrap; /* Позвольте элементам переноситься на новую строку при необходимости */
  }
}
</style>