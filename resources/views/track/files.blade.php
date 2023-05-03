@extends('layouts.app')

@section('title', 'Треки')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="block">


                <div class="block_one">
                    <label for="file">Название</label>
                    <input type="file" class="form-control" id="name" placeholder="Выберите файл" name="file">
                    @error('file')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>


    </section>
    <!-- /.content -->
</div>
@endsection


<style>
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


   .block {
        position: absolute;
    top:  50%;
    left: 50%;
    transform: translate(-50%,-50%);

   }


  </style>
