<?php

namespace App\Http\Controllers\Risk\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Location;
use App\Models\MrItinerary;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application as ApplicationAlias;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FleetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return ApplicationAlias|Factory|View
     */
    public function __invoke(Request $request)
    {
        return view('risk.fleet.index', [
            'active_primary_menu' => '',
        ]);
    }

    public function movements_schedule()
    {
        return view('risk.fleet.movements_schedule', [
            'active_primary_menu' => 'movements_schedule',
        ]);
    }

    /**
     * @param Request $request
     * @return ApplicationAlias|Factory|View
     */
    public function assign_movements(Request $request)
    {
        if (Car::where('is_delete', 0)->count() > 0) {
            if ($request->input('date-from') == null) {
                $date_from = today()->format('d-m-Y');
            } else {
                $date_from = $request->input('date-from');
            }

            $date_range = [];
            for ($i = 0; $i < 7; $i++) {
                array_push($date_range, date('Y-m-d', strtotime("+" . $i . " day", strtotime($date_from))));
            }

            $cars = Car::select('id', 'name', 'driver_id')
                ->where('is_delete', 0)
                ->get();

            $users = User::select('id', 'first_name', 'last_name')
                ->orderBy('first_name')
                ->where('is_delete', 0)
                ->get();

            $locations = Location::select('id', 'name')
                ->orderBy('name')
                ->where('is_available', 1)
                ->where('is_delete', 0)
                ->get();


            $itineraries = MrItinerary::select()
                ->get();

//            dd($itineraries);

            return view('risk.fleet.assign_movements', [
                'active_primary_menu' => 'assign_movements',
                'no_cars' => false,
                'cars' => $cars,
                'users' => $users,
                'locations' => $locations,
                'date_range' => $date_range,
            ]);
        } else {
            return view('risk.fleet.assign_movements', [
                'active_primary_menu' => 'assign_movements',
                'no_cars' => true,
            ]);
        }
    }
}
