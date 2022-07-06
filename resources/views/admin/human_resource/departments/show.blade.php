@extends('admin.layouts.app')

@section('ib-content-actions')
    @include('admin.human_resource.departments.partials.content_actions')
@endsection

@section('ib-content-body')
    <div class="form-text fst-italic ms-3">created at {{ $department->dep_created_at }}
        @if($department->dep_updated_at != null )
            (Updated at {{ $department->dep_updated_at }})
        @endif
    </div>
    <div class="d-flex">
        <div class="col-6">
            <table class="table table-hover table-borderless m-3 ib-show-table">
                <tbody>
                <tr>
                    <td>Supervisor</td>
                    <td>
                        <a class="form-control-plaintext" href="{{ route('a.human-resources.users.show', $department->supervisor_id) }}">
                            {{ $department->supervisor_first_name }} {{ $department->supervisor_last_name }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>{{ $department->dep_description }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
