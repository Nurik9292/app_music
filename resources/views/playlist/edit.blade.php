@extends('layouts.app')

@section('title', 'Плейлист')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">изменить Плейлиста</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{route('playlist.index')}}">Плейлист</a></li>
              <li class="breadcrumb-item active">Изменение</li>
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
            <form action="{{route('playlist.update', $playlist)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
              <div class="card-body">

                <div class="row">
                    <div class="block_one">
                        <label for="title_tm">Название TM</label>
                        <input type="text" class="form-control" id="title_tm" placeholder="Введите Название" name="title_tm" value="{{$playlist->title_tm}}">
                        @error('title_tm')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                      </div>

                      <div class="block_one">
                        <label for="title_ru">Название RU</label>
                        <input type="text" class="form-control" id="title_ru" placeholder="Введите Название" name="title_ru" value="{{$playlist->title_ru}}">
                        @error('title_ru')
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

                </div>

                <div class="row">
                    <div class="block_one">
                        <label>Треки</label>
                        <div class="select2-purple">
                            <select class="select2" multiple="multiple" name="tracks[]" data-placeholder="Выберите трэки" data-dropdown-css-class="select2-purple" style="width: 100%;">
                              @foreach ($tracks as $track)
                              <option @foreach ($playlist->tracks as $tr)
                                  {{$track->id == $tr->id ? 'selected' : ''}}
                              @endforeach
                               value="{{$track->id}}">{{$track->title}}
                                </option>
                              @endforeach
                            </select>
                          </div>
                          @error('tracks')
                          <p class="text-danger">{{$message}}</p>
                        @enderror
                      </div>

                      <div class="block_one">
                        <label>Жанры</label>
                        <div class="select2-purple">
                            <select class="select2" multiple="multiple" name="genres[]" data-placeholder="Выберите жанры" data-dropdown-css-class="select2-purple" style="width: 100%;">
                              @foreach ($genres as $genre)
                              <option  @foreach ($playlist->genres as $gr)
                                {{$genre->id == $gr->id ? 'selected' : ''}}
                                @endforeach
                            value="{{$genre->id}}">{{$genre->name_ru}}
                           </option>
                              @endforeach
                            </select>
                          </div>
                    @error('genres')
                    <p class="text-danger">{{$message}}</p>
                  @enderror
                  </div>

                </div>

                          {{-- checked --}}
                          <div class="row">
                            <div class="block_one">
                                <label for="status">Статуc</label>
                                  <input type="checkbox" name="status" id="status" data-bootstrap-switch {{$playlist->status == true ? 'checked' : ''}}>
                                  @error('status')
                                  <p class="text-danger">{{$message}}</p>
                                @enderror
                              </div>

                        </div>



                </div>







                <!-- /.card-body -->

                <div class="card-footer ">
                    <a href="{{route('playlist.index')}}" class="btn btn-primary btn-lg mr-3" >Отмена</a>
                    <button type="submit" class="btn btn-primary btn-lg " >Обновить</button>
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


