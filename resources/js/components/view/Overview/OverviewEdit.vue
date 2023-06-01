<template>
    <div class="content">
        <div class="card card-white">


  <div class="card-body">

    <div class="row">
        <div class="block_one">
            <label for="name">Название блока</label>
            <InputText type="text" v-model="name" id="name" size="30"/>
        </div>
        <div class="block_one">
            <label for="name_status">Название статуса</label>
            <InputText type="text" v-model="name_status" id="name_status" size="30"/>
        </div>
    </div>

    <div class="row">
        <label class="mb-3">Выберите соодержание блока</label>
        <div class="check">
        <label for="album_and_playlist" >Альбомы и Плейлисты</label>
        <RadioButton v-model="body" inputId="album_and_playlist" name="body" value="album_and_playlist" />
    </div>
    <div class="check">
        <label for="track" >Треки</label>
        <RadioButton v-model="body" inputId="track" name="body" value="track" />
    </div>
    <div class="check">
        <label for="artist" >Аритсты</label>
        <RadioButton v-model="body" inputId="artist" name="body" value="artist" />
    </div>
    </div>

    <!-- <span>{{ albums[3] }}</span>
    ,<br>
    <span>{{ selectAlbums[0] }}</span> -->

<div class="row">
    <div>
        <div class="block_one">
            <div :class="isAlbumAndPlaylist() ? 'mb-3' : 'd-none'">
                            <div class="block_one">
                                <label for="album">Альбомы</label>
                              <MultiSelect v-model="selectAlbums" :options="albums" filter optionLabel="title" placeholder="Выбирите Альбомы" :maxSelectedLabels="10" :selectionLimit="10" class="w-full md:w-40rem" id="album" />
                            </div>
                        <div class="block_onw">
                            <label for="playlist">Плейлисты</label>
                          <MultiSelect v-model="selectPlaylists" :options="playlists" filter optionLabel="title_ru" placeholder="Выбирите Плейлисты" :maxSelectedLabels="10" :selectionLimit="10" class="w-full md:w-40rem" id="playlist" />
                        </div>
                    </div>

                      <div :class="isTrack() ? 'mb-3' : 'd-none'">
                          <label for="track">Треки</label>
                        <MultiSelect v-model="selectTracks" :options="tracks" filter optionLabel="title" placeholder="Выбирите Трек" :virtualScrollerOptions="{ itemSize: 10 }" :maxSelectedLabels="20" :selectionLimit="20" class="w-full md:w-40rem" id="track" />
                      </div>
                      <div :class="isArtist() ? 'mb-3' : 'd-none'">
                          <label for="genre">Артисты</label>
                        <MultiSelect v-model="selectArtists" :options="artists" filter optionLabel="name" placeholder="Выбирите Артиста" :maxSelectedLabels="20" :selectionLimit="20" class="w-full md:w-40rem" id="artist" />
                      </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="block_one">
            <label for="status">Нумерация</label>
            <InputNumber v-model="order_number" min="1"/>
    </div>
     <div class="block_one">
            <label for="status">Статус</label>
            <InputSwitch v-model="status" />
    </div>
</div>


</div>
    </div>


  <!-- /.card-body -->

  <div class="card-footer ">
    <router-link :to="{name: 'overview.index'}" class="btn btn-primary btn-lg">Отмена</router-link>
    <a href="#" class="btn btn-primary btn-lg ml-3" @click.prevent="update()">Обновить</a>
  </div>

    </div>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "OverviewEdit",

        data(){
           return {
            block: null,
               albums: null,
               tracks: null,
               artists: null,
               playlists: null,
               name: null,
               name_status: null,
               selectAlbums: null,
               selectPlaylists: null,
               selectTracks: null,
               selectArtists: null,
               status: false,
               order_number: null,
               body: null
           }
        },

        computed:{

        },



        mounted() {
            this.getBlocks();
            this.getAlbumts();
            this.getPlaylists();
            this.getTracks();
            this.getArtists();

        },

        methods: {

            getBlocks() {
                axios.get(`/api/overviews/show/${this.$route.params.id}`).then(res => {
                    this.name = res.data.data.block.name;
                    this.order_number = res.data.data.block.order_number;
                    this.status = res.data.data.block.status;
                    this.selectAlbums = res.data.data.albums;
                    this.selectPlaylists = res.data.data.playlists;
                    this.selectTracks = res.data.data.tracks;
                    this.selectGenres = res.data.data.genres;
                    this.name_status = res.data.data.name_status;


                    for(let idx in this.selectAlbums){
                        for(let element in this.selectAlbums[idx]){
                            if(this.selectAlbums[idx][element] == null)
                            this.selectAlbums[idx][element] = "";
                        }
                    }

                    for(let idx in this.selectPlaylists){
                        for(let element in this.selectPlaylists[idx]){
                            if(this.selectPlaylists[idx][element] == null)
                            this.selectPlaylists[idx][element] = "";
                        }
                    }

                    for(let idx in this.selectTracks){
                        for(let element in this.selectTracks[idx]){
                            if(this.selectTracks[idx][element] == null)
                            this.selectTracks[idx][element] = "";
                        }
                    }

                    for(let idx in this.selectArtists){
                        for(let element in this.selectArtists[idx]){
                            if(this.selectArtists[idx][element] == null)
                            this.selectArtists[idx][element] = "";
                        }
                    }

                    this.body = [];

                    res.data.data.albums != '' ? this.body = 'album_and_playlist' : '';
                    res.data.data.playlists != '' ? this.body = 'album_and_playlist' : '';
                    res.data.data.tracks != '' ? this.body = 'track' : '';
                    res.data.data.artists != '' ? this.body = 'artist' : '';


                })
            },

            getPlaylists() {
            axios.get("/api/overviews/playlists").then(res => { this.playlists = res.data.data });
          },

          getAlbumts() {
            axios.get("/api/overviews/albums").then(res => { this.albums = res.data.data });
          },

          getTracks() {
            axios.get("/api/overviews/tracks").then(res => { this.tracks = res.data.data });
          },

          getArtists() {
            axios.get("/api/overviews/artists").then(res => { this.artists = res.data.data });
          },


          update(){
            axios.patch(`/api/overviews/${this.$route.params.id}`, {
                status: this.status,
                name_status: this.name_status,
                name: this.name,
                order_number: this.order_number,
                albums: this.selectAlbums,
                playlists: this.selectPlaylists,
                tracks: this.selectTracks,
                artists: this.selectArtists, }).then(res =>{
                this.$router.push({name: 'overview.index'});
            });
          },


          isAlbumAndPlaylist(){
                return  "album_and_playlist" == this.body;
             },

             isTrack(){
                return "track" == this.body;
             },

             isArtist(){
                return "artist" == this.body;
             },
        }


    }
</script>



<style scoped>

.content {
        margin-right: 20px;
        margin-left: 270px;
        margin-bottom: 40px;
        margin-top: 30px;
   }
.block_one {
        float: left;
        width: 320px;
        margin-right: 50px;
        margin-bottom: 40px;
   }


   .check {
        float: left;
        width: 240px;
        margin-right: 50px;
        margin-bottom: 40px;
   }

   .lable_item{
       /* Other styling... */
       text-align: right;
    clear: both;
    float:left;
    margin-right:15px;
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
