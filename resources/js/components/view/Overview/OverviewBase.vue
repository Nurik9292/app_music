<template>
    <div>
        <router-view></router-view>
</div>

</template>

<script>

import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "OverviewBase",
    }
</script>


<style scoped>
.buttons {
  margin-top: 35px;
}

.flip-list-move {
  transition: transform 0.5s;
}
.no-move {
  transition: transform 0s;
}
</style>
