@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.show', $department->id) }}">{{ $department->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Delete</li>
@endsection

@section('title', $department->name)
@section('heading', $department->name)

@section('primary_menu')
    @include('human_resource.department.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        <p class="lead">Are you sure you want to delete "{{ $department->name }}"?</p>
        <form action="{{ route('departments.destroy', $department->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <button class="btn btn-danger">Delete User</button>
            <a class="btn btn-link text-decoration-none text-secondary" href="{{ route('departments.index') }}">Cancel</a>
        </form>

    </div>
@endsection
