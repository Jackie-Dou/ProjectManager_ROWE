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
                            {{Form::textarea('description', $sample->description, ['class' => 'form-control', 'cols' => '50', 'rows' => '10'])}}
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::label('deadline', __('tasks.Deadline'))}}
                            {{Form::input('date', 'deadline', $sample->deadline, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::label('status_id', __('taskStatuses.Status'))}}
                            {{Form::select('status_id', $taskStatuses, $sample->status->id, ['placeholder' => '----------', 'class' => 'form-control'])}}
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
                            {{Form::label('project_id', __('projects.Project'))}}
                            {{Form::select('project_id', $projects, $sample->project->id, ['placeholder' => '----------', 'class' => 'form-control'])}}
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
                            {{Form::label('label_id', __('labels.Labels'))}}
                            {{Form::select('label_id', $labels, $sample->labels, ['placeholder' => '', 'multiple' => 'multiple', 'name' => 'labels[]', 'class' => 'form-control'])}}
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
