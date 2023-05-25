<template>
 <div>
    <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Артисты</h1>
                        </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                               <a href="/">Главная</a>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link :to="{name: 'artist.index'}">Артисты</router-link>
                            </li>
                            <li class="breadcrumb-item active">Обновить</li>
                        </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
<!-- /.content-header -->



<section class="content">

    <div class="container-fluid">

    <!-- form start -->
      <div class="card">

        <br>
        <div class="row ml-3">
            <div class="block_two">
                <label>Имя</label>
                <InputText type="text" v-model="name" id="name" placeholder="Введите имя артиста" style="width: 400px;" :class="isErrorName() ? 'p-invalid' : ''"/>
                <div v-if="isErrorName()">
                    <p class="text-danger">{{ errorMessageName() }}</p>
                    </div>
            </div>
        </div>

        <div class="row ml-3">
            <div class="block_two">
                <label>Биография Tm</label>
                <Editor v-model="bio_tk" editorStyle="height: 320px" />
            </div>

            <div class="block_two">
                <label>Биография Ru</label>
                <Editor v-model="bio_ru" editorStyle="height: 320px" />
            </div>
        </div>

        <div class="row ml-3">
            <div class="block_one" style="width: 420px;">
                <label>Выберите изображение</label>
                    <div ref="dropzone"  class="btn d-block p-5 bg-dark text-center text-light">
                        Upload
                    </div>
                    <div v-if="isErrorArtwork()">
                    <p class="text-danger">{{ errorMessageArtwork() }}</p>
                    </div>
            </div>

            <div class="block_one">
                <label>Страна</label>
                <MultiSelect v-model="selectedCountry" :options="countries" optionLabel="name"  filter placeholder="Выберите страну" :maxSelectedLabels="5" :selectionLimit="5"  :class="isErrorCountry() ? 'p-invalid' : '', 'w-full md:w-14rem'" />
                <div v-if="isErrorCountry()">
                    <p class="text-danger">{{ errorMessageContry() }}</p>
                    </div>
            </div>
        </div>

        <div class="row ml-3">
            <div class="block_one">
                <label for="status">Статуc</label>
                <InputSwitch v-model="status" />
              </div>
        </div>


        </div>
      <!-- /.card-body -->

      <router-link class="btn btn-primary btn-lg mb-3" :to="{name: 'artist.index'}">Отмена</router-link>
        <a href="#" class="btn btn-primary btn-lg mb-3 ml-3" @click.prevent="update()">Обновить</a>

    </div>
<!-- /.row (main row) -->
</section>
    </div>
</div>
</template>

<script>
import Dropzone from 'dropzone'
import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "ArtistEdit",

        data(){
                return {
                    name: null,
                    bio_tk: null,
                    bio_ru: null,
                    status: false,
                    countries: null,
                    selectedCountry: [],
                    errors: null,

             }
        },

        mounted() {
            this.dropzone = new Dropzone(this.$refs.dropzone, {url: 'none', autoProcessQueue: false, acceptedFiles: 'image/*'});
            this.getCountries();
            this.getArtist();
        },

        methods: {
            getArtist(){
                axios.get(`/api/artists/show/${this.$route.params.id}`).then(res => {
                    this.name = res.data.data.name,
                    this.bio_tk = res.data.data.bio_tk,
                    this.bio_ru = res.data.data.bio_ru,
                    this.status = res.data.data.status,
                    this.selectedCountry.push(res.data.data.country)
                })
            },

            getCountries() {
            axios.get("/api/artists/countries").then(res => { this.countries = res.data.data });
          },


          update() {
            const data = new FormData();
            let image = this.dropzone.getAcceptedFiles();

            let artwork_url = image.length > 0 ? image[0] : '';

            data.append('artwork_url', artwork_url);
            data.append('name', this.name ? this.name : '');
            data.append('status', this.status);
            data.append('bio_tk', this.bio_tk);
            data.append('bio_ru', this.bio_ru);
            data.append('country_id', this.selectedCountry ? this.selectedCountry[0].id : '');
            data.append('_method', 'PATCH');

            axios.post(`/api/artists/${this.$route.params.id}`, data).then(res =>{
                this.$router.push({name: 'artist.index'});
            }).catch(error => {
                this.errors = error.response.data.errors
            });
          },

          isErrorName(){
                for(let error in this.errors)
                    if(error == 'name') return true;
                return false;
          },

          isErrorArtwork(){
                for(let error in this.errors)
                    if(error == 'artwork_url') return true;
                return false;
          },

          isErrorCountry(){
                for(let error in this.errors)
                    if(error == 'country_id') return true;
                return false;
          },

          errorMessageName(){
                if(this.isErrorName()) return this.errors.name[0];
                if(this.isErrorCountry()) return this.errors.country_id[0];
          },

          errorMessageArtwork(){
                if(this.isErrorArtwork()) return this.errors.artwork_url[0];
          },

          errorMessageContry(){
                if(this.isErrorCountry()) return this.errors.country_id[0];
          },

        },
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
    width: 420px;
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
