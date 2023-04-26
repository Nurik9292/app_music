@extends('layouts.app')

@section('title', 'Плейлисты')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Плейлисты</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Главная</a></li>
              <li class="breadcrumb-item active">Плейлисты</li>
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
                <a class="btn btn-primary btn-lg" href="{{route('playlist.create')}}">Добавить</a>
            </div>
            <!-- Main row -->
            <div class="row" >
                <table class="table table-hover">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название Tm</th>
                        <th scope="col">Название RU</th>
                        <th scope="col">Жанр</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Добавлен</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($playlists as $num => $playlist)
                        <tr>
                            <th scope="row">{{$num + 1}}</th>
                        <td>{{$playlist->title_tm}}</td>
                        <td>{{$playlist->title_ru}}</td>
                        <td > @foreach ($playlist->genres as $genre){{$genre->name_ru}}  @endforeach</td>
                        <td><b class="text-{{$playlist->status == 'on' ? 'green' : 'danger'}}">{{$playlist->status}}</b></td>
                        <td>{{$dates[$playlist->id]}}</td>
                        <td><a href="{{route('playlist.edit', $playlist)}}" class="btn btn-outline-success">Edit</a></td>
                        <form action="{{route('playlist.destroy', $playlist)}}" method="POST">
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



