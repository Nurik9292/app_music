@extends('layouts.app')

@section('title', 'Жанры')

@section('content')
  <div class="row" id="genre">
        <genre-base :data='@json($auth)'></genre-base>
  </div>

@endsection



