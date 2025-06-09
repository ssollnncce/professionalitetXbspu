<template>
  <div class="not-found">
    <h1 class="error-code">404</h1>
    <p class="error-message">Страница не найдена</p>
    <router-link to="/" class="back-home">Вернуться на главную</router-link>
  </div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>

<style scoped>
@import '../assets/styles/variables.css';

.not-found {
  width: 100vw;
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
}

.error-code {
  font-size: 10rem;
  color: var(--primary-color);
}

.error-message {
  font-size: 24px;
  margin-top: 20px;
  color: black;
}
</style>