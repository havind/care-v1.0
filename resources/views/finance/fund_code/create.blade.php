@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('finance.index') }}">Finance</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fund-codes.index') }}">Fund Codes</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
@endsection

@section('title', 'New Fund Code')
@section('heading', 'New Fund Code')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <form id="fund-code-form" method="POST" action="{{ route('fund-codes.store') }}">
            @csrf
            <div class="mb-3 row">
                <label for="fund-code-name" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="fund-code-name" name="fund-code-name">
                    <div class="invalid-feedback">
                        Please write the fund code name.
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="fund-code-description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-5">
                    <textarea type="password" class="form-control" id="fund-code-description" rows="3" name="fund-code-description"></textarea>
                </div>
            </div>

            <button class="btn btn-outline-success offset-2" id="formSubmit" type="submit">Submit</button>
            <a class="btn btn-outline-danger" href="{{ route('fund-codes.index') }}">Cancel</a>

        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        /**
         * Fund Code Form validation
         */
        $('#fund-code-form').submit((e) => {
            // Travel Purpose
            if ($('#fund-code-name').val().length <= 0) {
                $('#fund-code-name').addClass('is-invalid');
                $('#fund-code-name').removeClass('is-valid');
                return false;
            } else if ($('#fund-code-name').val().length > 0) {
                $('#fund-code-name').addClass('is-valid');
                $('#fund-code-name').removeClass('is-invalid');
            }
            $('#fund-code-form').submit();
            e.preventDefault();
        });
    </script>
@endsection
