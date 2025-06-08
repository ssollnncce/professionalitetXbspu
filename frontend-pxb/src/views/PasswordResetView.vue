<template>
  <div class="login-container">
    <div class="login-form">
      <h2>Задайте новый пароль</h2>
      <form @submit.prevent="submit">
        <input
          type="password"
          placeholder="Новый пароль"
          v-model="password"
        />
        <span v-if="errors.password" class="loginerror">{{ errors.password[0] }}</span>

        <input
          type="password"
          placeholder="Повторите новый пароль"
          v-model="password_confirmation"
        />
        <span v-if="errors.password_confirmation" class="loginerror">{{ errors.password_confirmation[0] }}</span>

        <span v-if="generalError" class="loginerror">{{ generalError }}</span>
        <span v-if="successMessage" class="success">{{ successMessage }}</span>
        <button type="submit">Сохранить новый пароль</button>
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
import { RouterLink, useRoute, useRouter } from 'vue-router';
import api from '@/api';
import '../assets/styles/auth.css';

export default {
  data() {
    return {
      password: '',
      password_confirmation: '',
      errors: {},
      generalError: '',
      successMessage: '',
      loading: false,
    };
  },
  mounted() {
    // Получаем токен и email из query-параметров
    const route = this.$route;
    this.token = route.query.token || route.params.token;
    this.email = route.query.email || '';
  },
  methods: {
    async submit() {
      this.errors = {};
      this.generalError = '';
      this.successMessage = '';
      this.loading = true;
      try {
        const token = this.$route.query.token || this.$route.params.token;
        const email = this.$route.query.email || '';
        const response = await api.post('/reset-password', {
          email,
          token,
          password: this.password,
          password_confirmation: this.password_confirmation,
        }, { withCredentials: true });
        this.successMessage = 'Пароль успешно изменён. Теперь вы можете войти.';
        setTimeout(() => {
          this.$router.push('/login');
        }, 2000);
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors || {};
        } else if (error.response) {
          this.generalError = error.response.data.message || 'Ошибка сброса пароля';
        } else {
          this.generalError = 'Ошибка сети';
        }
      } finally {
        this.loading = false;
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