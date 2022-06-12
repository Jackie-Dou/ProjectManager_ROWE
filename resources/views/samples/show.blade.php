@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">
            {{ __('samples.View a sample') . ": ". $sample->id }}
            <a href="{{ route('samples.edit', ['sample' => $sample->id]) }}">⚙</a>
        </h1>
        <div class="row">
            <div class="col">
                <p>{{ __('tasks.Deadline') . ": ". $sample->deadline }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>{{ __('tasks.Project') . ": ". $sample->project->name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>{{ __('taskStatuses.Status') . ": ". $sample->status->name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>{{ __('tasks.Description') . ": ". $sample->description }}</p>
            </div>
        </div>
        @if ($sample->labels()->exists())
            <div class="row">
                <div class="col">
                    <p>{{ __('labels.Labels') . ": " }}</p>
                    <ul>
                        @foreach ($sample->labels as $sample)
                            <li>{{ $sample->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if(Auth::check())
            <td>
                {{Form::open(['url' => route('tasks.sample', ['sample_id' => $sample->id]), 'method' => 'POST', 'class' => 'form-inline'])}}
                {{Form::submit(__('samples.Use'), ['class' => 'btn btn-outline-primary mr-2 my-2'])}}
                {{Form::close()}}
            </td>
        @endif
    </div>
@endsection
