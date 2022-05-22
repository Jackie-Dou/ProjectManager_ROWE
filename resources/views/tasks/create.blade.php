@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">{{ __('tasks.Create task') }}</h1>
        <div class="row">
            <div class="col">
                {{Form::open(['url' => route('tasks.store')])}}
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::label('name', __('tasks.Task name'))}}
                            {{Form::text('name', '', ['class' => 'form-control'])}}
                            @if ($errors->has('name'))
                                @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::label('description', __('tasks.Description'))}}
                            {{Form::textarea('description', null, ['class' => 'form-control', 'cols' => '50', 'rows' => '10'])}}
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::label('deadline', __('tasks.Deadline'))}}
                            {{Form::input('date', 'deadline', null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::label('status_id', __('taskStatuses.Status'))}}
                            {{Form::select('status_id', $taskStatuses, null, ['placeholder' => '----------', 'class' => 'form-control'])}}
                            @if ($errors->has('status_id'))
                                @error('status_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::label('project_id', __('projects.Project'))}}
                            {{Form::select('project_id', $projects, '1', ['placeholder' => '----------', 'class' => 'form-control'])}}
                            @if ($errors->has('project_id'))
                                @error('project_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::label('label_id', __('labels.Labels'))}}
                            {{Form::select('label_id', $labels, null, ['placeholder' => '', 'multiple' => 'multiple', 'name' => 'labels[]', 'class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        {{Form::submit(__('tasks.Create'), ['class' => 'btn btn-primary mt-3'])}}
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
