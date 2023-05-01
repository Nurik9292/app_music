<template>
<div>
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Обзор</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><router-link :to="{name: 'overview.index'}">Главная</router-link></li>
              <li class="breadcrumb-item active">Обзор</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="d-flex justify-content-end mb-3">
            <router-link :to="{name: 'overview.create'}" class="btn btn-primary btn-lg">Создаоть</router-link>
        </div>
    <table class="table table-hover">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                      </tr>
                    </thead>
                    <draggable v-model="blocks" tag="tbody" item-key="id">

                        <template #item="{element}">
                            <tr>
                                <th scope="row">{{ element.order_number }}</th>
                                <td>{{element.name}}</td>
                                <td><InputSwitch  v-model="status[element.id]" @change="update(element.id)"/></td>
                                <td>
                                   <router-link :to="{name: 'overview.edit', params: {id: element.id}}" class="btn btn-outline-success">Edit</router-link>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-outline-danger" @click.prevent="deleteBlock(element.id)" >Delete</a>
                                </td>
                            </tr>
                        </template>
                    </draggable>
     </table>
                <div class="d-flex justify-content-end mb-3">
                     <input type="submit" class="btn btn-primary btn-lg" value="Отправить">
                 </div>
      </div>
    </section>
    <!-- /.content -->
    </div>
    <rawDisplayer class="col-3" :value="items" title="Items" />
 </div>

</template>

<script>
import draggable from "vuedraggable";
import { RouterLink, RouterView } from 'vue-router'

    export default {
        name: "OverviewIndex",

        components: {
                draggable
            },

        data(){
           return {
               blocks: null,
               status: [],
                dragging: false
           }
        },

        computed:{

        },

        mounted() {
            this.getBlocks()
        },

        methods: {
            getBlocks() {
                axios.get("/api/overviews").then(res => {
                    console.log(res);
                    this.blocks = res.data.data;
                    this.addStatus();
                });
            },

            addStatus(){
                for(let block in this.blocks){
                   this.status[this.blocks[block].id] = this.blocks[block].status;
                }
            },

            update(id){
                let updateStatus = false;

                for(let block in this.blocks){
                    updateStatus = this.status[this.blocks[block].id];
                }

                axios.patch(`/api/overviews/${id}`, {status: updateStatus}).then(res => { this.getBlocks()});
        },

            deleteBlock(id){
                axios.delete(`/api/overviews/${id}`).then(res => { this.getBlocks() })
            },

            goEdit(){
                this.$router.push({name: 'overview.edit'});
            }

        },


    }
</script>


<style scoped>


.buttons {
  margin-top: 35px;
}

.flip-list-move {
  transition: transform 0.5s;
}
.no-move {
  transition: transform 0s;
}
</style>
