<template>
  <div class="content">

    <div class="row">
    <div :class="isBlock() ? '' : 'd-none'">
    <dir class="row">
        <div class="block_one">
                    <div class="mb-3">
                          <label for="new_album">Новые альбомы</label>
                        <MultiSelect v-model="selectNewAlbums" :options="albums" filter  optionLabel="title"  placeholder="Выбирите Альбомы" :maxSelectedLabels="10" :selectionLimit="10" class="w-full md:w-40rem" id="new_album" />
                      </div>
                      <div class="mb-3">
                          <label for="new_playlist">Новые плейлисты</label>
                        <MultiSelect v-model="selectNewPlaylists" :options="playlists" filter optionLabel="title_ru"  placeholder="Выбирите Плейлисты" :maxSelectedLabels="10" :selectionLimit="10" class="w-full md:w-40rem" id="new_playlist" />
                      </div>
                      <div class="mb-3">
                          <label for="updated_playlist">Обновленные плейлисты</label>
                        <MultiSelect v-model="selectUpdatedPlaylists" :options="playlists" filter optionLabel="title_ru" placeholder="Выбирите Плейлисты" :maxSelectedLabels="10" :selectionLimit="10" class="w-full md:w-40rem" id="updated_playlist" />
                      </div>
        </div>
    </dir>
    <div class="row ml-4">
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
            blocks: null,
            albums: null,
            selectNewAlbums: null,
            playlists: null,
            selectNewPlaylists: null,
            selectUpdatedPlaylists: null,
            block:null,
            order_number: null,
            status: false,
           }
        },

        computed:{

        },



        mounted() {
            this.getBlock();
            this.getBlocks();
            this.getPlaylists();
            this.getAlbumts();
        },

        methods: {
            getBlock(){
                axios.get(`/api/overviews/show/${this.$route.params.id}`).then(res => {
                    console.log(res);
                    this.block = res.data.data.block;
                    this.status = res.data.data.block.status;
                    this.order_number = res.data.data.block.order_number;
                    this.selectNewAlbums = res.data.data.albums;
                    this.selectNewPlaylists = res.data.data.newPlaylists;
                    this.selectUpdatedPlaylists = res.data.data.updatePlaylists;
                });
            },

            getBlocks() {
            axios.get("/api/overviews").then(res => { console.log(res.data.data); this.blocks = res.data.data });
          },

          getPlaylists() {
            axios.get("/api/overviews/playlists").then(res => { console.log(res.data.data); this.playlists = res.data.data });
          },

          getAlbumts() {
            axios.get("/api/overviews/albums").then(res => { console.log(res.data.data); this.albums = res.data.data });
          },

          update(){
            axios.patch(`/api/overviews/${this.block.id}`, {
                status: this.status,
                order_number: this.order_number,
                newAlbums: this.selectNewAlbums,
                newPlaylists: this.selectNewPlaylists,
                updatedPlaylists: this.selectUpdatedPlaylists, }).then(res =>{
                this.$router.push({name: 'overview.index'});
            });
          },

            isBlock() {
                for(let bb in this.blocks){
                    console.log(this.blocks[bb].id);
                    if(this.block.id == this.blocks[bb].id){
                        console.log(true);
                        return true;

                    }
                }
                return false;
            },

            value(){
                return this.albums[0];
            }
        },


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
