@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Risk</li>
@endsection


@section('title', 'Risk')
@section('heading', 'Risk')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3">
            @authCheck('risk_movementRequest_index')
            @include('layouts.partials.card', [
		      'link' => 'movement-requests.index',
		      'title' => 'All Movement Requests',
		      'title_small' => 'AM',
		      ])
            @endif
            @authCheck('risk_movementRequest_approvals')
            @include('layouts.partials.card', [
		      'link' => 'approvals.index',
		      'title' => 'Movement Request Approvals',
		      'title_small' => 'MA',
		      ])
            @endif
            @authCheck('risk_fleet_index')
            @include('layouts.partials.card', [
		      'link' => 'fleet',
		      'title' => 'Fleet',
		      'title_small' => 'F',
		      ])
            @endif
            @authCheck('risk_location_index')
            @include('layouts.partials.card', [
		      'link' => 'locations.index',
		      'title' => 'Locations',
		      'title_small' => 'L',
		      ])
            @endif
        </div>
    </div>
@endsection
