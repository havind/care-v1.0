@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('a.index') }}">Administration</a></li>
    <li class="breadcrumb-item"><a href="{{ route('a.users.index') }}">Users</a></li>
    <li class="breadcrumb-item"><a href="{{ route('a.users.show', $profile->id) }}">{{ $profile->first_name }} {{ $profile->last_name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('title', 'Reset password for ' . $profile->first_name . ' ' . $profile->last_name )
@section('heading', 'Reset password for ' . $profile->first_name . ' ' . $profile->last_name )

@section('primary_menu')
    @include('admin.human_resource.users.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        @error('wrong-password')
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i>{{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @enderror

        <form method="post" action="{{ route('a.users.reset-password', $profile->id)}}">
            @method('PUT')
            @csrf
            <div class="mb-3 row">
                <label for="reset-password" class="col-sm-2 col-form-label">New Password</label>
                <div class="col-sm-5">
                    <input class="form-control" id="reset-password" name="reset-password" type="password">
                </div>
            </div>
            <div class="my-3 row">
                <div class="col-sm-5 offset-2">
                    <button class="btn btn-success">Update</button>
                    <a class="btn text-danger" href="{{ route('a.users.show', $profile->id) }}">Cancel</a>
                </div>
            </div>

        </form>
    </div>
@endsection
