<template>
    <div>
        <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Треки</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <router-link :to="{name: 'track.index'}">Главная</router-link>
                </li>
              <li class="breadcrumb-item active">Треки</li>
            </ol>
          </div>
        </div>
      </div>
    </div>


    <section class="content">

        <div class="container-fluid">

                <div class="card">
                    <TabMenu :model="items"/>
                    <router-view />
                </div>

            <div class="card">
                <Toast />
            <DataTable  v-model:selection="selectedTracks" v-model:filters="filters" :value="tracks" paginator :rows="10"
                stateStorage="session" stateKey="dt-state-demo-session"  filterDisplay="menu"  selectionMode="multiple"
                dataKey="id" tableStyle="min-width: 50rem">
            <template #header>
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-wrap gap-3">
                        <div class="d-flex align-items-between">
                            <Dropdown v-model="selectedArtist" :options="artists" optionLabel="name" filter  placeholder="Выбирите артиста" @change="changeTracks()" class="w-full md:w-40rem"/>
                        </div>
                        <div class="d-flex align-items-between p-input-icon-left">
                            <i class="pi pi-search" />
                            <InputText v-model="filters['global'].value" placeholder="Search" />
                        </div>
                    </div>

                <div class="d-flex align-items-end">
                    <div :class="isTracks() ? '' : 'd-none'">
                    <Button label="Добавить" @click="dialogVisible = true" />
                    <Dialog v-model:visible="dialogVisible" header="Добавить" :style="{ width: '30vw' }" maximizable modal :contentStyle="{ height: '200px' }">
                        <div class="mb-3">
                            <SelectButton v-model="value" :options="options" aria-labelledby="basic"/>
                        </div>
                        <div :class="isAlbum() ? '' : 'd-none'">
                            <MultiSelect v-model="selectedAlbum" :options="albums" filter optionLabel="title" optionValue="id"  placeholder="Выбирите альбом" :maxSelectedLabels="1" :selectionLimit="1" class="w-full md:w-40rem" id="album" />
                        </div>
                        <div :class="isPlaylist() ? '' : 'd-none'">
                            <MultiSelect v-model="selectedPlaylist" :options="playlists" filter optionLabel="title_ru" optionValue="id" placeholder="Выбирите плейлист" :maxSelectedLabels="1" :selectionLimit="1" class="w-full md:w-40rem" id="album" />

                        </div>
                        <template #footer >
                        <div :class="isAlbum() ? '' : 'd-none'">
                             <Button label="Добавить" icon="pi pi-check" @click="dialogVisible = false, storeAlbum()" />
                        </div>
                        <div :class="isPlaylist() ? '' : 'd-none'">
                             <Button label="Добавить" icon="pi pi-check" @click="dialogVisible = false, storePlaylist()" />
                        </div>
                        </template>

                    </Dialog>
                    </div>
                </div>
              </div>
            </template>
            <Column selectionMode="multiple" headerStyle="width: 3rem" @click="isTracks()"></Column>
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
import { useToast } from "primevue/usetoast";

export default {
    name: "TrackIndex",

    props:['data'],

    data(){
        return {
            value:'Альбомы',
            options: ['Альбомы', 'Плейлисты'],
            dialogVisible: false,
            selectedAlbum: null,
            albums: null,
            selectedPlaylist: null,
            playlists: null,
            tracks: null,
            selectedTracks: null,
            artists: null,
            selectedArtist: null,
            toast: null,
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
        this.getAlbumts();
        this.getPlaylists();
        this.toast = useToast();
    },

    methods: {
        getTracks() {
            if(this.selectedArtist != null)
            axios.post('/api/tracks/filter', {artist: this.selectedArtist.id}).then(res => { this.tracks = res.data.data.tracks; this.artists =res.data.data.artists });
            else
            axios.get('/api/tracks').then(res => { this.tracks = res.data.data.tracks; this.artists =res.data.data.artists });
        },

        getAlbumts() {
            axios.get("/api/tracks/albums").then(res => { this.albums = res.data.data });
          },

        getPlaylists() {
            axios.get("/api/tracks/playlists").then(res => { this.playlists = res.data.data });
          },


        updateStatus(id) {
            let updateTrack = null;

            for(let track in this.tracks){
                if(this.tracks[track].id == id) updateTrack = this.tracks[track];
            }

            axios.patch(`/api/tracks/status/${id}`, {status: updateTrack.status}).then(res => { this.getTracks()});
        },

        storeAlbum() {
            axios.post(`/api/tracks/albums/${this.selectedAlbum[0]}`, {tracks: this.selectedTracks}).then(res => {this.getTracks()});
        },

        storePlaylist() {
            axios.post(`/api/tracks/playlists/${this.selectedPlaylist[0]}`, {tracks: this.selectedTracks}).then(res => {this.getTracks()});
        },

        changeTracks() {
            this.getTracks()
        },

        edit(id){
            return `/tracks/${id}/edit`;
        },

        deleteTracks(id){
            if(this.data === 3){
                this.toast.add({ severity: 'info', summary: 'Info', detail: 'Ваш запрос отправлен администратору', life: 3000 });
                axios.post(`/api/moderators/tracks/${id}`, {track_id: this.data, actions: 'delete'}).then(res => { this.getTracks() })
            }else{
                axios.delete(`/api/tracks/${id}`).then(res => { this.getTracks() })
            }
        },

        isAlbum(){
            return this.value == 'Альбомы';
        },

        isPlaylist(){
            return this.value == 'Плейлисты';
        },

        isTracks(){
            return this.selectedTracks != null && this.selectedTracks.length > 0;
        },

    }
}
</script>


<style scoped>

</style>
