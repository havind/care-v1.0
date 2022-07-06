@extends('admin.layouts.app')

@section('ib-header-actions')
    <li class="list-inline-item">
        <a class="ib-btn ib-btn-primary" aria-current="page" href="{{ route('a.human-resources.departments.create') }}">
            <span class="material-icons">add</span>
            <span>New</span>
        </a>
    </li>
@endsection

@section('ib-content-body')

    <div id="no-departments" class="position-absolute w-50 d-flex invisible mx-3 mt-3">
        <div class="alert alert-primary flex-fill" role="alert">
            <span class="material-icons">info</span>
            No Departments found, please <a class="fw-bold fst-italic" href="{{ route('a.human-resources.departments.create') }}">add a new Department</a>
        </div>
    </div>

    <div id="departments-available" class="invisible">
        <div id="departments-filters" class="my-1 ms-3 row">
            <div class="col">
                <label for=""></label>
            </div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
        </div>


        <div id="departments"></div>

        <div class="d-flex justify-content-center align-items-center" id="ib-loading">
            <h1 class="display-6">
                <img style="width: 53px; height: 53px;" src="{{ asset('svg/loading.svg') }}">
                <span style="">departments will be loaded Soon.</span>
            </h1>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.human_resource.departments.js.index')
@endsection

