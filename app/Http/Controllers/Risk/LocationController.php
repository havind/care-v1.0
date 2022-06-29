<?php

namespace App\Http\Controllers\Risk;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ibFunctions;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
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
        $locations = Location::select('id', 'name', 'is_krg', 'is_available', 'is_accommodation')
            ->orderBy('name')
            ->where('is_delete', 0)
            ->get();

        return view('risk.location.index', [
            'locations' => $locations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|string
     */
    public function create()
    {
        if (!ibFunctions::check_permission('risk_location_create')) {
            return redirect()->route('access_denied');
        } else {
            return view('risk.location.create');
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
        if (!ibFunctions::check_permission('risk_location_create')) {
            return redirect()->route('access_denied');
        } else {
            if ((Location::firstWhere('name', $request->input('location-name')) == null)) {
                $location = new Location();

                $location->name = $request->input('location-name');
                $location->is_krg = ($request->input('location-is-krg') == 'on') ? 1 : 0;
                $location->is_available = ($request->input('location-is-available') == 'on') ? 1 : 0;
                $location->is_accommodation = ($request->input('location-is-accommodation') == 'on');

                $location->save();

                return redirect()->route('locations.index');
            } else {
                return redirect()->route('locations.create')->with('status', 'The Location is already available.');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!ibFunctions::check_permission('risk_location_edit')) {
            return redirect()->route('access_denied');
        } else {
            $location = Location::select('id', 'name', 'is_krg', 'is_available', 'is_accommodation')
                ->firstWhere('id', $id);
            return view('risk.location.edit', [
                'active_primary_menu' => 'edit',
                'location' => $location,
            ]);
        }
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
        Location::where('id', $id)
            ->update([
                'name' => $request->input('location-name'),
                'is_krg' => ($request->input('location-is-krg') == 'on') ? 1 : 0,
                'is_available' => ($request->input('location-is-available') == 'on') ? 1 : 0,
                'is_accommodation' => ($request->input('location-is-accommodation') == 'on') ? 1 : 0,
            ]);

        return redirect()->route('locations.index');
    }

    /**
     * Display the specified resource from storage to be deleted.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $location = Location::select()
            ->firstWhere('id', $id);

        return view('risk.location.delete', [
            'active_primary_menu' => 'delete',
            'location' => $location,
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
        Location::where('id', $id)
            ->update([
                'is_delete' => 1,
            ]);

        return redirect()->route('locations.index');
    }
}
