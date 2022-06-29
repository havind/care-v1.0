@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('finance.index') }}">Finance</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fund-codes.index') }}">Fund Codes</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fund-codes.show', $fund_code->id) }}">{{ $fund_code->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Edit</li>
@endsection

@section('title', 'Edit ' . $fund_code->name)
@section('heading', 'Edit ' . $fund_code->name)

@section('primary_menu')
    @include('finance.fund_code.partials.primary_menu')
@endsection

@section('content')
    <div class="container">
        <form action="{{ route('fund-codes.update', $fund_code->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="mb-2 row">
                <label for="fund-code-name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-5">
                    <input class="form-control" id="fund-code-name" name="fund-code-name" type="text" value="{{ $fund_code->name }}">
                </div>
            </div>

            <div class="mb-2 row">
                <label for="fund-code-status" class="col-sm-2 col-form-label">Status</label>
                <div class="col-sm-5">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="fund-code-status" name="fund-code-status" checked>
                        <label class="form-check-label" for="fund-code-status" id="fund-code-status-label"></label>
                    </div>
                </div>
            </div>

            <div class="mb-2 row">
                <label for="fund-code-description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-5">
                    <textarea class="form-control" id="fund-code-description" name="fund-code-description" rows="3" type="password">{{ $fund_code->description }}</textarea>
                </div>
            </div>
            <div class="mb-2 row">
                <div class="offset-2">
                    <button class="col-2 btn btn-success">Update</button>
                    <a class="col-1 btn btn-link text-decoration-none text-secondary" href="{{ route('fund-codes.show', $fund_code->id) }}">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">

        $(window).on('load', () => {
            let status_field_value = ($('#fund-code-status').prop('checked') === true)? 1:0;
            if (status_field_value == {{ $fund_code->is_active }}) {
                $('#fund-code-status-label').html('Active');
                $('#fund-code-status').prop('checked', true);
                $('#fund-code-status-label').removeClass('text-danger');
                $('#fund-code-status-label').addClass('text-success');
                $('#fund-code-status').css('background-color', '#198754')
                $('#fund-code-status').css('border', '#198754')
            } else {
                $('#fund-code-status-label').text('Inactive');
                $('#fund-code-status').prop('checked', false);
                $('#fund-code-status-label').addClass('text-danger');
                $('#fund-code-status').css('background-color', '#dc3545')
                $('#fund-code-status').css('border', '#dc3545')
            }
        });

        $('#fund-code-status').on('change', () => {
            let status_field_value = ($('#fund-code-status').prop('checked') === true)? 1:0;
            if (status_field_value == 1) {
                $('#fund-code-status-label').html('Active');
                $('#fund-code-status').prop('checked', true);
                $('#fund-code-status-label').removeClass('text-danger');
                $('#fund-code-status-label').addClass('text-success');
                $('#fund-code-status').css('background-color', '#198754')
                $('#fund-code-status').css('border', '#198754')
            } else {
                $('#fund-code-status-label').text('Inactive');
                $('#fund-code-status').prop('checked', false);
                $('#fund-code-status-label').addClass('text-danger');
                $('#fund-code-status').css('background-color', '#dc3545')
                $('#fund-code-status').css('border', '#dc3545')
            }
        });

    </script>
@endsection
