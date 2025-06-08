<script setup>
import Header from '../components/Header.vue';
import ProfileNav from '@/components/ProfileNav.vue';
import UserCourses from '@/components/UserCourses.vue';
</script>

<template>
  <Header />
  <div class="profile-layout">
    <ProfileNav />
    <div class="profile-content">
        <UserCourses />
    </div>
  </div>
</template>

<style scoped>
.profile-layout {
  display: flex;
}

.profile-content {
  flex: 1;
  margin-left: 260px; /* Добавлен отступ для фиксированной навигации */
  padding: 2rem 2rem 2rem 0;
  width: calc(100vw - 260px);
}

@media (max-width: 900px) {
  .profile-content {
    margin-left: 0;
    padding: 1rem;
  }
}
</style>