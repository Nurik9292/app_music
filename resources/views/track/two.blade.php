@extends('layouts.app')

@section('title', 'Треки')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- Main content -->

        <div class="block">
                <a href="{{route('track.create')}}" class="btn btn-primary btn-lg ">Через поля</a>
                <a href="{{route('track.create.scan')}}" class="btn btn-primary btn-lg ">Сканировать</a>
          </div>

    <!-- /.content -->
  </div>
@endsection



<style>
    .block {
        position: absolute;
    top:  50%;
    left: 50%;
    transform: translate(-50%,-50%);
}
</style>
