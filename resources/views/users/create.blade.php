@extends('layouts.app')

@section('title', 'Пользователи')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Создание нового пользователя</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('main')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('user.index')}}">Users</a></li>
              <li class="breadcrumb-item active">Create</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">




        <div class="card card-white">

            <!-- form start -->
            <form action="{{route('user.store')}}" method="POST">
                @csrf
              <div class="card-body">
                <div class="block_two">
                  <label for="name">Имя</label>
                  <input type="text" class="form-control" id="name" placeholder="Введите имя" name="name">
                  @error('name')
                    {{$message}}
                  @enderror
                </div>

                <div class="block_one">
                  <label for="password">Password</label>
                  <input type="text" class="form-control" id="password" placeholder="Введите пароль" name="password">
                  @error('password')
                  {{$message}}
                @enderror
                </div>

                <div class="block_one">
                  <label for="email">Email</label>
                  <input type="text" class="form-control" id="email" placeholder="Email" name="email">
                  @error('email')
                  {{$message}}
                @enderror
                </div>

                <div class="block_two">
                  <label for="role">Ролиь</label>
                    <select name="role" class="form-control" >
                      <option selected value="">все</option>
                      @foreach ($roles as $id => $role)
                      <option value="{{$id}}">{{$role}}</option>
                      @endforeach
                    </select>
                    @error('role')
                    {{$message}}
                  @enderror
                  </div>
                </div>
                  </div>


              <!-- /.card-body -->

              <div class="card-footer d-flex justify-content-end mb-3">
                <button type="submit" class="btn btn-primary btn-lg" >Создать</button>
              </div>
            </form>
          </div>



        {{-- <form action="{{route('register')}}" method="POST">
            @csrf





<div class="row-3 mt-5">
            <input type="submit" class="btn btn-primary btn-lg" value="Create">
        </div>
    </form> --}}



    <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
  </div>


  <style>
    .block_one {
        float: left;
        width: 320px;
        margin-right: 50px;
        margin-bottom: 40px;
   }

    .block_two {
          width: 320px;
          margin-right: 50px;
          margin-bottom: 40px;
            }


  </style>
@endsection


