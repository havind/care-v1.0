@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('a.index') }}">Administration</a></li>
    <li class="breadcrumb-item active" aria-current="page">Users</li>
@endsection

@section('title', $user->first_name . ' ' . $user->last_name )
@section('heading', $user->first_name . ' ' . $user->last_name )

@section('primary_menu')
    @include('admin.human_resource.users.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        <p class="lead">Are you sure you want to delete "{{ $user->first_name }} {{ $user->last_name }}"?</p>
        <form method="POST" action="{{ route('a.users.delete', $user->id) }}">
            @method('DELETE')
            @csrf
            <button class="btn btn-outline-danger">Delete User</button>
        </form>

    </div>
@endsection
