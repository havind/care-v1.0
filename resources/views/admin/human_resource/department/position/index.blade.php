@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('a.index') }}">Administration</a></li>
    <li class="breadcrumb-item"><a href="{{ route('a.departments.index') }}">Departments</a></li>
    <li class="breadcrumb-item"><a href="{{ route('a.departments.show', $department->id) }}">{{ $department->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Positions</li>
@endsection


@section('title', 'Positions of ' . $department->name)
@section('heading', 'Positions of ' . $department->name)

@section('primary_menu')
    @include('admin.human_resource.department.position.primary_menu')
@endsection

@section('content')
    <div class="container">

        {{--        @if(empty(count($departments)))--}}
        <div class="alert alert-warning align-items-center m-3" role="alert">
            <i class="bi bi-exclamation-square-fill"></i> You have not submitted any Movement Requests.
        </div>
        {{--        @else--}}
        <table class="table table-sm table-bordered table-hover">
            <thead>
            <tr class="text-center">
                <td class="align-middle">#</td>
                <td class="align-middle">Department name</td>
                <td class="align-middle">Supervisor</td>
                <td class="align-middle">Created at</td>
                <td class="align-middle">Updated at</td>
                <td class="align-middle">Actions</td>
            </tr>
            </thead>
            <tbody>
            {{--                @foreach($departments as $department)--}}
            <tr>
                {{--                        <td class="align-middle text-center">{{ $loop->iteration }}</td>--}}
                <td class="align-middle">
                    {{--                            <a href="{{ route('a.departments.show', $department->id) }}">{{ $department->name }}</a>--}}
                </td>
                <td class="align-middle">
                    {{--                            @foreach($supervisors as $supervisor)--}}
                    {{--                                @if( $supervisor[0]->id == $department->supervisor_id)--}}
                    {{--                                    <a href="{{ route('a.users.show', $supervisor[0]->id) }}">{{ $supervisor[0]->first_name }} {{ $supervisor[0]->last_name }}</a>--}}
                    {{--                                @endif--}}
                    {{--                            @endforeach--}}
                </td>
                <td class="align-middle text-center">
                    {{--                            {{(!empty($department->created_at)) ? $department->created_at : 'Not Available' }}--}}
                </td>
                <td class="align-middle text-center">
                    {{--                            {{(!empty($department->updated_at)) ? $department->updated_at : 'Not Available' }}--}}
                </td>
                <td class="align-middle text-center">
                    {{--                            <a class="text-info" href="{{ route('a.departments.edit', $department->id) }}"><i class="bi bi-pencil-square"></i> edit</a>--}}
                    &nbsp;
                    {{--                            <a class="text-danger" href="{{ route('a.departments.delete', $department->id) }}"><i class="bi bi-x-square"></i> delete</a>--}}
                </td>
            </tr>
            {{--                @endforeach--}}
            </tbody>
        </table>
        {{--        @endif--}}
    </div>
@endsection
