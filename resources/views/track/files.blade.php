@extends('layouts.app')

@section('title', 'Треки')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="block">
        <form action="{{route('track.store.file')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="block_one">
                    <label for="file">Название</label>
                    <input type="file" class="form-control" id="name" placeholder="Выберите файл" name="file">
                    @error('file')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
            </div>

            <div class="raw mb-5">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="local" value="tm" checked>
                  <label class="form-check-label">Tm</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="local" value="ru">
                  <label class="form-check-label">Ru</label>
                </div>
              </div>
            <div >
                <a href="{{route('track.index')}}" class="btn btn-primary btn-lg mr-3" >Отмена</a>
                <button type="submit" class="btn btn-primary btn-lg " >Добавить</button>
               </div>
        </form>
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
