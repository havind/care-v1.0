@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.profile') }}">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('movements.index') }}">My Movements</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
@endsection

@section('title', $title )
@section('heading', $title )

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <form id="movement-request-form" action="{{ route('movements.store') }}" method="POST">
            @csrf
            {{----------------
                Travel Purpose
            ----------------}}
            <div class="mb-3" id="mv-purpose-section">
                <label for="mv-purpose" class="form-label">
                    <h2>Travel Purpose<span class="text-danger">*</span></h2>
                </label>
                <textarea class="form-control editor" id="mv-purpose" name="mv-purpose"></textarea>
                <div class="form-text help-text">Write the descriptive purpose of the travel.</div>
            </div>

            <br/>

            {{--    Itinerary  --}}
            <table style="width: 100%">
                <tr>
                    <td>
                        <h2 class="align-middle">
                            <div class="form-check">
                                <label class="form-check-label lh-base" for="itinerary-check">Itinerary<span
                                            class="text-danger">*</span></label>
                            </div>
                        </h2>
                    </td>
                    <td>
                        <a id="add-itinerary" class="btn btn-info btn-sm" style="float: right" href="javascript:void(0)">
                            <span class="material-icons">add_box</span> Add Itinerary
                        </a>
                    </td>
                </tr>
            </table>
            <table id="itinerary" class="table table-sm table-hover table-bordered">
                <caption class="form-text help-text">Adding at least one Itinerary is mandatory for the movement to be
                    submitted.
                </caption>
                <thead>
                <tr class="text-center">
                    <th class="align-middle" rowspan="2">#</th>
                    <th class="align-middle" colspan="3">From</th>
                    <th class="align-middle" colspan="3">To</th>
                    <th class="align-middle" rowspan="2">Actions</th>
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
                @for ($i = 1; $i <= 2; $i++)
                    <tr class="text-center">
                        <td class="align-middle p-0">{{ $i }}{!! ($i == 1) ? '<span class="text-danger">*</span>' : '' !!}</td>
                        <td class="align-middle p-0">
                            <select class="form-control border-0" id="iti-{{ $i }}-from-location"
                                    name="iti-{{ $i }}-from-location"
                                    onfocusout="javascript:validate_itinerary({{ $i }})" required>
                                <option value="0" selected>-- SELECT --</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="align-middle p-0">
                            <input class="form-control border-0" id="iti-{{ $i }}-from-date" id="iti-{{ $i }}-from-date"
                                   min="{{ date('Y-m-d') }}" name="iti-{{ $i }}-from-date"
                                   onchange="setMinDate('iti', {{ $i }})"
                                   onfocusout="javascript:validate_itinerary({{ $i }})"
                                   onfocusout="javascript:validate_itinerary({{ $i }})" type="date">
                        </td>
                        <td class="align-middle p-0">
                            <input class="form-control border-0" id="iti-{{ $i }}-from-time"
                                   name="iti-{{ $i }}-from-time" onfocusout="javascript:validate_itinerary({{ $i }})"
                                   type="time">
                        </td>
                        <td class="align-middle p-0">
                            <select class="form-control border-0" id="iti-{{ $i }}-to-location"
                                    onfocusout="javascript:validate_itinerary({{ $i }})"
                                    name="iti-{{ $i }}-to-location">
                                <option value="0" selected>-- SELECT --</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="align-middle p-0">
                            <input class="form-control border-0" id="iti-{{ $i }}-to-date" name="iti-{{ $i }}-to-date"
                                   onfocusout="javascript:validate_itinerary({{ $i }})" type="date">
                        </td>
                        <td class="align-middle p-0">
                            <input class="form-control border-0" id="iti-{{ $i }}-to-time" name="iti-{{ $i }}-to-time"
                                   onfocusout="javascript:validate_itinerary({{ $i }})" type="time">
                        </td>
                        <th class="align-middle p-0">
                            <a class="text-danger" href="javascript:clear('iti-{{ $i }}')">
                                <span class="material-icons">clear</span>
                            </a>
                        </td>
                    </tr>
                @endfor
                </tbody>
            </table>

            <br/>

            {{------------
                Passengers
            ------------}}
            <table style="width: 100%">
                <tr>
                    <td>
                        <h2 class="align-middle">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="passengers-check" name="passengers-check">
                                <label class="form-check-label lh-base" for="passengers-check">Passengers</label>
                            </div>
                        </h2>
                    </td>
                    <td>
                        <a id="add-passenger" class="btn btn-info btn-sm" style="float: right" href="javascript:void(0)">
                            <span class="material-icons">add_box</span> Add Passenger
                        </a>
                    </td>
                </tr>
            </table>

            <div id="passengers-content"></div>

            <br/>

            {{--    Accommodation  --}}
            <div id="accommodation-enable">
                <table style="width: 100%">
                    <tr>
                        <td>
                            <h2 class="align-middle">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="accommodation-check"
                                           name="accommodation-check">
                                    <label class="form-check-label lh-base"
                                           for="accommodation-check">Accommodation</label>
                                </div>
                            </h2>
                        </td>
                        <td>
                            <a id="add-accommodation" class="btn btn-info btn-sm" style="float: right" href="javascript:void(0)">
                                <span class="material-icons">add_box</span> Add Accommodation
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="accommodation-content"></div>

            <br/>

            {{-------
                Items
            -------}}
            <table style="width: 100%">
                <tr>
                    <td>
                        <h2 class="align-middle">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="items-check" name="items-check">
                                <label class="form-check-label lh-base" for="items-check">Items</label>
                            </div>
                        </h2>
                    </td>
                    <td>
                        <a id="add-items" class="btn btn-info btn-sm" style="float: right" href="javascript:void(0)">
                            <span class="material-icons">add_box</span> Add Items
                        </a>
                    </td>
                </tr>
            </table>

            <div id="items-content"></div>

            {{--  Error messages  --}}
            <div class="alert alert-warning alert-dismissible fade show mt-5" role="alert" hidden>
                <span class="material-icons">error_outline</span> Solve the below errors to submit the movement
                request:
                <ul>
                    <li><strong>Travel purpose</strong> is mandatory, please write a clear description of your
                        movements.
                    </li>
                    <li><strong>Itinerary (Row 1)</strong> is mandatory cannot be left unfilled.</li>
                    <li><strong>Itinerary (Row n)</strong> all fields are required and must be filled.</li>
                    <li>Three</li>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            {{--  End - Error messages  --}}

            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <button class="btn btn-outline-success" id="formSubmit" type="submit">
                    <span class="material-icons">publish</span>Submit
                </button>
                <a class="btn btn-outline-danger" href="{{ route('movements.index') }}">
                    <span class="material-icons">cancel</span> Cancel
                </a>
            </div>
        </form>
    </div>

@endsection

@section('footnote')
    <hr/>
    <table>
        <tr>
            <td><small><span class="material-icons text-danger">clear</span></small></td>
            <td><small>Clear</small></td>
        </tr>
    </table>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/32.0.0/classic/ckeditor.js"></script>
    @include('users.movements.js.create')
@endsection
