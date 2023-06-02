<template>

        <div class="content-wrapper">

  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Жанры</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="\">Главная</a></li>
            <li class="breadcrumb-item active">Жанры</li>
          </ol>
        </div>
      </div>
    </div>



  <section class="content" >

      <div class="container-fluid">
          <div class="d-flex justify-content-end mb-3">
            <router-link class="btn btn-primary btn-lg" :to="{name: 'genre.create'}">Добавить</router-link>
          </div>
          <!-- Main row -->

          <div class="card p-fluid">
        <DataTable v-model:editingRows="editingRows" v-model:filters="filters" :value="genres" editMode="row" dataKey="id"  paginator :rows="10"
                @row-edit-save="updateGenre" tableClass="editable-cells-table" tableStyle="min-width: 50rem">
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
            <Column field="name_tm" header="Название Tm" sortable style="width: 40%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column field="name_ru" header="Название Ru" sortable style="width: 40%">
                <template #editor="{ data, field }">
                    <InputText v-model="data[field]" />
                </template>
            </Column>
            <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center color:green"></Column>
            <Column style="width: 10%">
        <template #body="{ data}">
            <Button type="button" icon="pi pi-trash" style="color: red" text size="small" @click="deleteGenre(data.id)" />
        </template>
    </Column>
        </DataTable>
    </div>

        </div>

  </section>
  <!-- /.content -->
</div>

        </div>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'
import { FilterMatchMode, FilterOperator } from 'primevue/api';
    export default {
        name: 'GenreIndex',

        props: ['data'],

        data(){
           return {
            genres: null,
            editingRows: null,
            filters: {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                name_tm: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] },
                name_ru: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.STARTS_WITH }] }
            },
           }
        },

        mounted() {
            this.getGenres()
        },

        methods: {
            getGenres(){
                axios.get('/api/genres').then(res => { this.genres = res.data.data });
            },

            deleteGenre(id){
                axios.delete(`/api/genres/${id}/${this.data}`).then(res => { this.getGenres()});
            },

            changeEditPersonId(id, name_tm, name_ru){
                this.editGenreId = id;
                this.name_tm = name_tm;
                this.name_ru = name_ru;
            },

            isEdit(id){
                return this.editGenreId === id;
            },

            updateGenre(event) {
                let { newData, data } = event;
                axios.patch(`/api/genres/${newData.id}`, {name_tm: newData.name_tm, name_ru: newData.name_ru, user_id: this.data}).then(res => {this.getGenres()});

        },

        }
    }
</script>


<style scoped>

::v-deep(.editable-cells-table td.p-cell-editing) {
    padding-top: 0.6rem;
    padding-bottom: 0.6rem;
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
