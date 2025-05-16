<template>
    <div class="login-container">
        <div class="login-form">
            <h2>Авторизация</h2>
            <form @submit.prevent="login">
                <span class="loginerror">{{ generalError }}</span>
                <input type="email" placeholder="Email" v-model="email">
                <span v-if="errors.email" class="loginerror">{{ errors.email[0] }}</span>
                <input type="password" placeholder="Пароль" v-model="password">
                <span v-if="errors.password" class="loginerror">{{ errors.password[0] }}</span>
                <button type="submit">Войти</button>
            </form>
            <div class="login-links">
                <RouterLink to="/register">Зарегистрироваться</RouterLink>
                <RouterLink to="/forgot-password">Забыли пароль?</RouterLink>
            </div>
            <RouterLink to="/" class="back-link">Вернуться на главную</RouterLink>
        </div>
    </div>
</template>

<script>
import { RouterLink } from 'vue-router';
import api from '@/api';
import '../assets/styles/auth.css';

export default {
  data() {
    return {
      email: '',
      password: '',
      errors: {},
      generalError: '',
    };
  },
  methods: {
    async login() {
      this.errors = {};
      this.generalError = '';

      try {
        const response = await api.post('/login', {
          email: this.email,
          password: this.password,
        });

        // Сохраняем токен
        localStorage.setItem('auth_token', response.data.data.token);

        // Переходим на страницу аккаунта (или куда нужно)
        this.$router.push('/');

      } catch (error) {
        if (error.response) {
          if (error.response.status === 422) {
            // Ошибки валидации
            this.errors = error.response.data.errors || {};
          } else if (error.response.status === 401) {
            // Ошибка авторизации
            this.generalError = error.response.data.message || 'Неверный логин или пароль';
          } else {
            this.generalError = 'Произошла ошибка, попробуйте позже';
          }
        } else {
          this.generalError = 'Нет ответа от сервера';
        }
      }
    },
  },
  mounted() {
    // Проверяем, есть ли токен в localStorage
    const token = localStorage.getItem('auth_token');
    if (token) {
      this.$router.push('/');
    }
  },
};

</script>

<style scoped>

</style>