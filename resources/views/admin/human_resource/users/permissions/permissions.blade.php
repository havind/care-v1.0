@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('a.index') }}">Administration</a></li>
    <li class="breadcrumb-item"><a href="{{ route('a.users.index') }}">Users</a></li>
    <li class="breadcrumb-item"><a href="{{ route('a.users.show', $profile->id) }}">{{ $profile->first_name }} {{ $profile->last_name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Permissions</li>
@endsection

@section('title', $profile->first_name . ' ' . $profile->last_name . ' Permissions')
@section('heading', $profile->first_name . ' ' . $profile->last_name . ' Permissions')

@section('primary_menu')
    @include('admin.human_resource.users.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        @if(empty(count($permissions)))
            <div class="alert alert-warning align-items-center m-3" role="alert">
                <i class="bi bi-exclamation-square-fill"></i> You have not submitted any Movement Requests.
            </div>
        @else
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr class="text-center">
                    <td class="align-middle" style="width: 5%;">#</td>
                    <td class="align-middle" style="width: 5%;">Enable</td>
                    <td class="align-middle">Permission</td>
                </tr>
                </thead>
                <tbody>

                <form id="permissions" method="POST" action="{{ route('a.users.update-permissions', $profile->id) }}">
                    @method('PUT')
                    @csrf
                    @foreach($permissions as $permission)
                        <tr>
                            <td class="align-middle text-center">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                <div class="form-check form-switch">
                                    @foreach($user_permissions as $user_permission)
                                        @if($user_permission->permission == $permission->name)
                                            @if($user_permission->value == true)
                                                <input checked class="form-check-input" id="{{ $permission->name }}" name="{{ $permission->name }}" role="switch" type="checkbox"/>
                                            @elseif($user_permission->value == false)
                                                <input class="form-check-input" id="{{ $permission->name }}" name="{{ $permission->name }}" role="switch" type="checkbox"/>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="align-middle">{{ $permission->name }}</td>
                        </tr>
                    @endforeach
                </form>
                </tbody>
            </table>

            <button type="submit" class="btn btn-success" form="permissions">Update</button>
            <a class="btn text-danger" href="{{ route('a.users.show', $profile->id) }}">Cancel</a>

        @endif
    </div>
@endsection
