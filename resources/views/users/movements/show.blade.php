@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.profile') }}">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('movements.index') }}">My Movements</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $movement_request->name }}</li>
@endsection

@section('title', $movement_request->name)
@section('heading', $movement_request->name)

@section('primary_menu')
    @include('users.movements.partials.primary_menu')

    <div class="form-text fst-italic">created at {{ $movement_request->created_at }}
        @if($movement_request->updated_at != null )
            (Updated at {{ $movement_request->updated_at }})
        @endif
    </div>
@endsection

@section('content')
    <div class="container">
        <h2>Approvals</h2>

        <div class="row mt-3">
            <div class="{{ ($approvals->country_director_approval != 4) ? 'col-4' : 'col-6 col-xs-12' }}">
                <p class="lead text-center">Step 1 (Supervisors)</p>

                @if ( $approvals->items_approval != 4 )
                    <h6>Items</h6>
                    <table class="table table-bordered">
                        <thead class="table-light">
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="table-light text-center">{{ $movement_request->first_name }} {{ $movement_request->last_name }} <span class="badge bg-primary">Items</span>
                            </td>

                            @if ($approvals->items_approval == 0)
                                <td class="table-info text-info text-center">Pending</td>
                            @elseif ($approvals->items_approval == 1)
                                <td class="table-success text-success text-center">Approved</td>
                            @elseif ($approvals->items_approval == 2)
                                <td class="table-danger text-danger text-center">Denied</td>
                            @endif

                            @if ($approvals->items_approval_timestamp == null)
                                <td class="table-secondary text-secondary text-center">Not Available</td>
                            @else
                                <td>
                                    {{ date('h:ia, d-m-Y', strtotime($approvals->items_approval_timestamp)) }}
                                </td>
                            @endif
                        </tr>
                        @endif
                        </tbody>
                    </table>

                    <h6>Passengers</h6>
                    <table class="table table-bordered">
                        <thead class="table-light">
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($passengers as $passenger)
                            <tr>
                                <td>{{ $passenger->p_first_name . ' ' . $passenger->p_last_name }} <span class="badge bg-primary">{{ $passenger->sv_first_name . ' ' . $passenger->sv_last_name }}</span>
                                </td>
                                @if ($passenger->line_manager_approval == 0)
                                    <td class="table-info text-info text-center">Pending</td>
                                @elseif ($passenger->line_manager_approval == 1)
                                    <td class="table-success text-success text-center">Approved</td>
                                @elseif ($passenger->line_manager_approval == 2)
                                    <td class="table-danger text-danger text-center">Denied</td>
                                @endif
                                @if ($passenger->line_manager_timestamp == null)
                                    <td class="table-secondary text-secondary text-center">
                                        Not Available
                                    </td>
                                @else
                                    <td>
                                        {{ date('h:ia, d-m-Y', strtotime($passenger->line_manager_timestamp)) }}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div>
            <div class="{{ ($approvals->country_director_approval != 4) ? 'col-4' : 'col-6' }}">
                <p class="lead text-center">Step 2 (Risk)</p>
                <table class="table table-bordered">
                    <thead class="table-light">
                    <tr class="text-center">
                        <th>Name</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $risk_approval_info->first_name }} {{ $risk_approval_info->last_name }}</td>
                        @if($approvals->risk_approval == 0)
                            <td class="table-info text-info text-center">Pending</td>
                        @elseif($approvals->risk_approval == 1)
                            <td class="table-success text-success text-center">Approved</td>
                        @elseif($approvals->risk_approval == 2)
                            <td class="table-danger text-danger text-center">Denied</td>
                        @endif
                        @if ($approvals->risk_timestamp == null)
                            <td class="table-secondary text-secondary text-center">
                                Not Available
                            </td>
                        @else
                            <td>
                                {{ date('H:i a, d-m-Y', strtotime($approvals->risk_timestamp)) }}
                            </td>
                        @endif
                    </tr>
                    </tbody>
                </table>
            </div>
            @if ($approvals->country_director_approval != 4)
                <div class="col-4">
                    <p class="lead text-center">Step 3 (Country Director)</p>
                    <table class="table table-bordered">
                        <thead class="table-light">
                        <tr class="text-center">
                            <th>Name</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $cd_approval_info->first_name }} {{ $cd_approval_info->last_name }}</td>
                            @if($approvals->country_director_approval == 0)
                                <td class="table-info text-info text-center">Pending</td>
                            @elseif($approvals->country_director_approval == 1)
                                <td class="table-success text-success text-center">Approved</td>
                            @elseif($approvals->country_director_approval == 2)
                                <td class="table-danger text-danger text-center">Denied</td>
                            @endif
                            @if ($approvals->country_director_timestamp == null)
                                <td class="table-secondary text-secondary text-center">
                                    Not Available
                                </td>
                            @else
                                <td>
                                    {{ date('H:i a, d-m-Y', strtotime($approvals->country_director_timestamp)) }}
                                </td>
                            @endif
                        </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>


        {{--    Show reason if declied  --}}
        <div class="">
            {{--            @if($approvals->line_manager_approval == 2)--}}
            {{--                <p class="lead">Movement Request has been <span class="text-danger">Declined</span> by your Supervisor.</p>--}}
            {{--                <p class="lead">--}}
            {{--                    <span class="fw-bold">Reason:</span> {{ $approvals->line_manager_reason }}--}}
            {{--                </p>--}}
            {{--            @elseif($approvals->risk_approval == 2)--}}
            {{--                <p class="lead">Movement Request has been <span class="text-danger">Declined</span> by Risk Team.</p>--}}
            {{--                <p class="lead">--}}
            {{--                    <span class="fw-bold">Reason:</span> {{ $approvals->risk_reason }}--}}
            {{--                </p>--}}
            {{--            @elseif($approvals->country_director_approval == 2)--}}
            {{--                <p class="lead">Movement Request has been <span class="text-danger">Declined</span> by Country Director.</p>--}}
            {{--                <p class="lead">--}}
            {{--                    <span class="fw-bold">Reason:</span> {{ $approvals->country_director_reason }}--}}
            {{--                </p>--}}
            {{--            @endif--}}
        </div>

        <hr class="mt-5"/>
        <h2>Travel Purpose</h2>
        <p class="lead p-2 bg-white">{!! $movement_request->purpose !!}</p>

        <hr class="mt-5"/>
        <h2>Itinerary</h2>
        <table class="table table-sm table-hover table-bordered table-striped">
            <thead class="table-light">
            <tr class="text-center">
                <th class="align-middle" rowspan="2">#</th>
                <th class="align-middle" colspan="3">From</th>
                <th class="align-middle" colspan="3">To</th>
            </tr>
            <tr class="text-center">
                <th class="align-middle">Location</th>
                <th class="align-middle">Date</th>
                <th class="align-middle">Time</th>
                <th class="align-middle">Location</th>
                <th class="align-middle">Date</th>
                <th class="align-middle">Time</th>
            </tr>
            </thead>
            <tbody>
            @foreach($itineraries as $itinerary)
                <tr class="text-center">
                    <td class="align-middle p-0">{{ $loop->iteration }}</td>
                    <td class="align-middle p-0">{{ $itinerary->from_location }}</td>
                    <td class="align-middle p-0">{{ date('d-m-Y', strtotime($itinerary->from_date)) }}</td>
                    <td class="align-middle p-0">{{ date('h:ia', strtotime($itinerary->from_time)) }}</td>
                    <td class="align-middle p-0">{{ $itinerary->to_location }}</td>
                    <td class="align-middle p-0">{{ date('d-m-Y', strtotime($itinerary->to_date)) }}</td>
                    <td class="align-middle p-0">{{ date('h:ia', strtotime($itinerary->to_time)) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <hr class="mt-5"/>
        <h2>Passengers</h2>
        @if(empty(count($passengers)))
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-square"></i> The movement request does not have any Passengers.
            </div>
        @else
            <table class="table table-sm table-bordered table-hover table-striped">
                <thead class="table-light">
                <tr class="text-center">
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Financial Codes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($passengers as $passenger)
                    <tr>
                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            {{ $passenger->p_first_name }} {{ $passenger->p_last_name }}
                        </td>
                        <td class="p-0">
                            <table class="table table-sm table-bordered m-0">
                                <thead class="table-light">
                                <tr>
                                    <th class="text-center">Fund Codes</th>
                                    <th class="text-center">Budget Lines</th>
                                    <th class="text-center">&#37;</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($passengersFinance as $passengerFinance)
                                    @if($passengerFinance->user_id == $passenger->passenger_id)
                                        <tr>
                                            <td class="text-center">{{ $passengerFinance->fund_code }}</td>
                                            <td class="text-center">{{ $passengerFinance->budget_line }}</td>
                                            <td class="text-center">{{ $passengerFinance->percentage }}&#37;</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif


        <hr class="mt-5"/>
        <h2>Accommodation</h2>
        @if(empty(count($accommodations)))
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-square"></i> No Accommodation found
            </div>
        @else
            <table class="table table-sm table-bordered table-hover table-striped">
                <thead class="table-light">
                <tr class="text-center">
                    <th class="align-middle">#</th>
                    <th class="align-middle">Full Name</th>
                    <th class="align-middle">City</th>
                    <th class="align-middle">Check-In</th>
                    <th class="align-middle">Full Name</th>
                    <th>Financial Codes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accommodations as $accommodation)
                    <tr>
                        <td class="align-middle text-center p-0">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            {{ $accommodation->first_name }} {{ $accommodation->last_name }}
                        </td>
                        <td class="align-middle text-center p-0">
                            {{ $accommodation->location_name }}
                        </td>
                        <td class="align-middle text-center p-0">
                            {{ date('d-m-Y', strtotime($accommodation->check_in)) }}
                        </td>
                        <td class="align-middle text-center p-0">
                            {{ date('d-m-Y', strtotime($accommodation->check_out)) }}
                        </td>
                        <td class="align-middle p-0">
                            <table class="table table-sm table-bordered m-0 p-0">
                                <thead class="table-light">
                                <tr class="text-center">
                                    <th class="align-middle">Fund Codes</th>
                                    <th class="align-middle">Budget Lines</th>
                                    <th class="align-middle" style="width: 20%;">&#37;</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($accommodationsFinance as $accommodationFinance)
                                    @if ($accommodationFinance->id == $accommodation->id)
                                        <tr class="text-center">
                                            <td class="align-middle p-0">{{ $accommodationFinance->fund_code }}</td>
                                            <td class="align-middle p-0">{{ $accommodationFinance->budget_line }}</td>
                                            <td class="align-middle p-0">{{ $accommodationFinance->percentage }}&#37;</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <hr class="mt-5"/>
        <h2>Items</h2>
        @if(empty(count($items)))
            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-square"></i> This movement request does not have any items.
            </div>
        @else
            <table class="table table-sm table-hover table-bordered table-striped">
                <thead class="table-light">
                <tr class="text-center">
                    <th class="align-middle">#</th>
                    <th class="align-middle" style="width: 40%;">Items</th>
                    <th>Financial Codes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td class="align-middle text-center p-0">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            {!! $item->description !!}
                        </td>
                        <td class="p-0">
                            <table class="table table-sm table-bordered m-0 p-0">
                                <thead class="table-light">
                                <tr class="text-center">
                                    <th class="align-middle">Fund Codes</th>
                                    <th class="align-middle">Budget Lines</th>
                                    <th class="align-middle" style="width: 20%;">&#37;</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($itemsFinance as $itemFinance)
                                    @if ($itemFinance->item_id == $item->id)
                                        <tr class="text-center">
                                            <td class="align-middle p-0">{{ $itemFinance->fund_code }}</td>
                                            <td class="align-middle p-0">{{ $itemFinance->budget_line }}</td>
                                            <td class="align-middle p-0">{{ $itemFinance->percentage }}&#37;</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

@section('scripts')

@endsection
