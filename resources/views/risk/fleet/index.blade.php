@inject('ibFunctions', 'App\Http\Controllers\ibFunctions')
@extends('layouts.app')

@section('title', 'Fleet')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Fleet</li>
        </ol>
    </nav>
@endsection

@section('heading')
    <h1>Fleet</h1>
@endsection

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 g-4">
            {{--            @if($ibFunctions::check_permission(''))--}}
            <div class="col">
                <div class="card">
                    <a class="card-link" href="{{ route('fleet.movements-schedule') }}">
                        <div class="card-body">
                            Movements Schedule
                        </div>
                    </a>
                </div>
            </div>
            {{--            @endif--}}
            {{--            @if($ibFunctions::check_permission(''))--}}
            <div class="col">
                <div class="card">
                    <a class="card-link" href="{{ route('fleet.assign-movements') }}">
                        <div class="card-body">
                            Assign Movements
                        </div>
                    </a>
                </div>
            </div>
            {{--            @endif--}}
            @if($ibFunctions::check_permission('risk_fleet_car_index'))
                <div class="col">
                    <div class="card">
                        <a class="card-link" href="{{ route('cars.index') }}">
                            <div class="card-body">
                                Cars
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
