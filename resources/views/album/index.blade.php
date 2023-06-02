@extends('layouts.app')

@section('title', 'Альбомы')

@section('content')
    <div id="album">
        <album-base :data='@json($auth)'></album-base>
    </div>
@endsection



