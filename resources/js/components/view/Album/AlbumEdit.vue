<template>
 <div>
    <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Альбомы</h1>
                        </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                               <a href="/">Главная</a>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link :to="{name: 'album.index'}">Альбомы</router-link>
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
                <label>Название</label>
                <InputText type="text" v-model="title" placeholder="Введите имя артиста" style="width: 400px;"/>
            </div>

            <div class="block_two">
                <label>Дата добавление:</label>
                <Calendar v-model="release_date" showIcon  showTime hourFormat="24" dateFormat="dd/mm/yy"/>
            </div>

            <div class="block_two">
                <label>Дата выпуска:</label>
                <Calendar v-model="added_date" showIcon  showTime hourFormat="24" dateFormat="dd/mm/yy"/>
            </div>


        </div>

        <div class="row ml-3">
            <div class="block_two">
                <label>Содержание</label>
                <Editor v-model="description" editorStyle="height: 320px" />
            </div>

            <div class="block_one" style="width: 420px;">
                <label>Выберите изображение</label>
                    <div ref="dropzone"  class="btn d-block p-5 bg-dark text-center text-light">
                        Upload
                    </div>
            </div>

        </div>

        <div class="row ml-3">
            <label>Исполнитель</label>
            <div class="block_one">
                <MultiSelect v-model="selectedArtists" :options="artists" optionLabel="name"  filter placeholder="Выберите артиста" :maxSelectedLabels="4" :selectionLimit="4"  class="w-full md:w-14rem" />
            </div>

            <div class="block_one">
                <router-link :to="{name: 'artist.create'}" class="btn btn-outline-primary">Добавить</router-link>
            </div>
        </div>

        <div class="row ml-3">
            <div class="block_one">
                <label>Тип</label>
                <MultiSelect v-model="selectedType" :options="types" optionLabel="name"  filter placeholder="Выберите тип альбома" :maxSelectedLabels="1" :selectionLimit="1"  class="w-full md:w-14rem" />
            </div>

            <div class="block_one">
                <label for="status">Статуc</label>
                <InputSwitch v-model="status" />
              </div>

              <div class="block_one">
                <label for="status">Национальная</label>
                <InputSwitch v-model="is_national" />
              </div>
        </div>


        </div>

        <div class="card">

<DataTable  v-model:selection="selectedTracks" v-model:filters="filters" :value="tracks" paginator :rows="10"
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

      <router-link class="btn btn-primary btn-lg mb-3" :to="{name: 'album.index'}">Отмена</router-link>
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

        data(){
                return {
                    tracks: null,
                    selectedTracks: null,
                    title: null,
                    description: null,
                    release_date: null,
                    added_date: null,
                    old_release_date: null,
                    old_added_date: null,
                    status: false,
                    types: null,
                    selectedType: [],
                    is_national: false,
                    artists: null,
                    selectedArtists: null,
                    filters: {
                                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                                title: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] }
                    },
             }
        },

        mounted() {
            this.dropzone = new Dropzone(this.$refs.dropzone, {url: 'none', autoProcessQueue: false, acceptedFiles: 'image/*'});
            this.getArtists();
            this.getTypies();
            this.getAlbum();
            this.getTracks();
        },

        methods: {
            getArtists() {
            axios.get("/api/albums/artists").then(res => { this.artists = res.data.data });
          },

          getAlbum() {
            axios.get(`/api/albums/show/${this.$route.params.id}`).then(res => {
                this.title = res.data.data.title,
                this.description = res.data.data.description,
                this.release_date = res.data.data.release_date,
                this.added_date = res.data.data.added_date,
                this.old_release_date = res.data.data.release_date,
                this.old_added_date = res.data.data.added_date,
                this.status = res.data.data.status,
                this.is_national = res.data.data.is_national,
                this.title = res.data.data.title
                this.selectedArtists = res.data.data.artists
                this.selectedType.push(res.data.data.type)
            });
          },

          getTypies() {
            axios.get("/api/albums/types").then(res => { this.types = res.data.data });
          },

          getTracks(){
            axios.get(`/api/albums/tracks/${this.$route.params.id}`).then(res => { this.tracks = res.data.data });
          },


          update() {
            let options = {
                        year: 'numeric', month: 'numeric', day: 'numeric',
                        hour: 'numeric', minute: 'numeric', second: 'numeric',
                        hour12: false
            };
            let date = new Intl.DateTimeFormat('en-GB', options);
            let artistsId = [];

            for(let idx in this.selectedArtists)
                artistsId.push(this.selectedArtists[idx].id);

            const data = new FormData();
            let image = this.dropzone.getAcceptedFiles();

            data.append('artwork_url', image.length == 0 ? null : image[0]);
            data.append('title', this.title);
            data.append('description', this.description);
            data.append('release_date', this.old_release_date == this.release_date ? this.release_date : date.format(this.release_date));
            data.append('added_date', this.old_added_date == this.added_date ? this.added_date : date.format(this.added_date));
            data.append('type',  this.selectedType.length == 0 ? null : this.selectedType[0].id);
            data.append('status', this.status);
            data.append('is_national', this.is_national);
            for (var i = 0; i < artistsId.length; i++)
            data.append('artists[]',artistsId[i]);
            data.append('_method', 'PATCH');

            axios.post(`/api/albums/${this.$route.params.id}`, data).then(res =>{
                this.$router.push({name: 'album.index'});
            });
          },

          deleteTracks(id){
            axios.post(`/api/albums/tracks/delete/${this.$route.params.id}`,{track: id}).then(res => { this.getTracks() });
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
