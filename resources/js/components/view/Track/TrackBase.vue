<template>
        <div class="card">
        <TabMenu :model="items"/>
    <router-view />
        </div>
</template>

<script>

import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "TrackBase",
    }
</script>

