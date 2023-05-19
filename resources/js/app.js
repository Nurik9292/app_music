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
import InputNumber from 'primevue/inputnumber';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Checkbox from 'primevue/checkbox';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';
import Row from 'primevue/row';
import Paginator from 'primevue/paginator';
import Dropdown from 'primevue/dropdown';
import TabMenu from 'primevue/tabmenu';
import Textarea from 'primevue/textarea';
import RadioButton from 'primevue/radiobutton';
import SelectButton from 'primevue/selectbutton';
import FileUpload from 'primevue/fileupload';



import "primevue/resources/themes/lara-light-indigo/theme.css"
import "primevue/resources/primevue.min.css";
import 'primeicons/primeicons.css';

import UserIndex from './components/view/User/UserIndex.vue';
import GenreIndex from './components/view/Genre/GenreIndex.vue';
import OverviewBase from './components/view/Overview/OverviewBase.vue';
import OverviewIndex from './components/view/Overview/OverviewIndex.vue';
import OverviewCreate from './components/view/Overview/OverviewCreate.vue';
import OverviewEdit from './components/view/Overview/OverviewEdit.vue';
import TrackIndex from './components/view/Track/TrackIndex.vue';
import TrackBase from './components/view/Track/TrackBase.vue';
import TrackScan from './components/view/Track/TrackScan.vue';
import TrackCreate from './components/view/Track/TrackCreate.vue';

const app = createApp({components:{UserIndex, OverviewBase}});
const ovr = createApp({components:{OverviewIndex, OverviewCreate, OverviewEdit, OverviewBase}});
const genre = createApp({components:{GenreIndex}});
const track = createApp({components:{TrackIndex, TrackBase, TrackScan, TrackCreate}});

ovr.component('MultiSelect', MultiSelect);
ovr.component('InputSwitch', InputSwitch);
ovr.component('InputNumber', InputNumber);
ovr.component('Button', Button);
ovr.component('InputText', InputText);
ovr.component('Checkbox', Checkbox);

track.component('DataTable', DataTable);
track.component('Column', Column);
track.component('ColumnGroup', ColumnGroup);
track.component('Row', Row);
track.component('InputText', InputText);
track.component('Paginator', Paginator);
track.component('Dropdown', Dropdown);
track.component('InputSwitch', InputSwitch);
track.component('TabMenu', TabMenu);
track.component('Textarea', Textarea);
track.component('MultiSelect', MultiSelect);
track.component('InputNumber', InputNumber);
track.component('Checkbox', Checkbox);
track.component('RadioButton', RadioButton);
track.component('SelectButton', SelectButton);
track.component('FileUpload', FileUpload);

// app.use(router);
ovr.use(router);
ovr.use(PrimeVue, { ripple: true });

track.use(router);
track.use(PrimeVue, { ripple: true });

app.mount('#app');
ovr.mount('#ovr');
genre.mount('#genre');
track.mount('#track');
