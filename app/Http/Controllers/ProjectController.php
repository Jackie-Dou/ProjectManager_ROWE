<?php


namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'task');
    }

    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        $users = User::pluck('name', 'id')->all();

        $projects = QueryBuilder::for(Project::class)
            ->allowedFilters([
                AllowedFilter::exact('created_by_id')
            ])
            ->orderBy('id', 'asc')
            ->paginate();
        $filter = $request->filter ?? null;
        return view('projects.index', compact('projects', 'users', 'filter'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        $project = new Project();
        $tasks = Task::pluck('name', 'id')->all();
        return view('projects.create', compact('project', 'tasks'));
    }

    public function show(Project $project): \Illuminate\Contracts\View\View
    {
        return view('projects.show', compact('project'));
    }
}
