<template>
    <Header />
    <section class="contacts-page">
        <h1 class="contacts-title">Контакты</h1>

        <div class="team-container">
            <div class="team-member">
                <img src="../assets/images/TeacherPhotoDraft.png" alt="Иван Золо">
                <p>Иван Золо</p>
                <p>Заведующий отделением робототехники</p>
                <p>+7 (999) 999-99-99</p>
                <p>ivan.zolobin@gmail.com</p>
            </div>
            <div class="team-member">
                <img src="../assets/images/TeacherPhotoDraft2.png" alt="Павел Техник">
                <p>Павел Техник</p>
                <p>Ректор</p>
                <p>+7 (999) 999-99-99</p>
                <p>pavel.tehnik@gmail.com</p>
            </div>
            <div class="team-member">
                <img src="../assets/images/TeacherPhotoDraft3.png" alt="Алена Швец">
                <p>Алена Швец</p>
                <p>Ведущий преподаватель</p>
                <p>+7 (999) 999-99-99</p>
                <p>alena.shvets@gmail.com</p>
            </div>
        </div>
    </section> 
    <div id="map"></div>
    <Footer />
</template>

<script>
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';

export default {
    components: {
        Header, Footer
    },
    mounted() {
        this.loadMapScript();
    },
    methods: {
        loadMapScript() {
            const script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A1c6e5450e6567d3535c49476e279353e93a38fb020cc1009d74c2ae66639e177&width=&height=500&lang=ru_RU&scroll=true';
            script.async = true;
            document.getElementById('map').appendChild(script);
        }
    }
}
</script>

<style scoped>

.contacts-page {
    margin-top: 5rem;
}

.team-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; 
    padding: 20px;
}

.team-member {
    width: 250px; 
    margin: 20px;
    background-color: #00000036; 
    border-radius: 15px; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
    text-align: center;
    overflow: hidden; 
}

.team-member img {
    width: 100%;
    height: auto;
    border-radius: 15px 15px 0 0; 
    display: block; 
    object-fit: cover; 
    aspect-ratio: 1/1; 

}

.team-member p {
    margin: 10px;
    font-weight: bold;
}

.contacts-page {
    background: url("../assets/images/banner-background.png") center/cover no-repeat; 
    padding: 30px 20px;
    text-align: center;
    min-height: 50vh; 
    box-sizing: border-box; 
}

.contacts-title {
    font-size: 48px;
    margin-bottom: 50px;
}

#map {
    width: 100%;
    height: 29.375rem;
    margin-bottom: 20px;
}

</style>