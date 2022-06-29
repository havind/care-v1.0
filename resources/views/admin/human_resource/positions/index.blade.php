@extends('layouts.app')
@inject('ibFunctions', 'App\Http\Controllers\ibFunctions')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Administration</li>
@endsection

@section('title', 'Administration')
@section('heading', 'Administration')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3">
            @authCheck('admin_user_index')
            @include('layouts.partials.card', [
		      'link' => 'a.users.index',
		      'title' => 'Users',
		      'title_small' => 'U',
		      ])
            @endif
            @authCheck('admin_department_index')
            @include('layouts.partials.card', [
		      'link' => 'a.departments.index',
		      'title' => 'Departments',
		      'title_small' => 'D',
		      ])
            @endif
            {{--            @authCheck('admin_position_index')--}}
            @include('layouts.partials.card', [
		      'link' => 'movement-requests.index',
		      'title' => 'Positions',
		      'title_small' => 'P',
		      ])
            {{--            @endif--}}
            {{--            @authCheck('risk_movementRequest_index')--}}
            @include('layouts.partials.card', [
		      'link' => 'movement-requests.index',
		      'title' => 'All Movement Requests',
		      'title_small' => 'AM',
		      ])
            {{--            @endif--}}
            {{--            @authCheck('risk_movementRequest_index')--}}
            @include('layouts.partials.card', [
		      'link' => 'movement-requests.index',
		      'title' => 'All Movement Requests',
		      'title_small' => 'AM',
		      ])
            {{--            @endif--}}
            {{--            @authCheck('risk_movementRequest_index')--}}
            @include('layouts.partials.card', [
		      'link' => 'movement-requests.index',
		      'title' => 'All Movement Requests',
		      'title_small' => 'AM',
		      ])
            {{--            @endif--}}
        </div>
    </div>
@endsection
