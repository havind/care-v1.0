@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.profile') }}">{{ $profile->first_name }} {{ $profile->last_name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Acting</li>
@endsection

@section('title', 'Acting')
@section('heading', 'Acting')

@section('primary_menu')
    @include('users.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('users.update-acting') }}">
            @method('PUT')
            @csrf
            <div class="mb-3 row">
                <label for="acting" class="col-sm-1 col-form-label">Acting</label>
                <div class="col-sm-3">
                    <select class="form-select" id="acting" name="acting" aria-label="Default select example">
                        <option value="0" {{ ($profile->acting_supervisor_id == 0) ? ' selected' : '' }}>-- SELECT --</option>
                        @foreach($users as $user)
                            @if($user->id != Auth::id())
                                <option value="{{ $user->id }}" {{ ($user->id == $acting) ? ' selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <button class="offset-1 btn btn-success">Assign</button>
            <a class="btn text-danger" href="{{ route('users.profile') }}">Cancel</a>
        </form>
    </div>
@endsection
