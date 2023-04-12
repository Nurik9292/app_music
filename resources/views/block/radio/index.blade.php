@extends('layouts.app')

@section('title', 'Радио')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Радио</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Home</a></li>
              <li class="breadcrumb-item active">Radio</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="mb-3">
            <input type="button" value="Create">
        </div>
        <!-- Main row -->
        <div class="row">
        </div>
    <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
  </div>
@endsection
