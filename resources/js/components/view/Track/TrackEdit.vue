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
                                <router-link :to="{name: 'track.create'}">Обновить</router-link>
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

        <br>
        <Toast />
        <div :class="isModer() ? 'd-none' : 'row ml-3'">
            <div class="block_two">
                <label for="audio_url">Трека</label>
                <InputText type="text" v-model="audio_url" id="audio_url" placeholder="Введите url трека" :class="isErrorUrl() ? 'p-invalid' : ''" style="width: 500px;"/>
                <div v-if="isErrorUrl()">
                    <p class="text-danger">{{ errorMessageUrl() }}</p>
                </div>
              </div>
        </div>

        <div class="row ml-3">
            <div class="block_one">
                <label for="title">Название трека</label>
                <InputText type="text" v-model="title" id="title" placeholder="Введите название трека"/>
              </div>
              <div class="text">
                <label for="lyrics">Текст Песни</label>
                <Textarea v-model="lyrics" autoResize rows="5" cols="30" id="lyrics" placeholder="Введите текст трека"/>

              </div>
        </div>

        <div class="row ml-3">
            <div :class="isModer() ? 'd-none' : 'block_two'">
                <label>Изменить изображение</label>
                <SelectButton v-model="value" :options="options" aria-labelledby="basic"/>
              </div>

        </div>

        <div class="row ml-3">

            <div :class="isFile() ? '' : 'd-none'">
                <div class="block_one">
                    <label for="customFile">Выберите изображение</label>
                    <div ref="dropzone"  class="btn d-block p-5 bg-dark text-center text-light">
                        Upload
                    </div>
                    <div v-if="isErrorImage()">
                    <p class="text-danger">{{ errorMessageImage() }}</p>
                </div>
              </div>
            </div>

        </div>


            <div class="row ml-3">
                <label>Исполнитель</label>
                  <div class="block_one">
                    <MultiSelect v-model="selectedArtists" :options="artists" filter optionLabel="name"   placeholder="Выбирите артиста" :maxSelectedLabels="5" :selectionLimit="5" class="w-full md:w-40rem" />
                </div>


                <div class="block_one">
                    <a  href="/artists/create" class="btn btn-outline-primary " >Добавить</a>
                </div>

            </div>

        <div class="row ml-3">
            <div class="block_one">
                <label>Альбомы</label>
                <MultiSelect v-model="selectedAlbum" :options="albums" optionLabel="title"  filter placeholder="Выберите альбом" :maxSelectedLabels="1" :selectionLimit="1"  class="w-full md:w-14rem" />
              </div>

              <div class="block_one">
                <label>Жанры</label>
                <MultiSelect v-model="selectedGenres" :options="genres" filter optionLabel="name_ru"  placeholder="Выбирите жанр" :maxSelectedLabels="5" :selectionLimit="5" class="w-full md:w-40rem"/>
          </div>

          <div class="block_one">
                    <label for="number">Номер трека </label>
                    <InputNumber v-model="track_number" inputId="integeronly" placeholder="Выбирите номер трека"/>

                  </div>
        </div>

        <div class="row ml-3">
            <div :class="isModer() ? 'd-none' : 'block_one'">
                <label for="status">Статуc</label>
                <InputSwitch v-model="status" />

              </div>
              <div class="block_one">
                <label for="is_national">Национальная</label>
                <InputSwitch v-model="is_national" />

              </div>
        </div>
        <!-- <button type="submit" class="btn btn-primary btn-block">Обновить</button> -->
    <!-- </form> -->
        </div>

      <!-- /.card-body -->

        <div>
            <router-link :to="{name: 'track.index'}" class="btn btn-primary btn-lg mb-3">Отмена</router-link>

            <a href="#" class="btn btn-primary btn-lg mb-3 ml-3" @click.prevent="update()">Обновить</a>
            <!-- <button class="btn btn-primary btn-block">Обновить</button> -->
        </div>


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
        name: "TrackEdit",

        props: ['data'],

        data(){
                return {
                    dropzone: null,
                    value: 'No',
                    options: ['No', 'Yes'],
                    title: null,
                    audio_url: null,
                    artwork_url: null,
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
                    toast: null,

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
            this.dropzone = new Dropzone(this.$refs.dropzone, {url: 'none', autoProcessQueue: false, acceptedFiles: 'image/*'});
            this.getTrack();
            this.getAlbumts();
            this.getArtists();
            this.getGenres();
        },

        methods: {
            getTrack() {
                axios.get(`/api/tracks/show/${this.$route.params.id}`).then(res => {
                    this.title = res.data.data.title;
                    this.status = res.data.data.status;
                    // this.artwork_url = res.data.data.artwork_url;
                    this.track_number = res.data.data.track_number;
                    this.audio_url = res.data.data.audio_url;
                    this.is_national = res.data.data.is_national;
                    this.selectedAlbum = res.data.data.album;
                    this.selectedArtists = res.data.data.artists;
                    this.selectedGenres = res.data.data.genres;
                    this.lyrics = res.data.data.lyrics;


                })
            },

            getAlbumts() {
            axios.get("/api/tracks/albums").then(res => { this.albums = res.data.data });
          },

          getArtists() {
            axios.get("/api/tracks/artists").then(res => { this.artists = res.data.data });
          },

          getGenres() {
            axios.get("/api/tracks/genres").then(res => { this.genres = res.data.data });
          },

          update() {

            const data = new FormData();
            let files = this.dropzone.getAcceptedFiles();

            let album = this.selectedAlbum.length === 0 ? null : this.selectedAlbum[0].id ;
            let artists = [];
            let genres = [];

            for(let idx in this.selectedArtists)
                artists.push(this.selectedArtists[idx].id)


            for(let idx in this.selectedGenres)
                genres.push(this.selectedGenres[idx].id)


            data.append('artwork_url', files.length > 0 ? files[0] : '');
            data.append('title', this.title);
            data.append('audio_url', this.audio_url);
            data.append('status', this.status);
            data.append('lyrics', this.lyrics);
            data.append('is_national', this.is_national);
            data.append('genres', genres);
            data.append('album', album ? album : '');
            data.append('artists', artists);
            data.append('is_national', this.is_national);
            data.append('user_id', this.data['id']);
            data.append('_method', 'PATCH');

            axios.post(`/api/tracks/${this.$route.params.id}`, data).then(res =>{
                    this.$router.push({name: 'track.index'});
            }).catch(error => {
                this.errors = error.response.data.errors
            })


          },

        isFile(){
            return this.value == 'Yes';
        },

        isErrorUrl(){
            for(let error in this.errors)
                    if(error == 'audio_url') return true;
                return false;
          },


        isErrorImage(){
            for(let error in this.errors)
                    if(error == 'artwork_url') return true;
                return false;
          },

          errorMessageUrl(){
            if(this.isErrorUrl()) return this.errors.audio_url[0];
          },

          errorMessageImage(){
            if(this.isErrorImage()) return this.errors.artwork_url[0];
          },

          isModer(){
            return this.data['role'] === 3;
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
