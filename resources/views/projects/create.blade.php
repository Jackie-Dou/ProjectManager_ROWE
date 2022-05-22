@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-5">{{ __('projects.Create project') }}</h1>
        <div class="row">
            <div class="col">
                {{Form::open(['url' => route('projects.store')])}}
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::label('name', __('projects.Project name'))}}
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
                            {{Form::label('description', __('projects.Description'))}}
                            {{Form::textarea('description', null, ['class' => 'form-control', 'cols' => '50', 'rows' => '10'])}}
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::checkbox('isFavourite', true)}}
                            {{Form::label('isFavourite', __('projects.Add to favourite?'))}}
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            {{Form::label('task_id', __('projects.Description'))}}
                            {{Form::select('task_id', $tasks, null, ['placeholder' => '', 'multiple' => 'multiple', 'name' => 'tasks[]', 'class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        {{Form::submit(__('projects.Create'), ['class' => 'btn btn-primary mt-3'])}}
                    </div>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
@endsection
