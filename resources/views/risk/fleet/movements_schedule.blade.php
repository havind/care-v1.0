@inject('ibFunctions', 'App\Http\Controllers\ibFunctions')
@extends('layouts.app')

@section('title', 'Fleet')

@section('breadcrumb')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('risk.index') }}">Risk</a></li>
            <li class="breadcrumb-item"><a href="{{ route('fleet') }}">Fleet</a></li>
            <li class="breadcrumb-item active" aria-current="page">Movements Schedule</li>
        </ol>
    </nav>
@endsection

@section('heading')
    <h1>Movements Schedule</h1>
@endsection

@section('primary_menu')
    @include('risk.fleet.primary_menu')
@endsection

@section('content')
    <div class="container">

    </div>
@endsection
