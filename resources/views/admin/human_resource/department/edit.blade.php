@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('a.index') }}">Administration</a></li>
    <li class="breadcrumb-item active" aria-current="page">Users</li>
@endsection

@section('title', $user->first_name . ' ' . $user->last_name)
@section('heading', $user->first_name . ' ' . $user->last_name)

@section('primary_menu')
    @include('admin.human_resource.users.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        {{ $user }}

        <h4>Full Name</h4>
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th class="text-center">First Name</th>
                <th class="text-center">Last Name</th>
                <th class="text-center">Username</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center">{{ $user->first_name }}</td>
                <td class="text-center">{{ $user->last_name }}</td>
                <td class="text-center">
                    <code>{{ $user->username }}</code>
                </td>
            </tr>
            </tbody>
        </table>

        <h4>Department</h4>
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th class="text-center">Position</th>
                <th class="text-center">Department</th>
                <th class="text-center">Supervisor</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ $user->position_id }}</td>
                <td>{{ $user->department_id }}</td>
                <td></td>
            </tr>
            </tbody>
        </table>

        <h4>Contact Information</h4>
        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th class="text-center">Type</th>
                <th class="text-center">Email</th>
                <th class="text-center">Phone Number</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>Personal</th>
                <td>{{ ($user->personal_email != null) ? $user->personal_email : 'Not Available' }}</td>
                <td>{{ ($user->personal_phone != null) ? '+' . $user->personal_phone : 'Not Available' }}</td>
            </tr>
            <tr>
                <th>Work</th>
                <td>{{ ($user->work_email != null) ? $user->work_email : 'Not Available' }}</td>
                <td>{{ ($user->work_phone != null) ? $user->work_phone : 'Not Available' }}</td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection
