@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Finance</li>
@endsection


@section('title', 'Finance')
@section('heading', 'Finance')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3">
            @authCheck('finance_fundCode_index')
            @include('layouts.partials.card', [
		      'link' => 'fund-codes.index',
		      'title' => 'Fund Codes',
		      'title_small' => 'FC',
		      ])
            @endif
            @authCheck('finance_budgetLine_index')
            @include('layouts.partials.card', [
		      'link' => 'budget-lines.index',
		      'title' => 'Budget Lines',
		      'title_small' => 'BL',
		      ])
            @endif
        </div>
    </div>
@endsection
