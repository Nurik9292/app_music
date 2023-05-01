/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp} from 'vue';
import router from './router';
import PrimeVue from 'primevue/config';
import MultiSelect from 'primevue/multiselect';
import InputSwitch from 'primevue/inputswitch';
import Dropdown from 'primevue/dropdown';
import InputNumber from 'primevue/inputnumber';
import Button from 'primevue/button';

import "primevue/resources/themes/lara-light-indigo/theme.css"
import "primevue/resources/primevue.min.css";

import UserIndex from './components/view/User/UserIndex.vue';
import GenreIndex from './components/view/Genre/GenreIndex.vue';
import OverviewBase from './components/view/Overview/OverviewBase.vue';
import OverviewIndex from './components/view/Overview/OverviewIndex.vue';
import OverviewCreate from './components/view/Overview/OverviewCreate.vue';
import OverviewEdit from './components/view/Overview/OverviewEdit.vue';

const app = createApp({components:{UserIndex, OverviewBase}});
const ovr = createApp({components:{OverviewIndex, OverviewCreate, OverviewEdit, OverviewBase}});
const genre = createApp({components:{GenreIndex}});

ovr.component('MultiSelect', MultiSelect);
ovr.component('InputSwitch', InputSwitch);
ovr.component('Dropdown', Dropdown);
ovr.component('InputNumber', InputNumber);
ovr.component('Button', Button);

// app.use(router);
ovr.use(router);
ovr.use(PrimeVue, { ripple: true });
app.mount('#app');
ovr.mount('#ovr');
genre.mount('#genre');
