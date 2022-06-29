@extends('layouts.app')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
            <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
            <li class="breadcrumb-item"><a href="{{ route('departments.show', $department->id) }}">{{ $department->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Staff</li>
        </ol>
    </nav>
@endsection


@section('heading')
    <h1>{{ $department->name }} Staff</h1>
@endsection

@section('primary_menu')
    @include('human_resource.department.primary_menu')
@endsection

@section('content')
    <div class="container">
        <a class="btn btn-outline-primary mb-3" href="{{ route('staff.create') }}"><i class="bi bi-plus-square"></i> Add new Staff</a>
        @if(empty(count($staff)))
            <div class="alert alert-warning align-items-center m-3" role="alert">
                <i class="bi bi-exclamation-square-fill"></i> You have not submitted any Movement Requests.
            </div>
        @else
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr class="text-center">
                    <td class="align-middle">#</td>
                    <td class="align-middle">Full name</td>
                    <td class="align-middle">Position</td>
                    <td class="align-middle">E-mail</td>
                    <td class="align-middle">Phone Number</td>
                    <td class="align-middle">Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($staff as $_staff)
                    <tr>
                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <a href="{{ route('staff.show', $_staff->id) }}">{{ $_staff->first_name }} {{ $_staff->last_name }}</a>
                        </td>
                        <td class="align-middle">
                            @foreach($positions as $position)
                                @if($position->id == $_staff->position_id)
                                    <a href="{{ route('departments.positions.show', [$department->id, $position->id]) }}">{{ $position->name }}</a>
                                @endif
                            @endforeach
                        </td>
                        <td class="align-middle">
                            @if(!empty($_staff->work_email))
                                {{ $_staff->work_email }}
                            @else
                                Not Available
                            @endif
                        </td>
                        <td class="align-middle">
                            @if(!empty($_staff->work_phone))
                                {{ $_staff->work_phone }}
                            @else
                                Not Available
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            <a class="text-info" href="{{ route('staff.edit', $_staff->id) }}"><i class="bi bi-pencil-square"></i> edit</a>
                            &nbsp;
                            <a class="text-danger" href="{{ route('staff.delete', $_staff->id) }}"><i class="bi bi-x-square"></i> delete</a>
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
            <td class="text-center m-5"><small><i class="bi bi-pencil-square text-info"></i></small></td>
            <td><small>Edit</small></td>
        </tr>
        <tr>
            <td class="text-center"><small><i class="bi bi-x-square text-danger"></i></small></td>
            <td><small>Delete</small></td>
        </tr>
    </table>
@endsection
