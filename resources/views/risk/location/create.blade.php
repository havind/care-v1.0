@inject('ibFunctions', 'App\Http\Controllers\ibFunctions')
@extends('layouts.app')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('locations.index') }}">Locations</a></li>
            <li class="breadcrumb-item active" aria-current="page">New location</li>
        </ol>
    </nav>
@endsection


@section('heading')
    <h1>New location</h1>
@endsection

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">

        @if (session('status'))
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-square"></i> {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('locations.store') }}" method="POST">
            @csrf
            <div class="mb-3 row">
                <label for="location-name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="location-name" name="location-name">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="location-is-krg" class="col-sm-2 col-form-label">Is KRG</label>
                <div class="col-sm-5">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="location-is-krg" name="location-is-krg">
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="location-is-available" class="col-sm-2 col-form-label">Is Available</label>
                <div class="col-sm-5">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="location-is-available" name="location-is-available">
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="location-is-accommodation" class="col-sm-2 col-form-label">Is Accommodation</label>
                <div class="col-sm-5">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="location-is-accommodation" name="location-is-accommodation">
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="offset-2 col-sm-10">
                    <button class="btn btn-outline-success">Save</button>
                    <a class="btn btn-outline-danger" href="{{ route('cars.index') }}">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
