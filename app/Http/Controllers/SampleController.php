<?php


namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Project;
use App\Models\Sample;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SampleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Sample::class, 'sample');
    }

    public function index(Request $request): \Illuminate\Contracts\View\View
    {
        $users = User::pluck('name', 'id')->all();
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $projects = Project::pluck('name', 'id')->all();

        $samples = QueryBuilder::for(Sample::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('project_id')
            ])
            ->orderBy('id', 'asc')
            ->paginate();
        $filter = $request->filter ?? null;
        return view('samples.index', compact('samples', 'taskStatuses', 'users', 'projects', 'filter'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        $sample = new Sample();
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        $labels = Label::pluck('name', 'id')->all();
        $projects = Project::pluck('name', 'id')->all();
        return view('samples.create', compact('sample', 'taskStatuses', 'users', 'labels', 'projects'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'status_id' => 'required',
            'description' => 'nullable|string',
            'project_id' => 'required',
            'labels' => 'nullable|array'
        ], $messages = []);

        $user = Auth::user();
        $sample = $user->samples()->make();
        $sample->fill($data);
        $deadline = $request->input('deadline');
        $sample->deadline = $deadline;
        $sample->save();

        $labels = collect($request->input('labels'))->filter(fn($label) => isset($label));
        $sample->labels()->attach($labels);

        $project = $request->input('project');
        if ($project === null) {
            $project = QueryBuilder::for(Project::class)
                ->where('id', '1');
        }
        $sample->project()->associate($project);

        flash(__('samples.Sample has been added successfully'))->success();
        return redirect()->route('samples.index');
    }

    public function show(Sample $sample): \Illuminate\Contracts\View\View
    {
        return view('samples.show', compact('sample'));
    }

    public function edit(Sample $sample): \Illuminate\Contracts\View\View
    {
        $taskStatuses = TaskStatus::pluck('name', 'id')->all();
        $users = User::pluck('name', 'id')->all();
        $labels = Label::pluck('name', 'id')->all();
        $projects = Project::pluck('name', 'id')->all();
        return view('samples.edit', compact('sample', 'taskStatuses', 'users', 'labels', 'projects'));
    }

    public function update(Request $request, Sample $sample): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'status_id' => 'required',
            'description' => 'nullable|string',
            'project_id' => 'required',
            'labels' => 'nullable|array'
        ], $messages = [
            'unique' => __('validation.The task name has already been taken'),
        ]);

        $sample->fill($data);
        $deadline = $request->input('deadline');
        $sample->deadline = $deadline;
        $sample->save();

        $labels = collect($request->input('labels'))->filter(fn($label) => isset($label));
        $sample->labels()->sync($labels);

        $project = $request->input('project');
        if ($project === null) {
            $project = QueryBuilder::for(Project::class)
                ->where('id', '1');
        }
        $sample->project()->associate($project);

        flash(__('samples.Sample has been updated successfully'))->success();
        return redirect()->route('samples.index');
    }

    public function destroy(Sample $sample): \Illuminate\Http\RedirectResponse
    {
        $sample->labels()->detach();
        $sample->delete();

        flash(__('samples.Sample has been deleted successfully'))->success();
        return redirect()->route('samples.index');
    }
}
