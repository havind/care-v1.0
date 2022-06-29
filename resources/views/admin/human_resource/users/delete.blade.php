@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('a.index') }}">Administration</a></li>
    <li class="breadcrumb-item"><a href="{{ route('a.users.index') }}">Users</a></li>
    <li class="breadcrumb-item"><a href="{{ route('a.users.show', $profile->id) }}">{{ $profile->first_name }} {{ $profile->last_name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Delete</li>
@endsection

@section('title', $profile->first_name . ' ' . $profile->last_name)
@section('heading', $profile->first_name . ' ' . $profile->last_name)

@section('primary_menu')
    @include('admin.human_resource.users.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        <p class="lead">Are you sure you want to delete "{{ $profile->first_name }} {{ $profile->last_name }}"?</p>
        <form method="POST" action="{{ route('a.users.delete', $profile->id) }}">
            @method('DELETE')
            @csrf
            <button class="btn btn-outline-danger">Delete User</button>
        </form>

    </div>
@endsection
