@extends('layouts.app')

@section('title', 'Обзор')

@section('content')

        <!-- Main row -->
        <div class="row" id="ovr">
            <overview-base :data='@json($auth)'></overview-base>
        </div>

  </div>
@endsection
