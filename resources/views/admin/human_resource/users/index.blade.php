@extends('admin.layouts.app')

@section('ib-header-actions')
    <li class="list-inline-item">
        <a class="ib-btn ib-btn-primary" aria-current="page" href="{{ route('a.human-resources.users.create') }}">
            <span class="material-icons">add</span>
            <span>New</span>
        </a>
    </li>
@endsection

@section('ib-content-body')

    <div id="no-users" class="position-absolute w-50 d-flex invisible mx-3 mt-3">
        <div class="alert alert-primary flex-fill" role="alert">
            <span class="material-icons">info</span>
            No Users found, please <a class="fw-bold fst-italic" href="{{ route('a.human-resources.users.create') }}">add a new user</a>
        </div>
    </div>

    <div id="users-available" class="invisible">
        <div id="users-filters">

        </div>

        @if(empty(count($users)))
            <div class="alert alert-warning align-items-center m-3" role="alert">
                <i class="bi bi-exclamation-square-fill"></i> You have users yes.
            </div>
        @else
            <div id="users"></div>
        @endif


        <div class="d-flex justify-content-center align-items-center" id="ib-loading">
            <h1 class="display-6">
                <img style="width: 53px; height: 53px;" src="{{ asset('svg/loading.svg') }}">
                <span style="">Users will be loaded Soon.</span>
            </h1>
        </div>
    </div>
@endsection

@section('footnote')
    <hr/>
    <table>
        <tr>
            <td><small><span class="material-icons text-muted">person</span></small></td>
            <td><small>Refers to personal data</small></td>
        </tr>
        <tr>
            <td><small><span class="material-icons text-muted">work_outline</span></small></td>
            <td><small>Refers to Work data</small></td>
        </tr>
        <tr>
            <td><small><span class="material-icons md-18 text-warning">lock_reset</span></small></td>
            <td><small>Reset password</small></td>
        </tr>
        <tr>
            <td><small><span class="material-icons text-danger">vpn_key</span></small></td>
            <td><small>Permissions</small></td>
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

@section('scripts')
    @include('admin.human_resource.users.js.index')
@endsection
