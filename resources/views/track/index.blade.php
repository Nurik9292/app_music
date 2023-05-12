@extends('layouts.app')

@section('title', 'Треки')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Треки</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Главная</a></li>
              <li class="breadcrumb-item active">Треки</li>
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
                <a class="btn btn-primary btn-lg" href="{{route('track.two')}}">Добавить</a>
            </div>
            <!-- Main row -->
            <div class="row" >
                <table class="table table-hover">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Текст</th>
                        <th scope="col">Длительность</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Номер</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($tracks as $num => $track)

                        <th scope="row">{{$num + 1}}</th>
                        <td>{{$track->title}}</td>
                        <td>{!!substr($track->lyrics, 0, 50)!!}</td>
                        <td>{{gmdate("i:s", $track->duration)}}</td>
                        <td><b class="text-{{$track->status == 'on' ? 'green' : 'danger'}}">{{$track->status}}</b></td>
                        <td>{{$track->track_number}}</td>
                        <td><a href="{{route('track.edit', $track)}}" class="btn btn-outline-success">Edit</a></td>
                        <form action="{{route('track.destroy', $track)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <td><input type="submit" class="btn btn-outline-danger" value="Delete"></td>
                        </form>
                    </tr>
                    @endforeach

                    </tbody>
                  </table>
            </div>

            {{$tracks->links()}}

          </div>

    </section>
    <!-- /.content -->
  </div>
@endsection



