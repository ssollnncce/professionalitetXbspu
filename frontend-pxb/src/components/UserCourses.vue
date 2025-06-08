<script setup>
import { ref, onMounted } from 'vue';
import api from '@/api';

const courses = ref({});
const loading = ref(true);
const error = ref(null);

onMounted(async () => {
  loading.value = true;
  try {
    const response = await api.get('/account/courses');
    courses.value = response.data.inprocess_courses;
    console.log(response.data.inprocess_courses);
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
          <div class="courses-list_items">
            <div class="courses-list_item"  v-for="course in courses" :key="course.id">
              <div class="courses_item-image">
                <div class="course_item-image-color" :style="{ backgroundColor: course.color }"></div>
                <div class="course_item-title">
                  <p>{{course.description.name}}</p>
                </div>
              </div>
              <div class="course_item-description">
                <p>{{course.description.teacher}}</p>
                <p>{{course.description.description}}</p>
                <p>Статус вашей заявки: {{course.status}}</p>
              </div>
            </div>
          </div>
        </div>
    </div>
</template>

<style scoped>
@import '../assets/styles/variables.css';

.courses-list_items {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(15rem, 1fr));
  gap: 2rem;
  padding: 0 5rem;
  color: white;
}

.courses-list_item {
  border-radius: 0.8rem;
  background-color: var(--secondary-color);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  box-sizing: border-box;
}

.courses_item-image {
  position: relative;
  height: 10rem;
}

.course_item-image-color {
  width: 100%;
  height: 100%;
}

.course_item-title {
  position: absolute;
  top: 0.5rem;
  right: 0.5rem;
  color: white;
  padding: 1rem;
  text-align: right;
  font-weight: bold;
}

.course_item-description {
  padding: 1rem;
  flex-grow: 1;
}
</style>