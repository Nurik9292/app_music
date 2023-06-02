<template>
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Добавление Жанра</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Главная</a></li>
              <li class="breadcrumb-item"><router-link :to="{name: 'genre.index'}">Жанры</router-link></li>
              <li class="breadcrumb-item active">Добавить</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="card">

<br>
<div class="row ml-3">
    <div class="block_one">
        <label>Название Tm</label>
        <InputText type="text" v-model="name_tm" placeholder="Введите Название" :class=" isErrorTm() ? 'p-invalid' : ''"/>
        <div v-if="isErrorTm()">
            <p class="text-danger">{{ errorMessage() }}</p>
        </div>
    </div>

    <div class="block_one">
        <label>Название Ru</label>
        <InputText type="text" v-model="name_ru" placeholder="Введите Название" :class=" isErrorRu() ? 'p-invalid' : ''"/>
        <div v-if="isErrorRu()">
            <p class="text-danger">{{ errorMessage() }}</p>
        </div>
      </div>
</div>



</div>

<router-link class="btn btn-primary btn-lg mb-3" :to="{name: 'album.index'}">Отмена</router-link>
        <a href="#" class="btn btn-primary btn-lg mb-3 ml-3" @click.prevent="store()">Добавить</a>

    </section>

   </div>
</template>

<script>

import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "GenreCreate",

        props: ['data'],

        data(){
            return {
                name_tm: null,
                name_ru: null,
                errors: null
            }
        },

        methods: {
            store(){
                axios.post('/api/genres', {name_tm: this.name_tm, name_ru: this.name_ru, user_id: this.data}).then(res => {
                    this.$router.push({name: 'genre.index'});
                }).catch(error => {
                   this.errors = error.response.data.errors
                })
            },

            isErrorTm(){
                for(let error in this.errors)
                    if(error == 'name_tm') return true;
                return false;
            },

            isErrorRu(){
                for(let error in this.errors)
                    if(error == 'name_ru') return true;
                return false;
            },

            errorMessage(){
                if(this.isErrorTm()) return this.errors.name_tm[0];
                if(this.isErrorRu()) return this.errors.name_ru[0];
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
