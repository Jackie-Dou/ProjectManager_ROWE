@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">{{ __('samples.Samples') }}</h1>
        @if(Auth::check())
            <div class="row">
                <div class="col">
                    <a href="{{ route('samples.create') }}" class="btn btn-primary mb-2">{{ __('samples.Create samples') }}</a>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col">
                <div class="d-flex">
                    <div>
                        {{Form::open(['url' => route('samples.index'), 'method' => 'GET', 'class' => 'form-inline'])}}
                        {{Form::select('filter[status_id]', $taskStatuses, $filter['status_id'] ?? null, ['placeholder' => __('taskStatuses.Status'), 'class' => 'form-control my-2 mr-2'])}}
                        {{Form::select('filter[created_by_id]', $users, $filter['created_by_id'] ?? null, ['placeholder' => __('tasks.Author'), 'class' => 'form-control my-2 mr-2'])}}
                        {{Form::select('filter[project_id]', $projects, $filter['project_id'] ?? null, ['placeholder' => __('tasks.Project'), 'class' => 'form-control my-2 mr-2'])}}
                        {{Form::submit(__('tasks.Apply'), ['class' => 'btn btn-outline-primary mr-2 my-2'])}}
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table mt-2">
                    <table class="table">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">{{ __('taskStatuses.Status') }}</th>
                            <th scope="col">{{ __('tasks.Project') }}</th>
                            <th scope="col">{{ __('tasks.Author') }}</th>
                            <th scope="col">{{ __('tasks.Deadline') }}</th>
                            <th scope="col">{{ __('tasks.Date of creation') }}</th>
                            @if(Auth::check())
                                <th scope="col">{{ __('tasks.Actions') }}</th>
                            @endif
                        </tr>
                        @if ($samples)
                            @foreach ($samples as $sample)
                                <tr>
                                    <td><a href="{{ route('samples.show', ['sample' => $sample->id]) }}">{{ $sample->id }}</a></td>
                                    <td scope="row"> {{ $sample->status->name }} </td>
                                    <td><a href="{{ route('projects.show', ['project' => $sample->project->id]) }}">{{ $sample->project->name }}</a></td>
                                    <td>{{ $sample->creator->name }}</td>
                                    @if($sample->deadline)
                                        <td>{{ $sample->deadline }}</td>
                                    @else
                                        <td>{{ '---' }}</td>
                                    @endif
                                    <td>{{ $sample->created_at->format('d.m.Y') }}</td>
                                    @if(Auth::check())
                                        <td>
                                            @can('delete', $sample)
                                                <a class="text-danger" href="{{ route('samples.destroy', ['sample' => $sample->id]) }}" data-method="delete" rel="nofollow" data-confirm="{{ __('tasks.Are you sure?') }}">{{ __('tasks.Delete') }}</a>
                                            @endcan
                                            @can('update', $sample)
                                                <a href="{{ route('samples.edit', ['sample' => $sample->id]) }}">{{ __('tasks.Edit') }}</a>
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
        <div class="row">
            <div class="col">
                {{ $samples->links() }}
            </div>
        </div>
    </div>
@endsection
