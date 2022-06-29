@inject('ibFunctions', 'App\Http\Controllers\ibFunctions')
@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    @authCheck('risk_index')
    <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
    @else
        <li class="breadcrumb-item active">Risk</li>
    @endif
    @authCheck('risk_movementRequest_index')
    <li class="breadcrumb-item"><a href="{{ route('movement-requests.index') }}">Movement Requests</a></li>
    @else
        <li class="breadcrumb-item active">Movement Requests</li>
    @endif
    <li class="breadcrumb-item active" aria-current="page">Approvals</li>
@endsection

@section('title', 'Approvals')
@section('heading', 'Movement Request Approvals')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        @authCheck('risk_movementRequest_approvals')

        {{--
          -- Country Director
          --}}
        @authCheck('risk_movementRequest_approvals_cd')
        <h4>Approving as Country Director approver:</h4>
        @if ($movements_cd != null)
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr class="align-middle text-center">
                    <td>#</td>
                    <td style="width: 20%;">Movement Request #</td>
                    <td style="width: 15%;">Submitted on</td>
                    <td>Requester Name</td>
                    <td>Passengers</td>
                    <td>Itinerary</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($movements_cd as $movement_cd)
                    <tr>
                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <a href="{{ route('approvals.show', [$movement_cd->id, 'level' => 'cd']) }}">{{ $movement_cd->name }}</a>
                        </td>
                        <td class="align-middle text-center">
                            {{ date('h:ia, d-m-Y', strtotime($movement_cd->created_at)) }}
                        </td>
                        <td class="align-middle">
                            <a href="{{ route('staff.show', $movement_cd->requester_id) }}">{{ $movement_cd->requester_first_name . ' ' . $movement_cd->requester_last_name }}</a>
                        </td>
                        <td class="align-middle">
                            <ul class="list-unstyled mb-0">
                                @foreach($passengers_cd as $passenger_cd)
                                    @if ($passenger_cd->mr_id == $movement_cd->id)
                                        <li>
                                            <a href="{{ route('staff.show', $passenger_cd->passenger_id) }}">{{ $passenger_cd->passenger_first_name . ' ' . $passenger_cd->passenger_last_name }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                        <td class="align-middle">
                            <ul class="list-unstyled mb-0">
                                @foreach($itineraries_cd as $itinerary_cd)
                                    @if ($itinerary_cd->mr_id == $movement_cd->id)
                                        <li>
                                            {{ $itinerary_cd->from_location }}
                                            <span class="material-icons">arrow_forward</span>
                                            {{ $itinerary_cd->to_location }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-success" role="alert">
                No requests available for approval.
            </div>
        @endif
        @endif

        {{--
          -- Risk
          --}}
        @authCheck('risk_movementRequest_approvals_risk')
        <h4>Approving as Risk approver:</h4>
        @if ($movements_risk != null)
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr class="align-middle text-center">
                    <td>#</td>
                    <td style="width: 20%;">Movement Request #</td>
                    <td style="width: 15%;">Submitted on</td>
                    <td>Requester Name</td>
                    <td>Passengers</td>
                    <td>Itinerary</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($movements_risk as $movement_risk)
                    <tr>
                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <a href="{{ route('approvals.show', [$movement_risk->id, 'level' => 'risk']) }}">{{ $movement_risk->name }}</a>
                        </td>
                        <td class="align-middle text-center">
                            {{ date('h:ia, d-m-Y', strtotime($movement_risk->created_at)) }}
                        </td>
                        <td class="align-middle">
                            <a href="{{ route('staff.show', $movement_risk->requester_id) }}">{{ $movement_risk->requester_first_name . ' ' . $movement_risk->requester_last_name }}</a>
                        </td>
                        <td class="align-middle">
                            <ul class="list-unstyled mb-0">
                                @foreach($passengers_risk as $passenger_risk)
                                    @if ($passenger_risk->mr_id == $movement_risk->id)
                                        <li>
                                            <a href="{{ route('staff.show', $passenger_risk->passenger_id) }}">{{ $passenger_risk->passenger_first_name . ' ' . $passenger_risk->passenger_last_name }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                        <td class="align-middle">
                            <ul class="list-unstyled mb-0">
                                @foreach($itineraries_risk as $itinerary_risk)
                                    @if ($itinerary_risk->mr_id == $movement_risk->id)
                                        <li>
                                            {{ $itinerary_risk->from_location }}
                                            <span class="material-icons">arrow_forward</span>
                                            {{ $itinerary_risk->to_location }}
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-success" role="alert">
                No requests available for approval.
            </div>
        @endif
        @endif

        {{--
          -- Line Manager
          --}}
        @authCheck('risk_movementRequest_approvals_lm')
        <h4>Approving as Supervisor approver:</h4>
        @if ($movements_line_manager != null)
        <table class="table table-sm table-bordered table-hover">
            <thead>
            <tr class="align-middle text-center">
                <td>#</td>
                <td style="width: 20%;">Movement Request #</td>
                <td style="width: 15%;">Submitted on</td>
                <td>Requester Name</td>
                <td>Passengers</td>
                <td>Itinerary</td>
            </tr>
            </thead>
            <tbody>
            @foreach ($movements_line_manager as $movement_line_manager)
                <tr>
                    <td class="align-middle text-center">{{ $loop->iteration }}</td>
                    <td class="align-middle">
                        <a href="{{ route('approvals.show', [$movement_line_manager->id, 'level' => 'lm']) }}">{{ $movement_line_manager->name }}</a>
                    </td>
                    <td class="align-middle text-center">
                        {{ date('h:ia, d-m-Y', strtotime($movement_line_manager->created_at)) }}
                    </td>
                    <td class="align-middle">
                        <a href="{{ route('staff.show', $movement_line_manager->requester_id) }}">{{ $movement_line_manager->requester_first_name . ' ' . $movement_line_manager->requester_last_name }}</a>
                    </td>
                    <td class="align-middle">
                        <ul class="list-unstyled mb-0">
                            @foreach($passengers_line_manager as $passenger_line_manager)
                                @if ($passenger_line_manager->mr_id == $movement_line_manager->id)
                                    <li>
                                        <a href="{{ route('staff.show', $passenger_line_manager->passenger_id) }}">{{ $passenger_line_manager->passenger_first_name . ' ' . $passenger_line_manager->passenger_last_name }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </td>
                    <td class="align-middle">
                        <ul class="list-unstyled mb-0">
                            @foreach($itineraries_line_manager as $itinerary_line_manager)
                                @if ($itinerary_line_manager->mr_id == $movement_line_manager->id)
                                    <li>
                                        {{ $itinerary_line_manager->from_location }}
                                        <span class="material-icons">arrow_forward</span>
                                        {{ $itinerary_line_manager->to_location }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
            <div class="alert alert-success" role="alert">
                No requests available for approval.
            </div>
        @endif
        @endif
        @endif

    </div>
@endsection
