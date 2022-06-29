@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.show', $department->id) }}">{{ $department->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Positions</li>
@endsection

@section('title', 'Positions of ' . $department->name)
@section('heading', 'Positions of ' . $department->name)

@section('primary_menu')
    @include('human_resource.department.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        <a class="btn btn-primary mb-3" href="{{ route('departments.positions.create', $department->id) }}">
            <i class="bi bi-plus-square"></i> Add new positions
        </a>

        @if(empty(count($positions)))
            <div class="alert alert-warning align-items-center m-3" role="alert">
                <i class="bi bi-exclamation-square-fill"></i> This Department does not have any positions.
            </div>
        @else
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr class="text-center">
                    <td class="align-middle">#</td>
                    <td class="align-middle">Position name</td>
                    <td class="align-middle">Description</td>
                    <td class="align-middle">Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($positions as $position)
                    <tr>
                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <a href="{{ route('departments.positions.show', [$department->id, $position->id]) }}">{{ $position->name }}</a>
                        </td>
                        <td class="align-middle text-center">
                            {{(!empty($position->description)) ? $position->description : 'Not Available' }}
                        </td>
                        <td class="align-middle text-center">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a class="text-info" href="{{ route('departments.positions.edit', [$department->id, $position->id]) }}">
                                        <span class="material-icons text-info">mode_edit</span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-danger" href="{{ route('departments.positions.delete', [$department->id, $position->id]) }}">
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
            <td><small><span class="material-icons text-info">mode_edit</span></small></td>
            <td><small>Edit</small></td>
        </tr>
        <tr>
            <td><small><span class="material-icons text-danger">delete</span></small></td>
            <td><small>Delete</small></td>
        </tr>
    </table>
@endsection
