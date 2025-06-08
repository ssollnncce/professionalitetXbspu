<template>
  <div class="profile-navigation">
    <ul class="profile-navigation__list">
      <li>
        <RouterLink
          to="/profile/info"
          class="profile-navigation__item"
          exact
        >
          <font-awesome-icon :icon="['far', 'user']" />
          <span>Личная информация</span>
        </RouterLink>
      </li>
      <li>
        <RouterLink
          to="/profile/courses"
          class="profile-navigation__item"
          exact
        >
          <font-awesome-icon :icon="['far', 'file-lines']" />
          <span>Мои курсы</span>
        </RouterLink>
      </li>
    </ul>
    <div class="profile-navigation__logout">
      <button @click="logout">
        <font-awesome-icon :icon="['fas', 'arrow-left']" />
        <span>Выйти</span>
      </button>
    </div>
  </div>
</template>

<script>
import api from '../api';
import { RouterLink } from 'vue-router';
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Cookies from "js-cookie";

export default {
  name: 'ProfileNav',
  components: { FontAwesomeIcon },

  methods: {
    async logout() {
      try {
        const token = localStorage.getItem('auth_token');
        await api.post('/logout', {}, { withCredentials: true });

        localStorage.removeItem('auth_token');
        Cookies.remove('professionalitet_x_bspu_session', { domain: 'profxbspu.ssollnncce.ru' });
        Cookies.remove('XSRF-TOKEN', { domain: 'profxbspu.ssollnncce.ru' });
        this.$router.push('/login');
      } catch (error) {
        console.log('Ошибка при выходе из системы:', error);
      }
    }
  }
}
</script>

<style scoped>
.profile-navigation {
  display: flex;
  flex-direction: column;
  height: 100%;
  justify-content: space-between;
}
.profile-navigation__list {
  list-style: none;
  padding: 0;
  margin: 0;
}
.profile-navigation__item {
  display: flex;
  align-items: center;
  padding: 1rem;
  font-size: 1.2rem;
  color: #222;
  text-decoration: none;
  border-radius: 8px;
  transition: background 0.2s;
}
.profile-navigation__item svg {
  margin-right: 1rem;
  width: 28px;
  height: 28px;
  color: #3b82f6;
}
.profile-navigation__item.router-link-exact-active {
  background: #f3f6fa;
  font-weight: 700;
}
.profile-navigation__item:hover {
  background: #f3f6fa;
}
.profile-navigation__logout {
  margin-top: 2rem;
  padding: 1rem;
  border-top: 1px solid #eee;
}
.profile-navigation__logout button {
  display: flex;
  align-items: center;
  background: none;
  border: none;
  color: #3b82f6;
  font-size: 1.1rem;
  cursor: pointer;
  padding: 0;
}
.profile-navigation__logout svg {
  margin-right: 0.5rem;
}
</style>