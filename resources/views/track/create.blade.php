@extends('layouts.app')

@section('title', 'Треки')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Добавление Трека</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{route('track.index')}}">Треки</a></li>
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
            <form action="{{route('track.store')}}" method="POST" enctype="multipart/form-data">
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
                    <div class="text">
                        <label for="lyrics">Текст Песни</label>
                        <textarea class="form-control" id="lyrics" name="lyrics" placeholder="Введите текст" rows="6"></textarea>
                        @error('lyrics')
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
                            <a  href="{{route('artist.create')}}" class="btn btn-outline-primary " >Добавить</a>
                        </div>

                    </div>



                <div class="row">
                    <div class="block_one">
                        <label>Альбомы</label>
                        <div >
                            <select class="form-control single" name="album">
                                <option value="0">все</option>
                                @foreach ($albums as $album)
                                <option value="{{$album->id}}">{{$album->title}}</option>
                                @endforeach
                              </select>
                            @error('album')
                            <p class="text-danger">{{$message}}</p>
                          @enderror
                          </div>

                      </div>

                      <div class="block_one">
                        <label>Жанры</label>
                        <div class="select2-purple">
                            <select class="select2" multiple="multiple" name="genres[]" data-placeholder="Выберите жанры" data-dropdown-css-class="select2-purple" style="width: 100%;">
                              @foreach ($genres as $genre)
                              <option value="{{$genre->id}}">{{$genre->name_ru}}</option>
                              @endforeach
                            </select>
                          </div>
                    @error('genres')
                    <p class="text-danger">{{$message}}</p>
                  @enderror
                  </div>

                </div>


                <div class="row">
                    <div class="block_one">
                        <label for="inputFile_1">Изображение</label>

                          <div class="custom-file">
                              <label class="custom-file-label" for="inputFile_1">Выберите изображение</label>
                            <input type="file" class="custom-file-input" id="inputFile_1" name="thumb_url" accept="image/png, image/jpg, image/jpeg">
                            @error('thumb_url')
                            <p class="text-danger">{{$message}}</p>
                          @enderror
                          </div>

                      </div>

                      {{-- <div class="block_one">
                        <label for="inputFile_2">Трек</label>
                          <div class="custom-file">
                              <label class="custom-file-label" for="inputFile_2">Выберите Трек</label>
                            <input type="file" class="custom-file-input"  id="inputFile_2" name="audio_url" accept="audio/mp4, audio/mpeg">
                            @error('audio_url')
                            <p class="text-danger">{{$message}}</p>
                          @enderror
                          </div>
                      </div> --}}

                      <div class="block_one">
                        <label for="audio_url">Введите трек</label>
                        <input type="text" class="form-control" id="audio_url" placeholder="Введите путь до трека" name="audio_url">
                        @error('audio_url')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                      </div>

                        <div class="block_one">
                            <label for="number">Номер трека </label>
                            <input type="number" class="form-control" id="number" placeholder="Введите номер трека" name="track_number">
                            @error('track_number')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                          </div>

                </div>

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


              <!-- /.card-body -->

              <div class="card-footer ">
                <a href="{{route('track.index')}}" class="btn btn-primary btn-lg mr-3" >Отмена</a>
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


