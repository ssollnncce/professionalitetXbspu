<template>
  <Header />
  <section class="main-courses">
    <div class="courses-navigation">
      <CourseFamiliesList :selectedFamily="selectedFamily"  @selectFamily="selectFamily"/>
    </div>
    <div class="course-content">
      <CoursesList :selectedFamily="selectedFamily"/>
    </div>
  </section>
  <Footer />
</template>

<script>
import CourseFamiliesList from '../components/CourseFamiliesList.vue'
import CoursesList from '../components/CoursesList.vue'
import Footer from '../components/Footer.vue'
import Header from '../components/Header.vue'

export default {
  data(){
    return {
      selectedFamily: 0,
    }
  },
  components: {
    CourseFamiliesList,
    Header,
    CoursesList,
    Footer,
  },
  methods: {
    selectFamily(id) {
      this.selectedFamily = id;
      console.log(this.selectedFamily)
    }
  }
}
</script>

<style scoped>
.main-courses {
    padding-top: 90px;
    display: flex;
    flex-direction: row;
}

.courses-navigation {
    width: 25%;
}

.course-content {
    width: 75%;
    margin-bottom: 5rem;
}

@media (max-width: 768px) {
    .main-courses {
        flex-direction: column;
    }
    .courses-navigation {
        width: 100%;
        margin-top: 1rem;
    }
    .course-content {
        width: 100%;
    }
}
</style>