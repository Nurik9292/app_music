import { createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/overviews/index',
            component: () =>  import('../components/view/Overview/OverviewIndex.vue'),
            name: 'overview.index'
        },
        {
            path: '/overviews/create',
            component: () =>  import('../components/view/Overview/OverviewCreate.vue'),
            name: 'overview.create'
        },
        {
            path: '/overviews/:id/edit',
            component: () =>  import('../components/view/Overview/OverviewEdit.vue'),
            name: 'overview.edit',
        },
        {
            path: '/tracks/index',
            component: () =>  import('../components/view/Track/TrackIndex.vue'),
            name: 'track.index',
        },
        {
            path: '/tracks/scan',
            component: () =>  import('../components/view/Track/TrackScan.vue'),
            name: 'track.scan',
        },
        {
            path: '/tracks/create',
            component: () =>  import('../components/view/Track/TrackCreate.vue'),
            name: 'track.create',
        },
        {
            path: '/tracks/:id/edit',
            component: () =>  import('../components/view/Track/TrackEdit.vue'),
            name: 'track.edit',
        },

]});



export default router;
