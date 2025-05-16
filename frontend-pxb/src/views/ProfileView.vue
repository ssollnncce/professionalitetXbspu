<script setup>
import Header from '../components/Header.vue';
import ProfileNav from '@/components/ProfileNav.vue';
</script>

<template>
  <Header />
  <div class="profile-layout">
    <ProfileNav />
    <div class="profile-content">
      <router-view />
    </div>
  </div>
</template>

<style scoped>
.profile-layout {
  display: flex;
}
</style>