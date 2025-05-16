<template>
  <div class="login-container">
    <div class="login-form">
      <h2>Восстановление пароля</h2>
      <form @submit.prevent="submit">
        <input
          type="email"
          placeholder="Email"
          v-model="email"
        />
        <span v-if="errors.email" class="loginerror">{{ errors.email[0] }}</span>
        <span v-if="generalError" class="loginerror">{{ generalError }}</span>
        <span v-if="successMessage" class="success">{{ successMessage }}</span>
        <button type="submit">Отправить ссылку</button>
      </form>
      <div class="login-links">
        <RouterLink to="/login">Войти</RouterLink>
        <RouterLink to="/register">Зарегистрироваться</RouterLink>
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
      errors: {},
      generalError: '',
      successMessage: '',
    };
  },
  methods: {
    async submit() {
      this.errors = {};
      this.generalError = '';
      this.successMessage = '';
      try {
        await api.post('/forgot-password', { email: this.email });
        this.successMessage = 'Ссылка для сброса пароля отправлена на ваш email';
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors || {};
        } else if (error.response) {
          this.generalError = error.response.data.message || 'Ошибка отправки';
        } else {
          this.generalError = 'Ошибка сети';
        }
      }
    },
  },
};
</script>

<style scoped>
.success {
  color: #2e7d32;
  font-size: 0.95rem;
  margin-bottom: 0.5rem;
  display: block;
}
</style>