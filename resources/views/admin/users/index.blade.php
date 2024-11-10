@extends('layouts.master')
@section('title', 'Users')
@section('content')
    <section class="content">

        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Users</h3>
            </div>
            <div class="card-body p-1 table-responsive text-nowrap">
                <table class="table table-striped projects" id="myTable">
                    <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th class="text-center">
                            Role
                        </th>
                        <th>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key => $row)
                        <tr>
                            <td>
                                {{ $key+1 }}
                            </td>
                            <td>
                                {{ $row->name }}
                            </td>
                            <td>
                               {{ $row->email }}
                            </td>
                            <td class="project-state">
                                <span class="badge badge-secondary">
                                        {{ $row->role }}
                                </span>
                            </td>
                            <td class="project-actions text-right">
                                @if(!(auth()->user()->role === $row->role || $row->role === 'manager'))
                                    <a
                                        class="btn btn-primary btn-sm"
                                        href="{{ route('admin.users.update', $row->id) }}">
                                        <i class="fas fa-user-tie">
                                        </i>
                                        Make Project Manager
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </section>
@endsection
