@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('finance.index') }}">Finance</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fund-codes.index') }}">Fund Codes</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fund-codes.show', $fund_code->id) }}">{{ $fund_code->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Delete</li>
@endsection

@section('title', 'Delete ' . $fund_code->name)
@section('heading', 'Delete ' . $fund_code->name)

@section('primary_menu')
    @include('finance.fund_code.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        <p class="lead">Are you sure you want to delete <i>"{{ $fund_code->name }}"</i>?</p>
        <form method="POST" action="{{ route('fund-codes.destroy', $fund_code->id) }}">
            @method('DELETE')
            @csrf
            <div class="mb-2 row">
                <div class="offset-0">
                    <button class="col-2 btn btn-danger">Delete</button>
                    <a class="col-1 btn btn-link text-decoration-none text-secondary" href="{{ route('fund-codes.show', $fund_code->id) }}">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
