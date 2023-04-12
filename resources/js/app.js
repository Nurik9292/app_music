/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import routet from './router';

import Index from './components/view/User/Index.vue';



const app = createApp({components:{Index}});


app.use(routet);
app.mount('#app');
