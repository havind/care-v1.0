@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
    <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
    <li class="breadcrumb-item active" aria-current="page">New department</li>
@endsection

@section('title', 'New department')
@section('heading', 'New department')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('departments.store') }}">
            @csrf
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="department-name">Name</label>
                <div class="col-sm-5">
                    <input class="form-control" id="department-name" name="department-name" type="text">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="department-supervisor">Supervisor</label>
                <div class="col-sm-5">
                    <select class="form-select" id="department-supervisor" name="department-supervisor">
                        <option value="0">-- SELECT --</option>
                        @foreach($users as $user)

                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="department-description">Description</label>
                <div class="col-sm-5">
                    <textarea class="form-control" id="department-description" name="department-description" rows="3"></textarea>
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
