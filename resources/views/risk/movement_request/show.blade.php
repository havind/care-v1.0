@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/print.css') }}" rel="stylesheet" media="print" type="text/css">
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
    <li class="breadcrumb-item"><a href="{{ route('movement-requests.index') }}">Movement Request</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $movement_request->name }}</li>
@endsection

@section('title', $movement_request->name )
@section('heading', $movement_request->name )

@section('heading-navbar')
    <li><a class="btn btn-sm btn-danger d-print-none" href="{{ route('movement-requests.print', $movement_request->id)  }}">Print</a></li>
@endsection

@section('primary_menu')
    @include('risk.movement_request.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        <h2>Approvals</h2>
        <div class="row mt-3">
            <div class="{{ ($approvals->cd_approval != 4) ? 'col-6' : 'col-6 col-xs-12' }}">
                <p class="lead text-center">Step 1 (Supervisors)</p>
                <table class="table table-bordered">
                    <thead>
                    <tr class="text-center">
                        <th>Supervisor</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ( $approvals->items_approval != 4 )
                        <tr>
                            <td class="table-primary">Items</td>

                            {{--                            @if ($approvals->items_approval == 0)--}}
                            {{--                                <td class="table-info text-info text-center">Pending</td>--}}
                            {{--                            @elseif ($approvals->items_approval == 1)--}}
                            {{--                                <td class="table-success text-success text-center">Approved</td>--}}
                            {{--                            @elseif ($approvals->items_approval == 2)--}}
                            {{--                                <td class="table-danger text-danger text-center">Denied</td>--}}
                            {{--                            @endif--}}

                            {{--                            @if ($approvals->items_approval_timestamp == null)--}}
                            {{--                                <td class="table-secondary text-secondary text-center">Not Available</td>--}}
                            {{--                            @else--}}
                            {{--                                <td>--}}
                            {{--                                    {{ date('H:i a, d-m-Y', strtotime($approvals->items_approval_timestamp)) }}--}}
                            {{--                                </td>--}}
                            {{--                            @endif--}}
                        </tr>
                    @endif

                    @foreach ($passengers as $passenger)
                        <tr>
                            <td>{{ $passenger->first_name }} {{ $passenger->last_name }}</td>
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
                                <td class="text-center">
                                    {{ date('H:i a, d-m-Y', strtotime($passenger->line_manager_timestamp)) }}
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="{{ ($approvals->cd_approval != 4) ? 'col-3' : 'col-6' }}">
                <p class="lead text-center">Step 2 (Risk)</p>

                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <th class="text-center">{{ $approvals->risk_first_name }} {{ $approvals->risk_last_name }}</th>
                    </tr>
                    <tr>
                        <th>Status</th>
                        @if($approvals->risk_approval == 0)
                            <td class="table-info text-info text-center">Pending</td>
                        @elseif($approvals->risk_approval == 1)
                            <td class="table-success text-success text-center">Approved</td>
                        @elseif($approvals->risk_approval == 2)
                            <td class="table-danger text-danger text-center">Denied</td>
                        @endif
                    </tr>
                    <tr>
                        <th>Date</th>
                        @if ($approvals->risk_timestamp == null)
                            <td class="table-secondary text-secondary text-center">Not Available</td>
                        @else
                            <td class="text-center">{{ date('H:i a, d-m-Y', strtotime($approvals->risk_timestamp)) }}</td>
                        @endif
                    </tr>
                </table>
            </div>
            @if ($approvals->cd_approval != 4)
                <div class="col-3">
                    <p class="lead text-center">Step 3 (Country Director)</p>
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <th class="text-center">{{ $approvals->cd_first_name }} {{ $approvals->cd_last_name }}</th>
                        </tr>
                        <tr>
                            <th>Status</th>
                            @if($approvals->cd_approval == 0)
                                <td class="table-info text-info text-center">Pending</td>
                            @elseif($approvals->cd_approval == 1)
                                <td class="table-success text-success text-center">Approved</td>
                            @elseif($approvals->cd_approval == 2)
                                <td class="table-danger text-danger text-center">Denied</td>
                            @endif
                        </tr>
                        <tr>
                            <th>Date</th>
                            @if ($approvals->cd_timestamp == null)
                                <td class="table-secondary text-secondary text-center">Not Available</td>
                            @else
                                <td class="text-center">{{ date('H:i a, d-m-Y', strtotime($approvals->cd_timestamp)) }}</td>
                            @endif
                        </tr>
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
            {{--            @else--}}
            @if($approvals->risk_approval == 2)
                <p class="lead">Movement Request has been <span class="text-danger">Declined</span> by Risk Team.</p>
                <p class="lead">
                    <span class="fw-bold">Reason:</span> {{ $approvals->risk_reason }}
                </p>
            @elseif($approvals->cd_approval == 2)
                <p class="lead">Movement Request has been <span class="text-danger">Declined</span> by Country Director.</p>
                <p class="lead">
                    {{--                    <span class="fw-bold">Reason:</span> {{ $approvals->country_director_reason }}--}}
                </p>
            @endif
        </div>

        {{--    Travel Purpose  --}}
        <hr class="mt-5"/>
        <h2>Travel Purpose</h2>
        <p class="lead p-2 bg-white">{!! $movement_request->purpose !!}</p>

        <hr class="mt-5"/>
        <h2>Itinerary</h2>
        <table class="table table-sm table-hover table-bordered table-striped">
            <thead>
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
                <tr>
                    <td class="align-middle text-center">{{ $loop->iteration }}</td>
                    <td class="align-middle">{{ $itinerary->from_name }}</td>
                    <td class="align-middle text-center">{{ date('d-m-Y', strtotime($itinerary->from_date)) }}</td>
                    <td class="align-middle text-center">{{ date('h:i a', strtotime($itinerary->from_time)) }}</td>
                    <td class="align-middle">{{ $itinerary->to_name }}</td>
                    <td class="align-middle text-center">{{ date('d-m-Y', strtotime($itinerary->to_date)) }}</td>
                    <td class="align-middle text-center">{{ date('h:i a', strtotime($itinerary->to_time)) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{--    Passengers  --}}
        <hr class="mt-5"/>
        <h2>Passengers</h2>
        @if(empty(count($passengers)))
            <div class="alert alert-info" role="alert">No Passengers found</div>
        @else
            <table class="table table-sm table-bordered table-hover table-striped">
                <thead>
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
                        <td class="align-middle">{{ $passenger->first_name }} {{ $passenger->last_name }}</td>
                        <td class="p-0">
                            <table class="table table-sm table-bordered m-0">
                                <thead>
                                <tr class="text-center">
                                    <th>Fund Codes</th>
                                    <th>Budget Lines</th>
                                    <th>Percentage</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($passengersFinance as $passengerFinance)
                                    @if($passenger->passenger_id == $passengerFinance->user_id)
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
        <h2>Items</h2>
        @if(empty(count($items)))
            <div class="alert alert-info" role="alert">
                No Items found
            </div>
        @else
            <table class="table table-sm table-hover table-bordered table-striped">
                <thead>
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
                        <td class="align-middle p-0">
                            {!! $item->description !!}
                        </td>
                        <td class="p-0">
                            <table class="table table-sm table-bordered m-0 p-0">
                                <thead>
                                <tr class="text-center">
                                    <th class="align-middle">Fund Codes</th>
                                    <th class="align-middle">Budget Lines</th>
                                    <th class="align-middle" style="width: 20%;">%</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($itemsFinance as $itemFinance)
                                    @if($item->id == $itemFinance->item_id)
                                        <tr class="text-center">
                                            <td class="text-center">{{ $itemFinance->fund_code }}</td>
                                            <td class="text-center">{{ $itemFinance->budget_line }}</td>
                                            <td class="text-center">{{ $itemFinance->percentage }}&#37;</td>
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
                No Accommodation found
            </div>
        @else
            <table class="table table-sm table-bordered table-hover table-striped">
                <thead>
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
                        <td class="align-middle">{{ $accommodation->first_name }} {{ $accommodation->last_name }}</td>
                        <td class="align-middle">{{ $accommodation->location }}</td>
                        <td class="align-middle text-center p-0">{{ date('d-m-Y', strtotime($accommodation->check_in)) }}</td>
                        <td class="align-middle text-center p-0">{{ date('d-m-Y', strtotime($accommodation->check_out)) }}</td>
                        <td class="align-middle p-0">
                            <table class="table table-sm table-bordered m-0 p-0">
                                <thead>
                                <tr class="text-center">
                                    <th class="align-middle">Fund Codes</th>
                                    <th class="align-middle">Budget Lines</th>
                                    <th class="align-middle" style="width: 20%;">%</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($accommodationsFinance as $accommodationFinance)
                                    @if($accommodation->id == $accommodationFinance->accommodations_id)
                                        <tr class="text-center">
                                            <td class="text-center">{{ $accommodationFinance->fund_code }}</td>
                                            <td class="text-center">{{ $accommodationFinance->budget_line }}</td>
                                            <td class="text-center">{{ $accommodationFinance->percentage }}&#37;</td>
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
