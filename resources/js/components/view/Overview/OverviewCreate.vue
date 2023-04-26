<template>
    <!-- <div class="container"> -->
        <div class="card card-white">



  <div class="card-body">
    <div class="block_two">
        <label>Выберите блок</label>
        <select class="form-control" @change="change($event)">
        <template v-for="(block, index) in blocks">
            <option :value="index">{{ block }}</option>
        </template>
        </select>


    </div>

    <div  :class="isChange() == 1 ? '' : 'd-none'">
      <label for="password">Password</label>
      <input type="text" class="form-control" id="password" placeholder="Введите пароль" name="password">

    </div>

    <div class="block_one">
      <label for="email">Email</label>
      <input type="text" class="form-control" id="email" placeholder="Email" name="email">

    </div>


    </div>


  <!-- /.card-body -->

  <div class="card-footer d-flex justify-content-end mb-3">
    <button type="submit" class="btn btn-primary btn-lg" >Создать</button>
  </div>
</div>
    <!-- </div> -->
</template>

<script>
import draggable from "vuedraggable";


    export default {
        name: "OverviewIndex",

        components: {

            },

        data(){
           return {
                blocks: null,
                block_num: null
           }
        },

        mounted() {
            this.getBlocks();
        },

        methods: {
          getBlocks() {
            axios.get("/api/overviews/show").then(res => { this.blocks = res.data.data });
          },

          change(event){
            console.log(event.target.value);
            this.block_num = event.target.value;
          },

          isChange(){
            return this.block_num;
          }
        },
    }
</script>


<style scoped>
 .block_one {
        float: left;
        width: 320px;
        margin-right: 50px;
        margin-bottom: 40px;
   }

    .block_two {
          width: 320px;
          margin-right: 50px;
          margin-bottom: 40px;
            }

</style>
