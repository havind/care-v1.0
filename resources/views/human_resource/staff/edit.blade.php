@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
    <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">Staff</a></li>
    <li class="breadcrumb-item"><a href="{{ route('staff.show', $user->id) }}">{{ $user->first_name }} {{ $user->last_name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('title', 'Edit ' . $user->first_name . ' ' . $user->last_name)
@section('heading', 'Edit ' . $user->first_name . ' ' . $user->last_name)

@section('primary_menu')
    @include('human_resource.staff.primary_menu')
@endsection

@section('content')

    <div class="container">
        @authCheck('humanResource_staff_edit')
        <form method="POST" action="{{ route('staff.update', $user->id) }}">
            @method('PUT')
            @csrf
            <h4>Full Name</h4>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">First name</label>
                <div class="col-sm-5">
                    <input class="form-control" id="first-name" name="first-name" type="text" value="{{ $user->first_name }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Last name</label>
                <div class="col-sm-5">
                    <input class="form-control" id="last-name" name="last-name" type="text" value="{{ $user->last_name }}">
                </div>
            </div>

            <h4>Department</h4>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Position</label>
                <div class="col-sm-5">
                    <select class="form-select" id="position-id" name="position-id">
                        @if ($user->position_id == 0)
                            <option value="0" selected>-- SELECT --</option>
                        @else
                            <option value="0">-- SELECT --</option>
                            @foreach($positions as $position)
                                @if($position->id == $user->position_id)
                                    <option value="{{ $position->id }}" selected>{{ $position->name }}</option>
                                @else
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Department</label>
                <div class="col-sm-5">
                    <select class="form-select" id="department-id" name="department-id">
                        @if ($user->department_id == 0)
                            <option value="0" selected>-- SELECT --</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        @else
                            <option value="0">-- SELECT --</option>
                            @foreach($departments as $department)
                                @if ($department->id == $user->department_id)
                                    <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                                @else
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Supervisor</label>
                <div class="col-sm-5">
                    @if ($user->acting_supervisor_id == 0)
                        <select class="form-select" id="supervisor-id" name="supervisor-id">
                            <option value="0">-- SELECT --</option>
                            @foreach($users as $userm)
                                @if ($userm->id == $user->supervisor_id)
                                    <option value="{{ $userm->id }}" selected>{{ $userm->first_name }} {{ $userm->last_name }}</option>
                                @else
                                    <option value="{{ $userm->id }}">{{ $userm->first_name }} {{ $userm->last_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    @endif
                    @if ($user->acting_supervisor_id != 0)
                        <div class="row">
                            <div class="col">
                                <select class="form-select" id="supervisor-id" name="supervisor-id">
                                    <option value="0">-- SELECT --</option>
                                    @foreach($users as $userm)
                                        @if ($userm->id == $user->supervisor_id)
                                            <option value="{{ $userm->id }}" selected>{{ $userm->first_name }} {{ $userm->last_name }}</option>
                                        @else
                                            <option value="{{ $userm->id }}">{{ $userm->first_name }} {{ $userm->last_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <h4>Contact Information</h4>
            <h6>Work</h6>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">E-Mail</label>
                <div class="col-sm-5">
                    @if ($user->work_email != null)
                        <input type="text" class="form-control" id="work-email" name="work-email" value="{{ $user->work_email }}">
                    @else
                        <input type="text" class="form-control" id="work-email" name="work-email" placeholder="Not Available">
                    @endif

                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Phone number</label>
                <div class="col-sm-5">
                    {{--                    @if ($users->work_phone != null)--}}
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">+</span>
                        <input class="form-control" id="work-phone" name="work-phone" placeholder="Not Available" type="text" value="{{ ($user->work_phone != null) ? $user->work_phone : '' }}">
                    </div>
                    {{--                    @endif--}}

                </div>
            </div>

            <h6>Personal</h6>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">E-Mail</label>
                <div class="col-sm-5">
                    @if ($user->personal_email != null)
                        <input type="text" class="form-control" id="personal-email" name="personal-email" value="{{ $user->personal_email }}">
                    @else
                        <input type="text" class="form-control" id="personal-email" name="personal-email" placeholder="Not Available">
                    @endif
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label">Phone number</label>
                <div class="col-sm-5">
                    @if ($user->personal_phone != null)
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">+</span>
                            <input type="text" class="form-control" id="personal-phone" name="personal-phone" value="{{ $user->personal_phone }}">
                        </div>
                    @else
                        <input type="text" class="form-control" id="personal-phone" name="personal-phone" placeholder="Not Available">
                    @endif
                </div>
            </div>

            <div class="my-3 row">
                <div class="col-sm-5 offset-2">
                    <button class="btn btn-outline-success">Update</button>
                    <a class="btn btn-outline-danger" href="{{ route('staff.show', $user->id) }}">Cancel</a>
                </div>
            </div>

        </form>
        @else

        @endif
    </div>
@endsection

@section('scripts')
    <script>
        $('#work-phone').on('focus', () => {
            $('#work-phone').attr("placeholder", "964 700 000 0000")
        });

        $('#work-phone').on('focusout', () => {
            $('#work-phone').attr("placeholder", "Not Available")
        });

        $('#personal-phone').on('focus', () => {
            $('#personal-phone').attr("placeholder", "964 700 000 0000")
        });

        $('#personal-phone').on('focusout', () => {
            $('#personal-phone').attr("placeholder", "Not Available")
        });

    </script>
@endsection
