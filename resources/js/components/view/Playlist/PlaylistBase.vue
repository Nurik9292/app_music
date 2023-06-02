<template>
    <div>
        <router-view :data="data"></router-view>
    </div>
</template>

<script>

import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "PlaylistBase",

        props: ['data'],
    }
</script>

