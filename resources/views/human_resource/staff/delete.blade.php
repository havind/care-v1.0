@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
    <li class="breadcrumb-item"><a href="{{ route('staff.index') }}">Staff</a></li>
    <li class="breadcrumb-item"><a href="{{ route('staff.show', $user->id) }}">{{ $user->first_name }} {{ $user->last_name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Deactivate</li>
@endsection


@section('title', $user->first_name . ' ' . $user->last_name)
@section('heading', $user->first_name . ' ' . $user->last_name)

@section('primary_menu')
    @include('human_resource.staff.primary_menu')
@endsection

@section('content')
    <div class="container">
        <p class="lead">Are you sure you want to deactivate "{{ $user->first_name }} {{ $user->last_name }}"?</p>
        <form method="POST" action="{{ route('staff.destroy', $user->id) }}">
            @method('DELETE')
            @csrf
            <button type="submit" class="btn btn-outline-danger">Deactivate User</button>
        </form>
    </div>
@endsection
