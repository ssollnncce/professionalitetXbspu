<script>
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap/dist/js/bootstrap.js';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faEnvelope, faPhone, faMapMarkerAlt } from '@fortawesome/free-solid-svg-icons';

export default {
  components: {
    FontAwesomeIcon
  },
  data() {
    return {
      icons: {
        envelope: faEnvelope,
        phone: faPhone,
        marker: faMapMarkerAlt
      }
    }
  }
}
</script>

<template>
  <footer class="footer-con">
    <div class="container">
      <div class="footer-content row">
        <div class="footer-logo col-md-3 mb-4 mb-md-0">
          <img src="../assets/logo.svg" alt="Логотип Профессионалитет Колледж БГПУ" class="img-fluid" style="max-height: 80px;">
        </div>

        <div class="footer-nav col-md-3 mb-4 mb-md-0">
          <h5 class="footer-title">Навигация</h5>
          <ul class="nav flex-column">
            <li class="nav-item">
              <RouterLink to="/" class="nav-link">Главная</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="/courses" class="nav-link">Курсы</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="/teachers" class="nav-link">Преподаватели</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink to="/contacts" class="nav-link">О нас</RouterLink>
            </li>
          </ul>
        </div>
        <div class="footer-contacts col-md-6">
          <h5 class="footer-title">Контакты</h5>
          <ul class="contact-list">
            <li class="contact-item">
              <FontAwesomeIcon :icon="icons.marker" class="me-2" />
              <span>г. Уфа, ул. Чернышеского, д. 49, к. 1</span>
            </li>
            <li class="contact-item">
              <FontAwesomeIcon :icon="icons.phone" class="me-2" />
              <a href="tel:+79999999999">+7 (999) 999-99-99</a>
            </li>
            <li class="contact-item">
              <FontAwesomeIcon :icon="icons.envelope" class="me-2" />
              <a href="mailto:profxbspu@prof.ru">profxbspu@prof.ru</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="footer-bottom text-center py-3 mt-4">
        <hr class="footer-divider">
        <p class="mb-0">&copy; 2025 ЦПК Профессионалитет и Колледж БГПУ. Все права защищены.</p>
      </div>
    </div>
  </footer>
</template>

<style scoped>
@import '../assets/styles/variables.css';

.footer-con {
  background-color: var(--primary-color);
  color: white;
  padding: 3rem 0 0;
  margin-top: 0;
}

.footer-title {
  color: white;
  font-weight: 600;
  margin-bottom: 1.5rem;
  font-size: 1.2rem;
}

.nav-link {
  color: rgba(255, 255, 255, 0.8);
  padding: 0.3rem 0;
  transition: color 0.3s;
}

.nav-link:hover {
  color: white;
  text-decoration: none;
}

.contact-list {
  list-style: none;
  padding: 0;
}

.contact-item {
  margin-bottom: 0.8rem;
  display: flex;
  align-items: center;
}

.contact-item a {
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
  transition: color 0.3s;
}

.contact-item a:hover {
  color: white;
  text-decoration: underline;
}

.footer-divider {
  border-color: rgba(255, 255, 255, 0.1);
  margin: 1rem 0;
}

.footer-bottom {
  color: rgba(255, 255, 255, 0.7);
  font-size: 0.9rem;
}

@media (max-width: 768px) {
  .footer-content {
    text-align: center;
  }

  .footer-nav,
  .footer-contacts {
    margin-top: 2rem;
  }

  .contact-item {
    justify-content: center;
  }
}
</style>