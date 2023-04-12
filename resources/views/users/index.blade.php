@extends('layouts.app')

@section('title', 'Пользователи')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Пользователи</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
                <a class="btn btn-primary btn-lg" href="{{route('user.create')}}">Create</a>
            </div>
            <!-- Main row -->
            <div class="row" id="app">
                <Index></Index>
            </div>

          </div>

    <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
  </div>
@endsection



