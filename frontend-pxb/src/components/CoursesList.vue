<script>
import api from "@/api.js";

export default {
  name: 'CoursesList',
  props: ['selectedFamily'],
  data() {
    return {
      courses: [],
      showModal: false,
      selectedCourse: null,
      bookingLoading: false,
      bookingError: null,
      bookingSuccess: null,
    }
  },
  created() {
    this.getAllCourses();
  },
  watch: {
    selectedFamily() {
      this.getAllCourses();
    }
  },
  methods: {
    async getAllCourses() {
      try {
        const params = {};
        if (this.selectedFamily) params.course_family = this.selectedFamily;
        const res = await api.get('/courses', { params });
        this.courses = res.data.data || [];
        console.log(res.data.data);
      }catch (error) {
        console.error('Во время получения курсов произошла ошибка: ', error);
      }
    },
    openBookingModal(course) {
      this.selectedCourse = course;
      this.showModal = true;
      this.bookingError = null;
      this.bookingSuccess = null;
    },
    closeBookingModal() {
      this.showModal = false;
      this.selectedCourse = null;
      this.bookingError = null;
      this.bookingSuccess = null;
    },
    async bookCourse() {
      if (!this.selectedCourse) return;
      this.bookingLoading = true;
      this.bookingError = null;
      this.bookingSuccess = null;
      try {
        const token = localStorage.getItem('auth_token');
        await api.post(`/courses/${this.selectedCourse.id}/book`);
        this.bookingSuccess = 'Вы успешно записались на курс!';
      } catch (e) {
        this.bookingError = e.response?.data?.message || 'Ошибка записи на курс';
      } finally {
        this.bookingLoading = false;
      }
    },
  }
}
</script>

<template>
  <div class="courses-list">
    <h2>Наши курсы</h2>
    <div class="courses-list_items">
      <div class="courses-list_item"  v-for="course in courses" :key="course.id">
        <div class="courses_item-image">
          <div class="course_item-image-color" :style="{ backgroundColor: course.course_family.color }"></div>
          <div class="course_item-title">
            <p>{{course.name}}</p>
          </div>
        </div>
        <div class="course_item-description">
          <p>{{course.teacher.full_name}}</p>
          <p>{{course.description}}</p>
          <p :class="{ 'slots-low': course.freeSlots < 5 }">Осталось мест: {{course.freeSlots}}</p>
          <p>{{course.price}} &#8381;</p>
        </div>
        <div class="courses_item-button">
          <RouterLink to="/courses/{course.id}" id="course">Подробнее</RouterLink>
          <button @click="openBookingModal(course)" id="course">Записаться</button>
        </div>
      </div>
    </div>
  </div>

  <!--  Модальное окно-->
  <div v-if="showModal" class="modal-overlay" @click.self="closeBookingModal">
    <div class="modal-window">
      <h3>Записаться на курс</h3>
      <p style="margin-bottom: 0.5rem; color: #274698; font-weight: 600;">
        Вы уверены, что хотите записаться на курс?
      </p>
      <p v-if="selectedCourse">
        <b>{{ selectedCourse.name }}</b>
      </p>
      <div v-if="bookingError" class="modal-error">{{ bookingError }}</div>
      <div v-if="bookingSuccess" class="modal-success">{{ bookingSuccess }}</div>
      <div class="modal-actions" v-if="!bookingSuccess">
        <button @click="bookCourse" :disabled="bookingLoading" class="modal-confirm-btn">
          {{ bookingLoading ? 'Записываем...' : 'Записаться' }}
        </button>
        <button @click="closeBookingModal" class="modal-cancel-btn">Отмена</button>
      </div>
      <div class="modal-actions" v-else>
        <button @click="closeBookingModal" class="modal-confirm-btn">Закрыть</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import '../assets/styles/variables.css';

.courses-list_items {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
  gap: 2rem;
  padding: 0 5rem;
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
.courses_item-button{
  width: 100%;
  display: flex;
  justify-content: center;
}
#course {
  text-decoration: none;
  width: 100%;
  padding:  0.5rem;
  background-color: white;
  color: black;
  border-radius: 0.8rem;
  margin: 0.5rem;
  text-align: center;
  border: none;
}
#course:hover {
  background-color: var(--primary-color);
  color: white;
  transition: 0.3s;
}

.modal-overlay {
  position: fixed;
  z-index: 2000;
  left: 0; top: 0; right: 0; bottom: 0;
  background: rgba(39, 70, 152, 0.18);
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-window {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 32px 0 rgba(39,70,152,0.13);
  padding: 2rem 2.5rem;
  min-width: 320px;
  max-width: 90vw;
  text-align: center;
}
.modal-actions {
  display: flex;
  gap: 1rem;
  justify-content: center;
  margin-top: 1.5rem;
}
.modal-confirm-btn {
  background: var(--light-primary-color);
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 0.6rem 1.5rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.18s;
}
.modal-confirm-btn:hover {
  background: var(--primary-color);
}
.modal-cancel-btn {
  background: #f5f6f8;
  color: var(--light-primary-color);
  border: none;
  border-radius: 10px;
  padding: 0.6rem 1.5rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.18s;
}
.modal-cancel-btn:hover {
  background: #e0e4ef;
}
.modal-error {
  color: #d32d2f;
  margin-top: 1rem;
}
.modal-success {
  color: #388e3c;
  margin-top: 1rem;
}

.slots-low {
  color: #d32d2f;
  font-weight: 700;
}

/* Медиа-запросы для адаптивности */
@media (max-width: 768px) {
  .courses-list_items {
    padding: 0 1rem; /* Уменьшите отступы на мобильных устройствах */
  }
  .courses-list_item {
    width: 100%; /* Задайте ширину 100% для мобильных устройств */
  }
}
</style>