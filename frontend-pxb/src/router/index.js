import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/LoginView.vue'
import ProfileView from '../views/ProfileView.vue'
import RegisterView from '../views/RegisterView.vue'
import ForgotPasswordView from '@/views/ForgotPasswordView.vue'
import PasswordResetView from '@/views/PasswordResetView.vue'
import CourseDetailView from '@/views/CourseDetailView.vue'
import userInfo from "@/components/UserInfo.vue";
import UserCourses from "@/components/UserCourses.vue";
import changePassword from "@/components/ChangePassword.vue";
import CoursesView from "@/views/CoursesView.vue";
import TeachersListView from "@/views/TeachersListView.vue";
import ContactsView from "@/views/ContactsView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView,
    },
    {
      path: '/forgot-password',
      name: 'forgot-password',
      component: ForgotPasswordView,
    },
    {
      path: '/password-reset/:token',
      name: 'password-reset',
      component: PasswordResetView,
    },
    {
      path: '/profile',
      name: 'profile',
      component: ProfileView,
      children: [
        {
          path: 'info',
          component: userInfo,
        },
        {
          path: 'courses',
          component: UserCourses,
        },
        {
          path: 'change-password',
          component: changePassword,
        }
      ]
    },
    {
      path: '/courses',
      name: 'courses',
      component: CoursesView,
    },
    {
      path: '/courses/:id',
      name: 'course-detail',
      component: CourseDetailView,
    },
    {
      path: '/drafts',
      name: 'drafts',
      component: CoursesView,
    },
    {
      path: '/teachers',
      name: 'teachers',
      component: TeachersListView,
    },
    {
      path: '/contacts',
      name: 'contacts',
      component: ContactsView,
    }
  ],
})

export default router
