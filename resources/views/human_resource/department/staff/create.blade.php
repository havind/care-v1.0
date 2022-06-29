@extends('layouts.app')

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
            <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
            <li class="breadcrumb-item"><a href="{{ route('departments.show', $department->id) }}">{{ $department->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Staff</li>
@endsection

@section('title', 'Add new staff to ' . $department->name)
@section('heading', 'Add new staff to ' . $department->name)

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('staff.store') }}">
            @csrf
            <h4>Full Name</h4>
            <div class="mb-3 row">
                <label for="first-name" class="col-sm-2 col-form-label">First name</label>
                <div class="col-sm-5">
                    <input class="form-control" id="first-name" name="first-name" placeholder="First name" type="text">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="last-name" class="col-sm-2 col-form-label">Last name</label>
                <div class="col-sm-5">
                    <input class="form-control" id="last-name" name="last-name" placeholder="Last name" type="text">
                </div>
            </div>
            <h4>Contact Information</h4>
            <h6>Work</h6>
            <div class="mb-3 row">
                <label for="care-email" class="col-sm-2 col-form-label">CARE Email</label>
                <div class="col-sm-5">
                    <input class="form-control" id="care-email" name="care-email" placeholder="CARE Email" type="text">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="care-phone" class="col-sm-2 col-form-label">CARE Phone</label>
                <div class="col-sm-5">
                    <input class="form-control" id="care-phone" name="care-phone" placeholder="CARE Phone" type="text">
                </div>
            </div>

            <h6>Personal</h6>
            <div class="mb-3 row">
                <label for="personal-email" class="col-sm-2 col-form-label">Personal Email</label>
                <div class="col-sm-5">
                    <input class="form-control" id="personal-email" name="personal-email" placeholder="Personal Email" type="text">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="personal-phone" class="col-sm-2 col-form-label">Phone number</label>
                <div class="col-sm-5">
                    <input class="form-control" id="personal-phone" name="personal-phone" placeholder="Personal Phone" type="text">
                </div>
            </div>
            <h4>Department</h4>
            <div class="mb-3 row">
                <label for="department" class="col-sm-2 col-form-label">Department</label>
                <div class="col-sm-5">
                    <select class="form-select" id="department" name="department">
                        <input type="">
                        @foreach($departments as $departmentum)
                            @if ($department->id == $departmentum->id)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @else
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Position</label>
                <div class="col-sm-5">
                    <select class="form-select" id="position" name="position" disabled>
                        <option value="0" selected>-- SELECT --</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="offset-2 col-sm-10">
                    <button class="btn btn-outline-success" tabindex="6">Save</button>
                    <a class="btn btn-outline-danger" href="{{ route('departments.staff', $department->id) }}" tabindex="7">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
