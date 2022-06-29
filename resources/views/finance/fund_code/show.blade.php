@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('finance.index') }}">Finance</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fund-codes.index') }}">Fund Codes</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $fund_code->name }}</li>
@endsection

@section('title', $fund_code->name)
@section('heading', $fund_code->name)

@section('primary_menu')
    @include('finance.fund_code.partials.primary_menu')

    <div id="emailHelp" class="form-text fst-italic">created at {{ $fund_code->created_at }}
        @if($fund_code->updated_at != null )
            (Updated at {{ $fund_code->updated_at }})
        @endif
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="mb-3 row">
            <table class="table table-borderless table-responsive table-hover">
                <tbody>
                <tr>
                    <td colspan="2">
                        <div class="row">
                            <div class="col-2"><h4>Status</h4></div>
                            @if ($fund_code->is_active == 1)
                                <div class="col-1 text-success d-flex align-items-center">
                                    <span class="material-icons">check_circle_outline</span> Active
                                </div>
                            @else
                                <div class="col-1 text-danger d-flex align-items-center">
                                    <span class="material-icons">highlight_off</span> Inactive
                                </div>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="row">
                            <div class="col-2"><h4>Description</h4></div>
                            <div class="col-10">{{ $fund_code->description }}</div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
    </div>
@endsection
