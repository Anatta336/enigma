import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue';
import VueApp from './components/VueApp.vue';

createApp({
    components: {
        VueApp,
    }
}).mount('#app');
