@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">{{ __('welcome.Hello from R.O.W.E.!') }}</h1>
            <p class="lead">{{ __('info.Common information') }}</p>
            <hr class="my-4">
            Тут общая информация о том, зачем и почему
        </div>
    </div>
@endsection
