import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faFileLines } from '@fortawesome/free-regular-svg-icons';
import { faUser as farUser } from '@fortawesome/free-regular-svg-icons';
import {faKey, faArrowRight} from '@fortawesome/free-solid-svg-icons';

library.add(farUser, faFileLines, faKey, faArrowRight);

import './assets/main.css'


import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.component('font-awesome-icon', FontAwesomeIcon);

app.use(router)

app.mount('#app')
