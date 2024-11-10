@extends('layouts.master')
@section('title', 'Tasks')
@section('content')
    <section class="content">

        <div class="card card-secondary">
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
                        <th>Project</th>
                        <th>Assigned</th>
                        <th class="text-center">Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tasks as $index => $row)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $row->task }}</td>
                            <td>{{ $row->description }}</td>
                            <td>{{ $row->project->name }}</td>
                            <td>{{ $row->staff->name }}</td>
                            <td class="project-state">
                                <span class="badge badge-secondary">{{ $row->status }}</span>
                            </td>
                            <td class="project-actions text-right">
                                <a
                                    class="btn btn-info btn-sm"
                                    href="{{ route('admin.tasks.edit', $row->id) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form style="display: contents;"  action="{{ route('admin.tasks.destroy', $row->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i></button>
                                </form>
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

    </section>
@endsection
