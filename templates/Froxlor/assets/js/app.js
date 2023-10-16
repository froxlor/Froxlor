import '@fortawesome/fontawesome-free';

import jQuery from 'jquery';
window.$ = jQuery;

import 'jquery-validation';
import 'bootstrap';
import 'chart.js/auto';

// Axios
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Vue
import { createApp } from 'vue';
const app = createApp({});

// import ExampleComponent from './components/ExampleComponent.vue';
// app.component('example-component', ExampleComponent);
//
// or
//
// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

app.mount('#app');

// Load jquery components
Object.entries(import.meta.glob('./jquery/*.js', { eager: true })).forEach(([path, definition]) => {
	definition.default();
});
