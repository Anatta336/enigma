import './bootstrap';
import '../css/app.css';

import { createApp } from 'vue';
import ExampleComponent from './components/Example.vue';

createApp({
    components: {
        ExampleComponent
    }
}).mount('#app');
