@extends('admin.layouts.app')

@section('ib-content-actions')
    @include('admin.human_resource.users.partials.content_actions')
@endsection

@section('ib-content-body')
    <div class="mx-3 mt-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="d-flex">
        <div class="col-lg-4 col-6 col-xs-12">
            <form id="edit-user" method="POST" action="{{ route('a.human-resources.users.update', $user->user_id) }}">
                @csrf
                @method('PUT')
                <table class="table table-hover table-borderless m-3">
                    <tbody>
                    <tr>
                        <td colspan="2">
                            <h4>Full Name</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>First name</td>
                        <td>
                            <input class="form-control" id="user-first-name" name="user-first-name" type="text" value="{{ $user->user_first_name }}">
                        </td>
                    </tr>
                    <tr>
                        <td>Last name</td>
                        <td>
                            <input class="form-control" id="user-last-name" name="user-last-name" type="text" value="{{ $user->user_last_name }}">
                        </td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td>
                            <input class="form-control" id="user-username" name="user-username" type="text" value="{{ $user->user_username }}">
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
                            <select class="form-select" id="user-department" name="user-department">
                                <option value="0" disabled>-- SELECT DEPARTMENT --</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Position</td>
                        <td>
                            <select id="user-position" name="user-position" class="form-select">
                                <option value="0" disabled>-- SELECT POSITION --</option>
                                {{ $user->position_title }}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Supervisor</td>
                        <td>
                            <select id="user-supervisor" name="user-supervisor" class="form-select">
                                <option value="0" disabled>-- SELECT SUPERVISOR --</option>
                            </select>
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
                        <td>E-mail</td>
                        <td>
                            <input class="form-control" id="user-work-email" name="user-work-email" type="email" value="{{ $user->user_work_email }}">
                        </td>
                    </tr>
                    <tr>
                        <td>Phone number</td>
                        <td>
                            @if($user->user_work_phone != null)
                                <input class="form-control" id="user-work-phone" name="user-work-phone" type="text" value="{{ $user->user_work_phone }}">
                            @else
                                <input class="form-control" id="user-work-phone" name="user-work-phone" type="text" placeholder="Not Available">
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <h6>Personal</h6>
                        </td>
                    </tr>
                    <tr>
                        <td>E-mail</td>
                        <td>
                            <input class="form-control" id="user-personal-email" name="user-personal-email" type="email" value="{{ $user->user_personal_email != null ? $user->user_personal_email : 'Not Available' }}">
                        </td>
                    </tr>
                    <tr>
                        <td>Phone number</td>
                        <td>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">+</span>
                                @if($user->user_personal_phone != null)
                                    <input class="form-control" id="user-personal-phone" name="user-personal-phone" type="text" value="{{ $user->user_personal_phone }}">
                                @else
                                    <input class="form-control" id="user-personal-phone" name="user-personal-phone" type="text" placeholder="Not Available">
                                @endif
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection

@section('ib-content-footer')
    <button type="submit" class="btn btn-success" form="edit-user">Update</button>
    <a href="{{ route('a.human-resources.users.show', $user->user_id) }}" class="btn btn-link text-secondary text-decoration-none">Cancel</a>
@endsection

@section('scripts')
    @include('admin.human_resource.users.js.edit')
@endsection
