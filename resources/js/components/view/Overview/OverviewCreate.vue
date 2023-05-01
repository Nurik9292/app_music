<template>
    <div class="content">
        <div class="card card-white">


  <div class="card-body">

    <div class="row">
        <div class="block_one">
             <Dropdown v-model="selectBlocks" :options="blocks" optionLabel="name" placeholder="Выберите блок" class="w-full md:w-14rem" />
        </div>
    </div>



<div class="row">
    <div :class="blockId ==  1 ? '' : 'd-none'">
        <div class="block_one">

                    <div class="mb-3">
                          <label for="new_album">Новые альбомы</label>
                        <MultiSelect v-model="selectNewAlbums" :options="albums" filter optionLabel="title" placeholder="Выбирите Альбомы" :maxSelectedLabels="10" :selectionLimit="10" class="w-full md:w-40rem" id="new_album" />
                      </div>
                      <div class="mb-3">
                          <label for="new_playlist">Новые плейлисты</label>
                        <MultiSelect v-model="selectNewPlaylists" :options="playlists" filter optionLabel="title_ru" placeholder="Выбирите Плейлисты" :maxSelectedLabels="10" :selectionLimit="10" class="w-full md:w-40rem" id="new_playlist" />
                      </div>
                      <div class="mb-3">
                          <label for="updated_playlist">Обновленные плейлисты</label>
                        <MultiSelect v-model="selectUpdatedPlaylists" :options="playlists" filter optionLabel="title_ru" placeholder="Выбирите Плейлисты" :maxSelectedLabels="10" :selectionLimit="10" class="w-full md:w-40rem" id="updated_playlist" />
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
                blocks: null,
                selectBlocks: null,
                albums: null,
                selectNewAlbums: null,
                playlists: null,
                selectNewPlaylists: null,
                selectUpdatedPlaylists: null,
                status: false,
                order_number: null,
           }
        },

        computed: {
            blockId(){ return this.selectBlocks ? this.selectBlocks.id : null }
        },

        mounted() {
            this.getBlocks();
            this.getAlbumts();
            this.getPlaylists();
        },


        methods: {

          getBlocks() {
            axios.get("/api/overviews/blocks").then(res => { console.log(res.data.data); this.blocks = res.data.data });
          },

          getPlaylists() {
            axios.get("/api/overviews/playlists").then(res => { console.log(res.data.data); this.playlists = res.data.data });
          },

          getAlbumts() {
            axios.get("/api/overviews/albums").then(res => { console.log(res.data.data); this.albums = res.data.data });
          },

          store(){
            axios.post('/api/overviews', {
                status: this.status,
                block: this.selectBlocks,
                order_number: this.order_number,
                newAlbums: this.selectNewAlbums,
                newPlaylists: this.selectNewPlaylists,
                updatedPlaylists: this.selectUpdatedPlaylists, }).then(res =>{
                this.getBlocks();
                this.$router.back();
            });
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
