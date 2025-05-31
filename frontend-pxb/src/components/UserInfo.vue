<template>
  <div class="user-info_card">
    <div class="user-info_card-d">
      <div class="user-indo_card-object">
        <label for="first_name">Имя</label>
        <input type="text" id="first_name" v-model="userdata.first_name">
      </div>
      <div class="user-indo_card-object">
        <label for="last_name">Фамилия</label>
        <input type="text" id="last_name" v-model="userdata.last_name">
      </div>
    </div>
    <div class="user-info_card-s">
      <div class="user-indo_card-object">
        <label for="patronymic">Отчество</label>
        <input type="text" id="patronymic" v-model="userdata.patronymic">
      </div>
    </div>
    <div class="user-info_card-s">
      <div class="user-indo_card-object">
        <label for="date_of_birth">Дата рождения</label>
        <input type="date" id="date_of_birth" v-model="userdata.date_of_birth">
      </div>
    </div>
    <h2>Контактная информация</h2>
    <div class="user-info_card-s">
      <div class="user-indo_card-object">
        <label for="email">Электронная почта</label>
        <input type="email" id="email" v-model="userdata.email" readonly>
      </div>
    </div>
    <div class="user-info_card-s">
      <div class="user-indo_card-object">
        <label for="phone">Номер телефона</label>
        <input type="text" id="phone" v-model="userdata.phone" readonly>
      </div>
    </div>

    <button :disabled="!isChanged" @click="saveChanges">Сохранить</button>
  </div>

  <div class="user-info_card-password">
    <router-link to="/profile/change-password" class="user-info_card-password-link">
      <font-awesome-icon :icon="['fas', 'key']" />
      <span class="text">Изменить пароль</span>
      <font-awesome-icon :icon="['fas', 'arrow-right']" />
    </router-link>
  </div>
</template>

<script>
import api from '../api.js';

export default {
  name: 'UserInfo',
  data() {
    return {
      userdata: {},
      originalUserdata: {}
    };
  },
  computed: {
    isChanged() {
      return JSON.stringify(this.userdata) !== JSON.stringify(this.originalUserdata);
    }
  },
  mounted() {
    this.getUserInfo();
  },
  methods: {
    async getUserInfo() {
      const token = localStorage.getItem('auth_token');
      const response = await api.get('/account/profile', {
        headers: { Authorization: `Bearer ${token}` }
      });
      this.userdata = response.data.data;
      this.originalUserdata = JSON.parse(JSON.stringify(this.userdata));
    },
    async saveChanges() {
      const token = localStorage.getItem('auth_token');
      try {
        await api.post('/account/profile', this.userdata, {
          headers: { Authorization: `Bearer ${token}` }
        });
        this.originalUserdata = JSON.parse(JSON.stringify(this.userdata));
        alert('Данные успешно сохранены');
      } catch (error) {
        alert('Ошибка при сохранении данных');
        console.error(error);
      }
    }
  }
};
</script>

<style scoped>
  input {
    border: 1px solid lightgray;
    color: lightgray;
    padding: 0.5rem;
    border-radius: 0.3rem;
    font-size: 1rem;
  }
  input:focus{
    border: 2px solid #274698;
    color: black;
    box-shadow: none;
  }

  .user-info_card {
    width: 80%;
    border-radius: 0.3rem;
    padding: 0.5rem;
    height: fit-content;
    background-color: #f1f0f0;
  }
  .user-info_card-d {
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }
  .user-info_card-d .user-indo_card-object {
    width: 48%;
  }
  .user-indo_card-object {
    display: flex;
    flex-direction: column;
    margin: 0.8rem 0;
  }
  button:disabled {
    width: 100%;
    color: black;
    background-color: lightgray;
    border: none;
    border-radius: 0.3rem;
    padding: 0.5rem;
    font-size: 1rem;
  }
  button {
    background-color: #274698;
    color: white;
    width: 100%;
    border: none;
    border-radius: 0.3rem;
    padding: 0.5rem;
    font-size: 1rem;
  }
  .user-info_card-password {
    margin-top: 1rem;
  }

  .user-info_card-password-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: white;
    padding: 0.75rem 1rem;
    border-radius: 0.3rem;
    text-decoration: none;
    color: #274698;
    font-weight: bold;
    font-size: 1rem;
  }

  .user-info_card-password-link .text {
    margin: 0 1rem;
    flex: 1;
    text-align: left;
  }
</style>
