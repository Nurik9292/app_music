<template>
    <div class="container">
        <table class="table table-hover">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название Tm</th>
                        <th scope="col">Название Ru</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                      </tr>
                    </thead>
                    <tbody>

                        <template v-for="(genre, index) in genres">
                        <tr :class="isEdit(genre.id) ? 'd-none' : ''">
                            <th scope="row">{{ index + 1 }}</th>
                            <td>{{ genre.name_tm }}</td>
                            <td>{{ genre.name_ru }}</td>
                            <td><a href="#" @click.prevent="changeEditPersonId(genre.id, genre.name_tm, genre.name_ru)" class="btn btn-outline-success">Edit</a></td>
                            <td><a href="#" @click.prevent="deleteGenre(genre.id)" class="btn btn-outline-danger">Delete</a></td>
                        </tr>
                        <tr :class="isEdit(genre.id) ? '' : 'd-none'">
                        <th scope="row">{{index + 1}}</th>
                        <td> <input type="text" v-model="name_tm" class="form-control"></td>
                        <td> <input type="text" v-model="name_ru" class="form-control"></td>
                        <td><a href="#" @click.prevent="updateGenre(genre.id)" class="btn btn-outline-success">Update</a></td>
                    </tr>
                    </template>

                    </tbody>
                  </table>
    </div>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'
    export default {
        name: 'GenreIndex',

        data(){
           return {
            genres: null,
            editGenreId: null,
            name_tm: null,
            name_ru: null,
           }
        },

        mounted() {
            this.getGenres()
        },

        methods: {
            getGenres(){
                axios.get('/api/genres').then(res => {  console.log(res); this.genres = res.data.data });
            },

            deleteGenre(id){
                axios.delete(`/api/genres/${id}`).then(res => { this.getGenres()});
            },

            updateGenre(id){
                this.editGenreId = null;
                axios.patch(`/api/genres/${id}`, {name_tm: this.name_tm, name_ru: this.name_ru}).then(res => {this.getGenres()});
            },

            changeEditPersonId(id, name_tm, name_ru){
                this.editGenreId = id;
                this.name_tm = name_tm;
                this.name_ru = name_ru;
            },

            isEdit(id){
                return this.editGenreId === id;
            }

        },
    }
</script>
