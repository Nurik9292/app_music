/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import router from './router';

import UserIndex from './components/view/User/UserIndex.vue';
import GenreIndex from './components/view/Genre/GenreIndex.vue';
import OverviewIndex from './components/view/Overview/OverviewIndex.vue';

const app = createApp({components:{UserIndex}});
const ovr = createApp({components:{OverviewIndex}});
const genre = createApp({components:{GenreIndex}});

app.use(router);
app.mount('#app');
ovr.mount('#ovr');
genre.mount('#genre');
