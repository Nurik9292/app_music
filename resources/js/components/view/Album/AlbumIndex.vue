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
                <router-link class="btn btn-primary btn-lg" :to="{name: 'album.create', }">Добавить</router-link>
            </div>

            <div class="card">
            <DataTable v-model:filters="filters" :value="albums" paginator :rows="10"
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
            <Column field="title" header="Название" sortable style="width: 20%"></Column>
            <Column field="type" header="Тип" sortable style="width: 10%"></Column>
            <Column  header="Статус" style="width: 10%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <InputSwitch v-model="data.status" @change.prevent="updateStatus(data.id)"/>
                    </div>
                </template>
            </Column>
            <Column field="release_date" header="Выпуска" sortable style="width: 15%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                     {{ release_date(data.id) }}
                    </div>
                </template>
            </Column>
            <Column field="added_date" header="Добавлен" sortable style="width: 15%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                     {{ added_date(data.id) }}
                    </div>
                </template>
            </Column>
            <Column header="Edit" style="width: 10%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <router-link :to="{name: 'album.edit',  params: { id:  data.id}}" class="btn btn-outline-success">Edit</router-link>
                    </div>
                </template>

            </Column>
            <Column header="Delete" style="width: 10%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <a href="#" class="btn btn-outline-danger" @click.prevent="deleteAlbums(data.id)" >Delete</a>
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
            countries: null,
            albums: null,
            selectedAlbum: null,
            added_dates: null,
            release_dates: null,
            filters: {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                title: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                type: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] }
            },
            }
    },

    mounted() {
        this.getAlbums();
    },

    methods: {

        getAlbums() {
            axios.get('/api/albums').then(res => {
                this.albums = res.data.data.albums
                this.added_dates = res.data.data.added_dates
                this.release_dates = res.data.data.release_dates
             });
        },


        updateStatus(id) {
            let updateAlbum = null;

            for(let idx in this.albums){
                if(this.albums[idx].id == id) updateAlbum = this.albums[idx];
            }



            axios.patch(`/api/albums/status/${id}`, {status: updateAlbum.status}).then(res => { this.getAlbums()});
        },

        deleteAlbums(id){
                axios.delete(`/api/albums/${id}`).then(res => { this.getAlbums() })
        },

        added_date(id){
            for(let idx in this.added_dates)
                if(id  == this.added_dates[idx].id) return this.added_dates[idx].time;
        },

        release_date(id){
            for(let idx in this.release_dates)
            if(id  == this.release_dates[idx].id) return this.release_dates[idx].time;
        }


    }
}
</script>


<style scoped>

</style>
