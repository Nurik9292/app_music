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
import Dialog from 'primevue/dialog';
import Editor from 'primevue/editor';
import Calendar from 'primevue/calendar';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';

import "primevue/resources/themes/lara-light-indigo/theme.css"
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";

import UserIndex from './components/view/User/UserIndex.vue';
import GenreIndex from './components/view/Genre/GenreIndex.vue';
import GenreBase from './components/view/Genre/GenreBase.vue';
import OverviewBase from './components/view/Overview/OverviewBase.vue';
import OverviewIndex from './components/view/Overview/OverviewIndex.vue';
import OverviewCreate from './components/view/Overview/OverviewCreate.vue';
import OverviewEdit from './components/view/Overview/OverviewEdit.vue';
import TrackIndex from './components/view/Track/TrackIndex.vue';
import TrackBase from './components/view/Track/TrackBase.vue';
import TrackScan from './components/view/Track/TrackScan.vue';
import TrackCreate from './components/view/Track/TrackCreate.vue';
import ArtistIndex from './components/view/Artist/ArtistIndex.vue';
import ArtistBase from './components/view/Artist/ArtistBase.vue';
import ArtistCreate from './components/view/Artist/ArtistCreate.vue';
import ArtistEdit from './components/view/Artist/ArtistEdit.vue';
import AlbumIndex from './components/view/Album/AlbumIndex.vue';
import AlbumBase from './components/view/Album/AlbumBase.vue';
import AlbumCreate from './components/view/Album/AlbumCreate.vue';
import AlbumEdit from './components/view/Album/AlbumEdit.vue';
import PlaylistIndex from './components/view/Playlist/PlaylistIndex.vue';
import PlaylistBase from './components/view/Playlist/PlaylistBase.vue';
import PlaylistCreate from './components/view/Playlist/PlaylistCreate.vue';
import PlaylistEdit from './components/view/Playlist/PlaylistEdit.vue';
import ModeratorIndex from './components/view/Moderator/ModeratorIndex.vue';
import ModeratorBase from './components/view/Moderator/ModeratorBase.vue';
import Toast from 'primevue/toast';
import ToastService from 'primevue/toastservice';
import Tag from 'primevue/tag';

const app = createApp({components:{UserIndex, OverviewBase}});
const ovr = createApp({components:{OverviewIndex, OverviewCreate, OverviewEdit, OverviewBase}});
const genre = createApp({components:{GenreIndex, GenreBase}});
const track = createApp({components:{TrackIndex, TrackBase, TrackScan, TrackCreate}});
const artist = createApp({components:{ArtistBase, ArtistIndex, ArtistCreate, ArtistEdit}});
const album = createApp({components:{AlbumBase, AlbumIndex, AlbumCreate, AlbumEdit}});
const playlist = createApp({components:{PlaylistBase, PlaylistIndex, PlaylistCreate, PlaylistEdit}});
const moder = createApp({components:{ModeratorBase, ModeratorIndex}});


moder.component('TabView', TabView);
moder.component('TabPanel', TabPanel);
moder.component('DataTable', DataTable);
moder.component('Column', Column);
moder.component('ColumnGroup', ColumnGroup);
moder.component('Row', Row);
moder.component('Tag', Tag);

ovr.component('MultiSelect', MultiSelect);
ovr.component('InputSwitch', InputSwitch);
ovr.component('InputNumber', InputNumber);
ovr.component('Button', Button);
ovr.component('InputText', InputText);
ovr.component('Checkbox', Checkbox);

genre.component('DataTable', DataTable);
genre.component('Column', Column);
genre.component('ColumnGroup', ColumnGroup);
genre.component('Row', Row);
genre.component('InputText', InputText);
genre.component('Button', Button);
genre.component('Paginator', Paginator);

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
track.component('Button', Button);
track.component('Dialog', Dialog);
track.component('Tag', Tag);
track.component('Toast', Toast);


artist.component('DataTable', DataTable);
artist.component('Column', Column);
artist.component('ColumnGroup', ColumnGroup);
artist.component('Row', Row);
artist.component('InputText', InputText);
artist.component('Paginator', Paginator);
artist.component('Dropdown', Dropdown);
artist.component('InputSwitch', InputSwitch);
artist.component('MultiSelect', MultiSelect);
artist.component('SelectButton', SelectButton);
artist.component('Editor', Editor);
artist.component('Tag', Tag);
artist.component('Toast', Toast);

album.component('DataTable', DataTable);
album.component('Column', Column);
album.component('ColumnGroup', ColumnGroup);
album.component('Row', Row);
album.component('InputText', InputText);
album.component('Paginator', Paginator);
album.component('Calendar', Calendar);
album.component('InputSwitch', InputSwitch);
album.component('MultiSelect', MultiSelect);
album.component('SelectButton', SelectButton);
album.component('Editor', Editor);

playlist.component('DataTable', DataTable);
playlist.component('Column', Column);
playlist.component('ColumnGroup', ColumnGroup);
playlist.component('Row', Row);
playlist.component('InputText', InputText);
playlist.component('Paginator', Paginator);
playlist.component('InputSwitch', InputSwitch);
playlist.component('MultiSelect', MultiSelect);


ovr.use(router);
ovr.use(PrimeVue, { ripple: true });

moder.use(router);
moder.use(PrimeVue, { ripple: true });


genre.use(router);
genre.use(PrimeVue, { ripple: true });

track.use(router);
track.use(PrimeVue, { ripple: true });
track.use(ToastService);

artist.use(router);
artist.use(PrimeVue, { ripple: true });
artist.use(ToastService);

album.use(router);
album.use(PrimeVue, { ripple: true });

playlist.use(router);
playlist.use(PrimeVue, { ripple: true });

album.mount('#album');
artist.mount('#artist');
app.mount('#app');
genre.mount('#genre');
playlist.mount('#playlist');
ovr.mount('#ovr');
track.mount('#track');
moder.mount('#moder');
