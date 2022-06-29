@extends('layouts.app')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('movement-requests.index') }}">Movement Request</a></li>
            <li class="breadcrumb-item"><a href="{{ route('movement-requests.show', $movement_request->id) }}">{{ $movement_request->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete</li>
        </ol>
    </nav>
@endsection

@section('title')
    Delete {{ $movement_request->name }}
@endsection

@section('heading')
    <h1>Delete {{ $movement_request->name }}</h1>
@endsection

@section('primary_menu')
    @include('risk.movement_request.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        <p class="lead">Are you sure you want to delete "{{ $movement_request->name }}"?</p>
        <form method="POST" action="{{ route('movement-requests.destroy', $movement_request->id) }}">
            @method('DELETE')
            @csrf
            <button class="btn btn-outline-danger">Cancel Movement</button>
        </form>
    </div>
@endsection
