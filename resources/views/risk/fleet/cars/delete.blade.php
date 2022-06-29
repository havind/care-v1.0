@extends('layouts.app')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Cars</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cars.show', $car->id) }}">{{ $car->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete</li>
        </ol>
    </nav>
@endsection

@section('title', 'Delete ' . $car->name)

@section('heading')
    <h1>Delete {{ $car->name }}</h1>
@endsection

@section('primary_menu')
    @include('risk.fleet.cars.primary_menu')
@endsection

@section('content')
    <div class="container">
        <p class="lead">Are you sure you want to delete "{{ $car->name }}"?</p>
        <form method="POST" action="{{ route('cars.destroy', $car->id) }}">
            @method('DELETE')
            @csrf
            <div class="mb-2 row">
                <div class="offset-0">
                    <button class="col-2 btn btn-secondary">Delete Car</button>
                    <a class="col-1 btn btn-outline-danger" href="{{ route('cars.show', $car->id) }}">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
