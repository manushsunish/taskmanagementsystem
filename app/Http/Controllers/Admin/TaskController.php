<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class TaskController extends Controller
{
    public function index() :View
    {
        $tasks = Task::with('project', 'staff')->get();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function edit(Task $task) :View
    {
        $project = Project::whereId($task->project_id)
            ->with('team')
            ->first()
        ;
        return view('admin.tasks.edit', compact('task', 'project'));
    }

    public function update(Request $request, Task $task) :RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'staff' => 'required'
        ]);

        try {
            $task->update([
                'task' => $request->name,
                'description' => $request->description,
                'status' => $request->status,
                'staff_id' => $request->staff,
                'project_id' => $request->project_id
            ]);

        } catch (Throwable $e) {
            $e->getMessage();
            return redirect()->back();
        }

        return redirect()->route('admin.tasks.index');
    }

    public function destroy(Task $task) :RedirectResponse
    {
        $task->delete();
        return redirect()->back();
    }
}
