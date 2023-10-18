import '@fortawesome/fontawesome-free';
import './bootstrap';

// Vue
import {createApp} from 'vue';

const app = createApp({});

// Load jquery components
Object.entries(import.meta.glob('./jquery/*.js', {eager: true})).forEach(([path, definition]) => {
	definition.default();
});

app.mount('#app');
