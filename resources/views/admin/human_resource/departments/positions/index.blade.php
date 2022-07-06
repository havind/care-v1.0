@extends('admin.layouts.app')

@section('ib-content-actions')
    @include('admin.human_resource.departments.positions.partials.content_actions')
@endsection

@section('ib-content-body')

    @if(count($positions) == 0)
        <div id="no-positions" class="position-absolute w-50 d-flex mx-3 mt-3">
            <div class="alert alert-primary flex-fill" role="alert">
                <span class="material-icons">info</span>
                No Departments found, please <a class="fw-bold fst-italic" href="{{ route('a.human-resources.departments.positions.create', $department->id) }}">add a new Position</a>
            </div>
        </div>

    @else

        <table class="table table-sm table-bordered table-hover">
            <thead>
            <tr class="text-center">
                <td class="align-middle">#</td>
                <td class="align-middle">Department name</td>
                <td class="align-middle w-50">Description</td>
                <td class="align-middle">Actions</td>
            </tr>
            </thead>
            <tbody>
            @foreach($positions as $position)
                <tr>
                    <td class="align-middle text-center">{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('a.human-resources.departments.positions.show', [$department->id, $position->id]) }}">{{ $position->name }}</a>
                    </td>
                    <td>{{ $position->description }}</td>
                    <td class="align-middle text-center">
                        <ul class="list-inline" style="margin-bottom: unset !important;">
                            <li class="list-inline-item">
                                <a href="{{ route('a.human-resources.departments.positions.edit', [$department->id, $position->id]) }}">
                                    <span class="material-icons text-info">mode_edit</span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{ route('a.human-resources.departments.positions.delete', [$department->id, $position->id]) }}">
                                    <span class="material-icons text-danger">delete</span>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
