<?php

namespace App\Http\Controllers\Risk\Fleet;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ibFunctions;
use App\Models\Car;
use App\Models\CarBrand;
use App\Models\User;
use Illuminate\Http\Request;

class CarController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::select()
            ->where('is_delete', 0)
            ->get();

        $car_brands = CarBrand::all();

        $drivers = User::select('id', 'first_name', 'last_name')
            ->get();

        return view('risk.fleet.cars.index', [
            'active_primary_menu' => 'cars',
            'cars' => $cars,
            'car_brands' => $car_brands,
            'drivers' => $drivers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        if (ibFunctions::check_permission('risk_fleet_car_create')) {
            $make = CarBrand::select('id', 'name')
                ->orderBy('name')
                ->get();
            $users = User::select('id', 'first_name', 'last_name')
                ->orderBy('first_name')
                ->where('is_active', 1)
                ->where('is_delete', 0)
                ->get();
            return view('risk.fleet.cars.create', [
                'make' => $make,
                'users' => $users,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (ibFunctions::check_permission('risk_fleet_car_create')) {
            $car_exists = Car::where('vin', $request->input('car-vin'));
            if ($car_exists->count() == 0) {
                Car::insert([
                    'make' => $request->input('car-make'),
                    'model' => $request->input('car-model'),
                    'year' => $request->input('car-year'),
                    'vin' => $request->input('car-vin'),
                    'driver_id' => $request->input('car-driver'),
                ]);
                $car = Car::orderBy('created_at')->first();
                Car::where('id', $car->id)
                    ->update([
                        'name' => 'Vehicle-' . $car->id,
                        'created_at' => now(),
                        'updated_at' => null,
                    ]);
                return redirect()->route('cars.show', $car->id);
            } else {
                return redirect()->route('cars.create');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car = Car::firstWhere('id', $id);

        $make = CarBrand::select('name')
            ->orderBy('name')
            ->where('id', $car->make)
            ->first();

        $driver = User::select('first_name', 'last_name')
            ->where('is_delete', 0)
            ->where('id', $car->driver_id)
            ->first();

        return view('risk.fleet.cars.show', [
            'active_primary_menu' => 'view',
            'car' => $car,
            'make' => $make,
            'driver' => $driver,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Car::select('id', 'vin', 'name', 'make', 'model', 'year', 'driver_id', 'created_at', 'updated_at')
            ->where('id', $id)
            ->where('is_delete', 0)
            ->first();

        $users = User::select('id', 'first_name', 'last_name')
            ->orderBy('first_name')
            ->where('is_active', 1)
            ->where('is_delete', 0)
            ->get();

        $make = CarBrand::select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('risk.fleet.cars.edit', [
            'active_primary_menu' => 'edit',
            'car' => $car,
            'make' => $make,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $car = Car::select('id', 'name')
            ->where('id', $id)
            ->where('is_delete', 0)
            ->first();

        return view('risk.fleet.cars.delete', [
            'active_primary_menu' => 'delete',
            'car' => $car,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Car::where('id', $id)
            ->update([
                'is_delete' => 1,
            ]);

        return redirect()->route('cars.index');
    }
}
