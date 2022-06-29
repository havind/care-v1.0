@extends('admin.layouts.app')

@section('header-actions')
    <li class="list-inline-item">
        <a class="ib-btn ib-btn-primary" aria-current="page" href="{{ route('a.departments.create') }}">
            <span class="material-icons">add</span>
            <span>New</span>
        </a>
    </li>
@endsection

@section('page-quick-links')
    <ul class="nav justify-content-end">
        <li class="nav-item">

        </li>
        <li class="nav-item dropdown">
            <a aria-current="page" class="nav-link btn btn-sm no-focus secondary" data-bs-toggle="dropdown" href="javascript:void(0)">
                <span class="material-icons">more_horiz</span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </li>


        {{--    Last Item --}}
        <li class="nav-item">
            <a class="nav-link btn btn-sm page-tips">
                <span class="material-icons">tips_and_updates</span> Page Tips
            </a>
        </li>
    </ul>
@endsection

@section('content')
    @if(empty(count($departments)))
        <div class="alert alert-warning align-items-center m-3" role="alert">
            <i class="bi bi-exclamation-square-fill"></i> You have not submitted any Movement Requests.
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
                        <a href="{{ route('a.departments.show', $department->dp_id) }}">{{ $department->dp_title }}</a>
                    </td>
                    <td class="align-middle">
                        <a href="{{ route('a.users.show', $department->dp_supervisor_id) }}">{{ $department->dp_supervisor_first_name }} {{ $department->dp_supervisor_last_name }}</a>
                    </td>
                    <td class="align-middle text-center" style="width: 5%;">
                        <a class="text-info" href="{{ route('a.departments.edit', $department->dp_id) }}">
                            <span class="material-icons text-info">mode_edit</span>
                        </a>
                        &nbsp;
                        <a class="text-danger" href="{{ route('a.departments.delete', $department->dp_id) }}">
                            <span class="material-icons text-danger">delete</span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection

@section('scripts')
    @include('admin.human_resource.department.js.index')
@endsection

