@extends('admin.layouts.app')

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
        <form method="POST" action="{{ route('staff.store') }}">
            @csrf
            <div class="mb-3 row">
                <label for="first-name" class="col-sm-2 col-form-label">Full name</label>
                <div class="col-sm-5">
                    <div class="row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">First name</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="first-name" name="first-name" placeholder="First name" type="text">
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="row">
                        <label for="last-name" class="col-sm-3 col-form-label">Last name</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="last-name" name="last-name" placeholder="Last name" type="text">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="personal-email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-5">
                    <div class="row">
                        <label for="personal-email" class="col-sm-3 col-form-label">Personal Email</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="personal-email" name="personal-email" placeholder="Personal Email" type="text">
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="row">
                        <label for="care-email" class="col-sm-3 col-form-label">CARE Email</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="care-email" name="care-email" placeholder="CARE Email" type="text">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="personal-phone" class="col-sm-2 col-form-label">Phone number</label>
                <div class="col-sm-5">
                    <div class="row">
                        <label for="personal-phone" class="col-sm-3 col-form-label">Personal Phone</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="personal-phone" name="personal-phone" placeholder="Personal Phone" type="text">
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="row">
                        <label for="care-phone" class="col-sm-3 col-form-label">CARE Phone</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="care-phone" name="care-phone" placeholder="CARE Phone" type="text">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="department" class="col-sm-2 col-form-label">Department</label>
                <div class="col-sm-5">
                    <div class="row">
                        <label for="department" class="col-sm-3 col-form-label">Department</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="department" name="department">
                                <option value="0" selected>-- SELECT --</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Position</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="position" name="position" disabled>
                                <option value="0" selected>-- SELECT --</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-sm-10 offset-2">
                    <button type="submit" class="btn btn-outline-success">Save</button>
                    <a class="btn btn-link" href="{{ route('staff.index') }}">Cancel</a>
                </div>
            </div>

        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script>
        $(function () {

        });

        $('#departments').on('change', () => {
            if ($('#departments option:selected').val() != 0) {
                console.log($('#departments option:selected').val());

                i = 0;
                positions = [];
                {{ $i = 0 }}
                    @foreach($positions as $position)
                    positions[{{$i}}]['id'] = {{ $position->id }};
                positions[{{$i}}]['name'] = {!!  "'" . $position->name . "'"  !!};
                positions[{{$i++}}]['department_id'] = {{ $position->department_id }};
                    @endforeach

                for (i = 0; i < positions.length; i++) {
                    console.log(positions[i]);
                }
                $('#positions').removeAttr('disabled')
            } else {
                $('#positions').attr('disabled', true)
            }

        });
    </script>
@endsection
