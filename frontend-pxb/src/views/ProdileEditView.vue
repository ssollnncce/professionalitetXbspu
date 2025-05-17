<script setup>
import Header from '../components/Header.vue';
import ProfileNav from '@/components/ProfileNav.vue';
import UserEdit from '@/components/UserEdit.vue';
</script>

<template>
  <Header />
  <div class="profile-layout">
    <ProfileNav />
    <div class="profile-content">
        <UserEdit />
    </div>
  </div>
</template>

<style scoped>
.profile-layout {
  display: flex;
}
</style>