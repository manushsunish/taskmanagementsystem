@extends('layouts.master')
@section('title', 'Create Project')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Project Create</h3>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger mt-2">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form
                        action="{{ route('admin.projects.store') }}"
                        method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputName">Project Name</label>
                                <input type="text" id="inputName" class="form-control" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">Project Description</label>
                                <textarea id="inputDescription" class="form-control" rows="4" name="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <select
                                    id="inputStatus"
                                    class="form-control custom-select"
                                    name="status"
                                >
                                    <option selected="" disabled="">Select one</option>
                                    <option value="pending">Pending</option>
                                    <option value="in-progress">IN Progress</option>
                                    <option name="completed">Completed</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputProjectLeader">Project Leader</label>
                                <select
                                    name="project_leader" id=""
                                    class="form-control custom-select" required>
                                    <option selected="" disabled="">Select one</option>
                                    @foreach($managers as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputProjectLeader">Start Date</label>
                                        <input type="date" name="start_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputProjectLeader">End Date</label>
                                        <input type="date" name="end_date" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Add Team Members</label>
                                <div class="select2-purple">
                                    <select
                                        name="team_members[]"
                                        class="select2"
                                        multiple="multiple"
                                        data-placeholder="Select team members"
                                        data-dropdown-css-class="select2-purple"
                                        style="width: 100%;">
                                        @foreach($staffs as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12">
                                    <a href="{{ route('admin.projects.index') }}" class="btn btn-danger btn-sm btn-flat">Cancel</a>
                                    <button type="submit" class="btn btn-info btn-sm btn-flat float-right">Create new Project</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </section>
@endsection
