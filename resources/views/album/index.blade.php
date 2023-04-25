@extends('layouts.app')

@section('title', 'Альбомы')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Альбомы</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Главная</a></li>
              <li class="breadcrumb-item active">Альбомы</li>
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
                <a class="btn btn-primary btn-lg" href="{{route('album.create')}}">Добавить</a>
            </div>
            <!-- Main row -->
            <div class="row" >
                <table class="table table-hover">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Тип</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Выпуск</th>
                        <th scope="col">Добавлен</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($albums as $num => $album)
                        <tr>
                            <th scope="row">{{$num + 1}}</th>
                        <td>{{$album->title}}</td>
                        <td>{!!substr($album->description, 0, 50)!!}</td>
                        <td>{{$album->type}}</td>
                        <td><b class="text-{{$album->status == 'on' ? 'green' : 'danger'}}">{{$album->status}}</b></td>
                        <td>{{$added_dates[$album->id]}}</td>
                        <td>{{$release_dates[$album->id]}}</td>
                        <td><a href="{{route('album.edit', $album)}}" class="btn btn-outline-success">Edit</a></td>
                        <form action="{{route('album.destroy', $album)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <td><input type="submit" class="btn btn-outline-danger" value="Delete"></td>
                        </form>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
            </div>

          </div>

    </section>
    <!-- /.content -->
  </div>
@endsection



