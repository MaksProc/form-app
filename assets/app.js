/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import 'bootstrap/dist/css/bootstrap.min.css';
import './styles/app.css';

import { createApp } from 'vue';
import FormBase from './components/FormBase.vue';

require('bootstrap');

const app = createApp({});
app.component('form-base', FormBase);
app.mount('#vue-app');