@extends('layouts.app')

@section('title', 'Альбом')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Создание Альбома</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{route('album.index')}}">Альбом</a></li>
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
            <form action="{{route('album.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
              <div class="card-body">

                <div class="row">
                    <div class="block_one">
                        <label for="name">Название</label>
                        <input type="text" class="form-control" id="name" placeholder="Введите Название" name="title">
                        @error('title')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                      </div>
                </div>

                    <div class="row">
                        <div class="block_one">
                            <label for="description">Содержание</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Введите текст" rows="6"></textarea>
                            @error('description')
                            <p class="text-danger">{{$message}}</p>
                          @enderror
                          </div>
                        </div>

                        <div class="row">
                            <label>Исполнитель</label>
                              <div class="block_one">
                                <div class="select2-purple">
                                  <select class="form-control select2" multiple="multiple" name=artists[]" data-placeholder="Выберите испольнителя" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                    @foreach ($artists as $artist)
                                    <option value="{{$artist->id}}">{{$artist->name}}</option>
                                    @endforeach
                                  </select>
                                  @error('artists')
                                  <p class="text-danger">{{$message}}</p>
                                @enderror
                                </div>
                            </div>


                            <div class="block_one">
                                {{-- <a  href="{{route('artist.create')}}" class="btn btn-outline-primary " >Добавить</a> --}}
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
                        <p class="text-danger">{{$message}}</p>
                      @enderror
                      </div>

                      <div class="block_one">
                        <label>Дата добавления:</label>
                          <div class="input-group date" id="date_added" data-target-input="nearest">
                              <input type="text" class="form-control datetimepicker-input" data-target="#date_added" placeholder="Нажми ---->" name="added_date">
                              <div class="input-group-append" data-target="#date_added" data-toggle="datetimepicker">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                    @error('added_date')
                    <p class="text-danger">{{$message}}</p>
                  @enderror
                  </div>

                </div>

                <div class="row">
                    <div class="block_one">
                        <label for="inputFile">Изображение</label>

                          <div class="custom-file">
                              <label class="custom-file-label" for="inputFile">Выберите изображение</label>
                            <input type="file" class="custom-file-input" id="inputFile" name="artwork_url" accept="image/png, image/jpg, image/jpeg">
                            @error('artwork_url')
                            <p class="text-danger">{{$message}}</p>
                          @enderror
                          </div>
                      </div>

                        <!-- select -->
                        <div class="block_one">
                            <label>Тип альбома</label>
                            <select class="form-control" name="type">
                                <option>все</option>
                                @foreach ($types as $num => $type)
                                <option value="{{$num}}">{{$type}}</option>
                                @endforeach
                            </select>
                            @error('type')
                            <p class="text-danger">{{$message}}</p>
                          @enderror
                          </div>

                          {{-- checked --}}
                          <div class="row">
                            <div class="block_one">
                                <label for="status">Статуc</label>
                                  <input type="checkbox" name="status" id="status" data-bootstrap-switch>
                                  @error('status')
                                  <p class="text-danger">{{$message}}</p>
                                @enderror
                              </div>
                              <div class="block_one">
                                <label for="is_national">Национальная</label>
                                  <input type="checkbox" name="is_national" id="is_national" data-bootstrap-switch>
                                  @error('is_national')
                                  <p class="text-danger">{{$message}}</p>
                                @enderror
                              </div>
                        </div>

                </div>






            </div>
                <!-- /.card-body -->

                <div class="card-footer ">
                    <a href="{{route('album.index')}}" class="btn btn-primary btn-lg mr-3" >Отмена</a>
                    <button type="submit" class="btn btn-primary btn-lg " >Создать</button>
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

   label {
    display: block;
   }

  </style>
@endsection


