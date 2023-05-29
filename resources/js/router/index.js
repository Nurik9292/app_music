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
        {
            path: '/artists/index',
            component: () =>  import('../components/view/Artist/ArtistIndex.vue'),
            name: 'artist.index',
        },
        {
            path: '/artists/create',
            component: () =>  import('../components/view/Artist/ArtistCreate.vue'),
            name: 'artist.create',
        },
        {
            path: '/artists/:id/edit',
            component: () =>  import('../components/view/Artist/ArtistEdit.vue'),
            name: 'artist.edit',
        },
        {
            path: '/albums/index',
            component: () =>  import('../components/view/Album/AlbumIndex.vue'),
            name: 'album.index',
        },
        {
            path: '/albums/create',
            component: () =>  import('../components/view/Album/AlbumCreate.vue'),
            name: 'album.create',
        },
        {
            path: '/albums/:id/edit',
            component: () =>  import('../components/view/Album/AlbumEdit.vue'),
            name: 'album.edit',
        },
        {
            path: '/playlists/index',
            component: () =>  import('../components/view/Playlist/PlaylistIndex.vue'),
            name: 'playlist.index',
        },
        {
            path: '/playlists/create',
            component: () =>  import('../components/view/Playlist/PlaylistCreate.vue'),
            name: 'playlist.create',
        },
        {
            path: '/playlists/:id/edit',
            component: () =>  import('../components/view/Playlist/PlaylistEdit.vue'),
            name: 'playlist.edit',
        },
        {
            path: '/genres/index',
            component: () =>  import('../components/view/Genre/GenreIndex.vue'),
            name: 'genre.index',
        },
        {
            path: '/genres/create',
            component: () =>  import('../components/view/Genre/GenreCreate.vue'),
            name: 'genre.create',
        },
        {
            path: '/moders/index',
            component: () =>  import('../components/view/Moderator/ModeratorIndex.vue'),
            name: 'moder.index',
        },




]});

// router.beforeEach((to, from, next) => {
//     const token = localStorage.getItem('x_xsrf_token');

//     if(!token){
//         if(to.name === 'login') {
//             return next();
//         }else{
//             return next({name: 'login'});
//         }
//     }

//     if(to.name === 'login' && token){
//         return next({name: 'track.index'});
//     }

//     next();
// });


export default router;
