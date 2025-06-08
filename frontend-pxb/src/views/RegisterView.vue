<template>
  <div class="registration-container">
    <div class="registration-form">
      <h2>Регистрация</h2>
      <form @submit.prevent="register">
        <input type="text" placeholder="Имя" v-model="first_name" />
        <span v-if="errors.first_name" class="error">{{ errors.first_name[0] }}</span>

        <input type="text" placeholder="Фамилия" v-model="last_name" />
        <span v-if="errors.last_name" class="error">{{ errors.last_name[0] }}</span>

        <input type="text" placeholder="Отчество" v-model="patronymic" />
        <span v-if="errors.patronymic" class="error">{{ errors.patronymic[0] }}</span>

        <input
          type="tel"
          placeholder="Телефон"
          v-model="phone"
          @input="formatPhone"
          maxlength="18"
        />
        <span v-if="errors.phone" class="error">{{ errors.phone[0] }}</span>

        <input type="email" placeholder="Email" v-model="email" />
        <span v-if="errors.email" class="error">{{ errors.email[0] }}</span>

        <input type="password" placeholder="Пароль" v-model="password" />
        <span v-if="errors.password" class="error">{{ errors.password[0] }}</span>

        <input type="password" placeholder="Повторите пароль" v-model="password_confirmation" />
        <span v-if="errors.password_confirmation" class="error">{{ errors.password_confirmation[0] }}</span>

        <span v-if="generalError" class="error">{{ generalError }}</span>
        <button type="submit">Зарегистрироваться</button>
      </form>
      <div class="registration-links">
        <span>Уже зарегистрированы?</span>
        <RouterLink to="/login">Войти</RouterLink>
      </div>
      <RouterLink to="/" class="back-link">Вернуться назад</RouterLink>
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
      first_name: '',
      last_name: '',
      patronymic: '',
      phone: '',
      email: '',
      password: '',
      password_confirmation: '',
      errors: {},
      generalError: '',
    };
  },
  methods: {
    formatPhone() {
      // Формат: +7(ххх)ххх-хх-хх
      let digits = this.phone.replace(/\D/g, '');
      if (digits.startsWith('8')) digits = '7' + digits.slice(1);
      if (!digits.startsWith('7')) digits = '7' + digits;
      digits = digits.slice(0, 11); // максимум 11 цифр

      let formatted = '+7';
      if (digits.length > 1) formatted += '(' + digits.slice(1, 4);
      if (digits.length >= 4) formatted += ')';
      if (digits.length >= 5) formatted += digits.slice(4, 7);
      if (digits.length >= 8) formatted += '-' + digits.slice(7, 9);
      if (digits.length >= 10) formatted += '-' + digits.slice(9, 11);

      this.phone = formatted;
    },
    async register() {
      this.errors = {};
      this.generalError = '';
      try {
        const response = await api.post('/register', {
          first_name: this.first_name,
          last_name: this.last_name,
          patronymic: this.patronymic,
          phone: this.phone,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        }, { withCredentials: true });
        this.$router.push('/');
      } catch (error) {
        if (error.response) {
          if (error.response.status === 422) {
            this.errors = error.response.data.errors || {};
          } else if (error.response.status === 401) {
            this.generalError = error.response.data.message || 'Ошибка регистрации';
          }
        } else {
          this.generalError = 'Ошибка сети';
        }
      }
    },
  },
};
</script>

<style scoped>
.error {
  color: #d32d2f;
  font-size: 0.95rem;
  margin-bottom: 0.5rem;
  display: block;
}
</style>