@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">{{ __('welcome.Hello from R.O.W.E.!') }}</h1>
            <p class="lead">{{ __('info.Information header') }}</p>
            <hr class="my-4">
            {{ __('info.Common information') }}
        </div>
    </div>
@endsection
