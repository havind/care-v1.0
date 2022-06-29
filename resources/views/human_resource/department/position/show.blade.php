@extends('layouts.app')

@section('breadcrumb')
            <li class="breadcrumb-item"><a href="{{ route('human-resources.index') }}">Human Resources</a></li>
            <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Departments</a></li>
            <li class="breadcrumb-item"><a href="{{ route('departments.show', $department->id) }}">{{ $department->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('departments.positions.index', $department->id) }}">Positions</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $position->name }}</li>
@endsection

@section('title', $position->name)
@section('heading', $position->name)

@section('primary_menu')
    @include('human_resource.department.position.partials.primary_menu')

    Test

    <div id="emailHelp" class="form-text fst-italic">created at {{ $department->created_at }}
        @if($department->updated_at != null )
            (Updated at {{ $department->updated_at }})
        @endif
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label">Supervisor</label>
            <div class="col-sm-10">
                {{--                @if($supervisor == null)--}}
                <input type="text" class="form-control-plaintext" readonly value="Not Assigned"/>
                {{--                @else--}}
                {{--                    <a class="btn btn-link" href="{{ route('a.users.show', $supervisor->id) }}">--}}
                {{--                        {{ $supervisor->first_name }} {{ $supervisor->last_name }}--}}
                </a>
                {{--                @endif--}}
            </div>
        </div>

        <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Description</label>
            <div class="col-sm-10">
                <textarea readonly class="form-control-plaintext" onfocus="blur()">{{ $department->description }}</textarea>
            </div>
        </div>

    </div>
@endsection
