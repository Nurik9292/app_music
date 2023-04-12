import { createRouter, createWebHistory} from 'vue-router';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/users',
            component: () =>  import('../components/view/User/Index.vue'),
            name: 'user.index'
        },

]});



export default router;
