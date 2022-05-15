
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">
            {{ __('projects.View a project') . ": ". $project->name }}
            <a href="{{ route('projects.edit', ['project' => $project->id]) }}">⚙</a>
        </h1>
        <div class="row">
            <div class="col">
                <p>{{ __('projects.Project name') . ": ". $project->name }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>{{ __('projects.Description') . ": ". $project->description }}</p>
            </div>
        </div>
        @if ($project->tasks()->exists())
            <div class="row">
                <div class="col">
                    <p>{{ __('tasks.Tasks') . ": " }}</p>
                    <ul>
                        @foreach ($project->tasks as $task)
                            <li>{{ $task->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
@endsection
