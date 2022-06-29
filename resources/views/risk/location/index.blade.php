@inject('ibFunctions', 'App\Http\Controllers\ibFunctions')
@extends('layouts.app')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Locations</li>
        </ol>
    </nav>
@endsection

@section('title', 'Locations')

@section('heading')
    <h1>Locations</h1>
@endsection

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        @if($ibFunctions::check_permission('risk_location_create'))
            <a class="btn btn-outline-primary mb-3" href="{{ route('locations.create') }}">
                <i class="bi bi-plus-square"></i> Add Location
            </a>
        @endif

        @if(empty(count($locations)))
            <div class="alert alert-warning align-items-center m-3" role="alert">
                <i class="bi bi-exclamation-square-fill"></i> You have not submitted any Location.
            </div>
        @else
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr class="text-center">
                    <th class="align-middle">#</th>
                    <th class="align-middle">Location name</th>
                    <th class="align-middle">Is KRG</th>
                    <th class="align-middle" style="width: 15%;">Accommodation</th>
                    <th class="align-middle">Available</th>
                    <th class="align-middle" style="width: 10%;">Actions</th>
                </tr>
                </thead>
                <tbody>

                @foreach($locations as $location)
                    <tr>
                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $location->name }}</td>
                        <td class="align-middle text-center {{ ($location->is_krg == 1) ? ' bg-success bg-gradient' : '' }}">{{ $location->is_krg }}</td>
                        <td class="align-middle text-center {{ ($location->is_accommodation == 1) ? ' bg-success bg-gradient' : '' }}">{{ $location->is_accommodation }}</td>
                        <td class="align-middle text-center {{ ($location->is_available == 1) ? ' bg-success bg-gradient' : '' }}">{{ $location->is_available }}</td>
                        <td class="align-middle text-center">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a class="text-info" href="{{ route('locations.edit', $location->id) }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-danger" href="{{ route('locations.delete', $location->id) }}">
                                        <i class="bi bi-x-square"></i>
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
            <td class="text-center"><small><strong>Is KRG</strong></small></td>
            <td><small>Means the location is located inside KRG authorities</small></td>
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
