@extends('admin.layouts.app')

@section('ib-content-actions')
    @include('admin.human_resource.departments.partials.content_actions')
@endsection

@section('ib-content-body')
    <div class="mx-3 mt-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="d-flex">
        <div class="col-lg-4 col-6 col-xs-12">
            <form action="{{ route('a.human-resources.departments.update', $department->dep_id) }}" id="edit-department" method="POST">
                @csrf
                @method('PUT')
                <table class="table table-hover table-borderless m-3">
                    <tbody>
                    <tr>
                        <td>Supervisor</td>
                        <td>
                            <select id="department-supervisor" name="department-supervisor" class="form-select"></select>
                        </td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>
                            <textarea class="form-control" id="department-description" name="department-description">{{ $department->dep_description }}</textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection


@section('ib-content-footer')
    <button type="submit" class="btn btn-success" form="edit-department">Update</button>
    <a href="{{ route('a.human-resources.departments.show', $department->dep_id) }}" class="btn btn-link text-secondary text-decoration-none">Cancel</a>
@endsection

@section('scripts')
    @include('admin.human_resource.departments.js.edit')
@endsection

