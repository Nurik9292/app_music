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
                    <DataTable v-model:expandedRows="expandedRows" :value="auditTracks" paginator :rows="10" stateStorage="session" stateKey="dt-state-demo-session"  filterDisplay="menu"
                     selectionMode="multiple" dataKey="id" tableStyle="min-width: 50rem">
                     <Column expander style="width: 5rem" />
                        <Column header="№" sortable style="width: 10%">
                            <template #body="{data, index}">
                                {{ index + 1 }}
					        </template></Column>
                        <Column field="user_name" header="Имя" sortable style="width: 20%">
                            <template #body="{data}">
                                {{ getUserName(data.user_id)}}
					        </template>
                        </Column>
                        <Column header="Название тркеа" sortable style="width: 20%">
                            <template #body="{data}">
                                {{ getATrackTitle(data)}}
					        </template>
                        </Column>
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
                                     <a href="#" class="btn btn-outline-success mr-3" @click.prevent="yes(data.event, data.id, 'track')">Ok</a>
                                     <a href="#" class="btn btn-outline-danger ml-3" @click.prevent="no(data.event, data.id, 'track')">No</a>
                            </div>
                        </template>
                        </Column>

            <template #empty> No customers found. </template>
            <template #expansion="slotProps">
                <div class="p-3">
                    <DataTable :value="getChange(slotProps.data)" :rows="10" stateStorage="session" stateKey="dt-state-demo-session"  filterDisplay="menu"
                     selectionMode="multiple" dataKey="id" tableStyle="min-width: 50rem">
                        <Column field="columName" header="Название поля" sortable style="width: 20%">

                        </Column>
                        <Column field="old" header="Старое значение" sortable style="width: 40%"></Column>
                        <Column field="new" header="Новое значение" sortable style="width: 40%"></Column>
                    </DataTable>
                 </div>
            </template>
        </DataTable>
                </TabPanel>
                <TabPanel>
                    <template #header>
                        <span>Артисты</span>
                        <i class="pi pi-user ml-2"></i>
                    </template>
                    <DataTable v-model:expandedRows="expandedRows" :value="auditArtists" paginator :rows="10" stateStorage="session"
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
                        <Column field="name" header="Имя артиста" sortable style="width: 20%">
                            <template #body="{data}">
                                {{ getArtistName(data)}}
					        </template>
                        </Column>
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
                                     <a href="#" class="btn btn-outline-success mr-3" @click.prevent="yes(data.event, data.id, 'artist')">Ok</a>
                                     <a href="#" class="btn btn-outline-danger ml-3" @click.prevent="no(data.event, data.id, 'artist')">No</a>
                            </div>
                        </template>
                        </Column>

            <template #empty> No customers found. </template>
            <template #expansion="slotProps">
                <div class="p-3">
                    <DataTable :value="getChange(slotProps.data)" :rows="10" stateStorage="session" stateKey="dt-state-demo-session"  filterDisplay="menu"
                     selectionMode="multiple" dataKey="id" tableStyle="min-width: 50rem">
                        <Column field="columName" header="Название поля" sortable style="width: 20%">

                        </Column>
                        <Column field="old" header="Старое значение" sortable style="width: 40%"></Column>
                        <Column field="new" header="Новое значение" sortable style="width: 40%"></Column>
                    </DataTable>
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
<span>></span>
</div>

</template>

<script>

import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "ModeratorBase",

        data(){
            return {
                auditTracks: null,
                artists: null,
                auditArtists: null,
                users: null,
                expandedRows: null
            }
        },

        mounted(){
            this.getAuditTracks();
            this.getAuditArtists();
            this.getUsers();
            this.getArtists()
            this.getTracks()
        },

        methods:{
            getAuditTracks(){
            axios.get('/api/moderators/tracks/show').then(res => {
                this.auditTracks = res.data.data;
            })
            },

            getUsers(){
                axios.get('/api/moderators/users/').then( res => {
                    this.users = res.data.data;
                });
            },

            getAuditArtists(){
            axios.get('/api/moderators/artists/show').then(res => {
                this.auditArtists = res.data.data;
            })
            },

            getArtists(){
            axios.get('/api/artists').then(res => {
                this.artists = res.data.data;
            })
            },

            getTracks(){
            axios.get('/api/tracks').then(res => {
                this.tracks = res.data.data;
            })
            },


            yes(actions, id, item){
                if(actions == 'deleted'){
                  if(item == 'artist')
                        axios.delete(`/api/moderators/${id}`).then(res => { this.getAuditArtists() })

                  if(item == 'track')
                        axios.delete(`/api/moderators/${id}`).then(res => { this.getAuditTracks() })

                }
                if(actions == 'created'){
                    if(item == 'artist')
                        axios.post(`/api/moderators/allows/${id}`).then(res => { this.getAuditArtists() })

                    if(item == 'track')
                        axios.post(`/api/moderators/allows/${id}`).then(res => { this.getAuditTracks() })

                }

                if(actions == 'updated'){
                    if(item == 'artist')
                        axios.post(`/api/moderators/allows/${id}`).then(res => { this.getAuditArtists() })

                    if(item == 'artist')
                        axios.post(`/api/moderators/allows/${id}`).then(res => { this.getAuditTracks() })

                }
            },

            no(actions, id, item){

                if(actions == 'deleted'){
                  if(item == 'artist')
                        axios.post(`/api/moderators/restore/${id}`).then(res => { this.getAuditArtists()})

                if(item == 'track')
                        axios.post(`/api/moderators/restore/${id}`).then(res => { this.getAuditTracks()})
                }

                if(actions == 'created'){
                  if(item == 'artist')
                        axios.post(`/api/moderators/restore/${id}`).then(res => { this.getAuditArtists()})
                  if(item == 'track')
                        axios.post(`/api/moderators/restore/${id}`).then(res => { this.getAuditTracks()})

                }

                if(actions == 'updated'){
                  if(item == 'artist'){
                        axios.post(`/api/moderators/restore/${id}`).then(res => {
                            this.getAuditArtists()
                        })
                  }
                }
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
                    case 'created': return 'success';
                    case 'deleted': return 'danger';
                }
            },



            getChange(data){

                let values = [];

                if(data.event == 'deleted'){
                    for(let idx in data.old_values){
                    values.push({
                        columName: idx,
                        old:  data.old_values[idx],
                    });
                }
                }else{

                for(let idx in data.new_values){
                    values.push({
                        columName: idx,
                        old:  data.old_values[idx],
                        new:  data.new_values[idx],
                    });
                }
                }


                return values;
            },

            getArtistName(data){
                if(data.event == 'deleted' || data.event == 'updated'){
                    return data.old_values.name
                } else {
                    return data.new_values.name
                }
            },

            getATrackTitle(data){
                console.log(data);
                if(data.event == 'deleted' || data.event == 'updated'){
                    return data.old_values.title
                } else {
                    return data.new_values.title
                }
            }


        }
    }
</script>

