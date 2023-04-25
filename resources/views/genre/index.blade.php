@extends('layouts.app')

@section('title', 'Жанры')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Жанры</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Главная</a></li>
              <li class="breadcrumb-item active">Жанры</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" >

        <div class="container-fluid">
            <div class="d-flex justify-content-end mb-3">
                <a class="btn btn-primary btn-lg" href="{{route('genre.create')}}">Добавить</a>
            </div>
            <!-- Main row -->
            <div class="row" id="genre">

                <genre-index></genre-index>
                {{-- <table class="table table-hover">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название Tm</th>
                        <th scope="col">Название Ru</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                      </tr>
                    </thead>
                    <tbody>

                        @foreach ($genres as $num => $genre)
                        <tr>
                            <th scope="row">{{$num + 1}}</th>
                            <td>{{$genre->name_tm}}</td>
                            <td>{{$genre->name_ru}}</td>
                            <td>@</td>
                            <td>@</td>
                        </tr>
                        @endforeach


                    </tbody>
                  </table> --}}
            </div>

          </div>

    </section>
    <!-- /.content -->
  </div>
@endsection



