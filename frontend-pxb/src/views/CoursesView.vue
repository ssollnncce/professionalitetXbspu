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
  }
  .course-content {
    width: calc(100vw - 383px);
  }
</style>