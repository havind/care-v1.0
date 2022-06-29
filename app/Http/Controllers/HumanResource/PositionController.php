<?php

namespace App\Http\Controllers\HumanResource;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
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
    public function index($department_id)
    {
        $department = Department::firstWhere('id', $department_id);

        $positions = Position::where('department_id', $department_id)
            ->where('is_delete', false)
            ->get(['id', 'name', 'description', 'created_at', 'updated_at']);

        return view('human_resource.department.positions.index', [
            'active_primary_menu' => 'positions',
            'department' => $department,
            'positions' => $positions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create($department_id)
    {
        $department = Department::select('id', 'name')->firstWhere('id', $department_id);

        return view('human_resource.department.positions.create', [
            'department' => $department,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $position = Position::find($id);

        $position->name = $request->input('positions-name');
        $position->description = $request->input('positions-description');
        $position->department_id = $id;
        $position->save();

        return redirect()->route('departments.positions.show', [
            $id,
            Position::get()->last()->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($department_id, $position_id)
    {
        $department = Department::select('id', 'name')->find($department_id);

        $position = Position::select('id', 'name', 'department_id', 'description')
            ->where('is_delete', 0)
            ->firstWhere('id', $position_id);

        if ($position != null) {
            return view('human_resource.department.positions.show', [
                'active_primary_menu' => 'view',
                'department' => $department,
                'positions' => $position,
            ]);
        } else {
            return redirect()->route('errors.page-not-found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($department_id, $position_id)
    {
        $department = Department::select('id', 'name')->find($department_id);

        $position = Position::select('id', 'name', 'department_id', 'description')
            ->where('is_delete', 0)
            ->firstWhere('id', $position_id);
        if ($position != null) {
            return view('human_resource.department.positions.edit', [
                'active_primary_menu' => 'edit',
                'department' => $department,
                'positions' => $position,
            ]);
        } else {
            return redirect()->route('errors.page-not-found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function delete($department_id, $position_id)
    {
        $department = Department::select('id', 'name')->find($department_id);

        $position = Position::select('id', 'name', 'department_id', 'description')
            ->where('is_delete', 0)
            ->firstWhere('id', $position_id);

        return view('human_resource.department.positions.delete', [
            'active_primary_menu' => 'delete',
            'department' => $department,
            'positions' => $position,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Request $request, $department_id, $position_id)
    {
        if ($request->input('is-delete') == 1) {
            Position::where('id', $position_id)
                ->update([
                    'is_delete' => 1,
                    'updated_at' => now(),
                ]);

            return redirect()->route('departments.positions.index', $department_id);
        }
    }
}
