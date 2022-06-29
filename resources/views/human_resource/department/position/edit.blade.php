@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.show', $department->id) }}">{{ $department->name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.positions.index', $department->id) }}">Positions</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $position->name }}</li>
@endsection

@section('title', $position->name)
@section('heading', $position->name)

@section('primary_menu')
    @include('human_resource.department.position.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('departments.positions.update', [$department->id, $position->id]) }}">
            @method('PUT')
            @csrf
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" value="{{ $position->name }}"/>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-5">
                    <textarea class="form-control" onfocus="blur()">{{ $department->description }}</textarea>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="offset-2 col-sm-10">
                    <button class="btn btn-outline-success" tabindex="6">Save</button>
                    <a class="btn btn-outline-danger" href="{{ route('cars.index') }}" tabindex="7">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
