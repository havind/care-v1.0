@extends('layouts.app')
@inject('ibFunctions', 'App\Http\Controllers\ibFunctions')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
    <li class="breadcrumb-item active" aria-current="page">All Movement Requests</li>
@endsection


@section('title', 'All Movement Requests')
@section('heading', 'All Movement Requests')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">

        @if(empty(count($movement_requests)))
            <div class="alert alert-warning align-items-center m-3" role="alert">
                <span class="material-icons">error_outline</span> You have not submitted any Movement Requests.
            </div>
        @else
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr class="text-center">
                    <td class="align-middle" rowspan="2">#</td>
                    <td class="align-middle" rowspan="2" style="width: 15%">Movement Request #</td>
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
                        <td class="align-middle text-center">{{ date('h:i a, d-m-Y', strtotime($movement_request->created_at)) }}</td>
                        <td class="align-middle">
                            @foreach($users as $user)
                                @if($user->id == $movement_request->requester_id)
                                    {{ $user->first_name }} {{ $user->last_name }}
                                @endif
                            @endforeach
                        </td>
                        <td class="align-middle">
                            @foreach($passengers as $passenger)
                                <ul class="list-unstyled mb-0">
                                    @if($passenger->mr_id == $movement_request->id)
                                        <li>{{ $passenger->first_name }} {{ $passenger->last_name }}</li>
                                    @endif
                                </ul>
                            @endforeach
                        </td>
                        <td class="align-middle">
                            <ul class="list-unstyled mb-0" style="font-size: 15px;">
                                @foreach($itinerary as $itinerary_item)
                                    @if($movement_request->id == $itinerary_item->mr_id)
                                        <li>@foreach($locations as $location)
                                                @if($location->id == $itinerary_item->from_location_id)
                                                    {{ $location->name }}
                                                @endif
                                            @endforeach
                                            <span class="material-icons">east</span>
                                            @foreach($locations as $location)
                                                @if($location->id == $itinerary_item->to_location_id)
                                                    {{ $location->name }}
                                                @endif
                                            @endforeach
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
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
                                    <td class="align-middle align-middle table-info text-info text-center">Pending</td>
                                @elseif($approval->risk_approval == 1)
                                    <td class="align-middle align-middle table-success text-success text-center">Approved</td>
                                @elseif($approval->risk_approval == 2)
                                    <td class="align-middle align-middle table-danger text-danger text-center">Declined</td>
                                @endif

                                @if($approval->country_director_approval == 0)
                                    <td class="align-middle table-info text-info text-center">Pending</td>
                                @elseif($approval->country_director_approval == 1)
                                    <td class="align-middle table-success text-success text-center">Approved</td>
                                @elseif($approval->country_director_approval == 2)
                                    <td class="align-middle table-danger text-danger text-center">Declined</td>
                                @elseif($approval->country_director_approval == 4)
                                    <td class="table-secondary text-secondary align-middle text-center">Not Available</td>
                                @endif
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="container">
                {{--    Pagination  --}}
                {{ $movement_requests->links('risk.movement_request.pagination') }}
            </div>
        @endif
    </div>
@endsection
