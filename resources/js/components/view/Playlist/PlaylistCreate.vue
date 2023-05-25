<template>
 <div>
    <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Плейлисты</h1>
                        </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                               <a href="/">Главная</a>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link :to="{name: 'playlist.index'}">Плейлисты</router-link>
                            </li>
                            <li class="breadcrumb-item active">Добавить</li>
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
                <label>Название Tm</label>
                <InputText type="text" v-model="title_tm" placeholder="Введите имя артиста" style="width: 400px;" :class="isErrorTitleTm() ? 'p-invalid' : ''"/>
                <div v-if="isErrorTitleTm()">
                    <p class="text-danger">{{ errorMessageTitleTm() }}</p>
                    </div>
            </div>

            <div class="block_two">
                <label>Название Ru</label>
                <InputText type="text" v-model="title_ru" placeholder="Введите имя артиста" style="width: 400px;" :class="isErrorTitleRu() ? 'p-invalid' : ''"/>
                <div v-if="isErrorTitleRu()">
                    <p class="text-danger">{{ errorMessageTitleRu() }}</p>
                    </div>
            </div>

        </div>

        <div class="row ml-3">
            <div class="block_two">
                <label>Треки</label>
                <MultiSelect v-model="selectedTracks" :options="tracks" optionLabel="title"  filter placeholder="Выберите трек" :maxSelectedLabels="2" :class="isErrorTracks() ? 'p-invalid' : '', 'w-full md:w-14rem'"  />
                <div v-if="isErrorTracks()">
                    <p class="text-danger">{{ errorMessageTracks() }}</p>
                    </div>
            </div>

            <div class="block_two">
                <label>Жанры</label>
                <MultiSelect v-model="selectedGenres" :options="genres" optionLabel="name_ru" filter placeholder="Выберите жанр плейлиста" :maxSelectedLabels="3" :class="isErrorGenres() ? 'p-invalid' : '', 'w-full md:w-14rem'" />
                <div v-if="isErrorGenres()">
                    <p class="text-danger">{{ errorMessageGenres() }}</p>
                    </div>
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
                <label for="status">Статуc</label>
                <InputSwitch v-model="status" />
            </div>

        </div>

        </div>

      <!-- /.card-body -->

      <router-link class="btn btn-primary btn-lg mb-3" :to="{name: 'playlist.index'}">Отмена</router-link>
        <a href="#" class="btn btn-primary btn-lg mb-3 ml-3" @click.prevent="store()">Добавить</a>

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
        name: "AlbumCreate",

        data(){
                return {
                    title_tm: null,
                    title_ru: null,
                    status: false,
                    genres: null,
                    selectedGenres: null,
                    tracks: null,
                    selectedTracks: null,
                    errors: null,
             }
        },

        mounted() {
            this.dropzone = new Dropzone(this.$refs.dropzone, {url: 'none', autoProcessQueue: false, acceptedFiles: 'image/*'});
            this.getTracks();
            this.getGenres();
        },

        methods: {
            getTracks() {
            axios.get("/api/playlists/tracks").then(res => { this.tracks = res.data.data });
          },

          getGenres() {
            axios.get("/api/playlists/genres").then(res => {this.genres = res.data.data });
          },

          store() {

            let tracksId = [];
            let genresId = [];

            for(let idx in this.selectedTracks)
                tracksId.push(this.selectedTracks[idx].id);

            for(let idx in this.selectedGenres)
                genresId.push(this.selectedGenres[idx].id);


            const data = new FormData();
            let image = this.dropzone.getAcceptedFiles();

            data.append('artwork_url', image.length > 0 ? image[0] : '');
            data.append('title_tm', this.title_tm ? this.title_tm : '');
            data.append('title_ru', this.title_ru ? this.title_ru : '');
            data.append('status', this.status);
            for (var i = 0; i < tracksId.length; i++){
                data.append('tracks[]',tracksId[i]);
            }
            for (var i = 0; i < genresId.length; i++){
                data.append('genres[]',genresId[i]);
            }

            axios.post('/api/playlists/', data).then(res =>{
                this.$router.push({name: 'playlist.index'});
            }).catch(error => {
                this.errors = error.response.data.errors
            });
          },

          isErrorTitleTm(){
                for(let error in this.errors)
                    if(error == 'title_tm') return true;
                return false;
          },

          isErrorTitleRu(){
                for(let error in this.errors)
                    if(error == 'title_ru') return true;
                return false;
          },

          isErrorArtwork(){
                for(let error in this.errors)
                    if(error == 'artwork_url') return true;
                return false;
          },

          isErrorTracks(){
                for(let error in this.errors)
                    if(error == 'tracks') return true;
                return false;
          },

          isErrorGenres(){
                for(let error in this.errors)
                    if(error == 'genres') return true;
                return false;
          },

          errorMessageTitleTm(){
            if(this.isErrorTitleTm) return this.errors.title_tm[0];
          },

          errorMessageTitleRu(){
            if(this.isErrorTitleTm) return this.errors.title_ru[0];
          },

          errorMessageArtwork(){
            if(this.isErrorTitleTm) return this.errors.artwork_url[0];
          },

          errorMessageTracks(){
            if(this.isErrorTitleTm) return this.errors.tracks[0];
          },

          errorMessageGenres(){
            if(this.isErrorTitleTm) return this.errors.genres[0];
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
