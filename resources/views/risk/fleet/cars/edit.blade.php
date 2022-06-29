@inject('ibFunctions', 'App\Http\Controllers\ibFunctions')
@extends('layouts.app')

@section('title', 'Fleet')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Cars</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $car->name }}</li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('heading')
    <h1>Edit {{ $car->name }}</h1>
@endsection

@section('primary_menu')
    @include('risk.fleet.cars.primary_menu')
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('cars.update', $car->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mb-3 row">
                <label for="car-make" class="col-sm-2 col-form-label">Driver</label>
                <div class="col-sm-5">
                    <select class="form-select" id="car-make" name="car-make">
                        @if ($car->driver_id != 0)
                            <option value="0">-- SELECT --</option>
                            @foreach($users as $user)
                                @if ($user->id == $car->driver_id)
                                    <option value="{{ $user->id }}" selected>{{ $user->first_name }} {{ $user->last_name }}</option>
                                @else
                                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                @endif
                            @endforeach
                        @else
                            <option value="0" selected>-- SELECT --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="car-make" class="col-sm-2 col-form-label">Make</label>
                <div class="col-sm-5">
                    <select class="form-select" id="car-make" name="car-make">
                        <option value="0">-- SELECT --</option>
                        @foreach($make as $makeum)
                            {{$makeum->id }}
                            {{$car->make}}
                            @if ($makeum->id == $car->make)
                                <option value="{{ $makeum->id }}" selected>{{ $makeum->name }}</option>
                            @else
                                <option value="{{ $makeum->id }}">{{ $makeum->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="car-model" class="col-sm-2 col-form-label">Model</label>
                <div class="col-sm-5">
                    <input class="form-control" id="car-model" name="car-model" type="text" value="{{ $car->model }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="car-year" class="col-sm-2 col-form-label">Year</label>
                <div class="col-sm-5">
                    <input class="form-control" id="car-year" max="{{ date('Y') + 1 }}" min="2010" name="car-year" type="number" value="{{ $car->year }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="car-vin" class="col-sm-2 col-form-label">Car VIN</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="car-vin" name="car-vin" value="{{ $car->vin }}">
                </div>
            </div>

            <div class="mb-3 row">
                <div class="offset-2 col-sm-10">
                    <button class="btn btn-outline-success">Update</button>
                    <a class="btn btn-outline-danger" href="{{ route('cars.index') }}">Cancel</a>
                </div>
            </div>
        </form>


    </div>
@endsection
