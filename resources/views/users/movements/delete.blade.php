@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.profile') }}">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('movements.index') }}">My Movements</a></li>
    <li class="breadcrumb-item"><a href="{{ route('movements.show', $movement_request->id) }}">{{ $movement_request->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Delete</li>
@endsection

@section('title', 'Delete ' . $movement_request->name)
@section('heading', 'Delete ' . $movement_request->name)

@section('primary_menu')
    @include('users.movements.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        <p class="lead">Are you sure you want to delete "{{ $movement_request->name }}"?</p>
        <form method="POST" action="{{ route('movements.destroy', $movement_request->id) }}">
            @method('DELETE')
            @csrf
            <button class="btn btn-danger">Cancel Movement</button>
            <a role="button" class="btn btn-link text-secondary" href="{{ route('movements.show', $movement_request->id)}}">Cancel</a>
        </form>
    </div>
@endsection
