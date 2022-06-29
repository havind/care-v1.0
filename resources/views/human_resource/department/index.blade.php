@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
    <li class="breadcrumb-item active" aria-current="page">Departments</li>
@endsection

@section('title', 'Departments')
@section('heading', 'Departments')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <a class="btn btn-primary mb-3" href="{{ route('departments.create') }}">
            <span class="material-icons">add_box</span> Add Department
        </a>

        @if(empty(count($departments)))
            <div class="alert alert-warning align-items-center m-3" role="alert">
                <span class="material-icons">warning</span> You have not submitted any Movement Requests.
            </div>
        @else
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr class="text-center">
                    <td class="align-middle">#</td>
                    <td class="align-middle">Department name</td>
                    <td class="align-middle">Supervisor</td>
                    <td class="align-middle">Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($departments as $department)
                    <tr>
                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <a href="{{ route('departments.show', $department->id) }}">{{ $department->name }}</a>
                        </td>
                        <td class="align-middle">
                            @foreach($supervisors as $supervisor)
                                @if( $supervisor->id == $department->supervisor_id)
                                    <a href="{{ route('staff.show', $supervisor->id) }}">{{ $supervisor->first_name }} {{ $supervisor->last_name }}</a>
                                @endif
                            @endforeach
                        </td>
                        <td class="align-middle text-center">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a class="text-primary" href="{{ route('departments.staff', $department->id) }}">
                                        <span class="material-icons">group</span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-primary" href="{{ route('departments.positions.index', $department->id) }}">
                                        <span class="material-icons">work_outline</span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-info" href="{{ route('departments.edit', $department->id) }}">
                                        <span class="material-icons text-info">mode_edit</span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-danger" href="{{ route('departments.delete', $department->id) }}">
                                        <span class="material-icons text-danger">delete</span>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

@section('footnote')
    <hr/>
    <table>
        <tr>
            <td>
                <small><span class="material-icons">group</span></small>
            </td>
            <td><small>Staff</small></td>
        </tr>
        <tr>
            <td>
                <small><span class="material-icons">work_outline</span></small>
            </td>
            <td><small>Positions</small></td>
        </tr>
        <tr>
            <td><small><span class="material-icons text-info">mode_edit</span></small></td>
            <td><small>Edit</small></td>
        </tr>
        <tr>
            <td><small><span class="material-icons text-danger">delete</span></small></td>
            <td><small>Delete</small></td>
        </tr>
    </table>
@endsection

