@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">{{ __('projects.Edit project') }}</h1>
        <div class="row">
            <div class="col">
                {{Form::model($project, ['url' => route('projects.update', ['project' => $project]), 'method' => 'PATCH'])}}
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::label('name', __('projects.Project name'))}}
                            {{Form::text('name', $project->name, ['class' => 'form-control'])}}
                            @if ($errors->any())
                                <div class="invalid-feedback d-block">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::label('description', __('projects.Description'))}}
                            {{Form::textarea('description', null, ['class' => 'form-control', 'cols' => '50', 'rows' => '10'])}}
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::checkbox('isFavourite', true, $project->isFavourite)}}
                            {{Form::label('isFavourite', __('projects.Add to favourite?'))}}
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::label('task_id', __('projects.Tasks'))}}
                            {{Form::select('task_id', $tasks, $project->tasks, ['placeholder' => '', 'multiple' => 'multiple', 'name' => 'labels[]', 'class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        {{Form::submit(__('projects.Update'), ['class' => 'btn btn-primary mt-3'])}}
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
