<template>
     <div >
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
                        <Column field="title" header="Название тркеа" sortable style="width: 35%"></Column>
                        <Column header="Действие" style="width: 35%">
                            <template #body="{data}">
						<div class="danger">
                            <Tag :value="data.actions" severity="danger" style="width: 100px; height: 50px;"/>
                        </div>

					</template>
                        </Column>
                         <Column header="Ответ" style="width: 20%">
                        <template #body="{ data }">
                            <div class="flex align-items-center gap-2">
                                     <a :to="{name: 'track.edit',  params: { id:  data.id}}" class="btn btn-outline-success mr-3" @click.prevent="yes(data.actions, data.id)">Ok</a>
                                     <a :to="{name: 'track.edit',  params: { id:  data.id}}" class="btn btn-outline-danger ml-3" @click.prevent="">No</a>
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
                    <p>
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim
                        ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Consectetur, adipisci velit, sed quia non numquam eius modi.
                    </p>
                </TabPanel>
                <TabPanel>
                    <template #header>
                        <span>Альбомы</span>
                        <i class="pi pi-align-justify ml-2"></i>
                    </template>
                    <p>
                        At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui
                        officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus.
                    </p>
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
</div>

</template>

<script>

import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "ModeratorBase",

        data(){
            return {
                tracks: []
            }
        },

        mounted(){
            this.getTracks();
        },

        methods:{
            getTracks(){
            axios.get('/api/moderators/tracks/show').then(res => {
                console.log(res);
                this.tracks.push(res.data.data);
            })
            },

            yes(action, id){
                console.log(action, id);
            }
        }
    }
</script>

