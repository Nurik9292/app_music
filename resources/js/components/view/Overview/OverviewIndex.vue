<template>
    <div class="container">
        <table class="table table-hover">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                      </tr>
                    </thead>
                    <draggable v-model="items" tag="tbody" item-key="id" @change="update()"  >

                        <template #item="{element}">
                            <tr >
                                <th scope="row">{{ element.id }}</th>
                                <td>{{element.name}}</td>
                                <td>{{element.email}}</td>
                                <td>{{element.role}}</td>
                                <td>{{element.edit}}</td>
                                <td>{{element.delete}}</td>
                            </tr>
                        </template>

                    </draggable>
                  </table>

                  <rawDisplayer class="col-3" :value="items" title="Items" />
                </div>
</template>

<script>
import draggable from "vuedraggable";


    export default {
        name: "OverviewIndex",

        components: {
                draggable
            },

        data(){
           return {
                items: [
                {id:1, name: '@1', email: '@1', role: '@1', edit: '@1', delete: '@1',},
                {id:2, name: '@2', email: '@2', role: '@2', edit: '@2', delete: '@2',},
                {id:3, name: '@3', email: '@3', role: '@3', edit: '@3', delete: '@3',},
                ],
                dragging: false
           }
        },

        mounted() {

        },

        methods: {
                update(){
                    console.log('update');
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
