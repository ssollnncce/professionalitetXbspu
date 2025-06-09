<script>
import api from '@/api'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js';

export default {
  data() {
    return {
      course_families: [],
    }
  },
  props: ['selectedFamily'],
  mounted() {
    this.getCourseFamilies();
  },
  methods: {
    async getCourseFamilies() {
      try {
        const response = await api.get('/course-families')
        this.course_families = response.data.data
        console.log(this.course_families)
      } catch (error) {
        console.log('Во время списка групп курсов возникла ошибка', error)
      }
    },
    selectFamily(id) {
      this.$emit('selectFamily', id);
    }
  }
}
</script>

<template>
  <div class="courses-family_nav">
    <aside class="fixed-sidebar families-list">
      <h2>Выберите направление курсов</h2>
      <div class="sidebar-content">
        <ul class="nav flex-column">
          <li :class="['course-family_link', {active: selectedFamily === 0}]" @click="selectFamily(0)">
            Все направления
          </li>
          <li :class="['course-family_link', {active: selectedFamily === family.id}]" v-for="family in course_families" :key="family.id" @click="selectFamily(family.id)">
            {{family.name}}
          </li>
        </ul>
      </div>
    </aside>
  </div>
</template>

<style scoped>
@import '../assets/styles/variables.css';

.families-list {
    background: white;
    color: black;
    padding: 1rem;
}

.families-list h2{
    font-size: var(--font-size-s);
}

.course-family_link{
    padding: 0.4rem;
    font-size: var(--font-size-xs);
    cursor: pointer;
    margin: 0 0 0.5rem 0;
}

.course-family_link:hover{
    color: var(--light-primary-color);
    text-decoration: underline;
    transition: 0.2s;
}

.course-family_link.active{
    color: var(--primary-color);
    background: var(--selected-color);
    border-radius: 0.3rem
}

/* Медиа-запросы для адаптивности */
@media (max-width: 768px) {
    .families-list {
        padding: 0.5rem; /* Уменьшите отступы на мобильных устройствах */
    }
    .course-family_link {
        font-size: var(--font-size-xs); /* Уменьшите размер шрифта на мобильных устройствах */
    }
}
</style>