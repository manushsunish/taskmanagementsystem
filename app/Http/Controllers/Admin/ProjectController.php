<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\UserProjectActivity;
use Helper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use Throwable;

class ProjectController extends Controller
{
    public function index() :View
    {
        $projects = Project::with(['manager', 'team'])
            ->orderByDesc('created_at')
            ->get()
        ;
        return view('admin.project.index', compact('projects'));
    }

    public function create() :View
    {
        $managers = User::whereRole('manager')->get();
        $staffs = User::whereRole('staff')->get();
        return view('admin.project.create', compact('managers', 'staffs'));
    }

    public function store(Request $request) :RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required | min:3',
            'project_leader' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'team_members' => 'required'
        ]);

        $startDate = Helper::dateFormatAlt($request->start_date, 'Y-m-d');
        $endDate = Helper::dateFormatAlt($request->end_date, 'Y-m-d');

        try {

            $project = Project::create([
                'name' => $request->name,
                'description' => $request->description,
                'manager_id' => $request->project_leader,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $request->status
            ]);

            $project->team()->attach($request->team_members);

        }catch (Throwable $e) {
            $e->getMessage();
            Alert::error('OPPs!', 'Something Went Wrong');
            return redirect()->back()->with('errorMessage', 'Something Went Wrong');
        }
        Alert::success('Success!', 'Successfully created');
        return redirect()->route('admin.projects.index');
    }


    public function show(Project $project) :View
    {
        return view('admin.project.details', compact('project'));
    }


    public function edit(Project $project) :View
    {
        $managers = User::whereRole('manager')->get();
        $staffs = User::whereRole('staff')->get();

        return view('admin.project.edit',
            compact('managers', 'project', 'staffs')
        );
    }


    public function update(Request $request, Project $project) :RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required | min:3',
            'project_leader' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'team_members' => 'required'
        ]);

        $startDate = Helper::dateFormatAlt($request->start_date, 'Y-m-d');
        $endDate = Helper::dateFormatAlt($request->end_date, 'Y-m-d');

        try {

            $project->team()->detach();

            $project->update([
                'name' => $request->name,
                'description' => $request->description,
                'manager_id' => $request->project_leader,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $request->status
            ]);

            $project->team()->attach($request->team_members);

        }catch (Throwable $e) {
            $e->getMessage();
            Alert::error('OPPs!', 'Something Went Wrong');
            return redirect()->back()->with('errorMessage', 'Something Went Wrong');
        }
        Alert::success('Success!', 'Successfully Updated');
        return redirect()->route('admin.projects.index');
    }


    public function destroy($id)
    {
        //
    }

    public function taskStore(Request $request) :RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'staff' => 'required'
        ]);

        try {
            Task::create([
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

        return redirect()->back();
    }

    public function discussionStore(Request $request) :RedirectResponse
    {
        $request->validate([
            'task' => 'required',
            'subject' => 'required',
            'comment' => 'required'
        ]);

        try {
            UserProjectActivity::create([
                'project_id' => $request->id,
                'task_id' => $request->task,
                'user_id' => auth()->user()->id,
                'subject' => $request->subject,
                'comment' => $request->comment
            ]);
        } catch (Throwable $e) {
            $e->getMessage();
            return redirect()->back()->with('warning', 'Something went wrong');
        }

        return redirect()->back()->with('success', 'Success');
    }
}
