@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <p class="lead">{{ __('tasks.Today tasks') }}</p>
            <hr class="my-4">
            <div class="row">
                <div class="col">
                    <div class="table mt-2">
                        <table class="table">
                            <tr>
                                <th scope="col">{{ __('tasks.Task name') }}</th>
                                <th scope="col">{{ __('taskStatuses.Status') }}</th>
                                <th scope="col">{{ __('tasks.Project') }}</th>
                                <th scope="col">{{ __('tasks.Deadline') }}</th>
                                <th scope="col">{{ __('tasks.Date of creation') }}</th>
                                @if(Auth::check())
                                    <th scope="col">{{ __('tasks.Actions') }}</th>
                                @endif
                            </tr>
                            @if ($todayTasks)
                                @foreach ($todayTasks as $task)
                                    <tr>
                                        <td><a href="{{ route('tasks.show', ['task' => $task->id]) }}">{{ $task->name }}</a></td>
                                        <td scope="row"> {{ $task->status->name }} </td>
                                        <td><a href="{{ route('projects.show', ['project' => $task->project->id]) }}">{{ $task->project->name }}</a></td>
                                        @if($task->deadline)
                                            <td>{{ $task->deadline }}</td>
                                        @else
                                            <td>{{ '---' }}</td>
                                        @endif
                                        <td>{{ $task->created_at->format('d.m.Y') }}</td>
                                        @if(Auth::check())
                                            <td>
                                                @can('delete', $task)
                                                    <a class="text-danger" href="{{ route('tasks.destroy', ['task' => $task->id]) }}" data-method="delete" rel="nofollow" data-confirm="{{ __('tasks.Are you sure?') }}">{{ __('tasks.Delete') }}</a>
                                                @endcan
                                                @can('update', $task)
                                                    <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">{{ __('tasks.Edit') }}</a>
                                                @endcan
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <p class="lead">{{ __('tasks.Expired tasks') }}</p>
        <div class="row">
            <div class="col">
                <div class="table mt-2">
                    <table class="table">
                        <tr>
                            <th scope="col">{{ __('tasks.Task name') }}</th>
                            <th scope="col">{{ __('taskStatuses.Status') }}</th>
                            <th scope="col">{{ __('tasks.Project') }}</th>
                            <th scope="col">{{ __('tasks.Deadline') }}</th>
                            <th scope="col">{{ __('tasks.Date of creation') }}</th>
                            @if(Auth::check())
                                <th scope="col">{{ __('tasks.Actions') }}</th>
                            @endif
                        </tr>
                        @if ($todayTasks)
                            @foreach ($expTasks as $task)
                                <tr>
                                    <td><a class="exp" href="{{ route('tasks.show', ['task' => $task->id]) }}">{{ $task->name }}</a></td>
                                    <td scope="row"> {{ $task->status->name }} </td>
                                    <td><a href="{{ route('projects.show', ['project' => $task->project->id]) }}">{{ $task->project->name }}</a></td>
                                    @if($task->deadline)
                                        <td>{{ $task->deadline }}</td>
                                    @else
                                        <td>{{ '---' }}</td>
                                    @endif
                                    <td>{{ $task->created_at->format('d.m.Y') }}</td>
                                    @if(Auth::check())
                                        <td>
                                            @can('delete', $task)
                                                <a class="text-danger" href="{{ route('tasks.destroy', ['task' => $task->id]) }}" data-method="delete" rel="nofollow" data-confirm="{{ __('tasks.Are you sure?') }}">{{ __('tasks.Delete') }}</a>
                                            @endcan
                                            @can('update', $task)
                                                <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">{{ __('tasks.Edit') }}</a>
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <p class="lead">{{ __('tasks.Future tasks') }}</p>
        <div class="row">
            <div class="col">
                <div class="table mt-2">
                    <table class="table">
                        <tr>
                            <th scope="col">{{ __('tasks.Task name') }}</th>
                            <th scope="col">{{ __('taskStatuses.Status') }}</th>
                            <th scope="col">{{ __('tasks.Project') }}</th>
                            <th scope="col">{{ __('tasks.Deadline') }}</th>
                            <th scope="col">{{ __('tasks.Date of creation') }}</th>
                            @if(Auth::check())
                                <th scope="col">{{ __('tasks.Actions') }}</th>
                            @endif
                        </tr>
                        @if ($todayTasks)
                            @foreach ($futureTasks as $task)
                                <tr>
                                    <td><a href="{{ route('tasks.show', ['task' => $task->id]) }}">{{ $task->name }}</a></td>
                                    <td scope="row"> {{ $task->status->name }} </td>
                                    <td><a href="{{ route('projects.show', ['project' => $task->project->id]) }}">{{ $task->project->name }}</a></td>
                                    @if($task->deadline)
                                        <td>{{ $task->deadline }}</td>
                                    @else
                                        <td>{{ '---' }}</td>
                                    @endif
                                    <td>{{ $task->created_at->format('d.m.Y') }}</td>
                                    @if(Auth::check())
                                        <td>
                                            @can('delete', $task)
                                                <a class="text-danger" href="{{ route('tasks.destroy', ['task' => $task->id]) }}" data-method="delete" rel="nofollow" data-confirm="{{ __('tasks.Are you sure?') }}">{{ __('tasks.Delete') }}</a>
                                            @endcan
                                            @can('update', $task)
                                                <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">{{ __('tasks.Edit') }}</a>
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endif
                    </table>
                </div>
            </div>
        </div>

    </div>

    <style>
        .exp {
            color: #ae1c17; /* Цвет символа */
        }
    </style>
@endsection
