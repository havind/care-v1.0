@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
    <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">Staff</a></li>
    <li class="breadcrumb-item active" aria-current="page">New</li>
@endsection

@section('title', 'Add new Staff')
@section('heading', 'Add new Staff')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">

        @if (session('userExists'))
            <div class="alert alert-danger">
                {{ session('userExists') }}
            </div>
        @endif

        <form method="POST" action="{{ route('staff.store') }}">
            @csrf
            <h4>Full Name</h4>
            <div class="mb-3 row">
                <label for="first-name" class="col-sm-2 col-form-label">First name<sup class="text-danger">*</sup></label>
                <div class="col-sm-5">
                    <input class="form-control" id="first-name" name="first-name" onkeyup="javascript:newUsername()" placeholder="First name" type="text">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="last-name" class="col-sm-2 col-form-label">Last name<sup class="text-danger">*</sup></label>
                <div class="col-sm-5">
                    <input class="form-control" id="last-name" name="last-name" onkeyup="javascript:newUsername()" placeholder="Last name" type="text">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="username" class="col-sm-2 col-form-label">Username<sup class="text-danger">*</sup></label>
                <div class="col-sm-5">
                    <input class="form-control" id="username" name="username" placeholder="username" type="text">
                </div>
            </div>
            <h4>Contact Information</h4>
            <h6>Work</h6>
            <div class="mb-3 row">
                <label for="work-email" class="col-sm-2 col-form-label">CARE Email</label>
                <div class="col-sm-5">
                    <input class="form-control" id="work-email" name="work-email" placeholder="email.address@care.de" type="text">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="work-phone" class="col-sm-2 col-form-label">CARE Phone</label>
                <div class="col-sm-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">+</span>
                        <input class="form-control" id="work-phone" name="work-phone" placeholder="964 700 000 0000" type="text">
                    </div>
                </div>
            </div>

            <h6>Personal</h6>
            <div class="mb-3 row">
                <label for="personal-email" class="col-sm-2 col-form-label">Personal Email</label>
                <div class="col-sm-5">
                    <input class="form-control" id="personal-email" name="personal-email" placeholder="Personal Email" type="text">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="personal-phone" class="col-sm-2 col-form-label">Phone number</label>
                <div class="col-sm-5">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">+</span>
                        <input class="form-control" id="personal-phone" name="personal-phone" placeholder="964 700 000 0000" type="text">
                    </div>
                </div>
            </div>
            <h4>Department</h4>
            <div class="mb-3 row">
                <label for="department" class="col-sm-2 col-form-label">Department<sup class="text-danger">*</sup></label>
                <div class="col-sm-5">
                    <select class="form-select" id="department" name="department">
                        <option value="0" selected>-- SELECT --</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="position" class="col-sm-2 col-form-label">Position</label>
                <div class="col-sm-5">
                    <select class="form-select" id="position" name="position" disabled>
                        <option value="0" selected>-- SELECT --</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="supervisor" class="col-sm-2 col-form-label">Supervisor<sup class="text-danger">*</sup></label>
                <div class="col-sm-5">
                    <select class="form-select" id="supervisor" name="supervisor">
                        <option value="0" selected>-- SELECT --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="offset-2 col-sm-10">
                    <button class="btn btn-outline-success" tabindex="6">Save</button>
                    <a class="btn btn-outline-danger" href="{{ route('departments.staff', $department->id) }}" tabindex="7">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>

        /**
         * 01. Filter Positions by Department.
         */
        $('#department').change(() => {
            if ($('#department').val() == 0) {
                $('#positions').val(0);
                $('#positions').prop('disabled', 'disabled')
            } else {
                $('#positions').prop('disabled', '')

                const url = 'http://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/departments/positionByDepartment/' + $('#department').val();

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "JSON",
                    success: function (response) {
                        $('#positions').empty();
                        $('#positions').append('<option value="0" selected>-- SELECT --</option>');
                        for (i = 0; i < response.positions.length; i++) {
                            $('#positions').append('<option value="' + response.positions[i]['id'] + '">' + response.positions[i]['name'] + '</option>');
                        }
                    }
                });
            }
        }); // End 01

        /**
         * 02. Generage username
         */
        function newUsername() {
            $('#username').val($('#first-name').val().toLowerCase() + '.' + $('#last-name').val().toLowerCase())

        };

    </script>
@endsection
