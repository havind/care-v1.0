@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.show', $department->id) }}">{{ $department->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('title', 'Edit ' . $department->name )
@section('heading', 'Edit ' . $department->name )

@section('primary_menu')
    @include('human_resource.department.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('departments.update', $department->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mb-3 row">
                <label for="dept-name" class="col-sm-2 col-form-label">Department name</label>
                <div class="col-sm-5">
                    <input class="form-control" id="dept-name" name="dept-name" value="{{ $department->name }}"/>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="dept-supervisor" class="col-sm-2 col-form-label">Supervisor</label>
                <div class="col-sm-5">
                    <select class="form-select" id="dept-supervisor" name="dept-supervisor">
                        <option value="0" {{ ($department->supervisor_id == 0) ? ' selected' : '' }}>-- SELECT --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ ($user->id == $department->supervisor_id) ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="dept-description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-5">
                    <textarea class="form-control" id="dept-description" name="dept-description" rows="3"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-success offset-2">Update</button>
            <a class="btn btn-link text-decoration-none text-secondary" href="{{ route('departments.index') }}">Cancel</a>
        </form>
    </div>
@endsection
