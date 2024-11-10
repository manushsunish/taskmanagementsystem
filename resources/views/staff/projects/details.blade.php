@extends('layouts.master')
@section('title', 'Project Details')
@section('content')
    <section class="content">
        @if(session()->has('warning'))
            <div class="alert alert-warning">
                {{ session()->get('warning') }}
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Project Details</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Task</h3>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger m-2">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form
                                        action="{{ route('admin.projects.task.store') }}"
                                        method="post"
                                        enctype="multipart/form-data">
                                        <input type="hidden" value="{{ $project->id }}" name="project_id">
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label for="inputName">Task</label>
                                                    <input
                                                        type="text"
                                                        id="inputName"
                                                        placeholder="Task Name"
                                                        class="form-control"
                                                        name="name">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label for="inputDescription">Description</label>
                                                    <textarea
                                                        placeholder="write here"
                                                        id="inputDescription"
                                                        class="form-control"
                                                        rows="2"
                                                        name="description"></textarea>
                                                </div>
                                                @php
                                                    $statuses = config('sites.task_statuses');
                                                @endphp
                                                <div class="form-group col-6">
                                                    <label for="inputStatus">Status</label>
                                                    <select
                                                        id="inputStatus"
                                                        class="form-control custom-select"
                                                        name="status"
                                                    >
                                                        <option selected="" disabled="">Select one</option>
                                                        @foreach($statuses as $item)
                                                            <option value="{{ $item }}">{{ $item }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="inputProjectLeader">Assign To</label>
                                                    <select
                                                        name="staff" id=""
                                                        class="form-control custom-select" required>
                                                        <option selected="" disabled="">Select one</option>
                                                        @foreach($project->team as $key => $value)
                                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-secondary btn-sm btn-flat float-right">Save Task</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Tasks</h3>
                                    </div>
                                    <div class="card-body p-1 table-responsive text-nowrap">
                                        <table class="table table-striped projects" id="myTable">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Task</th>
                                                <th>Description</th>
                                                <th>Assigned</th>
                                                <th class="text-center">Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($project->tasks as $index => $row)
                                                <tr>
                                                    <td>{{ $index+1 }}</td>
                                                    <td>{{ $row->task }}</td>
                                                    <td>{{ $row->description }}</td>
                                                    <td>{{ $row->staff->name }}</td>
                                                    <td class="project-state">
                                                        <span class="badge badge-secondary">{{ $row->status }}</span>
                                                    </td>
                                                    <td class="project-actions text-right">
                                                        <a
                                                            class="btn btn-info btn-sm"
                                                            href="#">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm" href="#">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>No Data available</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <h3 class="text-primary">
                            <i class="fas fa-paint-brush"></i>
                            {{ $project->name }}
                        </h3>
                        <p class="text-muted">
                            {{ $project->description }}
                        </p>
                        <br>
                        @php
                            $alert = "";
                            if ($project->status == 'pending') {
                              $alert = "warning";
                            }elseif ($project->status == 'in-progress') {
                              $alert = "info";
                            }else {
                              $alert = "success";
                            }
                        @endphp
                        <div class="text-muted">
                            <p class="text-sm">Start Date
                                <b class="d-block">{{ Helper::dateFormatAlt($project->start_date) }}</b>
                            </p>
                            <p class="text-sm">End Date
                                <b class="d-block">{{ Helper::dateFormatAlt($project->end_date) }}</b>
                            </p>
                            <p class="text-sm">Project Status
                                <b class="d-block">
                                    <span class="badge badge-{{ $alert }}">{{ $project->status }}</span>
                                </b>
                            </p>
                            <p class="text-sm">Project Manager
                                <b class="d-block">{{ $project->manager->name }}</b>
                            </p>
                        </div>
                        <h5 class="mt-5 text-muted">Team Members</h5>
                        <ul class="list-unstyled">
                            @forelse($project->team as $key => $value)
                                <li class="mb-2">
                                    <a href="" class="btn-link text-secondary">
                                        <img style="border-radius: 50%;" width="30" height="30" alt="Avatar" class="table-avatar " src="{{ asset('asset') }}/dist/img/avatar.png">
                                        &nbsp; {{ $value->name }}
                                    </a>
                                </li>
                            @empty
                                <li>
                                    No member added
                                </li>
                            @endforelse
                        </ul>
                        <div class=" mt-5 mb-3">
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-danger">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
