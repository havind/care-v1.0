@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ $profile->first_name }} {{ $profile->last_name }}</li>
    <li class="breadcrumb-item active" aria-current="page">Profile</li>
@endsection

@section('title',  $profile->first_name . ' ' . $profile->last_name . '\'s Profile')
@section('heading',  $profile->first_name . ' ' . $profile->last_name . '\'s Profile')

@section('primary_menu')
    @include('users.partials.primary_menu')
    <div class="fst-italic text-muted">
        <span>created_at {{ $profile->created_at }}</span>
        @if($profile->updated_at != null)
            (updated at {{ $profile->updated_at }})
        @endif
    </div>
@endsection

@section('content')
    <div class="container">

        {{--  CHECK CODE  --}}
        @if(Session('success'))
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle"></i> {{ Session::get('success') }}
            </div>
        @endif
        {{--  CHECK CODE  --}}

        <div class="row">
            <div class="col-6">
                <table class="table table-borderless table-responsive table-hover">
                    <tbody>
                    <tr>
                        <td colspan="2">
                            <h4>Full Name</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>First name</td>
                        <td>
                            {{ $profile->first_name }}
                        </td>
                    </tr>
                    <tr>
                        <td>Last name</td>
                        <td>
                            {{ $profile->last_name }}
                        </td>
                    </tr>
                    <tr class="pt-2">
                        <td>Username</td>
                        <td>
                            <code>{{ $profile->username }}</code>
                        </td>
                    </tr>
                    {{---------------------}}
                    <tr>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h4>Department</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>Position</td>
                        <td>
                            @if ($department != null)
                                @if ($position != null)
                                    <a href="{{ route('departments.positions.show', [$department->id, $position->id]) }}">{{ $position->name }}</a>
                                @else
                                    <span class="badge bg-warning text-dark">Not Available</span>
                                @endif
                            @else
                                <span class="badge bg-warning text-dark">Not Available</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Department</td>
                        <td>
                            @if ($department != null)
                                <a href="{{ route('departments.show', $department->id) }}">{{ $department->name }}</a>
                            @else
                                <span class="badge bg-warning text-dark">Not Available</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Supervisor</td>
                        <td>
                            @if ($profile->acting == 0)
                                @if ($profile->supervisor_id == 0)
                                    <span class="badge bg-warning text-dark">Not Available</span>
                                @else
                                    <a href="{{ route('staff.show', $supervisor->id) }}">{{ $supervisor->first_name }} {{ $supervisor->last_name }}</a>
                                @endif
                            @else
                                <a href="{{ route('staff.show', $supervisor->id) }}">{{ $supervisor->first_name }} {{ $supervisor->last_name }}</a>
                                <br/>
                                <a href="{{ route('staff.show', $acting_supervisor->id) }}">{{ $acting_supervisor->first_name }} {{ $acting_supervisor->last_name }}</a>
                                <span class="badge bg-secondary">Acting</span>
                            @endif
                        </td>
                    </tr>
                    {{---------------------}}
                    <tr>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h4>Contact Information</h4>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h6><strong>Work</strong></h6>
                        </td>
                    </tr>
                    <tr>
                        <td>E-Mail</td>
                        <td>
                            @if ($profile->work_email != null)
                                <a readonly href="mailto:{{$profile->work_email}}" type="text">{{$profile->work_email}}</a>
                            @else
                                <span class="badge bg-warning text-dark">Not Available</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Phone number</td>
                        <td>
                            @if ($profile->work_phone != null)
                                <a href="tel:{{ $profile->work_phone }}" readonly type="text"><code>+{{$profile->work_phone}}</code></a>
                            @else
                                <span class="badge bg-warning text-dark">Not Available</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h6><strong>Personal</strong></h6>
                        </td>
                    </tr>
                    <tr>
                        <td>E-Mail</td>
                        <td>
                            @if ($profile->personal_email != null)
                                <a readonly href="mailto:{{$profile->personal_email}}" type="text">{{$profile->personal_email}}</a>
                            @else
                                <span class="badge bg-warning text-dark">Not Available</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Phone number</td>
                        <td>
                            @if ($profile->personal_phone != null)
                                <a href="tel:+{{ $profile->personal_phone }}" readonly type="text"><code>+{{$profile->personal_phone}}</code></a>
                            @else
                                <span class="badge bg-warning text-dark">Not Available</span>
                            @endif
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
