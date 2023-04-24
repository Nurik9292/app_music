@extends('layouts.app')

@section('title', 'Артисты')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Артисты</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Главная</a></li>
              <li class="breadcrumb-item active">Артисты</li>
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
                <a class="btn btn-primary btn-lg" href="{{route('artist.create')}}">Добавить</a>
            </div>
            <!-- Main row -->
            <div class="row" >
                <table class="table table-hover">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Имя</th>
                        <th scope="col">Биография Tm</th>
                        <th scope="col">Биография Ru</th>
                        <th scope="col">Страна</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Добавлен</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($artists as $num => $artist)

                        <tr>
                            <th scope="row">{{$num + 1}}</th>
                            <td>{{$artist->name}}</td>
                            <td>{!!substr($artist->bio_tk, 0, 50)!!}</td>
                            <td>{!!substr($artist->bio_ru, 0, 50)!!}</td>
                            <td>{{$artist->country->name}}</td>
                            <td><b class="text-{{$artist->status == 'on' ? 'green' : 'danger'}}">{{$artist->status}}</b></td>
                            <td>{{$dates[$artist->id]}}</td>

                            <td><a href="{{route('artist.edit', $artist)}}" class="btn btn-outline-success">Edit</a></td>
                            <form action="{{route('artist.destroy', $artist)}}" method="POST">
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



