@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
    <li class="breadcrumb-item"><a href="{{ route('approvals.index') }}">Approvals</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $movement_request->name }}</li>
@endsection


@section('title', $movement_request->name )
@section('heading', $movement_request->name )

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <p class="lead mb-5">This movement is submitted by <strong>{{ $movement_request->first_name . ' ' . $movement_request->last_name }}</strong></p>

        <h2>Approvals</h2>

        @authCheck('risk_movementRequest_approvals')
        <p class="lead">Please click below to either Approve or Deny this movement Request.</p>
        @switch($level)
            @case('cd')
            @authCheck('risk_movementRequest_approvals_cd')
            <form action="{{ route('approvals.update', $movement_request->id) }}" id="approval" method="POST">
                @method('PUT')
                @csrf
                <input type="hidden" name="approval-level" value="cd">
                <button class="btn btn-success btn-sm align-self-center" name="approval-value" value="1">
                    <span class="material-icons">done</span>Approve
                </button>
                <a class="btn btn-danger btn-sm" href="javascript:cdDenialRequest()" id="deny" role="button">
                    <span class="material-icons">close</span>Deny
                </a>
            </form>
            <div id="cd-denial-reason" class="row mt-3"></div>
            @endif
            @break
            @case('risk')
            @authCheck('risk_movementRequest_approvals_risk')
            <form action="{{ route('approvals.update', $movement_request->id) }}" id="approval" method="POST">
                @method('PUT')
                @csrf
                <input type="hidden" name="approval-level" value="risk">
                <button class="btn btn-success btn-sm align-self-center" name="approval-value" value="1">
                    <span class="material-icons">done</span>Approve
                </button>
                <a class="btn btn-danger btn-sm" href="javascript:riskDenialRequest()" id="deny" role="button">
                    <span class="material-icons">close</span>Deny
                </a>
            </form>
            <div id="risk-denial-reason" class="row mt-3"></div>
            @endif
            @break
            @case('lm')
            @if ($availableApprovals->items_approval != 4)
                @if ($itemsApprovals->items_approval == 0)
                    @if ($itemsApprovals->supervisor_id == Auth::id())
                        <h5>Items</h5>
                        <table class="table table-sm table-hover table-bordered table-striped p-0 col-6">
                            <tbody>
                            <tr class="align-middle text-center">
                                <th>Item(s) Approval <span class="badge bg-primary">{{ $movement_request->first_name . ' ' . $movement_request->last_name }}</span></th>
                                <th style="width: 30%;">
                                    <form action="{{ route('approvals.update', $movement_request->id) }}" id="approval" method="POST">
                                        @method('PUT')
                                        @csrf
                                        <input type="hidden" name="approval-type" value="items">
                                        <input type="hidden" name="approval-level" value="lm">
                                        <button class="btn btn-success btn-sm align-self-center" name="approval-value" value="1">
                                            <span class="material-icons">done</span>Approve
                                        </button>
                                        <a class="btn btn-danger btn-sm" href="javascript:denyApproval('items', 'lm')" id="deny" role="button">
                                            <span class="material-icons">close</span>Deny
                                        </a>
                                    </form>
                                </th>
                            </tr>
                            </tbody>
                        </table>
                    @else
                        <table class="table table-sm table-hover table-bordered table-striped p-0 col-6">
                            <tbody>
                            <tr>
                                <th class="align-middle">Item(s) Approval <span class="badge bg-primary">{{ $movement_request->first_name . ' ' . $movement_request->last_name }}</span></th>
                                <th class="align-middle text-center table-info">Pending</th>
                            </tr>
                            </tbody>
                        </table>
                    @endif
                @elseif ($itemsApprovals->items_approval == 1)
                    <table class="table table-sm table-hover table-bordered table-striped p-0 col-6">
                        <tbody>
                        <tr>
                            <th class="align-middle">Item(s) Approval <span class="badge bg-primary">{{ $movement_request->first_name . ' ' . $movement_request->last_name }}</span></th>
                            <th class="align-middle text-center table-success text-success">Approved</th>
                        </tr>
                        </tbody>
                    </table>
                @elseif ($itemsApprovals->items_approval == 2)
                    <table class="table table-sm table-hover table-bordered table-striped p-0 col-6">
                        <tbody>
                        <tr>
                            <th class="align-middle">Item(s) Approval <span class="badge bg-primary">{{ $movement_request->first_name . ' ' . $movement_request->last_name }}</span></th>
                            <th class="align-middle text-center table-danger">
                                <div class="row">
                                    <div class="col text-danger">Denied</div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        {{ $itemsApprovals->items_approval_reason }}
                                    </div>
                                </div>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                @endif
            @endif
            @if($availableApprovals->line_manager_approval != 4)
                <h5>Passengers</h5>
                <table class="table table-sm table-hover table-bordered table-striped p-0 col-6">
                    <thead>
                    <tr class="align-middle text-center">
                        <th>Passenger Name</th>
                        <th style="width: 30%;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($passengersApprovals as $passenger)
                        <tr class="align-middle">
                            <th>{{ $passenger->p_first_name . ' ' . $passenger->p_last_name }}</th>
                            @if( $passenger->line_manager_approval == 0 )
                                <td class="align-middle text-center">
                                    <form action="{{ route('approvals.update', $movement_request->id) }}" id="approval" method="POST">
                                        @method('PUT')
                                        @csrf
                                        <input type="hidden" name="approval-type" value="passengers">
                                        <input type="hidden" name="approval-level" value="lm">
                                        <input type="hidden" name="passenger-id" value="{{ $passenger->id }}">
                                        <button class="btn btn-success btn-sm align-self-center" name="approval-value" value="1">
                                            <span class="material-icons">done</span>Approve
                                        </button>
                                        <a class="btn btn-danger btn-sm" href="javascript:denyApproval('passengers', 'lm', {{ $passenger->id }})" id="deny" role="button" value="{{ $passenger->id }}">
                                            <span class="material-icons">close</span>Deny
                                        </a>
                                    </form>
                                </td>
                            @elseif($passenger->line_manager_approval == 1)
                                <th class="align-middle text-center table-success text-success">Approved</th>
                            @elseif($passenger->line_manager_approval == 2)
                                <th class="align-middle text-center table-danger">
                                    <div class="row">
                                        <div class="col text-danger">Denied</div>
                                    </div>
                                    <div class="row">
                                        <div class="col">{{ $passenger->line_manager_reason }}</div>
                                    </div>
                                </th>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
            @break
            @default
            Something Went wrong, contact Administrator.

        @endswitch
        @endif

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
            <div class="alert alert-warning" role="alert">No Passengers found</div>
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
                        <td class="align-middle">
                            {{ $passenger->first_name . ' ' . $passenger->last_name }}
                        </td>
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
                                    @if($passenger->id == $passengerFinance->user_id)
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
            <div class="alert alert-warning" role="alert">
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
                    <th class="align-middle">Financial Codes</th>
                </tr>
                </thead>
                <tbody>
                @foreach($accommodations as $accommodation)
                    <tr>
                        <td class="align-middle text-center p-0">{{ $loop->iteration }}</td>
                        <td class="align-middle">{{ $accommodation->first_name . ' ' . $accommodation->last_name }}</td>
                        <td class="align-middle text-center">{{ $accommodation->location_name }}</td>
                        <td class="align-middle text-center">{{ date('d-m-Y', strtotime($accommodation->check_in)) }}</td>
                        <td class="align-middle text-center">{{ date('d-m-Y', strtotime($accommodation->check_out)) }}</td>
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
                                    <tr class="text-center">
                                        <td class="align-middle p-0">{{ $accommodationFinance->fund_code }}</td>
                                        <td class="align-middle p-0">{{ $accommodationFinance->budget_line }}</td>
                                        <td class="align-middle p-0">{{ $accommodationFinance->percentage }}&#37;</td>
                                    </tr>
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
            <div class="alert alert-warning" role="alert">
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
                        <td class="align-middle">{!! $item->description !!}</td>
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
                                    @if($itemFinance->item_id == $item->id)
                                        <td class="align-middle text-center p-0">{{ $itemFinance->fund_code }}</td>
                                        <td class="align-middle text-center p-0">{{ $itemFinance->budget_line }}</td>
                                        <td class="align-middle text-center p-0">{{ $itemFinance->percentage }}&#37;</td>
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


    <div id="modalPlacer"></div>
@endsection

@section('scripts')
    <script>
        function denyApproval(approvalType, approvalLevel, passengerId) {
            $('#modalPlacer').empty();
            output = '';
            output += '<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">';
            output += '<div class="modal-dialog">';
            output += '<div class="modal-content">';
            output += '<div class="modal-header">';
            output += '<h5 class="modal-title"">Denial Reason</h5>';
            output += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            output += '</div>';
            output += '<div class="modal-body">';
            output += '<form class="m-0" id="denial-form" method="POST" action="{{ route('approvals.update', $movement_request->id)}}">'
            output += '@method('PUT')';
            output += '@csrf';
            output += '<input type="hidden" name="approval-type" value="' + approvalType + '">';
            output += '<input type="hidden" name="approval-level" value="' + approvalLevel + '">';
            output += '<input type="hidden" value="2" name="approval-value" />';
            if (approvalType == 'passengers') {
                output += '<input type="hidden" name="passenger-id" value="' + passengerId + '">';
            }
            output += '<textarea class="form-control" id="denial-reason" name="denial-reason" rows="3"></textarea>';
            output += '</form>';
            output += '</div>';
            output += '<div class="modal-footer">';
            output += '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>';
            output += '<button type="submit" form="denial-form" class="btn btn-primary">Save changes</button>';
            output += '</div>';
            output += '</div>';
            output += '</div>';
            output += '</div>';

            $('#modalPlacer').append(output);

            $('#modal').modal('show');
        }

        // Risk Denial Request
        function riskDenialRequest() {
            output = '';
            output += '<form class="col-8" action="{{ route('approvals.update', $movement_request->id) }}" id="approval" method="POST">';
            output += '@csrf';
            output += '@method('PUT')';
            output += '<input type="hidden" name="approval-level" value="risk">';
            output += '<input type="hidden" value="2" name="approval-value" />';
            output += '<div class="row">';
            output += '<div class="col-8">';
            output += '<textarea class="form-control" id="denial-reason" name="denial-reason" rows="3"></textarea>';
            output += '</div>';
            output += '<div class="col-4 d-flex align-items-center">';
            output += '<div class="row">';
            output += '<button class="btn btn-danger mb-1">Save</button>';
            output += '<a class="btn btn-link text-decoration-none" href="javascript:riskDenialRequestempty()">Cancel</a>';
            output += '</div>';
            output += '</div>';
            output += '</div>';
            output += '</form>';

            $('#risk-denial-reason').html(output);
        }

        // Cancel Denial box.
        function riskDenialRequestempty() {
            $('#risk-denial-reason').empty();
        }

        // CD Denial Request
        function cdDenialRequest() {
            output = '';
            output += '<form class="col-8" action="{{ route('approvals.update', $movement_request->id) }}" id="approval" method="POST">';
            output += '@csrf';
            output += '@method('PUT')';
            output += '<input type="hidden" name="approval-level" value="risk">';
            output += '<input type="hidden" value="2" name="approval-value" />';
            output += '<div class="row">';
            output += '<div class="col-8">';
            output += '<textarea class="form-control" id="denial-reason" name="denial-reason" rows="3"></textarea>';
            output += '</div>';
            output += '<div class="col-4 d-flex align-items-center">';
            output += '<div class="row">';
            output += '<button class="btn btn-danger mb-1">Save</button>';
            output += '<a class="btn btn-link text-decoration-none" href="javascript:cdDenialRequestempty()">Cancel</a>';
            output += '</div>';
            output += '</div>';
            output += '</div>';
            output += '</form>';

            $('#cd-denial-reason').html(output);
        }

        // Cancel Denial box.
        function cdDenialRequestempty() {
            $('#cd-denial-reason').empty();
        }

    </script>
@endsection
