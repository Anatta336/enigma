import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue';
import EnigmaApp from './components/Enigma.vue';

createApp({
    components: {
        EnigmaApp
    }
}).mount('#app');
