@extends('layouts.app')

@section('title', 'Плейлисты')

@section('content')
  <div id="playlist">
        <playlist-base :data='@json($auth)'></playlist-base>
  </div>
@endsection



