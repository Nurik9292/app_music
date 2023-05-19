<template>
    <div >
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Треки</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <router-link :to="{name: 'track.index'}">Главная</router-link>
                </li>
              <li class="breadcrumb-item active">Треки</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <!-- <div class="d-flex justify-content-end mb-3">
                <router-link :to="{name: 'track.option'}" class="btn btn-primary btn-lg">Добавить</router-link> -->
                <!-- <a class="btn btn-primary btn-lg" href="#">Добавить</a> -->
            <!-- </div> -->

                <div class="card">
                    <TabMenu :model="items"/>
                    <router-view />
                </div>

            <div class="card">
            <DataTable  v-model:filters="filters" :value="tracks" paginator :rows="10"
                stateStorage="session" stateKey="dt-state-demo-session"  filterDisplay="menu" selectionMode="single"
                dataKey="id" tableStyle="min-width: 50rem">
            <template #header>
                 <span>
             <Dropdown v-model="selectedArtist" :options="artists" optionLabel="name" filter  placeholder="Выбирите артиста" @change="changeTracks()" class="w-full md:w-40rem"/>
                 </span>
                    <span class="p-input-icon-left ml-3">
                        <i class="pi pi-search" />
                        <InputText v-model="filters['global'].value" placeholder="Search" />
                    </span>
            </template>
            <Column field="id" header="№" sortable style="width: 10%"></Column>
            <Column field="title" header="Название" sortable style="width: 45%"></Column>
            <Column  header="Status" style="width: 15%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <InputSwitch v-model="data.status" @change.prevent="updateStatus(data.id)"/>
                    </div>
                </template>

            </Column>
            <Column header="Edit" style="width: 15%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <router-link :to="{name: 'track.edit',  params: { id:  data.id}}" class="btn btn-outline-success">Edit</router-link>
                    </div>
                </template>

            </Column>
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
        </div>
    </section>
</div>





    </div>
</template>

<script>
import { FilterMatchMode, FilterOperator } from 'primevue/api';

export default {
    name: "TrackIndex",

    data(){
        return {
            tracks: null,
            artists: null,
            selectedArtist: null,
            filters: {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                title: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] }
            },
            items: [
                {
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
        this.getTracks();

    },

    methods: {
        getTracks() {
            if(this.selectedArtist != null)
            axios.post('/api/tracks/filter', {artist: this.selectedArtist.id}).then(res => { this.tracks = res.data.data.tracks; this.artists =res.data.data.artists });
            else
            axios.get('/api/tracks').then(res => { this.tracks = res.data.data.tracks; this.artists =res.data.data.artists });
        },

        updateStatus(id) {
            let updateTrack = null;

            for(let track in this.tracks){
                if(this.tracks[track].id == id) updateTrack = this.tracks[track];
            }

            axios.patch(`/api/tracks/${id}`, {status: updateTrack.status}).then(res => { this.getTracks()});
        },

        changeTracks() {
            this.getTracks()
        },

        edit(id){
            return `/tracks/${id}/edit`;
        },

        deleteTracks(id){
                axios.delete(`/api/tracks/${id}`).then(res => { this.getTracks() })
            }
    }
}
</script>


