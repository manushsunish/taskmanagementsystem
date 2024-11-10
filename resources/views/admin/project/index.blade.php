@extends('layouts.master')
@section('title', 'Projects')
@section('content')
    <section class="content">

        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Projects</h3>
                <div class="card-tools">
                    <a
                        href="{{ route('admin.projects.create') }}"
                        class="btn btn-sm btn-default btn-flat text-dark">
                        <i class="fas fa-plus"></i>
                        Add Project
                    </a>
                </div>
            </div>
            <div class="card-body p-1 table-responsive text-nowrap">
                <table class="table table-striped projects" id="myTable">
                    <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Project Name
                        </th>
                        <th>
                            Team Members
                        </th>
                        <th>
                            Start Date
                        </th>
                        <th>
                            End Date
                        </th>
{{--                        <th>--}}
{{--                            Project Progress--}}
{{--                        </th>--}}
                        <th class="text-center">
                            Status
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $key => $row)
                            <tr>
                                <td>
                                    {{ $key+1 }}
                                </td>
                                <td>
                                    <a>
                                        {{ $row->name }}
                                    </a>
                                    <br>
                                    <small>
                                        Created {{ Helper::dateFormatAlt($row->created_at) }}
                                    </small>
                                </td>
                                <td>
                                    <ul class="list-inline">
                                        @if(count($row->team) > 0)
                                            @foreach($row->team as $team)
                                                <li class="list-inline-item text-center">
                                                    <img alt="Avatar" class="table-avatar" src="{{ asset('asset') }}/dist/img/avatar.png"><br>
                                                    <small>{{ $team->name }}</small>
                                                </li>
                                            @endforeach
                                        @else
                                            <small>Team member not added yet</small>
                                        @endif
                                    </ul>
                                </td>
                                <td>
                                    {{ Helper::dateFormatAlt($row->start_date) }}
                                </td>
                                <td>
                                    {{ Helper::dateFormatAlt($row->end_date) }}
                                </td>
{{--                                <td class="project_progress">--}}
{{--                                    <div class="progress progress-sm">--}}
{{--                                        <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <small>--}}
{{--                                        57% Complete--}}
{{--                                    </small>--}}
{{--                                </td>--}}
                                <td class="project-state">
                                    @php
                                    $alert = "";
                                    if ($row->status == 'pending') {
                                      $alert = "warning";
                                    }elseif ($row->status == 'in-progress') {
                                      $alert = "info";
                                    }else {
                                      $alert = "success";
                                    }
                                    @endphp
                                    <span class="badge badge-{{ $alert }}">
                                        {{ $row->status }}
                                    </span>
                                </td>
                                <td class="project-actions text-right">
                                    <a
                                        class="btn btn-primary btn-sm"
                                        href="{{ route('admin.projects.show', $row->id) }}">
                                        <i class="fas fa-folder">
                                        </i>
                                        View
                                    </a>
                                    <a
                                        class="btn btn-info btn-sm"
                                        href="{{ route('admin.projects.edit', $row->id) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-trash">
                                        </i>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </section>
@endsection
