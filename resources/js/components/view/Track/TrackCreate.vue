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
                                <router-link :to="{name: 'track.create'}">Добавить</router-link>
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




    <!-- form start -->
      <div class="card">

        <br>
        <div class="row ml-3">
            <div class="block_two">
                <label for="audio_url">Введите трек</label>
                <InputText type="text" v-model="audio_url" id="audio_url" placeholder="Введите url трека" :class="isErrorUrl() ? 'p-invalid' : ''" style="width: 500px;"/>
                <div v-if="isErrorUrl()">
                    <p class="text-danger">{{ errorMessageUrl() }}</p>
                </div>
              </div>
              <div class="text">
                <label for="lyrics">Текст Песни</label>
                <Textarea v-model="lyrics" autoResize rows="5" cols="50" id="lyrics" placeholder="Введите текст трека"/>
              </div>
        </div>

        <div class="row ml-3">
            <div class="block_one">
                <label>Альбомы</label>
                <MultiSelect v-model="selectedAlbum" :options="albums" filter optionLabel="title" optionValue="id" placeholder="Выбирите альбом" :maxSelectedLabels="1" :selectionLimit="1" class="w-full md:w-40rem" />
              </div>

              <div class="block_one">
                <label>Жанры</label>
                <MultiSelect v-model="selectedGenres" :options="genres" filter optionLabel="name_ru" optionValue="id" placeholder="Выбирите жанр" :maxSelectedLabels="5" :selectionLimit="5" class="w-full md:w-40rem"/>
          </div>

          <div class="block_one">
                    <label for="number">Номер трека </label>
                    <InputNumber v-model="track_number" inputId="integeronly" placeholder="Выбирите номер трека"/>

                  </div>
        </div>

        <div class="row ml-3">
            <div class="block_one">
                <label for="status">Статуc</label>
                <InputSwitch v-model="status" />

              </div>
              <div class="block_one">
                <label for="is_national">Национальная</label>
                <InputSwitch v-model="is_national" />

              </div>
        </div>


        </div>


      <!-- /.card-body -->


        <!-- <a href="{{route('track.index')}}" class="btn btn-primary btn-lg mr-3" >Отмена</a> -->
        <a href="#" class="btn btn-primary btn-lg mb-3" @click.prevent="store()">Добавить</a>

    </div>
<!-- /.row (main row) -->
</section>
    </div>
</div>
</template>

<script>

import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "TrackCreate",

        data(){
                return {
                    audio_url: null,
                    lyrics: null,
                    track_number: null,
                    status: false,
                    is_national: false,
                    artists: null,
                    selectedArtists: null,
                    albums: null,
                    selectedAlbum: null,
                    genres: null,
                    selectedGenres: null,
                    errors: null,

                items: [{
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

        mounted() {
            this.getAlbumts();
            this.getArtists();
            this.getGenres();
        },

        methods: {
            getAlbumts() {
            axios.get("/api/tracks/albums").then(res => { this.albums = res.data.data });
          },

          getArtists() {
            axios.get("/api/tracks/artists").then(res => { this.artists = res.data.data });
          },

          getGenres() {
            axios.get("/api/tracks/genres").then(res => { this.genres = res.data.data });
          },

          store() {
            axios.post('/api/tracks', {
                audio_url: this.audio_url,
                status: this.status,
                lyrics: this.lyrics,
                is_national: this.is_national,
                album: this.selectedAlbum != null ? this.selectedAlbum.id : '',
                artists: this.selectedArtists,
                track_number: this.track_number,
                genres: this.selectedGenres,}).then(res =>{
                this.$router.back();
            }).catch(error => {
                console.log(error.response);
                this.errors = error.response.data.errors
            })
          },

          isErrorUrl(){
            for(let error in this.errors)
                    if(error == 'audio_url') return true;
                return false;
          },

          errorMessageUrl(){
            if(this.isErrorUrl()) return this.errors.audio_url[0];
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
