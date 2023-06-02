<template>
        <div class="card">
            <router-view :data="data"/>
        </div>
</template>

<script>

import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "TrackBase",
        props:['data'],


    }
</script>

