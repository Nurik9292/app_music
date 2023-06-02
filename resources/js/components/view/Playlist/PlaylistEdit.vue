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
                <label>Название Tm</label>
                <InputText type="text" v-model="title_tm" placeholder="Введите имя артиста" style="width: 400px;"/>
            </div>

            <div class="block_two">
                <label>Название Ru</label>
                <InputText type="text" v-model="title_ru" placeholder="Введите имя артиста" style="width: 400px;"/>
            </div>

        </div>

        <div class="row ml-3">
            <div class="block_two">
                <label>Треки</label>
                <MultiSelect v-model="selectedTracks" :options="tracks" optionLabel="title"  filter placeholder="Выберите трек" :maxSelectedLabels="2" :virtualScrollerOptions="{ itemSize: 10 }" class="w-full md:w-14rem" />
            </div>

            <div class="block_two">
                <label>Жанры</label>
                <MultiSelect v-model="selectedGenres" :options="genres" optionLabel="name_ru" filter placeholder="Выберите жанр плейлиста" :maxSelectedLabels="3" :virtualScrollerOptions="{ itemSize: 10 }" class="w-full md:w-14rem" />
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
                <label for="status">Статуc</label>
                <InputSwitch v-model="status" />
            </div>

        </div>

        </div>

        <div class="card">

<DataTable   v-model:filters="filters" :value="selectedTracks" paginator :rows="10"
    stateStorage="session" stateKey="dt-state-demo-session"  filterDisplay="menu"  selectionMode="multiple"
    dataKey="id" tableStyle="min-width: 50rem">
<template #header>
    <div class="d-flex justify-content-between">
        <div class="d-flex flex-wrap gap-3">
            <div class="d-flex align-items-between p-input-icon-left">
                <i class="pi pi-search" />
                <InputText v-model="filters['global'].value" placeholder="Search" />
            </div>
        </div>
  </div>
</template>
<Column field="id" header="№" sortable style="width: 10%"></Column>
<Column field="title" header="Название" sortable style="width: 45%"></Column>
<Column header="Delete" style="width: 15%">
    <template #body="{ data }">
        <div class="flex align-items-center gap-2">
            <a href="#" class="btn btn-outline-danger" @click.prevent="deleteTracks(data.id)" >Delete</a>
        </div>
    </template>
</Column>
<template #empty> No customers found. </template>
</DataTable>
</div>

      <!-- /.card-body -->

      <router-link class="btn btn-primary btn-lg mb-3" :to="{name: 'playlist.index'}">Отмена</router-link>
        <a href="#" class="btn btn-primary btn-lg mb-3 ml-3" @click.prevent="update()">Обновить</a>

    </div>
<!-- /.row (main row) -->
</section>
    </div>
</div>
</template>

<script>
import Dropzone from 'dropzone'
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "AlbumCreate",

        props: ['data'],

        data(){
                return {
                    title_tm: null,
                    title_ru: null,
                    status: false,
                    genres: null,
                    selectedGenres: null,
                    tracks: null,
                    selectedTracks: null,
                    playlistTracks: null,
                    filters: {
                                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                                title: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] }
                    },
             }
        },

        mounted() {
            this.dropzone = new Dropzone(this.$refs.dropzone, {url: 'none', autoProcessQueue: false, acceptedFiles: 'image/*'});
            this.getTracks();
            this.getGenres();
            this.getPlaylist();
        },

        methods: {

            getPlaylist(){
                axios.get(`/api/playlists/show/${this.$route.params.id}`).then(res => {
                    this.title_tm = res.data.data.title_tm,
                    this.title_ru = res.data.data.title_ru,
                    this.status = res.data.data.status,
                    this.selectedTracks = res.data.data.tracks,
                    this.selectedGenres = res.data.data.genres
                });
            },

            getTracks() {
            axios.get("/api/playlists/tracks").then(res => { this.tracks = res.data.data });
          },

          getGenres() {
            axios.get("/api/playlists/genres").then(res => {this.genres = res.data.data });
          },


          update() {

            let tracksId = [];
            let genresId = [];

            for(let idx in this.selectedTracks)
                tracksId.push(this.selectedTracks[idx].id);

            for(let idx in this.selectedGenres)
                genresId.push(this.selectedGenres[idx].id);

            const data = new FormData();
            let image = this.dropzone.getAcceptedFiles();

            data.append('artwork_url', image.length > 0 ? image[0] : '');
            data.append('title_tm', this.title_tm);
            data.append('title_ru', this.title_ru);
            data.append('status', this.status);
            for (var i = 0; i < tracksId.length; i++){
                data.append('tracks[]',tracksId[i]);
            }
            for (var i = 0; i < genresId.length; i++){
                data.append('genres[]',genresId[i]);
            }
            data.append('user_id', this.data);
            data.append('_method', 'PATCH');

            axios.post(`/api/playlists/${this.$route.params.id}`, data).then(res =>{
                this.$router.push({name: 'playlist.index'});
            });
          },

          deleteTracks(id){
            axios.post(`/api/playlists/tracks/delete/${this.$route.params.id}`,{track: id}).then(res => {
                this.getPlaylist()
              });
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
