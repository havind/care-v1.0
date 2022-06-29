@inject('ibFunctions', 'App\Http\Controllers\ibFunctions')
@extends('layouts.app')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('locations.index') }}">Locations</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $location->name }}</li>
        </ol>
    </nav>
@endsection


@section('heading')
    <h1>{{ $location->name }}</h1>
@endsection

@section('primary_menu')
    @include('risk.location.primary_menu')
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('locations.update', $location->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mb-3 row">
                <label for="location-name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="location-name" name="location-name" value="{{ $location->name }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="location-is-krg" class="col-sm-2 col-form-label">Is KRG</label>
                <div class="col-sm-5">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="location-is-krg" name="location-is-krg" {{ ($location->is_krg == 1 ) ? ' checked' : '' }}>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="location-is-available" class="col-sm-2 col-form-label">Is Available</label>
                <div class="col-sm-5">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="location-is-available" name="location-is-available" {{ ($location->is_available == 1 ) ? ' checked' : '' }}>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="location-is-accommodation" class="col-sm-2 col-form-label">Is Accommodation</label>
                <div class="col-sm-5">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="location-is-accommodation" name="location-is-accommodation" {{ ($location->is_accommodation == 1 ) ? ' checked' : '' }}>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="offset-2 col-sm-10">
                    <button class="btn btn-outline-success">Update</button>
                    <a class="btn btn-outline-danger" href="{{ route('locations.index') }}">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
