@extends('layouts.app')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Cars</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cars.show', $location->id) }}">{{ $location->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete</li>
        </ol>
    </nav>
@endsection


@section('heading')
    <h1>Delete {{ $location->name }}</h1>
@endsection

@section('primary_menu')
    @include('risk.location.primary_menu')
@endsection

@section('content')
    <div class="container">
        <p class="lead">Are you sure you want to delete "{{ $location->name }}"?</p>
        <form method="POST" action="{{ route('locations.update', $location->id) }}">
            @method('DELETE')
            @csrf
            <div class="mb-2 row">
                <div class="offset-0">
                    <button class="col-2 btn btn-outline-secondary">Delete Location</button>
                    <a class="col-1 btn btn-outline-danger" href="{{ route('locations.index') }}">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
