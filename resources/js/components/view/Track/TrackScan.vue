<template>
    <div>
        <div class="content-wrapper">

            <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Треки</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <router-link :to="{name: 'track.scan'}">Сканер</router-link>
                </li>
              <li class="breadcrumb-item active">Треки</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

     <section class="content">

<div class="container-fluid">

            <div class="card">
                <TabMenu :model="items"/>
                    <router-view />
            </div>

            <div class="card">
                <div class="row ml-3">
                    <div class="block_two"><br>
                <label for="path">Введите трек</label>
                <InputText type="text" v-model="path" id="path" placeholder="Введите url трека" style="width: 500px;"/>
                </div>
              </div>

              <div class="d-flex justify-content-between ml-3">
                <div class="d-flex flex-wrap gap-3 ml-3">
            <div class="d-flex align-items-between">
                <RadioButton v-model="local" inputId="tm" name="local" value="tm"/>
                <label for="tm" class="ml-2">Tm</label>
            </div>
            <div class="d-flex align-items-between">
                <RadioButton v-model="local" inputId="ru" name="local" value="ru" />
                <label for="ru" class="ml-2">Ru</label>
            </div>
            <div class="d-flex align-items-between">
                <RadioButton v-model="local" inputId="en" name="local" value="en" />
                <label for="en" class="ml-2">En</label>
            </div>
        </div>
              </div>
            </div>

            <a href="#" class="btn btn-primary btn-lg mb-3" @click.prevent="scan()">Сканировать</a>
            </div>
        </section>
    </div>
</div>
</template>

<script>

import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "TrackScan",

        props: ['data'],

        data(){
            return {
                path: null,
                local: 'tm',

                items: [
                {
                    label: 'Главная',
                    icon: 'pi pi-fw pi-home',
                    to: '/tracks/index'
                },
                {
                    label: 'Сканировать',
                    icon: 'pi pi-fw pi-home',
                    to: '/tracks/scan'
                },
                {
                    label: 'Добавить',
                    icon: 'pi pi-fw pi-calendar',
                    to: '/tracks/create'
                }]
            }
        },

        methods: {
            scan(){
                axios.post('/api/tracks/scan', {path: this.path, local: this.local, user_id: this.data['id']}).then(res => {  this.$router.back();});
            }
        }
    }
</script>

<style scoped>
.block_one {
    float: left;
    width: 320px;
    margin-right: 50px;
    margin-bottom: 40px;

}

.block_two{
    float: left;
    width: 520px;
    margin-right: 50px;
    margin-bottom: 40px;

}


.text {
float: left;
  width: 500px;
    margin-right: 50px;
    margin-bottom: 40px;
}

.text textarea {
height: 300px;
}

label {
display: block;
}


</style>
