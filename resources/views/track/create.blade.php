@extends('layouts.app')

@section('title', 'Треки')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Создание Трека</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{route('track.index')}}">Треки</a></li>
              <li class="breadcrumb-item active">Создание</li>
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
            <form action="{{route('album.store')}}" method="POST">
                @csrf
              <div class="card-body">

                <div class="row">
                    <div class="block_one">
                        <label for="name">Ru Название</label>
                        <input type="text" class="form-control" id="name" placeholder="Введите Название" name="title">
                        @error('title')
                          {{$message}}
                        @enderror
                      </div>

                      <div class="block_one">
                        <label for="name">Tm Название</label>
                        <input type="text" class="form-control" id="name" placeholder="Введите Название" name="title">
                        @error('title')
                          {{$message}}
                        @enderror
                      </div>
                </div>

                    <div class="row">
                        <label>Исполнитель</label>
                          <div class="block_one">
                            <div class="select2-purple">
                              <select class="select2" multiple="multiple" data-placeholder="Выберите испольнителя" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                <option>Alabama</option>
                                <option>Alaska</option>
                                <option>California</option>
                                <option>Delaware</option>
                                <option>Tennessee</option>
                                <option>Texas</option>
                                <option>Washington</option>
                              </select>

                            </div>
                        </div>


                        <div class="block_one">
                            <a  href="#" class="btn btn-outline-primary " >Добавить</a>
                        </div>

                    </div>



                <div class="row">
                    <div class="block_one">
                        <label>Альбомы</label>
                        <div class="select2-purple">
                            <select class="select2" multiple="multiple" data-placeholder="Выберите альбомы" data-dropdown-css-class="select2-purple" style="width: 100%;">
                              <option>Alabama</option>
                              <option>Alaska</option>
                              <option>California</option>
                              <option>Delaware</option>
                              <option>Tennessee</option>
                              <option>Texas</option>
                              <option>Washington</option>
                            </select>
                          </div>
                      </div>

                      <div class="block_one">
                        <label>Жанры</label>
                        <div class="select2-purple">
                            <select class="select2" multiple="multiple" data-placeholder="Выберите жанры" data-dropdown-css-class="select2-purple" style="width: 100%;">
                              <option>Alabama</option>
                              <option>Alaska</option>
                              <option>California</option>
                              <option>Delaware</option>
                              <option>Tennessee</option>
                              <option>Texas</option>
                              <option>Washington</option>
                            </select>
                          </div>
                    @error('added_date')
                    {{$message}}
                  @enderror
                  </div>

                </div>

                <div class="row">
                    <div class="block_one">
                        <label>Дата выпуска:</label>
                          <div class="input-group date" id="date_release" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#date_release" placeholder="Нажми ---->" name="release_date">
                              <div class="input-group-append" data-target="#date_release" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                    @error('release_date')
                    {{$message}}
                  @enderror
                  </div>
                </div>

                <div class="row">
                    <div class="block_one">
                        <label for="inputFile">Изображение</label>
                        <div class="input-group">
                          <div class="custom-file">
                              <label class="custom-file-label" for="inputFile">Выберите изображение</label>
                            <input type="file" class="custom-file-input" id="inputFile" name="artwork_url">
                            @error('artwork_url')
                            {{$message}}
                          @enderror
                          </div>
                        </div>
                      </div>

                </div>



                </div>
                  </div>


              <!-- /.card-body -->

              <div class="card-footer d-flex justify-content-end mb-3">
                <button  class="btn btn-primary btn-lg" >Создать</button>
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


  </style>
@endsection


