<script>
import Header from "@/components/Header.vue";
import Footer from "@/components/Footer.vue";
import api from "@/api";

export default {
  components: {
    Header,
    Footer,
  },
  data() {
    return {
      courses: [],
      featuredCourseIds: [1, 3, 5, 7, 9, 11],
    }
  },
  mounted() {
    this.getCourses();
  },
  computed: {
    featuredCourses() {
      return this.courses.filter(course =>
          this.featuredCourseIds.includes(course.id)
      );
    }
  },
  methods: {
    async getCourses() {
      try {
        const response = await api.get('/courses');
        const featuredIdsSet = new Set(this.featuredCourseIds);
        this.courses = response.data.data.filter(course =>
            featuredIdsSet.has(course.id)
        );
        console.log(this.courses);
      } catch (error) {
        console.log('Во время получения курсов возникла ошика: ', error);
      }
    }
  }

}

</script>

<template>
  <Header />
  <section class="section_main-content">
    <div class="main-content">
      <div class="banner">
        <img id="banner-image" src="../assets/images/banner-background.png" alt="Изображение баннера/Профессионалит/Колледж БГПУ">
        <div class="banner-content">
          <div class="banner-content_text">
            <h1>Курсы центра педагогических компетенций <br> Профессионалитет</h1>
            <RouterLink to="/courses">Все курсы</RouterLink>
          </div>
        </div>
      </div>
      <section class="contacts-container">
        <div class="contacts">
          <h2>Опыт который мы хотим вам передать</h2>
          <div class="contacts_text">
            <p>Колледж БГПУ и ЦПК Профессионалитет приглашает детей познать мир интересных курсов. Уровень подготовки может быть различным. Грамотные преподаватели с интересом работают с детьми.</p>
            <div class="contacts_text-feedback d-flex flex-column">
              <div class="d-flex justify-content-between mb-2 contacts-list">
                <div class="contacts_text-item">
                  <i class="fa-regular fa-envelope"></i>
                  <a href="mailto:profxbspu@prof.ru">profxbspu@prof.ru</a>
                </div>
                <div class="contacts_text-item">
                  <i class="fa-solid fa-phone"></i>
                  <a href="tel:+79999999999">+7 (999)-999-99-99</a>
                </div>
              </div>
              <RouterLink to="/courses" id="contacts-courses">Записаться</RouterLink>
            </div>
          </div>
        </div>
      </section>
      <section class="courses">
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
                <p>Осталось мест: {{course.freeSlots}}</p>
                <p>{{course.price}} &#8381;</p>
              </div>
              <div class="courses_item-button">
                <RouterLink to="/courses/{course.id}" id="about-course">Подробнее</RouterLink>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </section>
  <section class="questions-page">
        <h1 class="questions-title">Вопросы</h1>

        <div class="questions-container">
            <div class="question-item">
                <span class="question-number">1</span>
                <p>Сколько по времени длится урок?</p>
                <p>Каждый урок длится 90 минут, перерыв длится 10 минут.</p>
            </div>
            <div class="question-item">
                <span class="question-number">2</span>
                <p>Какие есть возрастные ограничения?</p>
                <p>У нас есть курсы для детей от 6-10 лет, а также от 11-17 лет</p>
            </div>
            <div class="question-item">
                <span class="question-number">3</span>
                <p>Есть ли пробный урок?</p>
                <p>Да, есть пробный урок.</p>
            </div>
            <div class="question-item">
                <span class="question-number">4</span>
                <p>Сколько по времени длится урок?</p>
                <p>Каждый урок длится 90 минут, перерыв длится 10 минут.</p>
            </div>
        </div>
    </section>

  <Footer />
</template>

<style scoped>
@import '../assets/styles/variables.css';

.main-content {
    padding-top: 90px;
    width: 100%;
    box-sizing: border-box;
}

/* Стили для баннера */
.banner {
    position: relative;
    width: 100%;
}
#banner-image {
    height: calc(100vh - 90px);
    width: 100%;
    display: block;
}
.banner-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 24px;
    font-weight: bold;
    z-index: 2;
}
.banner-content_text {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-around;
    gap: 1rem;
}
.banner-content_text h1 {
    text-align: center;
}
.banner-content_text a {
    text-decoration: none;
    color: white;
    padding: 0.4rem 4rem;
    border: 1px solid white;
    border-radius: 0.8rem;
}

/* Секция контактов */
.contacts {
    background: #25221F;
    padding: 7rem 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    width: 100%;
}
.contacts_text {
    padding: 0 15rem;
}
.contacts_text p {
    text-align: center;
}
.contacts_text-feedback {
    display: flex;
    align-items: center;
    flex-direction: column;
    width: 100%;
}
.contacts-list {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
}
.contacts_text-item {
    padding: 0.5rem 1.5rem;
    border: 1px solid white;
    border-radius: 0.8rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.5rem;
}
.contacts_text-item a {
    text-decoration: none;
    color: white;
}
#contacts-courses {
    text-decoration: none;
    color: black;
    padding: 0.5rem 11rem;
    background: white;
    border-radius: 0.8rem;
}

/* Список курсов */
.courses-list_items {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
    gap: 2rem;
    padding: 0 15rem;
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
.courses_item-button {
    width: 100%;
    display: flex;
    justify-content: center;
}
#about-course {
    text-decoration: none;
    width: 100%;
    padding: 0.5rem;
    background-color: white;
    color: black;
    border-radius: 0.8rem;
    margin: 0.5rem;
    text-align: center;
}

/* Раздел вопросов */
.questions-page {
    background: url("../assets/images/banner-background.png") center/cover no-repeat; 
    padding: 50px 20px;
    text-align: center;
    min-height: 100vh; 
    box-sizing: border-box; 
    margin-top: 5rem;
    height: fit-content;
}

.questions-title {
    font-size: 48px;
    margin-bottom: 50px;
    color: #fff;
}

.questions-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; 
    align-items: center;
    max-width: 900px;
    height: 100%;
    margin: 0 auto;
    color: #fff;
}

.question-item {
    width: 400px;
    background-color: rgba(255, 255, 255, 0.1); 
    border-radius: 10px;
    padding: 20px;
    margin: 10px;
    text-align: left;
    box-sizing: border-box;
}

.question-number {
    display: inline-block;
    width: 30px;
    height: 30px;
    background-color: white;
    color: #2962ff; 
    border-radius: 50%;
    text-align: center;
    line-height: 30px;
    margin-right: 10px;
    font-weight: bold;
}

.question-item p {
    margin: 5px 0;
}

/* Медиа-запросы для адаптивности */
@media (max-width: 768px) {
    .contacts_text {
        padding: 0 1rem;
    }
    .contacts-list {
        flex-direction: column;
        align-items: center;
    }
    .courses-list_items {
        padding: 0 1rem;
    }
    .question-item {
        width: 100%;
    }
}
</style>