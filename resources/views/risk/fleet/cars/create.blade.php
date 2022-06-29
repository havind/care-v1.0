@inject('ibFunctions', 'App\Http\Controllers\ibFunctions')
@extends('layouts.app')

@section('title', 'Fleet')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Cars</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
@endsection

@section('heading')
    <h1>New Car</h1>
@endsection

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('cars.store') }}" method="POST">
            @csrf

            <div class="mb-3 row">
                <label for="car-make" class="col-sm-2 col-form-label">Make</label>
                <div class="col-sm-5">
                    <select class="form-select" id="car-make" name="car-make" required tabindex="1">
                        <option value="0">-- SELECT --</option>
                        @foreach($make as $makeum)
                            <option value="{{ $makeum->id }}">{{ $makeum->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="car-model" class="col-sm-2 col-form-label">Model</label>
                <div class="col-sm-5">
                    <input class="form-control" id="car-model" name="car-model" required tabindex="2" type="text">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="car-year" class="col-sm-2 col-form-label">Year</label>
                <div class="col-sm-5">
                    <input class="form-control" id="car-year" max="{{ date('Y') + 1 }}" min="{{ date('Y') - 10 }}" name="car-year" required tabindex="3" type="number">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="car-vin" class="col-sm-2 col-form-label">Car VIN</label>
                <div class="col-sm-5">
                    <input class="form-control" id="car-vin" name="car-vin" required tabindex="4" type="text">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="car-driver" class="col-sm-2 col-form-label">Driver</label>
                <div class="col-sm-5">
                    <select class="form-select" id="car-driver" name="car-driver" tabindex="5">
                        <option value="0">-- SELECT --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>
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

@section('footnote')
    <hr/>
    <table>
        <tr>
            <td class="text-center"><small><strong>VIN</strong></small></td>
            <td><small>Vehicle identification number</small></td>
        </tr>
    </table>
@endsection
