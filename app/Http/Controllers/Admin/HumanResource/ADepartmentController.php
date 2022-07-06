<?php

namespace App\Http\Controllers\Admin\HumanResource;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('admin.human_resource.departments.index', [
            'navbar_category' => 'human-resources',
            'navbar_active' => 'departments',
            'title' => 'Departments',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $department = Department::select(
            'departments.id AS dep_id',
            'departments.name AS dep_title',
            'departments.supervisor_id AS supervisor_id',
            'u.first_name AS supervisor_first_name',
            'u.last_name AS supervisor_last_name',
            'departments.description AS dep_description',
            'departments.created_at AS dep_created_at',
            'departments.updated_at AS dep_updated_at',
        )
            ->leftJoin('users AS u', 'u.id', '=', 'departments.supervisor_id')
            ->firstWhere('departments.id', $id);

        return view('admin.human_resource.departments.show', [
            'navbar_category' => 'human-resources',
            'navbar_active' => 'departments',
            'active_primary_menu' => 'view',
            'title' => $department->dep_title,
            'department' => $department,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $department = Department::select(
            'departments.id AS dep_id',
            'departments.name AS dep_title',
            'departments.supervisor_id AS supervisor_id',
            'u.first_name AS supervisor_first_name',
            'u.last_name AS supervisor_last_name',
            'departments.description AS dep_description',
            'departments.created_at AS dep_created_at',
            'departments.updated_at AS dep_updated_at',
        )
            ->leftJoin('users AS u', 'u.id', '=', 'departments.supervisor_id')
            ->firstWhere('departments.id', $id);

        return view('admin.human_resource.departments.edit', [
            'navbar_category' => 'human-resources',
            'navbar_active' => 'departments',
            'active_primary_menu' => 'edit',
            'title' => 'Edit ' . $department->dep_title,
            'department' => $department,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Show the specified resource from storage to be deleted.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function delete($id)
    {
        return view('admin.human_resource.departments.delete', [
            'navbar_category' => 'human-resources',
            'navbar_active' => 'departments',
            'active_primary_menu' => 'delete',
            'title' => 'Edit',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
