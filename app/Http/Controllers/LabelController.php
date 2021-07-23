<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class, 'label');
    }

    public function index()
    {
        $labels = Label::orderBy('id', 'asc')->paginate();
        return view('labels.index', compact('labels'));
    }

    public function create()
    {
        $label = new Label();
        return view('labels.create', compact('label'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:labels',
            'description' => 'nullable|string'
        ], $messages = [
            'unique' => __('validation.The label name has already been taken'),
        ]);

        $label = new Label();
        $label->fill($data);
        $label->save();

        Log::info($label->name);

        flash(__('labels.Label has been added successfully'))->success();
        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    public function update(Request $request, Label $label)
    {
        $data = $request->validate([
            'name' => 'required|unique:labels,name,' . $label->id,
            'description' => 'nullable|string'
        ], $messages = [
            'unique' => __('validation.The label name has already been taken'),
        ]);

        $label->fill($data);
        $label->save();
        flash(__('labels.Label has been updated successfully'))->success();
        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        Log::info($label->name);

        if ($label->tasks()->exists()) {
            flash(__('labels.Failed to delete label'))->error();
            return back();
        }

        $label->delete();
        flash(__('labels.Label has been deleted successfully'))->success();
        return redirect()->route('labels.index');
    }
}
