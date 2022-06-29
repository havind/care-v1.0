@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.show', $department->id) }}">{{ $department->name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.positions.index', $department->id) }}">Positions</a></li>
    <li class="breadcrumb-item active" aria-current="page">New position</li>
@endsection

@section('title', 'New positions')
@section('heading', 'New positions')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('departments.positions.store', [$department->id]) }}">
            @csrf
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="positions-name">Name</label>
                <div class="col-sm-5">
                    <input class="form-control" id="positions-name" name="positions-name" type="text">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="positions-description">Description</label>
                <div class="col-sm-5">
                    <textarea class="form-control" id="positions-description" name="positions-description" rows="3"></textarea>
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
