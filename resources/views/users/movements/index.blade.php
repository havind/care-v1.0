@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.profile') }}">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">My Movements</li>
@endsection

@section('title', 'My Movement Requests')
@section('heading', 'My Movement Requests')

@section('primary_menu')
    @include('users.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        @if ($my_movements == null)
            <div class="alert alert-warning align-items-center m-3" role="alert">
                <span class="material-icons">error_outline</span> You have not submitted any Movement Requests. <a class="" href="{{ route('movements.create') }}">Add new Movement Request</a>
            </div>
        @else
            <a class="btn btn-primary mb-3" href="{{ route('movements.create') }}">
                <span class="material-icons">add_box</span> Add Movement Request
            </a>

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
                    <td class="align-middle" rowspan="2">Actions</td>
                </tr>
                <tr class="text-center">
                    <td class="align-middle">Line Manager</td>
                    <td class="align-middle">Risk</td>
                    <td class="align-middle">Country Director</td>
                </tr>
                </thead>
                <tbody>
                @foreach($my_movements as $my_movement)
                    <tr>
                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <a href="{{ route('movements.show', $my_movement->id) }}">{{ $my_movement->name }}</a>
                        </td>
                        <td class="align-middle text-center">
                            {{ $my_movement->created_at }}
                        </td>
                        <td class="align-middle">
                            @foreach($users as $user)
                                @if($user->id == $my_movement->requester_id)
                                    {{ $user->first_name }} {{ $user->last_name }}
                                @endif
                            @endforeach
                        </td>
                        <td class="align-middle">
                            @foreach($passengers as $passenger)
                                @if($passenger->mr_id == $my_movement->id)
                                    @foreach($users as $user)
                                        @if($user->id == $passenger->passenger_id)
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        @endif
                                    @endforeach
                                    <br/>
                                @endif
                            @endforeach
                        </td>
                        <td class="align-middle">
                            @foreach($itineraries as $itinerary)
                                @if($my_movement->id == $itinerary->mr_id)
                                    @foreach($locations as $location)
                                        @if($location->id == $itinerary->from_location_id)
                                            {{ $location->name }}
                                        @endif
                                    @endforeach
                                    <i class="bi bi-arrow-right"></i>
                                    @foreach($locations as $location)
                                        @if($location->id == $itinerary->to_location_id)
                                            {{ $location->name }}
                                        @endif
                                    @endforeach
                                    <br/>
                                @endif
                            @endforeach
                        </td>

                        {{--Approvals--}}
                        @foreach($approvals as $approval)
                            @if($approval->mr_id == $my_movement->id)
                                @if($approval->line_manager_approval == 0)
                                    <td class="table-info text-info align-middle text-center">Pending</td>
                                @elseif($approval->line_manager_approval == 1)
                                    <td class="table-success text-success text-center align-middle">Approved</td>
                                @elseif($approval->line_manager_approval == 2)
                                    <td class="table-danger text-danger text-center align-middle">Declined</td>
                                @elseif($approval->line_manager_approval == 4)
                                    <td class="table-secondary text-secondary align-middle text-center">Not Available</td>
                                @endif

                                @if($approval->risk_approval == 0)
                                    <td class="table-info text-info align-middle text-center">Pending</td>
                                @elseif($approval->risk_approval == 1)
                                    <td class="table-success text-success text-center align-middle">Approved</td>
                                @elseif($approval->risk_approval == 2)
                                    <td class="table-danger text-danger text-center align-middle">Declined</td>
                                @endif

                                @if($approval->country_director_approval == 0)
                                    <td class="table-info text-info align-middle text-center">Pending</td>
                                @elseif($approval->country_director_approval == 1)
                                    <td class="table-success text-success text-center align-middle">Approved</td>
                                @elseif($approval->country_director_approval == 2)
                                    <td class="table-danger text-danger text-center align-middle">Declined</td>
                                @elseif($approval->country_director_approval == 4)
                                    <td class="table-secondary text-secondary align-middle text-center">Not Available</td>
                                @endif
                            @endif
                        @endforeach
                        <td class="align-middle text-center">
                            <a class="text-danger" href="{{ route('movements.delete', $my_movement->id)}}">
                                <span class="material-icons text-danger">delete</span>
                            </a>
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
            <td><small><span class="material-icons text-danger">delete</span></small></td>
            <td><small>Clear</small></td>
        </tr>
    </table>
@endsection
