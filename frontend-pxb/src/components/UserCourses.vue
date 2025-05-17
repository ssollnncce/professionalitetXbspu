<script setup>
import { ref, onMounted } from 'vue';
import api from '@/api';

const courses = ref({});
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
  loading.value = true;
  try {
    const response = await api.get('/account/courses', {
        headers: {
            Authorization: `Bearer ${localStorage.getItem('auth_token')}`,
        },
    });
    courses.value = response.data.inprocess_courses;
  } catch (e) {
    error.value = 'Ошибка загрузки курсов';
  } finally {
    loading.value = false;
  }
});
</script>

<template>
    <div class="usercourses-container">
        <div v-if="error" class="courses-error">{{ error }}</div>
        <div v-else>
            <div v-if="courses.length === 0" class="courses-empty">
                Вы пока не записаны ни на один курс.
            </div>
            <div v-else class="courses-list">
                <div v-for="course in courses" :key="course.id" class="course-card">
                    <img v-if="course.description.image_path" :src="course.description.image_path" alt="course image" class="course-image"/>
                    <div class="course-info">
                        <h3 class="course-name">{{ course.description.name }}</h3>
                        <p class="course-desc">{{ course.description.description }}</p>
                            <div class="course-meta">
                                <span>Преподаватель: {{ course.description.teacher }}</span>
                                <span>Длительность: {{ course.description.duration }}</span>
                                <span>Направление: {{ course.description.course_family }}</span>
                            </div>
                        <span class="course-status">Статус: {{ course.status }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.courses-title {
  font-size: 1.5rem;
  margin-bottom: 1rem;
  font-weight: 600;
}
.courses-loading,
.courses-error,
.courses-empty {
  margin: 2rem 0;
  color: #888;
  text-align: center;
}
.courses-list {
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem;
}
.course-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  padding: 1.5rem;
  display: flex;
  flex-direction: row;
  align-items: flex-start;
  width: 350px;
  min-height: 180px;
}
.course-image {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border-radius: 8px;
  margin-right: 1rem;
  background: #f3f3f3;
}
.course-info {
  flex: 1;
}
.course-name {
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}
.course-desc {
  font-size: 0.95rem;
  color: #555;
  margin-bottom: 0.5rem;
}
.course-meta {
  font-size: 0.9rem;
  color: #888;
  margin-bottom: 0.5rem;
  display: flex;
  flex-direction: column;
  gap: 0.2rem;
}
.course-status {
  font-size: 0.9rem;
  color: #1976d2;
  font-weight: 500;
}
</style>