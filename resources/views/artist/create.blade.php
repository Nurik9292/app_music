@extends('layouts.app')

@section('title', 'Артисты')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Добавление Артиста</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{route('track.index')}}">Артисты</a></li>
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
                        <label for="name">Имя</label>
                        <input type="text" class="form-control" id="name" placeholder="Введите Название" name="name">
                        @error('title')
                          {{$message}}
                        @enderror
                      </div>
                </div>

                    <div class="row">
                        <div class="block_one">
                            <label for="bio_tk">Tm биография</label>
                            <textarea class="form-control" id="bio_tk" name="bio_tk" placeholder="Введите текст" rows="6"></textarea>
                            @error('bio_tk')
                            {{$message}}
                          @enderror
                          </div>

                          <div class="block_one">
                            <label for="bio_ru">Ru биография</label>
                            <textarea class="form-control" id="bio_ru" name="bio_ru" placeholder="Введите текст" rows="6"></textarea>
                            @error('bio_ru')
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

                        <!-- select -->
                        <div class="block_one">
                            <label>Страна</label>
                            <select class="form-control" name="country_id">
                              <option>option 1</option>
                              <option>option 2</option>
                              <option>option 3</option>
                              <option>option 4</option>
                              <option>option 5</option>
                            </select>
                            @error('type')
                            {{$message}}
                          @enderror
                          </div>

                          {{-- checked --}}
                          <div>
                              <input type="checkbox" name="status" data-bootstrap-switch>
                          </div>

                </div>



                </div>
                  </div>


              <!-- /.card-body -->

              <div class="card-footer d-flex justify-content-end mb-3">
                <button type="submit" class="btn btn-primary btn-lg" >Создать</button>
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


