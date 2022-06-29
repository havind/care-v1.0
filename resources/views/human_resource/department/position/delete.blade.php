@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.show', $department->id) }}">{{ $department->name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.positions.index', $department->id) }}">Positions</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $position->name }}</li>
    <li class="breadcrumb-item active" aria-current="page">Delete</li>
@endsection

@section('title', $position->name)
@section('heading', $position->name)

@section('primary_menu')
    @include('human_resource.department.position.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        <p class="lead">Are you sure you want to delete "{{ $position->name }}"?</p>
        <form action="{{ route('departments.positions.destroy', [$department->id, $position->id]) }}" method="POST">
            @method('DELETE')
            @csrf
            <input type="hidden" id="is-delete" name="is-delete" value="1">
            <button class="btn btn-outline-danger">Delete Position</button>
        </form>

    </div>
@endsection
