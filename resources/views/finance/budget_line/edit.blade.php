@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('finance.index') }}">Finance</a></li>
    <li class="breadcrumb-item"><a href="{{ route('budget-lines.index') }}">Budget Lines</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ $budget_line->id }}</li>
@endsection

@section('title', $budget_line->id )
@section('heading', $budget_line->id )

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
                <form action="{{ route('budget-lines.update', $budget_line->id) }}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="mb-3 row">
                        <label for="staticEmail" class="col-sm-3 col-form-label">Fund Code</label>
                        <div class="col-sm-9">
                            <select class="form-select" id="bl_fund_code_id" name="bl_fund_code_id">
                                <option value="0">-- SELECT --</option>
                                @foreach($fund_codes as $fund_code)
                                    @if ($fund_code->id == $budget_line->fund_code_id)
                                        <option value="{{ $fund_code->id }}" selected>{{ $fund_code->name }}</option>
                                    @else
                                        <option value="{{ $fund_code->id }}">{{ $fund_code->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Budget Line Name</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="bl_name" name="bl_name" type="text" value="{{ $budget_line->name }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label" for="inputPassword">Budget Line Name</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="bl_description" name="bl_description" type="text">{{ $budget_line->description }}</textarea>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="offset-3 col-sm-9">
                            <input type="submit" class="btn btn-success" value="Update">
                            <a class="btn btn-outline-danger" href="{{ route('budget-lines.show', $budget_line->id) }}">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
