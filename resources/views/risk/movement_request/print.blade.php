<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') · {{ config('app.name', 'CARE Iraq') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="{{ asset('css/print.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/print.css') }}" rel="stylesheet" media="print" type="text/css">
</head>
<body>

<page size="A4">
    <section id="header">
        <table class="table table-borderless table-header">
            <tr>
                <td>
                    <img id="logo" src="{{ asset('img/logo_print.png') }}" style="width: 150px">
                </td>
                <td class="d-flex justify-content-center">
                    {!! QrCode::size(50)->style('round')->eye('circle')->color(225, 106, 3)->generate(route('movement-requests.show', $movement_request->id)) !!}
                </td>
            </tr>
            <tr>
                <td><h4>Movement Request Form</h4></td>
                <td class="d-flex justify-content-center"><span>{{ $movement_request->name }}</span></td>
            </tr>
        </table>
    </section>
    <hr/>
    <section id="content">
        <aside>
            <h5 class="bold">Travel Purpose</h5>
            <p>{!! $movement_request->purpose !!}</p>
        </aside>

        @if ($passengers->count() > 0)
            <aside>
                <h5 class="bold">Passengers</h5>
                <table class="table table-sm table-bordered table-hover table-striped">
                    <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th style="min-width: 20%;">Full Name</th>
                        <th>Financial Codes</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($passengers as $passenger)
                        <tr>
                            <td class="align-middle text-center">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                @foreach($users as $user)
                                    @if($passenger->passenger_id == $user->id)
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    @endif
                                @endforeach
                            </td>
                            <td class="p-0">
                                <table class="table table-sm table-bordered m-0 table-finance">
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
                                                <td class="text-center">
                                                    @foreach($fundCodes as $fundCode)
                                                    @endforeach

                                                    @if($fundCode->id == $passengerFinance->fund_code_id)
                                                        {{ $fundCode->name }}
                                                    @endif

                                                </td>
                                                <td class="text-center">
                                                    @foreach($budgetLines as $budgetLine)
                                                        @if($budgetLine->id == $passengerFinance->budget_line_id)
                                                            {{ $budgetLine->name }}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="text-center">
                                                    {{ $passengerFinance->percentage }}</td>
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
            </aside>
        @endif

        @if ($items->count() > 0)
            <aside>
                <h5 class="bold">Items</h5>
                @foreach($items as $item)
                    <tr>
                        <td class="align-middle text-center p-0">{{ $loop->iteration }}</td>
                        <td class="align-middle p-0">
                            {{ $item->description }}
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
                                    @if($itemFinance->item_id == $item->id)
                                        <tr class="text-center">
                                            <td class="align-middle p-0">
                                                @foreach($fundCodes as $fundCode)
                                                    @if($fundCode->id == $itemFinance->fund_code_id)
                                                        {{ $fundCode->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="align-middle p-0">
                                                @foreach($budgetLines as $budgetLine)
                                                    @if($budgetLine->id == $itemFinance->budget_line_id)
                                                        {{ $budgetLine->name }}
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td class="align-middle p-0">%{{ $itemFinance->percentage }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </aside>
        @endif

        @if ($itineraries->count() > 0)
            <aside>
                <h5 class="bold">Itinerary</h5>
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
                            <td class="align-middle p-0">
                                @foreach($locations as $location)
                                    @if($location->id == $itinerary->from_location_id)
                                        {{ $location->name }}
                                    @endif
                                @endforeach
                            </td>
                            <td class="align-middle p-0">
                                {{ $itinerary->from_date->format('d-m-Y') }}
                            </td>
                            <td class="align-middle p-0">
                                {{ $itinerary->from_time }}
                            </td>
                            <td class="align-middle p-0">
                                @foreach($locations as $location)
                                    @if($location->id == $itinerary->to_location_id)
                                        {{ $location->name }}
                                    @endif
                                @endforeach
                            </td>
                            <td class="align-middle p-0">
                                {{ $itinerary->to_date->format('d-m-Y') }}
                            </td>
                            <td class="align-middle p-0">
                                {{ $itinerary->to_time }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </aside>
        @endif
    </section>
    <section id="footer">
        Footer
    </section>
</page>
<script>
    // window.print();
</script>
</body>
</html>
