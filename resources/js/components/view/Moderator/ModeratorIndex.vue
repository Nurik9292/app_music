<template>
        <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Запросы от модератора</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="/">Главная</a>
                </li>
              <li class="breadcrumb-item active">Запросы от модератора</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <TabView class="tabview-custom">
                <TabPanel>
                    <template #header>
                        <span>Треки</span>
                        <i class="pi pi-volume-up ml-2"></i>
                    </template>
                    <DataTable :value="tracks" paginator :rows="10" stateStorage="session" stateKey="dt-state-demo-session"  filterDisplay="menu"
                     selectionMode="multiple" dataKey="id" tableStyle="min-width: 50rem">
                        <Column field="id" header="№" sortable style="width: 10%"></Column>
                        <Column field="user_name" header="Имя" sortable style="width: 10%"></Column>
                        <Column field="title" header="Название тркеа" sortable style="width: 35%"></Column>
                        <Column header="Действие" style="width: 35%">
                            <template #body="{data}">
						<div class="danger">
                            <Tag :value="data.actions" :severity="actions(data.actions)" style="width: 100px; height: 50px;"/>
                        </div>

					</template>
                        </Column>
                         <Column header="Ответ" style="width: 20%">
                        <template #body="{ data }">
                            <div class="flex align-items-center gap-2">
                                     <a href="#" class="btn btn-outline-success mr-3" @click.prevent="yes(data.actions, data.id, 'track')">Ok</a>
                                     <a href="#" class="btn btn-outline-danger ml-3" @click.prevent="no(data.request, 'track')">No</a>
                            </div>
                        </template>
                        </Column>

            <template #empty> No customers found. </template>
        </DataTable>
                </TabPanel>
                <TabPanel>
                    <template #header>
                        <span>Артисты</span>
                        <i class="pi pi-user ml-2"></i>
                    </template>
                    <DataTable v-model:expandedRows="expandedRows" :value="artists" paginator :rows="10" stateStorage="session"
                     filterDisplay="menu" selectionMode="multiple" dataKey="id" tableStyle="min-width: 50rem">
                     <Column expander style="width: 5rem" />
                        <Column header="№" sortable style="width: 10%">
                            <template #body="{data, index}">
                                {{ index + 1 }}
					        </template>
                        </Column>
                        <Column field="user_name" header="Имя" sortable style="width: 20%">
                            <template #body="{data}">
                                {{ getUserName(data.user_id)}}
					        </template>
                        </Column>
                        <Column field="old_values.name" header="Имя артиста" sortable style="width: 20%"></Column>
                        <Column header="Действие" style="width: 20%">
                            <template #body="{data}">
						<div class="danger">
                            <Tag :value="data.event" :severity="actions(data.event)" style="width: 100px; height: 50px;"/>
                        </div>

					</template>
                        </Column>
                         <Column header="Ответ" style="width: 20%">
                        <template #body="{ data }">
                            <div class="flex align-items-center gap-2">
                                     <a href="#" class="btn btn-outline-success mr-3" @click.prevent="yes(data.actions, data.id, 'artist')">Ok</a>
                                     <a href="#" class="btn btn-outline-danger ml-3" @click.prevent="no(data.request, 'artist')">No</a>
                            </div>
                        </template>
                        </Column>

            <template #empty> No customers found. </template>
            <template #expansion="slotProps">
                <div class="p-3">
                    <h2>{{ values(slotProps.data) }}</h2>
                 </div>
            </template>
        </DataTable>
                </TabPanel>
                <TabPanel>
                    <template #header>
                        <span>Альбомы</span>
                        <i class="pi pi-align-justify ml-2"></i>
                    </template>

                </TabPanel>
                <TabPanel>
                    <template #header>
                        <span>Плейлисты</span>
                        <i class="pi pi-tablet ml-2"></i>
                    </template>
                    <p>
                        At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui
                        officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.
                    </p>
                </TabPanel>
                <TabPanel>
                    <template #header>
                        <span>Жанры</span>
                        <i class="pi pi-tag ml-2"></i>
                    </template>
                    <p>
                        At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui
                        officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.
                    </p>
                </TabPanel>
            </TabView>
        </div>
    </div>
</section>
</div>

</template>

<script>

import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "ModeratorBase",

        data(){
            return {
                tracks: null,
                artists: null,
                users: null,
                expandedRows: null
            }
        },

        mounted(){
            this.getTracks();
            this.getArtists();
            this.getUsers();
        },

        methods:{
            getTracks(){
            axios.get('/api/moderators/tracks/show').then(res => {
                if(res.data.length != 0)
                this.tracks = res.data.data;
                else this.tracks = null
            })
            },

            getUsers(){
                axios.get('/api/moderators/users/').then( res => {
                    console.log(res);
                    this.users = res.data.data;
                });
            },

            getArtists(){
            axios.get('/api/moderators/artists/show').then(res => {
                console.log(res);
                this.artists = res.data.data;
            })
            },

            yes(actions, id, item){


            },

            no(id, item){


            },

            getUserName(user_id){
                for(let idx in this.users){
                    if(this.users[idx].id === user_id)
                        return this.users[idx].name;
                }
            },

            actions(actions){
                switch(actions){
                    case 'updated': return 'primary';
                    case 'deleted': return 'danger';
                }
            },

            values(item){
                if(item.event == 'deleted'){
                    return "нет изменений";
                }
            }
        }
    }
</script>

