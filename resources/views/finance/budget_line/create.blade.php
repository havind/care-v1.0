@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('finance.index') }}">Finance</a></li>
    <li class="breadcrumb-item"><a href="{{ route('fund-codes.index') }}">Budget Lines</a></li>
    <li class="breadcrumb-item active" aria-current="page">Create</li>
@endsection

@section('title', 'New Budget Line')
@section('heading', 'New Budget Line')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <form id="bl-form" method="POST" action="{{ route('budget-lines.store') }}">
            @csrf
            <div class="mb-3 row">
                <label for="bl-fund-code" class="col-sm-2 col-form-label">Fund Code<span class="text-danger">*</span></label>
                <div class="col-sm-5">
                    <select class="form-select" name="bl-fund-code" id="bl-fund-code">
                        <option value="0">-- SELECT --</option>
                        @foreach ($fund_codes as $fund_code)
                            <option value="{{ $fund_code->id }}">{{ $fund_code->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        Please choose the fund code name.
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="bl-name" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="bl-name" name="bl-name">
                    <div class="invalid-feedback" id="bl-name-invalid-feedback">
                        Budget Line name is mandatory.
                    </div>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="bl-description" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-5">
                    <textarea type="password" class="form-control" id="bl-description" rows="3" name="bl-description"></textarea>
                </div>
            </div>

            <button class="btn btn-success offset-2" id="formSubmit" type="submit">Submit</button>
            <a class="btn btn-outline-danger" href="{{ route('fund-codes.index') }}">Cancel</a>

        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        /**
         * Fund Code Form validation
         */

        // On Change
        $('#bl-fund-code').on('change', () => {
            check_bl_fund_code();
        });
        $('#bl-fund-code').on('focusout', () => {
            check_bl_fund_code();
        });

        $('#bl-name').on('focusout', () => {
            check_bl_name();
        });


        // On Submit
        $('#bl-form').on('submit', (e) => {
            e.preventDefault();
            // Check Fund code
            check_bl_fund_code();
            check_bl_name();

            // check if name already exists.

            check_before_submit($('#bl-fund-code').val(), $('#bl-name').val());
        });

        function check_bl_name() {
            if ($('#bl-name').val().length <= 0) {
                $('#bl-name').addClass('is-invalid');
                $('#bl-name').removeClass('is-valid');
                return false;

            } else if ($('#bl-name').val().length > 0) {
                $('#bl-name').addClass('is-valid');
                $('#bl-name').removeClass('is-invalid');
                return true;
            }

        }

        function check_bl_fund_code() {
            if ($('#bl-fund-code').val() > 0) {
                $('#bl-fund-code').addClass('is-valid');
                $('#bl-fund-code').removeClass('is-invalid');
                return true;
            } else {
                $('#bl-fund-code').addClass('is-invalid');
                $('#bl-fund-code').removeClass('is-valid');
                return false;
            }
        }

        // Filtering Budget Lines according to the selected Fund Code.
        function check_before_submit(fund_code, name) {
            const bl_url = "http://{{ request()->getHost() . ':' . request()->getPort() }}/api/finance/budget-lines/isBudgetLinesByFundCodeExists/" + fund_code + '/' + name;
            $.ajax({
                type: "GET",
                url: bl_url,
                dataType: "json",
                success: function (response) {

                    console.log(response)

                    $('#bl-name').addClass('is-invalid');
                    $('#bl-name').removeClass('is-valid');
                    $('#bl-name-invalid-feedback').text('Budget Line already exists.');

                },
                error: function () {
                    if (check_bl_name() == true && check_bl_fund_code() == true) {
                        $("#bl-form")[0].submit();
                    }
                }
            });
        }
    </script>
@endsection
