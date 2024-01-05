import _ from 'lodash';
window._ = _;

// jQuery
import jQuery from 'jquery';
window.$ = jQuery;
import 'jquery-validation';

// Bootstrap
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// ChartJS
import Chart from 'chart.js/auto';
window.Chart = Chart;

// set a default theme
window.$theme = 'Froxlor';

// Axios
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
