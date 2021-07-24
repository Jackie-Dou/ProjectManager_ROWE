<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskStatusController extends Controller
{
    // use policies
    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class, 'task_status');
    }

    public function index(): \Illuminate\Contracts\View\View
    {
        $taskStatuses = TaskStatus::orderBy('id', 'asc')->paginate();
        return view('task_statuses.index', compact('taskStatuses'));
    }

    public function create(): \Illuminate\Contracts\View\View
    {
        $taskStatus = new TaskStatus();
        return view('task_statuses.create', compact('taskStatus'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:task_statuses'
        ], $messages = [
            'unique' => __('validation.The status name has already been taken'),
        ]);

        $taskStatus = new TaskStatus();
        $taskStatus->fill($data);
        $taskStatus->save();
        flash(__('taskStatuses.Status has been added successfully'))->success();
        return redirect()->route('task_statuses.index');
    }

    public function edit(TaskStatus $taskStatus): \Illuminate\Contracts\View\View
    {
        return view('task_statuses.edit', compact('taskStatus'));
    }

    public function update(Request $request, TaskStatus $taskStatus): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:task_statuses,name,' . $taskStatus->id
        ], $messages = [
            'unique' => __('validation.The status name has already been taken'),
        ]);

        $taskStatus->fill($data);
        $taskStatus->save();
        flash(__('taskStatuses.Status has been updated successfully'))->success();
        return redirect()->route('task_statuses.index');
    }

    public function destroy(TaskStatus $taskStatus): \Illuminate\Http\RedirectResponse
    {
        Log::info("del status{$taskStatus->name}");
        if ($taskStatus->tasks()->exists()) {
            flash(__('taskStatuses.Failed to delete status'))->error();
            return back();
        }

        $taskStatus->delete();
        flash(__('taskStatuses.Status has been deleted successfully'))->success();
        return redirect()->route('task_statuses.index');
    }
}
