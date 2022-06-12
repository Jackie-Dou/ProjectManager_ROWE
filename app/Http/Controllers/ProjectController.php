<?php


namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        $users = User::pluck('name', 'id')->all();

        $projects = QueryBuilder::for(Project::class)
            ->orderBy('isFavourite', 'desc')
            ->paginate();
        return view('projects.index', compact('projects', 'users'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        $project = new Project();
        $tasks = Task::pluck('name', 'id')->all();
        return view('projects.create', compact('project', 'tasks'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:projects',
            'description' => 'nullable|string',
            'tasks' => 'nullable|array'
        ], $messages = [
            'unique' => __('validation.The task name has already been taken'),
        ]);

        $project = new Project();
        $project->fill($data);
        $isFavourite = $request->input('isFavourite');
        if ($isFavourite) {
            $project->isFavourite = $isFavourite;
        } else {
            $project->isFavourite = false;
        }
        $project->save();

/*        $tasks = QueryBuilder::for(Task::class)
            ->whereIn('task_id', $request->input('tasks'));
        foreach ($tasks as $task) {
            $task->project()->associate($project);
        }
        $project->tasks()->saveMany($tasks);*/

        flash(__('projects.Project has been added successfully'))->success();
        return redirect()->route('projects.index');
    }

    public function show(Project $project): \Illuminate\Contracts\View\View
    {
        return view('projects.show', compact('project'));
    }

    public function destroy(Project $project): \Illuminate\Http\RedirectResponse
    {
        //$project->tasks()->detach();
        $project->delete();

        flash(__('projects.Project has been deleted successfully'))->success();
        return redirect()->route('projects.index');
    }

    public function edit(Project $project): \Illuminate\Contracts\View\View
    {
        $tasks = Task::pluck('name', 'id')->all();
        return view('projects.edit', compact('project', 'tasks'));
    }

    public function update(Request $request, Project $project): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:projects,name,' . $project->id,
            'description' => 'nullable|string',
            'tasks' => 'nullable|array'
        ], $messages = [
            'unique' => __('validation.The task name has already been taken'),
        ]);

        $project->fill($data);
        $isFavourite = $request->input('isFavourite');
        if ($isFavourite) {
            $project->isFavourite = $isFavourite;
        } else {
            $project->isFavourite = false;
        }
        $project->save();

        $tasks = collect($request->input('tasks'))->filter(fn($task) => isset($task));
        $project->tasks()->delete();
        $project->tasks()->saveMany($tasks);

        flash(__('projects.Project has been updated successfully'))->success();
        return redirect()->route('projects.index');
    }
}
