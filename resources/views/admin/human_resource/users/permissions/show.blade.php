@extends('admin.layouts.app')

@section('ib-content-actions')
    @include('admin.human_resource.users.partials.content_actions')
@endsection

@section('ib-content-body')
    <div class="container">

        @if(empty(count($permissions)))
            <div class="alert alert-warning align-items-center m-3" role="alert">
                <i class="bi bi-exclamation-square-fill"></i> You have not submitted any Movement Requests.
            </div>
        @else
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr class="text-center">
                    <td class="align-middle" style="width: 5%;">#</td>
                    <td class="align-middle" style="width: 5%;">Enable</td>
                    <td class="align-middle">Permission</td>
                </tr>
                </thead>
                <tbody>
                {{----}}
                <form id="permissions" method="POST" action="{{ route('a.human-resources.users.permissions.update', $user->user_id) }}">
                    @method('PUT')
                    @csrf
                    @foreach($permissions as $permission)
                        <tr>
                            <td class="align-middle text-center">{{ $loop->iteration }}</td>
                            <td class="align-middle">
                                <div class="form-check form-switch">
                                    {{ $permission->value }}
                                    <input {{ $permission->value == 1 ? 'checked' : '' }} checked class="form-check-input" id="{{ $permission->name }}" name="{{ $permission->name }}" role="switch" type="checkbox"/>
                                </div>
                            </td>
                            <td class="align-middle">{{ $permission->permission }}</td>
                        </tr>
                    @endforeach
                </form>
                </tbody>
            </table>
            {{----}}
            <button type="submit" class="btn btn-success" form="permissions">Update</button>
            <a class="btn text-danger" href="{{ route('a.human-resources.users.show', $user->user_id) }}">Cancel</a>

        @endif
    </div>
@endsection
