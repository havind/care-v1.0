<?php

namespace App\Http\Controllers\Admin\HumanResource;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class ADepartmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:adm|humanResources|departments|index', ['only' => 'index']);
        $this->middleware('permission:adm|humanResources|departments|create', ['only' => ['create', 'store']]);
        $this->middleware('permission:adm|humanResources|departments|edit|own', ['only' => ['edit', 'update']]);
        $this->middleware('permission:adm|humanResources|departments|edit|any', ['only' => ['edit', 'update']]);
        $this->middleware('permission:adm|humanResources|departments|delete|own', ['only' => ['delete', 'destroy']]);
        $this->middleware('permission:adm|humanResources|departments|delete|any', ['only' => ['delete', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::select(
            'departments.id AS dp_id',
            'departments.name AS dp_title',
            'departments.supervisor_id AS dp_supervisor_id',
            'u.first_name AS dp_supervisor_first_name',
            'u.last_name AS dp_supervisor_last_name',
        )
            ->leftJoin('users AS u', 'u.id', '=', 'departments.supervisor_id')
            ->where('departments.is_delete', 0)
            ->where('u.is_delete', 0)
            ->get();

        return view('admin.human_resource.department.index', [
            'navbar_category' => 'human-resources',
            'navbar_active' => 'departments',
            'title' => 'Departments',
            'departments' => $departments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = Department::select(
            'departments.id AS dp_id',
            'departments.name AS dp_title',
            'departments.supervisor_id AS dp_supervisor_id',
            'u.first_name AS dp_supervisor_first_name',
            'u.last_name AS dp_supervisor_last_name',
            'departments.description AS dp_description',
            'departments.created_at AS dp_created_at',
            'departments.updated_at AS dp_updated_at',
        )
            ->leftJoin('users AS u', 'u.id', '=', 'departments.supervisor_id')
            ->firstWhere('departments.id', $id);

        return view('admin.human_resource.department.show', [
            'navbar_active' => 'departments',
            'title' => $department->dp_title,
            'department' => $department,
            'active_primary_menu' => 'view',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Show the specified resource from storage to be deleted.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
