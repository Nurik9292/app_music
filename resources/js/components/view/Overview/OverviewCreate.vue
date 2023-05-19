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
        <Checkbox v-model="body" inputId="album" name="body" value="album"/>
        <label for="album" class="lable_item">Альбомы</label>
    </div>
    <div class="check">
        <Checkbox v-model="body" inputId="playlist" name="body" value="playlist"/>
        <label for="playlist" class="lable_item">Плейлисты</label>
        </div>
    <div class="check">
        <Checkbox v-model="body" inputId="track" name="body" value="track"/>
        <label for="track" class="lable_item">Треки</label>
    </div>
    <div class="check">
        <Checkbox v-model="body" inputId="genre" name="body" value="genre"/>
        <label for="genre" class="lable_item">Жанры</label>
    </div>
    </div>


<div class="row">
    <div>
        <div class="block_one">
                        <div :class="isAlbum() ? 'mb-3' : 'd-none'">
                          <label for="album">Альбомы</label>
                        <MultiSelect v-model="selectAlbums" :options="albums" filter optionLabel="title" placeholder="Выбирите Альбомы" :maxSelectedLabels="10" :selectionLimit="10" class="w-full md:w-40rem" id="album" />
                      </div>
                      <div :class="isPlaylist() ? 'mb-3' : 'd-none'">
                          <label for="playlist">Плейлисты</label>
                        <MultiSelect v-model="selectPlaylists" :options="playlists" filter optionLabel="title_ru" placeholder="Выбирите Плейлисты" :maxSelectedLabels="10" :selectionLimit="10" class="w-full md:w-40rem" id="playlist" />
                      </div>
                      <div :class="isTrack() ? 'mb-3' : 'd-none'">
                          <label for="track">Треки</label>
                        <MultiSelect v-model="selectTracks" :options="tracks" filter optionLabel="title" placeholder="Выбирите Трек" :maxSelectedLabels="20" :selectionLimit="20" class="w-full md:w-40rem" id="track" />
                      </div>
                      <div :class="isGenre() ? 'mb-3' : 'd-none'">
                          <label for="genre">Жанры</label>
                        <MultiSelect v-model="selectGenres" :options="genres" filter optionLabel="name_ru" placeholder="Выбирите Жанры" :maxSelectedLabels="20" :selectionLimit="20" class="w-full md:w-40rem" id="genre" />
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
    <a href="#" class="btn btn-primary btn-lg ml-3" @click.prevent="store()">Добавить</a>
  </div>

    </div>
</template>

<script>

    export default{
        name: "OverviewCreate",


        data(){
           return {
               albums: null,
               tracks: null,
               genres: null,
               playlists: null,
               name: null,
               name_status: null,
               selectAlbums: null,
               selectPlaylists: null,
               selectTracks: null,
               selectGenres: null,
               status: false,
               order_number: null,
               body: null
           }
        },

        computed: {

        },

        mounted() {
            this.getAlbumts();
            this.getPlaylists();
            this.getTracks();
            this.getGenres();

        },


        methods: {

            getPlaylists() {
            axios.get("/api/overviews/playlists").then(res => { console.log(res.data.data); this.playlists = res.data.data });
          },

          getAlbumts() {
            axios.get("/api/overviews/albums").then(res => { console.log(res.data.data); this.albums = res.data.data });
          },

          getTracks() {
            axios.get("/api/overviews/tracks").then(res => { console.log(res.data.data); this.tracks = res.data.data });
          },

          getGenres() {
            axios.get("/api/overviews/genres").then(res => { console.log(res.data.data); this.genres = res.data.data });
          },


          store(){

            axios.post('/api/overviews', {
                status: this.status,
                name_status: this.name_status,
                name: this.name,
                order_number: this.order_number,
                albums: this.selectAlbums,
                playlists: this.selectPlaylists,
                tracks: this.selectTracks,
                genres: this.selectGenres,}).then(res =>{
                this.$router.back();
            });
          },

          isAlbum(){
                for(let item in this.body){
                    if("album" == this.body[item])
                        return  true;
                }
                return false;
             },

            isPlaylist(){
                for(let item in this.body){
                    if("playlist" == this.body[item])
                        return  true;
                }
                return false;
             },

             isTrack(){
                for(let item in this.body){
                    if("track" == this.body[item])
                        return  true;
                }
                return false;
             },

             isGenre(){
                for(let item in this.body){
                    if("genre" == this.body[item])
                        return  true;
                }
                return false;
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
        size: 500px;
        margin-right: 50px;
        margin-bottom: 40px;
   }

   .check {
        float: left;
        width: 140px;
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

   body {
    font-family: var(--font-family);
}

</style>
