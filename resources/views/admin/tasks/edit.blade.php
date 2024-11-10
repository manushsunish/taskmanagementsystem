@extends('layouts.master')
@section('title', 'Update Task')
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
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-secondary">
                                    <div class="card-header">
                                        <h3 class="card-title">Update Task</h3>
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
                                        action="{{ route('admin.tasks.update', $task->id) }}"
                                        method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    <label for="inputName">Task</label>
                                                    <input
                                                        type="text"
                                                        id="inputName"
                                                        value="{{ $task->task }}"
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
                                                        name="description">{{ $task->description }}</textarea>
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
                                                            <option value="{{ $item }}" {{ $item === $task->status ? 'selected' : '' }}>
                                                                {{ $item }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="inputProjectLeader">Assign To</label>
                                                    <select
                                                        name="staff" id=""
                                                        class="form-control custom-select"
                                                        required>
                                                        <option selected="" disabled="">Select one</option>
                                                        @foreach($project->team as $key => $value)
                                                            <option
                                                                value="{{ $value->id }}"
                                                                {{ $value->id == $task->staff_id ? 'selected' : '' }}>
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-secondary btn-sm btn-flat float-right">Save Changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
