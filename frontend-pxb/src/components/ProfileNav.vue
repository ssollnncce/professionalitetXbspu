<template>
    <nav class="profile-nav">
        <div class="profile-links">
            <RouterLink to="/profile" class="profile-link" :class="{ active: $route.path === '/profile' }">
                Личная информация
            </RouterLink>
            <RouterLink to="/profile/courses" class="profile-link" :class="{ active: $route.path === '/profile/courses' }">
                Курсы
            </RouterLink>
        </div>
        <div class="profile-nav-bottom">
            <button class="logout-btn" @click="logout">Выйти</button>
        </div>
    </nav>
</template>

<script>
import { RouterLink } from 'vue-router';
import api from '@/api';

export default {
  name: 'ProfileNav',
  methods: {
    async logout() {
      try {
        const token = localStorage.getItem('auth_token');
        await api.post('/logout', {}, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        localStorage.removeItem('auth_token');
        this.$router.push('/');
      } catch (error) {
        console.error('Logout failed:', error);
      }
    },
  },
};
</script>

<style scoped>
.profile-nav {
    position: fixed;
    top: 88px; /* высота вашей шапки */
    left: 0;
    width: 260px;
    height: calc(100vh - 88px);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: none;
    border-right: 1px solid #e0e4ef;
    padding: 2rem 1rem;
    box-sizing: border-box;
    z-index: 100;
}

.profile-links {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.profile-link {
    display: block;
    color: #000;
    text-decoration: none;
    font-size: 1.125rem; /* 18px */
    font-weight: 400;
    padding: 18px 20px;
    border-radius: 16px;
    transition: background 0.18s, font-weight 0.18s;
    background: none;
}

.profile-link.active {
    background: #f5f6f8;
    font-weight: 700;
}

.profile-link:hover:not(.active) {
    background: #f0f1f3;
}

.logout-btn {
    width: 100%;
    border: none;
    background: #fbeaea;
    color: #d32d2f;
    padding: 18px 20px;
    border-radius: 16px;
    font-size: 1.125rem;
    font-weight: 700;
    cursor: pointer;
    margin-top: 1rem;
    transition: background 0.18s, color 0.18s;
}

.logout-btn:hover {
    background: #f5c6cb;
    color: #a71d2a;
}

@media (max-width: 900px) {
    .profile-nav {
        position: static;
        width: 100%;
        height: auto;
        border-right: none;
        border-bottom: 1px solid #e0e4ef;
        flex-direction: row;
        padding: 0.5rem 0.5rem;
        gap: 0.3rem;
        justify-content: flex-start;
    }
    .profile-links {
        flex-direction: row;
        gap: 0.3rem;
    }
    .profile-link,
    .logout-btn {
        font-size: 1rem;
        padding: 0.7rem 0.7rem;
        text-align: center;
        border-radius: 10px;
    }
}
</style>