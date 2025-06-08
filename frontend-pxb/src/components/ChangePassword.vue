<template>
  <div class="change-password_card">
    <h2>Смена пароля</h2>
    <div class="change-password_card-d">
      <div class="change-password_card-object">
        <label for="current_password">Текущий пароль</label>
        <input type="password" id="current_password" v-model="form.current_password">
      </div>
      <div class="change-password_card-object">
        <label for="new_password">Новый пароль</label>
        <input type="password" id="new_password" v-model="form.new_password">
      </div>
      <div class="change-password_card-object">
        <label for="new_password_confirmation">Подтвердите новый пароль</label>
        <input type="password" id="new_password_confirmation" v-model="form.new_password_confirmation">
      </div>
    </div>
    <button @click="changePassword">Сменить пароль</button>
    <p v-if="message">{{ message }}</p>
  </div>
</template>

<script>
import api from '../api.js';

export default {
  data() {
    return {
      form: {
        current_password: '',
        new_password: '',
        new_password_confirmation: ''
      },
      message: ''
    };
  },
  methods: {
    async changePassword() {
      try {
        const token = localStorage.getItem('auth_token');
        const response = await api.post('change-password', this.form, { withCredentials: true });
        this.message = 'Пароль успешно изменён';
        this.form.current_password = '';
        this.form.new_password = '';
        this.form.new_password_confirmation = '';
      } catch (error) {
        this.message = error.response?.data?.message || 'Произошла ошибка';
      }
    }
  }
};
</script>

<style scoped>
.change-password_card {
  margin-top: 2rem;
  padding: 1.5rem;
  background-color: #f1f0f0;
  width: 100%;
}

.change-password_card-d {
  display: flex;
  flex-direction: column;
  width: 100%;
  gap: 1rem;
}

.change-password_card-object {
  display: flex;
  flex-direction: column;
  margin: 0.8rem 0;
  flex: 1;
}

.change-password_card-object label {
  margin-bottom: 0.4rem;
  font-weight: normal;
}

.change-password_card-object input {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 0.3rem;
}

button {
  margin-top: 1rem;
  padding: 0.6rem 1.2rem;
  background-color: #007BFF;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}
</style>