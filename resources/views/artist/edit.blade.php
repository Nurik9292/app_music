@extends('layouts.app')

@section('title', 'Артисты')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Изменение Артиста</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{route('track.index')}}">Артисты</a></li>
              <li class="breadcrumb-item active">Измененить</li>
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
            <form action="{{route('artist.update', $artist)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
              <div class="card-body">

                <div class="row">
                    <div class="block_one">
                        <label for="name">Имя</label>
                        <input type="text" class="form-control" id="name" placeholder="Введите Название" name="name" value="{{$artist->name}}">
                        @error('name')
                          {{$message}}
                        @enderror
                      </div>
                </div>

                <div class="row">
                    <div class="text">
                        <label for="bio_tk">Tm биография</label>
                        <textarea class="form-control" id="bio_tm" name="bio_tk" placeholder="Введите текст"  rows="6">{{$artist->bio_tk}}</textarea>
                        @error('bio_tk')
                        <p class="text-danger">{{$message}}</p>
                      @enderror
                      </div>


                      <div class="text">
                        <label for="bio_ru">Ru биография</label>
                        <textarea class="form-control" id="bio_ru" name="bio_ru" placeholder="Введите текст" rows="6">{{$artist->bio_ru}}</textarea>
                        @error('bio_ru')
                        <p class="text-danger">{{$message}}</p>
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
                            <p class="text-danger">{{$message}}</p>
                          @enderror
                          </div>
                        </div>
                      </div>

                        <!-- select -->
                        <div class="block_one">
                            <label>Страна</label>
                            <select class="form-control" name="country_id">
                                @foreach ($countries as $country)
                                <option {{$artist->country->id == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </select>
                            @error('country_id')
                            <p class="text-danger">{{$message}}</p>
                          @enderror
                          </div>

                          {{-- checked --}}
                          <div>
                              <input type="checkbox" name="status" data-bootstrap-switch {{$artist->status == true ? 'checked' : ''}} >
                              @error('status')
                              <p class="text-danger">{{$message}}</p>
                            @enderror
                          </div>

                </div>



                </div>
                  </div>


              <!-- /.card-body -->




              <div class="card-footer d-flex justify-content-start mb-3 ">
                <a href="{{route('artist.index')}}" class="btn btn-primary btn-lg mr-3" >Отмена</a>
                <button type="submit" class="btn btn-primary btn-lg" >Обновить</button>
               </div>


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

  </style>
@endsection


