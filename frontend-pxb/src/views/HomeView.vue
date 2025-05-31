<script setup>
import Header from '@/components/Header.vue'

</script>

<template>
  <main>
    <Header/>
    <div class="banner">
      <h1 class="banner-title">Курсы Профессионалитет</h1>
      <p class="banner-subtitle">Создаем будущее для детей здесь!</p>
      <RouterLink to="/courses">Начать</RouterLink>
    </div>


    <section class="world-class">
      <h2 class="world-class-title">Опыт который мы хотим вам передать</h2>
      <p class="world-class-description">Колледж БГПУ приглашает детей познать мир интересных курсов. Уровень подготовки может быть различным. Грамотные преподаватели с интересом работают с детьми.</p>
      <div class="world-class-buttons">
        <a href="#" class="phone-button">+7 (000) 000-00-00</a>
        <a href="#" class="signup-button">Записаться</a>
      </div>
    </section>


    <h1>Наши курсы</h1>

    <div class="courses-container">

      <a href="#"/>
      <div class="course-card">
        <img src="../assets/images/python.png" alt="Python-разработчик" class="course-image">
        <div class="course-category">Программирование</div>
        <div class="course-title">Python-разработчик</div>
        <div class="course-duration">• 12 месяцев</div>
      </div>

    <div class="course-card">
      <img src="../assets/images/english.png" alt="Английский язык" class="course-image">
      <div class="course-category">Языки</div>
      <div class="course-title">Английский язык</div>
      <div class="course-duration">• 12 месяцев</div>
    </div>

    <div class="course-card">
      <img src="../assets/images/china.png" alt="Китайский язык" class="course-image">
      <div class="course-category">Языки</div>
      <div class="course-title">Китайский язык</div>
      <div class="course-duration">• 12 месяцев</div>
    </div>

    <div class="course-card">
      <img src="../assets/images/econom.png" alt="Экономика" class="course-image">
      <div class="course-category">Языки</div>
      <div class="course-title">Экономика</div>
      <div class="course-duration">• 12 месяцев</div>
    </div>

    <div class="course-card">
      <img src="../assets/images/manage.png" alt="Менеджер маркетплейсов" class="course-image">
      <div class="course-category">Профессия</div>
      <div class="course-title">Менеджер маркетплейсов</div>
      <div class="course-duration">• 7 месяцев • с трудоустройством</div>
    </div>

    <div class="course-card">
      <img src="../assets/images/ai.png" alt="Нейросети: практический курс" class="course-image">
      <div class="course-category">Профессия</div>
      <div class="course-title">Нейросети: практический курс</div>
      <div class="course-duration">• 3 месяца</div>
    </div>

    </div>

    <a href="#" class="all-courses-button">Все курсы</a>

    <section class="teachers">
      <h2 class="teachers-title">Часто задаваемые вопросы</h2>
      <p class="teachers-description">В этом разделе самые часто задаваемые вопросы.</p>
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

    <section class="contacts-page">
    </section>



    <section class="prices">
      <h2 class="prices-title">Цены</h2>
      <div class="prices-container">
        <div class="price-card">
          <h3 class="price-card-title">Начальный</h3>
          <p class="price-card-price">1600 руб/месяц</p>
          <p class="price-card-description">Годичная программа. Вам не нужен профессиональный опыт. Доступен также для лиц старше 16 лет.</p>
        </div>
        <div class="price-card">
          <h3 class="price-card-title">Средний</h3>
          <p class="price-card-price">4500 руб/месяц</p>
          <p class="price-card-description">Доступно для выпускников начальной программы. Неограниченный срок курса.</p>
        </div>
        <div class="price-card">
          <h3 class="price-card-title">Высокий</h3>
          <p class="price-card-price">7200 руб/месяц</p>
          <p class="price-card-description">Продвинутые уроки.</p>
        </div>
      </div>
    </section>
  </main>
</template>

<style scoped>
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
  padding: 0;
  color: #333; /* Тёмно-серый цвет для остального текста */
  text-align: center;
  background-color: #D9D9D9;
}

header {
  background-color: #D9D9D9; /* Белый фон для хедера */
  padding: 20px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: #1E1E1E; /* Текст хедера */

}

.logo {
  font-size: 24px;
  font-weight: bold;
}

nav {
  margin-left: auto;
}

nav ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
}

nav li {
  margin-left: 20px;
}

nav a {
  color: #1E1E1E;
  text-decoration: none;
}

/*баннер*/
.banner {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  padding: 180px 20px;
  background: url('../assets/images/img1.png')center/cover no-repeat;
  color: #fff;
  min-height: 50vh;
  position: relative;
  overflow: hidden;
}

.banner-title {
  font-size: 48px;
  margin-bottom: 10px;
  font-family: Helvetica;

}

.banner-subtitle {
  font-size: 24px;
  margin-bottom: 30px;
}

.banner-button {
  padding: 15px 80px;
  font-size: 20px;
  color: #fff;
  background-color: transparent;
  border: 2px solid #D9D9D9;
  border-radius: 15px;
  cursor: pointer;
  text-decoration: none;
  font-family: Helvetica;
}

/*второй блок*/
.world-class {
  background-color: #333;
  color: #fff;
  padding: 50px 20px;
  text-align: center;
}

.world-class-title {
  font-size: 48px;
  margin-bottom: 30px;
}

.world-class-description {
  font-size: 18px;
  line-height: 1.6;
  max-width: 800px;
  margin: 0 auto;
}

.world-class-buttons {
  display: flex;
  justify-content: center;
  gap: 30px;
  margin-top: 50px;
}

.phone-button {
  color: #fff;
  text-decoration: none;
  border: 1px solid #fff;
  border-radius: 30px;
  padding: 15px 30px;
  font-size: 18px;
}

.signup-button {
  background-color: #fff;
  color: #333;
  text-decoration: none;
  border-radius: 30px;
  padding: 15px 30px;
  font-size: 18px;
}

/*курсы */

.courses-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
  width: 80%; /* Занимает 80% ширины экрана */
  max-width: 1200px; /* Ограничивает максимальную ширину */
  margin-bottom: 20px;
}

.course-card {
  background-color: #fff;
  border-radius: 15px;
  overflow: hidden; /* Обрезает изображение по краям радиуса */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Тень */
  transition: transform 0.2s ease-in-out; /* Анимация при наведении */
}

.course-card:hover {
  transform: scale(1.05); /* Увеличение при наведении */
}

.course-image {
  width: 100%;
  height: 200px; /* Фиксированная высота изображения */
  object-fit: cover; /* Масштабирует изображение, чтобы заполнить контейнер */
}

.course-category {
  padding: 10px;
  font-size: 0.8em;
  color: #777;
}

.course-title {
  padding: 0 10px;
  font-size: 1.2em;
  font-weight: bold;
  margin-bottom: 5px;
}

.course-duration {
  padding: 0 10px 10px;
  font-size: 0.9em;
  color: #555;
}

.course-duration::before {
  content: "\2022"; /* Жирная точка перед длительностью */
  margin-right: 5px;
}

.all-courses-button {
  background-color: #3f51b5; /* Цвет кнопки */
  color: white;
  padding: 12px 24px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1.1em;
  transition: background-color 0.2s ease-in-out;
  text-decoration: none;
}

.all-courses-button:hover {
  background-color: #303f9f; /* Более темный цвет при наведении */
}

/* учителя */
.teachers {
  background-color: #ddd;
  padding: 50px 20px;
  text-align: center;
  margin-top: 30px;
}

.teachers-title {
  font-size: 36px;
  margin-bottom: 20px;
}

.teachers-description {
  font-size: 18px;
  line-height: 1.6;
  max-width: 800px;
  margin: 0 auto;
}

/*Преподаватели */
.questions-page {
  background: url("../assets/images/img1.png") center/cover no-repeat;
  padding: 50px 20px;
  text-align: center;
  min-height: 100vh;
  box-sizing: border-box;
}

.questions-title {
  font-size: 48px;
  margin-bottom: 50px;
}

.questions-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  max-width: 900px;
  margin: 0 auto;
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

.ask-question {
  margin-top: 50px;
}

.ask-question p {
  font-size: 24px;
  margin-bottom: 10px;
}

.ask-question a {
  display: inline-block;
  background-color: white;
  color: #2962ff;
  text-decoration: none;
  padding: 15px 30px;
  border-radius: 30px;
  font-size: 18px;
}
/*Цены*/
.prices {
  background-color: #333;
  color: #fff;
  padding: 50px 20px;
  text-align: center;
}

.prices-title {
  font-size: 48px;
  margin-bottom: 50px;
}

.prices-container {
  display: flex;
  justify-content: center;
  gap: 20px;
  flex-wrap: wrap;
}

.price-card {
  width: 300px;
  padding: 30px;
  box-sizing: border-box;
}

.price-card-title {
  font-size: 32px;
  margin-bottom: 20px;
}

.price-card-price {
  font-size: 24px;
  margin-bottom: 20px;
}

.price-card-description {
  font-size: 16px;
  line-height: 1.5;
}

.prices-button {
  display: inline-block;
  padding: 15px 30px;
  font-size: 18px;
  color: #fff;
  text-decoration: none;
  border: 1px solid #fff;
  border-radius: 30px;
  margin-top: 50px;
}

/*футер*/
footer {
  background-color: #0E559A;
  color: #fff;
  padding: 30px 20px;
}

.footer-container {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  max-width: 1200px;
  margin: 0 auto;
}

.footer-column {
  width: 250px;
  margin-bottom: 20px;
}

.footer-title {
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 10px;
}

.footer-column ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-column li {
  margin-bottom: 5px;
}

.footer-column a {
  color: #fff;
  text-decoration: none;
}

.footer-column p {
  margin-bottom: 5px;
}

.footer-column form {
  display: flex;
  align-items: center;
}

.footer-column input[type="email"] {
  padding: 8px;
  border: none;
  border-radius: 5px;
  margin-right: 5px;
  width: 150px;
  font-size: 14px;
}

.footer-column button[type="submit"] {
  padding: 8px 12px;
  background-color: #fff;
  color: #0E559A;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 14px;
}

/*Адаптивность*/
@media (max-width: 768px) {
  .course {
    width: 90%;
    min-width: auto;
  }
}


</style>
