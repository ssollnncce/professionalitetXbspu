<script setup>
import api from '@/api';
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const profile = ref({});
const loading = ref(true);
const router = useRouter();

const fetchProfile = async () => {
  try {
    const token = localStorage.getItem('auth_token');
    const res = await api.get('/account/profile', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    profile.value = res.data.data;
  } finally {
    loading.value = false;
  }
};

onMounted(fetchProfile);

const goToEdit = () => {
  router.push('/profile/edit');
};
</script>

<template>
    <div class="profile-card" v-if="!loading">
        <h2>Профиль пользователя</h2>
        <div class="profile-row">
          <label>Имя</label>
          <div>{{ profile.first_name }}</div>
        </div>
        <div class="profile-row">
          <label>Фамилия</label>
          <div>{{ profile.last_name }}</div>
        </div>
        <div class="profile-row">
          <label>Отчество</label>
          <div>{{ profile.patronymic }}</div>
        </div>
        <div class="profile-row">
          <label>Дата рождения</label>
          <div>{{ profile.date_of_birth || '—' }}</div>
        </div>
        <div class="profile-row">
          <label>Email</label>
          <div>{{ profile.email }}</div>
        </div>
        <div class="profile-row">
          <label>Телефон</label>
          <div>{{ profile.phone }}</div>
        </div>
        <div class="profile-row" v-if="profile.profile_photo_path">
          <label>Фото профиля</label>
          <img :src="profile.profile_photo_path" alt="Фото профиля" class="profile-photo" />
        </div>
        <div class="profile-actions">
          <button class="profile-btn" @click="goToEdit">Редактировать</button>
        </div>
    </div>
    <div v-else class="profile-card">Загрузка...</div>
</template>

<style>
.profile-content {
  padding: 2rem 2.5rem;
  min-width: 0;
  flex: 1 1 0;
}
.profile-card {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 2px 12px 0 rgba(39, 70, 152, 0.07);
  padding: 2rem 2.5rem;
  max-width: 540px;
  margin: 0 auto;
}
h2 {
  font-size: 1.4rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  color: #274698;
}
.profile-row {
    color: black;
  margin-bottom: 1.2rem;
  display: flex;
  flex-direction: column;
}
label {
  font-size: 1.05rem;
  font-weight: 500;
  margin-bottom: 0.4rem;
  color: #274698;
}
.profile-photo {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 50%;
  border: 2px solid #e0e4ef;
  margin-top: 0.5rem;
}
.profile-actions {
  display: flex;
  gap: 1rem;
  margin-top: 1.5rem;
}
.profile-btn {
  background: #274698;
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 0.7rem 1.5rem;
  font-size: 1.08rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.18s;
}
.profile-btn:hover {
  background: #4f6295;
}
</style>