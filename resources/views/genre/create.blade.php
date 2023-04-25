@extends('layouts.app')

@section('title', 'Жанры')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Добавление Жанра</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{route('genre.index')}}">Жанры</a></li>
              <li class="breadcrumb-item active">Добавить</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">




        <div class="card card-white">

            <!-- form start -->
            <form action="{{route('genre.store')}}" method="POST">
                @csrf
              <div class="card-body">

                <div class="row">
                    <div class="block_one">
                        <label for="name">Название Tm</label>
                        <input type="text" class="form-control" id="name" placeholder="Введите Название" name="name_tm">
                        @error('name_tm')
                          <p class="text-danger">{{$message}}</p>
                        @enderror
                      </div>

                      <div class="block_one">
                        <label for="name">Название Ru</label>
                        <input type="text" class="form-control" id="name" placeholder="Введите Название" name="name_ru">
                        @error('name_ru')
                          <p class="text-danger">{{$message}}</p>
                        @enderror
                      </div>
                </div>

                </div>



              <!-- /.card-body -->

              <div class="card-footer ">
                <a href="{{route('genre.index')}}" class="btn btn-primary btn-lg mr-3" >Отмена</a>
                <button type="submit" class="btn btn-primary btn-lg " >Добавить</button>
               </div>
            </form>
          </div>






    <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
  </div>




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

  </style>
@endsection


