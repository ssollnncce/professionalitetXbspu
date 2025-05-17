<template>
    <div class="profile-card">
        <h2>Редактирование профиля</h2>
        <form @submit.prevent="saveProfile">
          <div class="profile-row">
            <label>Имя</label>
            <input v-model="form.first_name" type="text" />
            <span v-if="errors.first_name" class="error">{{ errors.first_name[0] }}</span>
          </div>
          <div class="profile-row">
            <label>Фамилия</label>
            <input v-model="form.last_name" type="text" />
            <span v-if="errors.last_name" class="error">{{ errors.last_name[0] }}</span>
          </div>
          <div class="profile-row">
            <label>Отчество</label>
            <input v-model="form.patronymic" type="text" />
            <span v-if="errors.patronymic" class="error">{{ errors.patronymic[0] }}</span>
          </div>
          <div class="profile-row">
            <label>Дата рождения</label>
            <input v-model="form.date_of_birth" type="date" />
            <span v-if="errors.date_of_birth" class="error">{{ errors.date_of_birth[0] }}</span>
          </div>
          <div class="profile-actions">
            <button type="submit" class="profile-btn">Сохранить</button>
            <button type="button" class="profile-btn profile-btn-secondary" @click="goBack">Отмена</button>
          </div>
          <span v-if="successMessage" class="success">{{ successMessage }}</span>
          <span v-if="generalError" class="error">{{ generalError }}</span>
        </form>
    </div>
</template>

<script>
import api from '@/api';

export default {
  data() {
    return {
      form: {
        first_name: '',
        last_name: '',
        patronymic: '',
        date_of_birth: '',
      },
      errors: {},
      generalError: '',
      successMessage: '',
    };
  },
  created() {
    this.fetchProfile();
  },
  methods: {
    async fetchProfile() {
      try {
        const token = localStorage.getItem('auth_token');
        const res = await api.get('/account/profile', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });
        const data = res.data.data;
        this.form = {
          first_name: data.first_name,
          last_name: data.last_name,
          patronymic: data.patronymic,
          date_of_birth: data.date_of_birth,
        };
      } catch {
        this.generalError = 'Ошибка загрузки профиля';
      }
    },
    async saveProfile() {
      this.errors = {};
      this.generalError = '';
      this.successMessage = '';
      try {
        const token = localStorage.getItem('auth_token');
        const res = await api.post(
          '/account/profile',
          this.form,
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );
        this.successMessage = 'Профиль успешно обновлен';
        setTimeout(() => this.goBack(), 1200);
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors || {};
        } else {
          this.generalError = 'Ошибка сохранения профиля';
        }
      }
    },
    goBack() {
      this.$router.push('/profile');
    },
  },
};
</script>

<style scoped>
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
input[type="text"],
input[type="email"],
input[type="date"] {
  border: 1px solid #e0e4ef;
  border-radius: 8px;
  padding: 0.7rem 1rem;
  font-size: 1.08rem;
  background: #f5f6f8;
  outline: none;
  transition: border 0.18s;
}
input:focus {
  border-color: #274698;
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
.profile-btn-secondary {
  background: #e0e4ef;
  color: #274698;
}
.profile-btn:hover {
  background: #4f6295;
}
.profile-btn-secondary:hover {
  background: #d3d8e8;
}
.error {
  color: #d32d2f;
  font-size: 0.97rem;
  margin-top: 0.2rem;
  display: block;
}
.success {
  color: #2e7d32;
  font-size: 0.97rem;
  margin-top: 0.5rem;
  display: block;
}
</style>