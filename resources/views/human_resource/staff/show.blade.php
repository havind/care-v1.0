@extends('layouts.app')

@section('title', $user->first_name . ' ' . $user->last_name )
@section('heading', $user->first_name . ' ' . $user->last_name )

@section('primary_menu')
    @include('human_resource.staff.partials.primary_menu')

    <div class="form-text fst-italic">created at {{ date('h:ia, d-m-Y', strtotime($user->created_at)) }}
        @if($user->updated_at != null )
            (Updated at {{ date('h:ia, d-m-Y', strtotime($user->updated_at)) }})
        @endif
    </div>
@endsection

@section('content')
    <div class="container">
        @if(Session::has('password'))
            <div class="alert alert-danger" role="alert">
                The Password is <code>{{ Session::get('password') }}</code>
            </div>
        @endif
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
                            {{ $user->first_name }}
                        </td>
                    </tr>
                    <tr>
                        <td>Last name</td>
                        <td>
                            {{ $user->last_name }}
                        </td>
                    </tr>
                    <tr class="pt-2">
                        <td>Username</td>
                        <td>
                            <code>{{ $user->username }}</code>
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
                            @if ($user->acting == 0)
                                @if ($user->supervisor_id == 0)
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
                            @if ($user->work_email != null)
                                <a readonly href="mailto:{{$user->work_email}}" type="text">{{$user->work_email}}</a>
                            @else
                                <span class="badge bg-warning text-dark">Not Available</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Phone number</td>
                        <td>
                            @if ($user->work_phone != null)
                                <a href="tel:{{ $user->work_phone }}" readonly type="text"><code>+{{$user->work_phone}}</code></a>
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
                            @if ($user->personal_email != null)
                                <a readonly href="mailto:{{$user->personal_email}}" type="text">{{$user->personal_email}}</a>
                            @else
                                <span class="badge bg-warning text-dark">Not Available</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Phone number</td>
                        <td>
                            @if ($user->personal_phone != null)
                                <a href="tel:{{ $user->work_phone }}" readonly type="text"><code>+{{$user->personal_phone}}</code></a>
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
