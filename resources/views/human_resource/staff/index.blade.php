@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
    <li class="breadcrumb-item active" aria-current="page">Staff</li>
@endsection

@section('title', 'Staff')
@section('heading', 'Staff')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        @authCheck('humanResource_staff_create')
        <a class="btn btn-primary mb-3" href="{{ route('staff.create') }}">
            <span class="material-icons">add_box</span> Add new Staff
        </a>
        @endif

        @if(empty(count($staff)))
            <div class="alert alert-warning align-items-center m-3 align-content-center" role="alert">
                <span class="material-icons">error_outline</span> You have not submitted any Movement Requests.
            </div>
        @else
            @include('human_resource.staff.partials.table_staff')
        @endif
    </div>
@endsection

@section('footnote')
    <hr/>
    <table>
        <tr>
            <td><small><span class="material-icons">person</span></small></td>
            <td><small>Refers to personal data</small></td>
        </tr>
        <tr>
            <td><small><span class="material-icons">work_outline</span></small></td>
            <td><small>Refers to Work data</small></td>
        </tr>
        <tr>
            <td><small><span class="material-icons text-info">mode_edit</span></small></td>
            <td><small>Edit</small></td>
        </tr>
        <tr>
            <td><small><span class="material-icons text-danger">delete</span></small></td>
            <td><small>Delete</small></td>
        </tr>
    </table>
@endsection
