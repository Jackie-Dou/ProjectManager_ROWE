@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">{{ __('welcome.Hello from R.O.W.E.!') }}</h1>
            <p class="lead">{{ __('welcome.Read Often Write Everything') }}</p>
            <hr class="my-4">
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="" role="button">{{ __('welcome.Learn more') }}</a>
            </p>
        </div>
    </div>
@endsection
