<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function assignedProjects() :View
    {
        $projects = auth()->user()->projects;
        return view('staff.projects.index', compact('projects'));
    }
}
