@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
    <li class="breadcrumb-item"><a href="{{ route('movement-requests.index') }}">Movement Requests</a></li>
    <li class="breadcrumb-item active" aria-current="page">All</li>
@endsection

@section('title', 'All Movement Requests')
@section('heading', 'All Movement Requests')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">

        {{--    Filters --}}
        <form class="row g-3">
            <div class="col-3">
                <select class="form-control border-0" id="requester-name" name="requester-name">
                    @if($requester_name == 0)
                        <option value="0" selected>-- SELECT --</option>
                    @else
                        <option value="0">-- SELECT --</option>
                    @endif
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ ($requester_name == $user->id) ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary mb-3">Filter</button>
                <a class="btn btn-outline-info mb-3" href="{{ route('movement-requests.all', ['requester-name' => 0]) }}">Reset</a>
            </div>
        </form>

        @if(empty(count($movement_requests)))
            <div class="alert alert-warning align-items-center m-3" role="alert">
                <i class="bi bi-exclamation-square-fill"></i> You have not submitted any Movement Requests.
            </div>
        @else
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr class="text-center">
                    <td class="align-middle" rowspan="2">#</td>
                    <td class="align-middle" rowspan="2">Movement Request #</td>
                    <td class="align-middle" rowspan="2">Submitted on</td>
                    <td class="align-middle" rowspan="2">Requester Name</td>
                    <td class="align-middle" rowspan="2">Passengers</td>
                    <td class="align-middle" rowspan="2">Itinerary</td>
                    <td class="align-middle" colspan="3">Approvals</td>
                </tr>
                <tr class="text-center">
                    <td class="align-middle">Line Manager</td>
                    <td class="align-middle">Risk</td>
                    <td class="align-middle">Country Director</td>
                </tr>
                </thead>
                <tbody>
                @foreach($movement_requests as $movement_request)
                    <tr>
                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <a href="{{ route('movement-requests.show', $movement_request->id) }}">{{ $movement_request->name }}</a>
                        </td>
                        <td class="align-middle text-center">
                            {{ $movement_request->created_at }}
                        </td>
                        <td class="align-middle">
                            @foreach($users as $user)
                                @if($user->id == $movement_request->requester_id)
                                    {{ $user->first_name }} {{ $user->last_name }}
                                @endif
                            @endforeach
                        </td>
                        <td class="align-middle">
                            @foreach($passengers as $passenger)
                                @if($passenger->mr_id == $movement_request->id)
                                    @foreach($users as $user)
                                        @if($user->id == $passenger->passenger_id)
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        @endif
                                    @endforeach
                                    <br/>
                                @endif
                            @endforeach
                        </td>
                        <td class="text-center">
                            @foreach($itinerary as $itinerary_item)
                                @if($movement_request->id == $itinerary_item->mr_id)
                                    @foreach($locations as $location)
                                        @if($location->id == $itinerary_item->from_location_id)
                                            {{ $location->name }}
                                        @endif
                                    @endforeach
                                    <i class="bi bi-arrow-right"></i>
                                    @foreach($locations as $location)
                                        @if($location->id == $itinerary_item->to_location_id)
                                            {{ $location->name }}
                                        @endif
                                    @endforeach
                                    <br/>
                                @endif
                            @endforeach
                        </td>
                        {{--    Approvals   --}}
                        @foreach($approvals as $approval)
                            @if($approval->mr_id == $movement_request->id)
                                @if($approval->line_manager_approval == 0)
                                    <td class="align-middle table-info text-info text-center">Pending</td>
                                @elseif($approval->line_manager_approval == 1)
                                    <td class="align-middle table-success text-success text-center">Approved</td>
                                @elseif($approval->line_manager_approval == 2)
                                    <td class="align-middle table-danger text-danger text-center">Declined</td>
                                @endif

                                @if($approval->risk_approval == 0)
                                    <td class="align-middle table-info text-info text-center">Pending</td>
                                @elseif($approval->risk_approval == 1)
                                    <td class="align-middle table-success text-success text-center">Approved</td>
                                @elseif($approval->risk_approval == 2)
                                    <td class="align-middle table-danger text-danger text-center">Declined</td>
                                @endif

                                @if($approval->country_director_approval == 0)
                                    <td class="align-middle table-info text-info text-center">Pending</td>
                                @elseif($approval->country_director_approval == 1)
                                    <td class="align-middle table-success text-success text-center">Approved</td>
                                @elseif($approval->country_director_approval == 2)
                                    <td class="align-middle table-danger text-danger text-center">Declined</td>
                                @endif
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
