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

]});



export default router;
