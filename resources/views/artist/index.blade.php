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
                <li class="breadcrumb-item"><a href="{{route('main')}}">Home</a></li>
              <li class="breadcrumb-item active">Артисты</li>
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
            <button type="button" class="btn btn-block btn-primary btn-lg">Create</button>
        </div>
        <!-- Main row -->
        <div class="mb-3">
            <input type="button" value="Create">
        </div>
        <!-- Main row -->
        <div class="row">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Date</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                  </tr>
                </tbody>
              </table>
        </div>

        <div>
            <input type="button" value="Send">
        </div>
    <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
  </div>
@endsection
