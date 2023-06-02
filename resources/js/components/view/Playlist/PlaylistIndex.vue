<template>
    <div >

        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Плейлисты</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="\">Главная</a>
                </li>
              <li class="breadcrumb-item active">Плейлисты</li>
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
                <router-link class="btn btn-primary btn-lg" :to="{name: 'playlist.create', }">Добавить</router-link>
            </div>

            <div class="card">
            <DataTable v-model:filters="filters" :value="playlists" paginator :rows="10"
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
            <Column field="title_tm" header="Название Tm" sortable style="width: 20%"></Column>
            <Column field="title_ru" header="Название Ru" sortable style="width: 20%"></Column>
            <Column field="genre" header="Жанр" sortable style="width: 10%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                    <template v-for="name in genres(data.id)">
                        {{ name }}
                    </template>
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
            <Column  header="Статус" style="width: 10%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <InputSwitch v-model="data.status" @change.prevent="updateStatus(data.id)"/>
                    </div>
                </template>
            </Column>
            <Column header="Edit" style="width: 10%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <router-link :to="{name: 'playlist.edit',  params: { id:  data.id}}" class="btn btn-outline-success">Edit</router-link>
                    </div>
                </template>

            </Column>
            <Column header="Delete" style="width: 10%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <a href="#" class="btn btn-outline-danger" @click.prevent="deletePlaylists(data.id)" >Delete</a>
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
    name: "PlaylistIndex",

    props: ['data'],

    data(){
        return {
            genres:null,
            playlists: null,
            selectedPlaylist: null,
            added_dates: null,
            filters: {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                title_tm: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                title_ru: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                type: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] }
            },
            }
    },

    mounted() {
        this.getPlaylists();
    },

    methods: {

        getPlaylists() {
            axios.get('/api/playlists').then(res => {
                this.playlists = res.data.data.playlists
                this.added_dates = res.data.data.added_dates
                this.genres = res.data.data.genres
             });
        },


        updateStatus(id) {
            let updatePlaylist = null;

            for(let idx in this.playlists){
                if(this.playlists[idx].id == id) updatePlaylist = this.playlists[idx];
            }
            axios.patch(`/api/playlists/status/${id}`, {status: updatePlaylist.status}).then(res => { this.getPlaylists()});
        },

        deletePlaylists(id){
                axios.delete(`/api/playlists/${id}/${this.data}`).then(res => { this.getPlaylists() })
        },



        added_date(id){
            for(let idx in this.added_dates)
                if(id  == this.added_dates[idx].id) return this.added_dates[idx].time;
        },

        genres(id){
            for(let idx in this.genres)
            if(id  == this.genres[idx].id) {
                return this.genres[idx].name;
            }
        }


    }
}
</script>


<style scoped>

</style>
