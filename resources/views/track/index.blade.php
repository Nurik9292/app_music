@extends('layouts.app')

@section('title', 'Треки')

@section('content')

        <div id="track">
            <track-base :data='@json($auth)'></track-base>
        </div>


@endsection



