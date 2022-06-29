@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.profile') }}">{{ $profile->first_name }} {{ $profile->last_name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Reset my password</li>
@endsection

@section('title', 'Reset password')
@section('heading', 'Reset password')

@section('primary_menu')
    @include('users.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        @error('wrong-password')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i>{{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @enderror

        <form id="reset-password-form" method="POST" action="{{ route('users.update-password') }}">
            @method('Put')
            @csrf
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Current password</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="current-password" name="current-password">
                </div>
            </div>
            <br/>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">New password</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="new-password" name="new-password">
                    <div class="invalid-feedback">
                        Password and Confirm Password must be the same.
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Confirm password</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="confirm-password">
                </div>
            </div>

            <button class="btn btn-success offset-2">Update Password</button>
            <a class="btn text-danger" href="{{ route('users.profile') }}">Cancel</a>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        $('#reset-password-form').submit((e) => {
            e.preventDefault();
            // check if the new password and the confirm one are the same.
            if ($('#new-password').val() !== $('#confirm-password').val()) {
                $('#new-password').addClass('is-invalid');
                $('#confirm-password').addClass('is-invalid');
            } else {
                e.currentTarget.submit();
            }

        });
    </script>
@endsection
