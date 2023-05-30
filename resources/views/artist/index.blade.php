@extends('layouts.app')

@section('title', 'Артисты')

@section('content')

    <div id="artist">
        <artist-base :data='@json($auth)'></artist-base>
    </div>

@endsection



