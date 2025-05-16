<template>
  <nav class="navbar">
    <div class="container">
      <div class="logo">
        <RouterLink to="/">
          <span>
            <img class="logo-image" src="../assets/logo.svg" />
          </span>
        </RouterLink>
      </div>

      <button class="burger" @click="toggleMenu" aria-label="Открыть меню">
        <svg
          v-if="!isMenuOpen"
          width="36"
          height="36"
          viewBox="0 0 36 36"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <rect y="8" width="36" height="4" rx="2" fill="white"/>
          <rect y="16" width="36" height="4" rx="2" fill="white"/>
          <rect y="24" width="36" height="4" rx="2" fill="white"/>
        </svg>
        <svg
          v-else
          width="36"
          height="36"
          viewBox="0 0 36 36"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <rect x="8" y="8" width="28" height="4" rx="2" transform="rotate(45 8 8)" fill="white"/>
          <rect x="8" y="28" width="28" height="4" rx="2" transform="rotate(-45 8 28)" fill="white"/>
        </svg>
      </button>

      <!-- Меню для десктопа -->
      <ul class="main-links desktop">
        <li>
          <RouterLink to="/" exact>Главная</RouterLink>
        </li>
        <li>
          <RouterLink to="/courses" exact>Курсы</RouterLink>
        </li>
        <li>
          <RouterLink to="/teachers" exact>Преподаватели</RouterLink>
        </li>
      </ul>
      <ul class="auth-links desktop">
        <li v-if="isAuthenticated">
          <RouterLink to="/profile">Аккаунт</RouterLink>
        </li>
        <template v-else>
          <li>
            <RouterLink to="/login">Войти</RouterLink>
          </li>
          <li>
            <RouterLink to="/register">Зарегистрироваться</RouterLink>
          </li>
        </template>
      </ul>

      <!-- Меню для мобильного (бургер) -->
      <div class="mobile-menu" v-if="isMenuOpen">
        <ul class="main-links">
          <li>
            <RouterLink to="/" exact @click="toggleMenu">Главная</RouterLink>
          </li>
          <!-- Добавьте другие пункты основного меню здесь -->
        </ul>
        <ul class="auth-links">
          <li v-if="isAuthenticated">
            <RouterLink to="/profile" @click="toggleMenu">Аккаунт</RouterLink>
          </li>
          <template v-else>
            <li>
              <RouterLink to="/login" @click="toggleMenu">Войти</RouterLink>
            </li>
            <li>
              <RouterLink to="/register" @click="toggleMenu">Зарегистрироваться</RouterLink>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { RouterLink } from 'vue-router';

export default {
  name: 'Navbar',
  data() {
    return {
      isMenuOpen: false,
      isAuthenticated: false,
    };
  },
  mounted() {
    const token = localStorage.getItem('auth_token');
    this.isAuthenticated = !!token;
  },
  methods: {
    toggleMenu() {
      this.isMenuOpen = !this.isMenuOpen;
    },
  },
};
</script>

<style scoped>
.logo-image {
  width: 112px;
  height: auto;
}
.navbar {
  background-color: #274698;
}
.container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 1rem 157px;
  position: relative;
  min-height: 56px;
}
.logo {
  flex: 0 0 auto;
}
.main-links,
.auth-links {
  display: flex;
  gap: 1rem;
  list-style: none;
  margin: 0;
  padding: 0;
}
.main-links li a,
.auth-links li a {
  text-decoration: none;
  color: white;
  font-weight: 500;
  transition: color 0.3s;
}
.main-links li a.router-link-active,
.auth-links li a.router-link-active {
  color: #fff;
  font-weight: 700;
  background-color: #4f6295;
  border-radius: 0.4rem;
  padding: 0.5rem;
}
.main-links li a:hover,
.auth-links li a:hover {
  font-weight: 700;
}

/* Desktop only */
.desktop {
  display: flex;
}
.burger {
  display: none;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.25rem;
  margin-left: auto;
  z-index: 11;
}

/* Мобильный стиль */
@media (max-width: 768px) {
  .container {
    flex-direction: row;
    padding: 0.25rem 0.5rem;
    min-height: 44px;
  }
  .logo {
    margin-bottom: 0;
  }
  .desktop {
    display: none !important;
  }
  .burger {
    display: block;
  }
  .mobile-menu {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #274698;
    z-index: 10;
    padding: 0.5rem 1rem 1rem 1rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    border-bottom-left-radius: 8px;
    border-bottom-right-radius: 8px;
  }
  .mobile-menu .main-links,
  .mobile-menu .auth-links {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
  }
  .mobile-menu .main-links li a,
  .mobile-menu .auth-links li a {
    color: #fff;
    font-size: 1.1rem;
    border-bottom: none;
  }
  .mobile-menu .main-links li a.router-link-active,
  .mobile-menu .auth-links li a.router-link-active {
    color: #fff;
    font-weight: 700;
  }
}
</style>
