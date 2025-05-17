<template>
  <div>
    <Header />
    <div class="courses-layout">
      <aside class="course-family-nav">
        <div class="course-family-title">Направления</div>
        <ul class="course-family-list">
          <li
            v-for="family in courseFamilies"
            :key="family.id"
            :class="['course-family-link', { active: selectedFamily === family.id }]"
            @click="selectFamily(family.id)"
          >
            {{ family.name }}
          </li>
          <li
            :class="['course-family-link', { active: selectedFamily === 0 }]"
            @click="selectFamily(0)"
          >
            Все направления
          </li>
        </ul>
      </aside>
      <main class="courses-content">
        <div class="courses-grid">
          <div v-for="course in courses" :key="course.id" class="course-card">
            <img v-if="course.image_path" :src="course.image_path" alt="course image" class="course-image" />
            <div class="course-info">
              <div class="course-title">{{ course.name }}</div>
              <div class="course-desc">{{ course.description }}</div>
              <div class="course-meta">
                <span class="course-meta-item">Преподаватель: {{ course.teacher.full_name }}</span>
                <span class="course-meta-item">Длительность: {{ course.duration }}</span>
                <span class="course-meta-item">Возраст: {{ course.age }}+</span>
                <span class="course-meta-item">Цена: {{ course.price }} ₽</span>
                <span class="course-meta-item">Старт: {{ course.start_date }}</span>
              </div>
              <div class="course-actions">
                <RouterLink :to="`/courses/${course.id}`" class="course-detail-btn">
                  Подробнее
                </RouterLink>
                <button class="course-book-btn" @click="openBookingModal(course)">
                  Записаться
                </button>
              </div>
            </div>
          </div>
        </div>
        <div v-if="courses.length === 0" class="no-courses">Нет курсов по выбранному направлению</div>

        <!-- Модальное окно -->
        <div v-if="showModal" class="modal-overlay" @click.self="closeBookingModal">
          <div class="modal-window">
            <h3>Записаться на курс</h3>
            <p v-if="selectedCourse">
              Вы уверены, что хотите записаться на курс <b>{{ selectedCourse.name }}</b>?
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
      </main>
    </div>
  </div>
</template>

<script>
import Header from '@/components/Header.vue';
import { RouterLink } from 'vue-router';
import api from '@/api';

export default {
  components: { Header, RouterLink },
  data() {
    return {
      courseFamilies: [],
      selectedFamily: 0,
      courses: [],
      showModal: false,
      selectedCourse: null,
      bookingLoading: false,
      bookingError: null,
      bookingSuccess: null,
    };
  },
  created() {
    this.fetchCourseFamilies();
    this.fetchCourses();
  },
  methods: {
    async fetchCourseFamilies() {
      // Запрос на получение всех направлений (course families)
      const res = await api.get('/course-families');
      this.courseFamilies = res.data.data || [];
    },
    async fetchCourses() {
      // Запрос на получение курсов с фильтром по направлению
      const params = {};
      if (this.selectedFamily) params.course_family = this.selectedFamily;
      const res = await api.get('/courses', { params });
      this.courses = res.data.data || [];
    },
    selectFamily(id) {
      this.selectedFamily = id;
      this.fetchCourses();
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
        await api.post(`/courses/${this.selectedCourse.id}/book`, {}, {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.bookingSuccess = 'Вы успешно записались на курс!';
      } catch (e) {
        this.bookingError = e.response?.data?.message || 'Ошибка записи на курс';
      } finally {
        this.bookingLoading = false;
      }
    },
  },
};
</script>

<style scoped>
.courses-layout {
  display: flex;
  min-height: 100vh;
  background: #f7f8fa;
}

.course-family-nav {
  position: sticky;
  top: 88px; /* высота вашей шапки */
  width: 260px;
  min-width: 220px;
  height: calc(100vh - 88px);
  background: none;
  border-right: 1px solid #e0e4ef;
  padding: 2rem 1rem;
  box-sizing: border-box;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.course-family-title {
  font-size: 1.1rem;
  font-weight: 700;
  margin-bottom: 1rem;
  color: #274698;
}

.course-family-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.course-family-link {
  cursor: pointer;
  color: #274698;
  font-size: 1.08rem;
  padding: 0.9rem 1.2rem;
  border-radius: 8px;
  transition: background 0.2s, color 0.2s;
  background: none;
  font-weight: 500;
}
.course-family-link.active {
  background: #f5f6f8;
  font-weight: 700;
}
.course-family-link:hover:not(.active) {
  background: #f0f1f3;
}

.courses-content {
  flex: 1 1 0;
  padding: 2rem 2.5rem;
  min-width: 0;
  display: flex;
  flex-direction: column;
}

.courses-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
  gap: 2rem;
}

.course-card {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 2px 12px 0 rgba(39, 70, 152, 0.07);
  padding: 1.5rem 1.2rem 1.2rem 1.2rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  min-height: 260px;
  border: 1px solid #e0e4ef;
}

.course-image {
  width: 100%;
  height: 140px;
  object-fit: cover;
  border-radius: 12px;
  margin-bottom: 0.5rem;
  background: #f5f6f8;
}

.course-title {
  font-size: 1.15rem;
  font-weight: 700;
  color: #274698;
  margin-bottom: 0.3rem;
}

.course-desc {
  font-size: 1rem;
  color: #444;
  margin-bottom: 0.5rem;
  min-height: 40px;
}

.course-meta {
  font-size: 0.97rem;
  color: #6b7bb6;
  display: flex;
  flex-wrap: wrap;
  gap: 0.7rem 1.5rem;
  margin-bottom: 0.7rem;
}

.course-meta-item {
  white-space: nowrap;
}

.course-actions {
  display: flex;
  gap: 0.7rem;
  margin-top: 0.5rem;
}

.course-detail-btn {
  display: inline-block;
  background: #4f6295;
  color: #fff;
  border-radius: 10px;
  padding: 0.6rem 1.2rem;
  font-weight: 600;
  text-decoration: none;
  transition: background 0.18s;
  margin-top: 0.5rem;
}
.course-detail-btn:hover {
  background: #274698;
}

.course-book-btn {
  background: #1976d2;
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 0.6rem 1.2rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.18s;
  margin-top: 0.5rem;
}
.course-book-btn:hover {
  background: #274698;
}

.no-courses {
  color: #d32d2f;
  font-size: 1.1rem;
  margin-top: 2rem;
  text-align: center;
}

/* Модальное окно */
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
  background: #1976d2;
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 0.6rem 1.5rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.18s;
}
.modal-confirm-btn:hover {
  background: #274698;
}
.modal-cancel-btn {
  background: #f5f6f8;
  color: #274698;
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

@media (max-width: 900px) {
  .courses-layout {
    flex-direction: column;
  }
  .course-family-nav {
    position: static;
    width: 100%;
    min-width: 0;
    height: auto;
    border-right: none;
    border-bottom: 1px solid #e0e4ef;
    flex-direction: row;
    padding: 0.5rem 0.5rem;
    gap: 0.3rem;
    justify-content: flex-start;
    overflow-x: auto;
  }
  .course-family-list {
    flex-direction: row;
    gap: 0.3rem;
  }
  .courses-content {
    padding: 1rem 0.5rem;
  }
  .courses-grid {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
}
</style>