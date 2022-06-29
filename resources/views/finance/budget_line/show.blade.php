@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('finance.index') }}">Finance</a></li>
    <li class="breadcrumb-item"><a href="{{ route('budget-lines.index') }}">Budget Lines</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $budget_line->id . ' (' . $fund_code->name . ')' }}</li>
@endsection

@section('title', $budget_line->name . ' (' . $fund_code->name . ')')
@section('heading', $budget_line->name . ' (' . $fund_code->name . ')')

@section('primary_menu')
    @include('finance.budget_line.partials.primary_menu')
    <div class="fst-italic text-muted">
        <span>created_at {{ $budget_line->created_at }}</span>
        @if($budget_line->updated_at != null)
            (updated at {{ $budget_line->updated_at }})
        @endif
    </div>
@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <td>Fund Code</td>
                        <td>
                            <a href="{{ route('fund-codes.show', $fund_code->id) }}">{{ $fund_code->name }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 30%;">Budget Line name</td>
                        <td style="width: 70%;">{{ $budget_line->name }}</td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>{{ $budget_line->description }}</td>
                    </tr>

                    <tr>
                        <td>Status</td>
                        <td>
                            @if ($budget_line->is_active == 1)
                                <span class="material-icons text-success">toggle_on</span>
                            @else
                                <span class="material-icons text-danger">toggle_off</span>
                            @endif
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
