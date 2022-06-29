@inject('ibFunctions', 'App\Http\Controllers\ibFunctions')
@extends('layouts.app')

@section('title', 'Fleet')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fleet') }}">Fleet</a></li>
            <li class="breadcrumb-item active" aria-current="page">Movements Assigning</li>
        </ol>
    </nav>
@endsection

@section('heading')
    <h1>Assign Movements</h1>
@endsection

@section('primary_menu')
    @include('risk.fleet.primary_menu')
@endsection

@section('content')
    <div class="container">
        @if ($no_cars == true)
            <div class="alert alert-primary" role="alert">
                <i class="bi bi-exclamation-square"></i> Please add cars to start assigning movements. <a href="{{ route('cars.create') }}">Add car</a>
            </div>
        @else
            <div class="mb-3 row">
                <label for="date-from" class="col-sm-1 col-form-label">Date from</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="date-from" name="date-from" value="{{ $date_range[0] }}">
                </div>
            </div>

            <div class="table-responsive">
                <table id="assign-movements" class="table table-sm table-bordered">
                    <thead>
                    <tr>
                        <th style="position:sticky; left:0px; width: 6.1em;"></th>
                        @foreach($cars as $car)
                            <th class="align-middle text-center" style=" min-width: 17em;">
                                <div class="row">
                                    <div class="col">
                                        {{ $car->name }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-nowrap">
                                        @foreach($users as $user)
                                            @if ($user->id == $car->driver_id )
                                                Driver: {{$user->first_name}} {{$user->last_name}}
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($date_range as $key => $date)
                        <tr>
                            <th class="align-middle" style="position:sticky; left:0px; width: 7em;">
                                <ul class="list-unstyled mb-0">
                                    <li class="list-item text-center">{{ date_format(date_create($date), 'l') }}</li>
                                    <li class="list-item text-center">{{ date_format(date_create($date), 'd-m-Y') }}</li>
                                </ul>
                            </th>
                            @foreach($cars as $keyRow => $car)
                                <td class="p-0">
                                    <div class="row">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text rounded-0" style="width: 4em;">From</span>
                                            <select class="form-select form-select-sm rounded-0">
                                                <option>-- SELECT --</option>
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="time" class="form-control form-control-sm border-right-0 rounded-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text rounded-0" style="width: 4em;">To</span>
                                            <select class="form-select form-select-sm rounded-0">
                                                <option>-- SELECT --</option>
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                                @endforeach
                                            </select>
                                            <input type="time" class="form-control form-control-sm border-right-0 rounded-0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text rounded-0">Passenger 1</span>
                                            <select class="form-select form-select-sm rounded-0">
                                                <option value="0">-- SELECT --</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-group input-group-sm mb-1">
                                            <span class="input-group-text rounded-0">Passenger 2</span>
                                            <select class="form-select form-select-sm rounded-0">
                                                <option value="0">-- SELECT --</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text rounded-0">Passenger 3</span>
                                            <select class="form-select form-select-sm rounded-0">
                                                <option value="0">-- SELECT --</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center m-1">
                                        <div class="col-4">
                                            <a href="javascript:void(0)" onclick="javascript:saveTrip({{ $key }}, {{ $keyRow }})" class="link-success">Assign</a>
                                            <a href="javascript:void(0)" class="link-danger">clear</a>
                                        </div>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        $('#date-from').on('change', () => {
            console.log($('#date-from').val())
            window.location = "http://{{ request()->getHost() . ':' . request()->getPort() }}/risk/fleet/assign-movements?date-from=" + $('#date-from').val();
        });

        /**
         *
         */
        function saveTrip() {
            const url = 'http://{{ request()->getHost() . ':' . request()->getPort() }}/api/risk/saveNewTrip';
            $.ajax({
                type: "POST",
                url: url,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content'), '_method': 'patch'},
                data: {
                    csrfmiddlewaretoken: '{{ @csrf_token() }}',
                },
                success: function () {

                },
                error: function () {
                    console.log('Error');
                }
            });
        }

    </script>
@endsection
