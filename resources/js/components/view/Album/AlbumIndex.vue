<template>
    <div >

        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Альбомы</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <router-link :to="{name: 'album.index'}">Главная</router-link>
                </li>
              <li class="breadcrumb-item active">Альбомы</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="d-flex justify-content-end mb-3">
                <!-- <router-link class="btn btn-primary btn-lg" :to="{name: 'artist.create', }">Добавить</router-link> -->
            </div>

            <div class="card">
            <DataTable v-model:filters="filters" :value="artists" paginator :rows="10"
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
            <Column field="id" header="#" sortable style="width: 10%"></Column>
            <Column field="name" header="Название" sortable style="width: 20%"></Column>
            <Column field="name" header="Тип" sortable style="width: 10%"></Column>
            <Column  header="Статус" style="width: 10%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <InputSwitch v-model="data.status" @change.prevent="updateStatus(data.id)"/>
                    </div>
                </template>
            </Column>
            <Column field="name" header="Выпуска" sortable style="width: 15%"></Column>
            <Column field="name" header="Добавлен" sortable style="width: 15%"></Column>
            <Column header="Edit" style="width: 10%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <!-- <router-link :to="{name: 'artist.edit',  params: { id:  data.id}}" class="btn btn-outline-success">Edit</router-link> -->
                    </div>
                </template>

            </Column>
            <Column header="Delete" style="width: 10%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <a href="#" class="btn btn-outline-danger" @click.prevent="deleteArtists(data.id)" >Delete</a>
                    </div>
                </template>
            </Column>
            <template #empty> No customers found. </template>
        </DataTable>
    </div>
        </div>
    </section>
</div>





    </div>
</template>

<script>
import { FilterMatchMode, FilterOperator } from 'primevue/api';

export default {
    name: "AlbumIndex",

    data(){
        return {
            countries:null,
            albums: null,
            selectedAlbum: null,
            added_dates: null,
            release_dates: null,
            filters: {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                title: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] }
            },
            }
    },

    mounted() {
        this.getAlbums();
    },

    methods: {

        getAlbums() {
            axios.get('/api/artists').then(res => {
                this.albums = res.data.data.albums
                this.added_dates = res.data.data.added_dates
                this.release_dates = res.data.data.release_dates
             });
        },


        updateStatus(id) {
            console.log(id);

            let updateArtist = null;

            for(let idx in this.artists){
                if(this.artists[idx].id == id) updateArtist = this.artists[idx];
            }

            axios.patch(`/api/artists/${id}`, {status: updateArtist.status}).then(res => { this.getArtists()});
        },


        edit(id){
            return `/artists/${id}/edit`;
        },

        deleteArtists(id){
                axios.delete(`/api/artists/${id}`).then(res => { this.getArtists() })
        },

        countryName(id){

            for(let idx in this.countries)
                if(id == this.countries[idx].id) return this.countries[idx].name;

        }


    }
}
</script>


<style scoped>

</style>
