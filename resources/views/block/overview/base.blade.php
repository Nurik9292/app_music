@extends('layouts.app')

@section('title', 'Обзор')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Обзор</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Главная</a></li>
              <li class="breadcrumb-item active">Обзор</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    {{-- <section class="content">
      <div class="container-fluid">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{route('overview.create')}}" class="btn btn-primary btn-lg">Создаоть</a>
        </div> --}}
        <!-- Main row -->
        <div class="row" id="ovr">
            <overview-base></overview-base>
        </div>

        {{-- <div class="d-flex justify-content-end mb-3">
            <input type="submit" class="btn btn-primary btn-lg" value="Отправить">
        </div>
      </div>
    </section> --}}
    <!-- /.content -->
  </div>
@endsection
