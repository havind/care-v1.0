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
        </ol>
    </nav>
@endsection

@section('heading')
    <h1>{{ $car->name }}</h1>
@endsection

@section('primary_menu')
    @include('risk.fleet.cars.primary_menu')
@endsection

@section('content')
    <div class="container">
        <div class="mb-3 row">
            <label for="car-make" class="col-sm-2 col-form-label">Make</label>
            <div class="col-sm-5">
                <input type="text" readonly class="form-control-plaintext" value="{{ $make->name }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="car-model" class="col-sm-2 col-form-label">Model</label>
            <div class="col-sm-5">
                <input type="text" readonly class="form-control-plaintext" value="{{ $car->model }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="car-year" class="col-sm-2 col-form-label">Year</label>
            <div class="col-sm-5">
                <input type="text" readonly class="form-control-plaintext" value="{{ $car->year }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="car-vin" class="col-sm-2 col-form-label">Car VIN</label>
            <div class="col-sm-5">
                <input type="text" readonly class="form-control-plaintext" value="{{ $car->vin }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="car-driver" class="col-sm-2 col-form-label">Driver</label>
            <div class="col-sm-5">
                <input type="text" readonly class="form-control-plaintext" value="{{ $driver->first_name }} {{ $driver->last_name }}">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#car-year').datetimepicker({
            format: 'YYYY',
            viewMode: "years",
        });

        $("#car-year").on("dp.hide", function (e) {
            $('#year').datetimepicker('destroy');
            $('#year').datetimepicker({
                format: 'YYYY',
                viewMode: "years",
            });
        });

    </script>
@endsection
