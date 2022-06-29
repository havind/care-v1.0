@extends('admin.layouts.app')

@section('page_actions')
    @include('admin.human_resource.department.partials.primary_menu')

    <div id="emailHelp" class="form-text fst-italic">created at {{ $department->dp_created_at }}
        @if($department->dp_updated_at != null )
            (Updated at {{ $department->dp_updated_at }})
        @endif</div>
@endsection

@section('content')
    <div class="mb-3 row">
        <label for="inputPassword" class="col-sm-2 col-form-label">Supervisor</label>
        <div class="col-sm-10">
            <a class="form-control-plaintext text-info" href="{{ route('a.users.show', $department->dp_supervisor_id) }}">
                {{ $department->dp_supervisor_first_name }} {{ $department->dp_supervisor_last_name }}
            </a>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="staticEmail" class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-10">
                <textarea readonly class="form-control-plaintext" onfocus="blur()">{{ $department->dp_description }}
                </textarea>
        </div>
    </div>
@endsection
