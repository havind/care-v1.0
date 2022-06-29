@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('finance.index') }}">Finance</a></li>
    <li class="breadcrumb-item active" aria-current="page">Fund Codes</li>
@endsection

@section('title', 'Fund Codes')
@section('heading', 'Fund Codes')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <a class="btn btn-primary mb-3" href="{{ route('fund-codes.create') }}">
            <span class="material-icons">add_box</span> New
        </a>

        @if(empty(count($fund_codes)))
            <div class="alert alert-warning align-items-center m-3" role="alert">
                <i class="bi bi-exclamation-square-fill"></i> You have not submitted any Fund Codes.
            </div>
        @else
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr class="text-center">
                    <td class="align-middle" style="width: 5%;">#</td>
                    <td class="align-middle" style="width: 20%;">Fund Code</td>
                    <td class="align-middle">Description</td>
                    <td class="align-middle" style="width: 10%;">Status</td>
                    <td class="align-middle" style="width: 10%;">Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($fund_codes as $fund_code)
                    <tr>
                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            <a href="{{ route('fund-codes.show', $fund_code->id) }}">{{ $fund_code->name }}</a>
                        </td>
                        <td>
                            {{ $fund_code->description }}
                        </td>
                        @if($fund_code->is_active == true)
                            <td class="align-middle text-center table-success text-success">
                                Active
                            </td>
                        @elseif($fund_code->is_active == false)
                            <td class="align-middle text-center table-danger text-danger">
                                Inactive
                            </td>
                        @endif
                        <td class="align-middle text-center">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a class="text-info" href="{{ route('fund-codes.edit', $fund_code->id) }}">
                                        <span class="material-icons text-info">mode_edit</span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-danger" href="{{ route('fund-codes.delete', $fund_code->id) }}">
                                        <span class="material-icons text-danger">delete</span>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="container">
                {{--    Pagination  --}}
                {{ $fund_codes->links('finance.fund_code.partials.pagination') }}
            </div>
        @endif

        <hr/>
        <table>
            <tr>
                <td><small><span class="material-icons text-info">mode_edit</span></small></td>
                <td><small>Edit</small></td>
            </tr>
            <tr>
                <td><small><span class="material-icons text-danger">delete</span></small></td>
                <td><small>Delete</small></td>
            </tr>
        </table>
    </div>
@endsection
