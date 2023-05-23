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
                                <router-link :to="{name: 'artist.create'}">Добавить</router-link>
                            </li>
                            <li class="breadcrumb-item active">Артисты</li>
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
                <InputText type="text" v-model="name" id="name" placeholder="Введите имя артиста" style="width: 400px;"/>
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
            </div>

            <div class="block_one">
                <label>Страна</label>
                <MultiSelect v-model="selectedCountry" :options="countries" optionLabel="name"  filter placeholder="Выберите страну" :maxSelectedLabels="5" :selectionLimit="5"  class="w-full md:w-14rem" />
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

            console.log(this.name);
            console.log(131212);

            const data = new FormData();
            let image = this.dropzone.getAcceptedFiles();

            let artwork_url = image.length > 0 ? image[0] : null;

            data.append('artwork_url', artwork_url);
            data.append('name', this.name);
            data.append('status', this.status);
            data.append('bio_tk', this.bio_tk);
            data.append('bio_ru', this.bio_ru);
            data.append('country_id', this.selectedCountry[0].id);
            data.append('_method', 'PATCH');

            axios.post(`/api/artists/${this.$route.params.id}`, data).then(res =>{
                this.$router.push({name: 'artist.index'});
            });
          }

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
