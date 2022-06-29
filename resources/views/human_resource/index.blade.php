@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Human Resources</li>
@endsection

@section('title', 'Human Resources')
@section('heading', 'Human Resources')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3">
            @authCheck('humanResource_staff_index')
            @include('layouts.partials.card', [
		      'link' => 'staff.index',
		      'title' => 'Staff',
		      'title_small' => 'S',
		      ])
            @endif
            @authCheck('humanResource_department_index')
            @include('layouts.partials.card', [
		      'link' => 'departments.index',
		      'title' => 'Departments',
		      'title_small' => 'D',
		      ])
            @endif
        </div>
    </div>
@endsection
