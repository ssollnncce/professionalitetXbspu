<script setup>
//Импортирование компонентов || Import components
import Header from '../components/Header.vue';
import ProfileNav from '@/components/ProfileNav.vue';
import UserInfo from '@/components/UserInfo.vue';

</script>

<template>
  <Header class="header-container"/>
  <div class="profile-content">
    <div class="profile-content_navigation">
      <ProfileNav></ProfileNav>
    </div>
    <div class="profile-content_info">
      <RouterView/>
    </div>
  </div>
</template>

<style scoped>
  .header-container {
    position: fixed;
    width: 100%;
  }
  .profile-content {
    display: flex;
    width: 100vw;
    height: 100vh;
    padding-top: 85px;
    box-sizing: border-box;
  }

  .profile-content_navigation {
    width: 20%;
    position: fixed;
    top: 85px;
    bottom: 0;
    left: 0;
    overflow-y: auto;
    padding: 1rem;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .profile-content_info {
    box-sizing: border-box;
    display: flex;
    width: 80%;
    overflow-y: auto;
    margin-left: 20%;
    padding: 2rem;
    color: black;
    flex-direction: column;
    align-items: center;
  }

</style>