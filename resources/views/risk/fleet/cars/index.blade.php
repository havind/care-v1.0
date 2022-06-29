@inject('ibFunctions', 'App\Http\Controllers\ibFunctions')
@extends('layouts.app')

@section('title', 'Fleet')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fleet') }}">Fleet</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cars</li>
        </ol>
    </nav>
@endsection

@section('heading')
    <h1>Cars</h1>
@endsection

@section('primary_menu')
    @include('risk.fleet.primary_menu')
@endsection

@section('content')
    <div class="container">
        <a class="btn btn-outline-primary mb-3" href="{{ route('cars.create') }}">
            <i class="bi bi-plus-square"></i> Add Car
        </a>

        @if(empty(count($cars)))
            <div class="alert alert-info align-items-center m-3" role="alert">
                <i class="bi bi-exclamation-diamond"></i> No Cars have been added.
            </div>
        @else
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr class="text-center">
                    <th class="align-middle">#</th>
                    <th class="align-middle">Name</th>
                    <th class="align-middle">Driver Name</th>
                    <th class="align-middle">Make</th>
                    <th class="align-middle">Model</th>
                    <th class="align-middle">Year</th>
                    <th class="align-middle">VIN</th>
                    <th class="align-middle">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cars as $car)
                    <tr>
                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                        <td>{{ $car->name }}</td>
                        <td>
                            @foreach($drivers as $driver)
                                @if( $driver->id == $car->driver_id )
                                    {{ $driver->first_name }} {{ $driver->last_name }}
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($car_brands as $car_brand)
                                @if ($car_brand->id == $car->make )
                                    {{ $car_brand->name }}
                                @endif
                            @endforeach
                        </td>
                        <td>{{ $car->model }}</td>
                        <td class="align-middle text-center">{{ $car->year }}</td>
                        <td>{{ $car->vin }}</td>
                        <td class="align-middle text-center">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a href="{{ route('cars.show', $car->id) }}">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="{{ route('cars.edit', $car->id) }}">
                                        <i class="bi bi-pencil-square text-info"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="{{ route('cars.delete', $car->id) }}">
                                        <i class="bi bi-x-square text-danger"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

@section('footnote')
    <hr/>
    <table>
        <tr>
            <td class="text-center"><small><strong>VIN</strong></small></td>
            <td><small>Vehicle identification number</small></td>
        </tr>
        <tr>
            <td class="text-center"><small><i class="bi bi-eye" style="color: #0d6efd;"></i></small></td>
            <td><small>Preview</small></td>
        </tr>
        <tr>
            <td class="text-center"><small><i class="bi bi-pencil-square text-info"></i></small></td>
            <td><small>Edit</small></td>
        </tr>
        <tr>
            <td class="text-center"><small><i class="bi bi-x-square text-danger"></i></small></td>
            <td><small>Delete</small></td>
        </tr>
    </table>
@endsection
