@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">{{ __('projects.Projects') }}</h1>
        @if(Auth::check())
            <div class="row">
                <div class="col">
                    <a href="{{ route('projects.create') }}" class="btn btn-primary mb-2">{{ __('projects.Create project') }}</a>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col">
                <div class="d-flex">
                    <div>
                        {{Form::open(['url' => route('projects.index'), 'method' => 'GET', 'class' => 'form-inline'])}}
                        {{--фильтр по избранному и по дате--}}
                        {{Form::submit(__('projects.Apply'), ['class' => 'btn btn-outline-primary mr-2 my-2'])}}
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
                            <th scope="col">{{ __('projects.Project name') }}</th>
                            <th scope="col">{{ __('projects.Date of creation') }}</th>
                            <th scope="col">{{ __('projects.Favourite') }}</th>
                            @if(Auth::check())
                                <th scope="col">{{ __('projects.Actions') }}</th>
                            @endif
                        </tr>
                        @if ($projects)
                            @foreach ($projects as $project)
                                <tr>
                                    <td><a href="{{ route('projects.show', ['project' => $project->id]) }}">{{ $project->name }}</a></td>
                                    <td>{{ $project->created_at->format('d.m.Y') }}</td>
                                    <td>
                                        @if($project->isFavourite)
                                            ★
                                        @endif
                                    </td>
                                    @if(Auth::check())
                                        <td>
                                            @can('delete', $project)
                                                <a class="text-danger" href="{{ route('projects.destroy', ['project' => $project->id]) }}" data-method="delete" rel="nofollow" data-confirm="{{ __('projects.Are you sure?') }}">{{ __('projects.Delete') }}</a>
                                            @endcan
                                            @can('update', $project)
                                                <a href="{{ route('projects.edit', ['project' => $project->id]) }}">{{ __('projects.Edit') }}</a>
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
                {{ $projects->links() }}
            </div>
        </div>
    </div>
@endsection
