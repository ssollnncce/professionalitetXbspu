<template>
    <Header />
    <section class="teachers-list-page">
        <section class="world-class">
            <h2 class="world-class-title">Наши преподаватели</h2>
            <p class="world-class-description">Колледж БГПУ приглашает детей познать мир интересных курсов. Уровень подготовки может быть различным. Грамотные преподаватели с интересом работают с детьми.</p>
        </section>

        <div class="team-container">
            <div class="team-member" v-for="teacher in teachers" :key="teacher.id">
                <img src="../assets/images/TeacherPhotoDraft.png" alt="Иван Золо">
                <p>{{ teacher.full_name }}</p>
            </div>
        </div>
    </section>
    <Footer />
</template>

<script>
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';
import api from '@/api';

export default {
    components: {
        Header, Footer
    },
    data() {
        return {
            teachers: []
        }
    },
    mounted() {
        this.getTeachers();
    },
    methods: {
        async getTeachers() {
            try {
                const response = await api.get('/teachers');
                this.teachers = response.data.data;
                console.log(this.teachers);
            } catch (error) {
                console.error('Возникла ошибка при получении списка преподавателей:', error);
            }
        }
    }
}
</script>

<style scoped>

.teachers-list-page {
    margin-top: 5rem;
}

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
.team-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center; 
    padding: 20px;
}

.team-member {
    width: 250px; 
    margin: 20px;
    background-color: #fff; 
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
    color: black;
}

</style>