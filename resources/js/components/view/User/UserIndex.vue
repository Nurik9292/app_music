<template>
    <div class="container">
        <table class="table table-hover">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                        <th scope="col">Role</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                    <template v-for="(user, index) in users">
                        <tr :class="isEdit(user.id) ? 'd-none' : ''">
                        <th scope="row">{{index + 1}}</th>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ '******' }}</td>
                        <td>{{ user.role }}</td>
                        <td><a href="#" @click.prevent="changeEditPersonId(user.id, user.name, user.email, user.role)" class="btn btn-outline-success">Edit</a></td>
                        <td><a href="#" @click.prevent="deleteUser(user.id)" class="btn btn-outline-danger">Delete</a></td>
                    </tr>
                    <tr :class="isEdit(user.id) ? '' : 'd-none'">
                        <th scope="row">{{index + 1}}</th>
                        <td> <input type="text" v-model="name" class="form-control"></td>
                        <td> <input type="text" v-model="email" class="form-control"></td>
                        <td> <input type="text" v-model="password" class="form-control"></td>
                        <td> <input type="text" v-model="role" class="form-control"></td>
                        <td><a href="#" @click.prevent="updateUser(user.id)" class="btn btn-outline-success">Update</a></td>
                    </tr>
                    </template>
                    </tbody>
                  </table>
    </div>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'
    export default {
        name: 'UserIndex',

        data(){
           return {
            users: null,
            editPersonId: null,
            name: null,
            email: null,
            password: null,
            role: null,
           }
        },

        mounted() {
          this.getUsers()
        },

        methods: {
            getUsers(){
                axios.get('/api/users').then(res => { this.users = res.data.data });
            },

            deleteUser(id){
                axios.delete(`/api/users/${id}`).then(res => { this.getUsers()});
            },

            updateUser(id){
                this.editPersonId = null;
                axios.patch(`/api/users/${id}`, {name: this.name, email: this.email, role: this.role, password: this.password}).then(res => {this.getUsers()});
            },

            changeEditPersonId(id, name, email, role){
                this.editPersonId = id;
                this.name = name;
                this.email = email;
                this.role = role;
            },

            isEdit(id){
                return this.editPersonId === id;
            }

        },
    }
</script>
