<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Label;
use Illuminate\Support\Facades\Date;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        $projects = Project::pluck('name', 'id')->all();

        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('project_id')
            ])
            ->orderBy('id', 'asc')
            ->paginate();
        $filter = $request->filter ?? null;
        return view('tasks.index', compact('tasks', 'taskStatuses', 'users', 'projects', 'filter'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        $task = new Task();
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        $labels = Label::pluck('name', 'id')->all();
        $projects = Project::pluck('name', 'id')->all();
        return view('tasks.create', compact('task', 'taskStatuses', 'users', 'labels', 'projects'));
    }

    public function calendar(): \Illuminate\Contracts\View\View
    {
        $today = date('Y-m-d');
        $todayTasks = QueryBuilder::for(Task::class)
            ->where('deadline', $today)
            ->orderBy('id', 'asc')
            ->paginate();

        $expTasks = QueryBuilder::for(Task::class)
            ->where('deadline', '<', $today)
            ->where('status_id', '<>', 3)
            ->orderBy('id', 'asc')
            ->paginate();

        $futureTasks = QueryBuilder::for(Task::class)
            ->where('deadline', '>', $today)
            ->where('status_id', '<>', 3)
            ->orderBy('id', 'asc')
            ->paginate();

        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        $projects = Project::pluck('name', 'id')->all();
        return view('tasks.calendar', compact('todayTasks', 'expTasks', 'futureTasks', 'taskStatuses', 'users', 'projects'));
    }



    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:tasks',
            'status_id' => 'required',
            'description' => 'nullable|string',
            'project_id' => 'required',
            'labels' => 'nullable|array'
        ], $messages = [
            'unique' => __('validation.The task name has already been taken')
        ]);

        $user = Auth::user();
        $task = $user->tasks()->make();
        $task->fill($data);
        $deadline = $request->input('deadline');
        $task->deadline = $deadline;
        $task->save();

        $labels = collect($request->input('labels'))->filter(fn($label) => isset($label));
        $task->labels()->attach($labels);

        $project = $request->input('project');
        if ($project === null) {
            $project = QueryBuilder::for(Project::class)
                ->where('id', '1');
        }
        $task->project()->associate($project);

        flash(__('tasks.Task has been added successfully'))->success();
        return redirect()->route('tasks.index');
    }

    public function show(Task $task): \Illuminate\Contracts\View\View
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task): \Illuminate\Contracts\View\View
    {
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        $labels = Label::pluck('name', 'id')->all();
        $projects = Project::pluck('name', 'id')->all();
        return view('tasks.edit', compact('task', 'taskStatuses', 'users', 'labels', 'projects'));
    }

    public function update(Request $request, Task $task): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:tasks,name,' . $task->id,
            'status_id' => 'required',
            'description' => 'nullable|string',
            'project_id' => 'required',
            'labels' => 'nullable|array'
        ], $messages = [
            'unique' => __('validation.The task name has already been taken'),
        ]);

        $task->fill($data);
        $deadline = $request->input('deadline');
        $task->deadline = $deadline;
        $task->save();

        $labels = collect($request->input('labels'))->filter(fn($label) => isset($label));
        $task->labels()->sync($labels);

        $project = $request->input('project');
        if ($project === null) {
            $project = QueryBuilder::for(Project::class)
                ->where('id', '1');
        }
        $task->project()->associate($project);

        flash(__('tasks.Task has been updated successfully'))->success();
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task): \Illuminate\Http\RedirectResponse
    {
        $task->labels()->detach();
        $task->delete();

        flash(__('tasks.Task has been deleted successfully'))->success();
        return redirect()->route('tasks.index');
    }
}
