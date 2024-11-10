<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function assignedTasks() :View
    {
        $tasks = auth()->user()->tasks;
        return view('staff.tasks.index', compact('tasks'));
    }
}
