@extends('admin.layouts.app')

@section('ib-content-actions')
    @include('admin.human_resource.users.partials.content_actions')
@endsection

@section('ib-content-body')
    <div class="d-flex">
        <div class="col-6">
            <table class="table table-hover table-borderless m-3 ib-show-table">
                <tbody>
                <tr>
                    <td colspan="2">
                        <h4>Full Name</h4>
                    </td>
                </tr>
                <tr>
                    <td>First name</td>
                    <td>{{ $user->user_first_name }}</td>
                </tr>
                <tr>
                    <td>Last name</td>
                    <td>{{ $user->user_last_name }}</td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>
                        <code class="text-dark">{{ $user->user_username }}</code>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4>Department</h4>
                    </td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>
                        {{ $user->department_title }}
                    </td>
                </tr>
                <tr>
                    <td>Position</td>
                    <td>
                        {{ $user->position_title }}
                    </td>
                </tr>
                <tr>
                    <td>Supervisor</td>
                    <td>
                        <a href="{{ route('a.human-resources.users.show', $user->supervisor_id) }}">{{ $user->supervisor_first_name }} {{ $user->supervisor_last_name }}</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h4>Contact Information</h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h6>Work</h6>
                    </td>
                </tr>
                <tr>
                    <td>E-Mail</td>
                    <td>{!! ($user->user_work_email != null) ? '+' . $user->user_work_email : '<span class="badge bg-warning text-black">Not Available</span>' !!}</td>
                </tr>
                <tr>
                    <td>Phone number</td>
                    <td>{!! ($user->user_work_phone != null) ? '+' . $user->user_work_phone : '<span class="badge bg-warning text-black">Not Available</span>'  !!}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <h6>Personal</h6>
                    </td>
                </tr>
                <tr>
                    <td>E-Mail</td>
                    <td>{!! ($user->user_personal_email != null) ? $user->user_personal_email : '<span class="badge bg-warning text-black">Not Available</span>'  !!}</td>
                </tr>
                <tr>
                    <td>Phone number</td>
                    <td>{!! ($user->user_personal_phone != null) ? '+' . $user->user_personal_phone : '<span class="badge bg-warning text-black">Not Available</span>' !!}</td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection
