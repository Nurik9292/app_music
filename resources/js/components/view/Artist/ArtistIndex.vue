<template>
    <div >
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Артисты</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/">Главная</a>
                </li>
              <li class="breadcrumb-item active">Артисты</li>
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
                <router-link class="btn btn-primary btn-lg" :to="{name: 'artist.create', }">Добавить</router-link>
            </div>

            <div class="card">
                <Toast />
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
            <Column field="id" header="№" sortable style="width: 10%"></Column>
            <Column field="name" header="Name" sortable style="width: 35%"></Column>
            <Column field="" header="Countries" filterField="country_id" style="width: 15%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                      {{countryName(data.country_id)}}
                    </div>
                </template>
            </Column>
            <Column  header="Status" style="width: 15%" :class="isModer() ? 'd-none' : ''">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <InputSwitch v-model="data.status" @change.prevent="updateStatus(data.id)"/>
                    </div>
                </template>
            </Column>
            <Column header="Edit" style="width: 15%">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <router-link :to="{name: 'artist.edit',  params: { id:  data.id}}" class="btn btn-outline-success">Edit</router-link>
                    </div>
                </template>

            </Column>
            <Column header="Delete" style="width: 15%">
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
import { useToast } from "primevue/usetoast";

export default {
    name: "ArtistIndex",

    props: ['data'],

    data(){
        return {
            countries:null,
            artists: null,
            selectedArtist: null,
            toast: null,
            filters: {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                name: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
            },
            }
    },

    mounted() {
        this.getArtists();
        this.getCountries();
        this.toast = useToast();
    },

    methods: {
        getArtists() {
            axios.get('/api/artists').then(res => { this.artists =res.data.data });
        },

        getCountries() {
            axios.get('/api/artists/countries').then(res => { this.countries =res.data.data });
        },


        updateStatus(id) {

            let updateArtist = null;

            for(let idx in this.artists){
                if(this.artists[idx].id == id) updateArtist = this.artists[idx];
            }

            axios.patch(`/api/artists/status/${id}`, {status: updateArtist.status}).then(res => { this.getArtists()});
        },

        deleteArtists(id){
                axios.delete(`/api/artists/${id}/${this.data['id']}`).then(res => { this.getArtists() })
        },

        countryName(id){

            for(let idx in this.countries)
                if(id == this.countries[idx].id) return this.countries[idx].name;
        },

        isModer(){
            return this.data['role'] === 3;
        }

    }
}
</script>


<style scoped>

</style>
