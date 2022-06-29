@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('finance.index') }}">Finance</a></li>
    <li class="breadcrumb-item active" aria-current="page">Budget Lines</li>
@endsection

@section('title', 'Budget Lines')
@section('heading', 'Budget Lines')

@section('primary_menu')
    <hr/>
@endsection

@section('content')
    <div class="container">
        <a class="btn btn-primary mb-3" href="{{ route('budget-lines.create') }}">
            <span class="material-icons">add_box</span> New
        </a>

        <div class="mb-3 row ui-widget">
            <label for="fund-code" class="col-sm-1 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" class="col-sm-2 cil-form-control" id="fund-code">
            </div>
        </div>

        @if(empty(count($budget_lines)))
            <div class="alert alert-warning align-items-center m-3" role="alert">
                <i class="bi bi-exclamation-square-fill"></i> You have not submitted any Fund Codes.
            </div>
        @else
            <table class="table table-sm table-bordered table-hover">
                <thead>
                <tr class="text-center">
                    <td class="align-middle">#</td>
                    <td class="align-middle">Fund Code</td>
                    <td class="align-middle">Budget Line Name</td>
                    <td class="align-middle">Description</td>
                    <td class="align-middle">Actions</td>
                </tr>
                </thead>
                <tbody>
                @foreach($budget_lines as $budget_line)
                    <tr>
                        <td class="align-middle text-center">{{ $loop->iteration }}</td>
                        <td class="align-middle">
                            @foreach($fund_codes as $fund_code)
                                @if($fund_code->id == $budget_line->fund_code_id)
                                    <a href="{{ route('fund-codes.show', $fund_code->id) }}">{{ $fund_code->name }}</a>
                                @endif
                            @endforeach
                        </td>
                        <td class="align-middle">
                            <a href="{{ route('budget-lines.show', $budget_line->id) }}">{{ $budget_line->name }}</a>
                        </td>
                        <td class="align-middle">
                            {{ $budget_line->description }}
                        </td>
                        <td class="align-middle text-center">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <a class="text-info" href="{{ route('budget-lines.edit', $budget_line->id) }}">
                                        <span class="material-icons text-info">mode_edit</span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-danger" href="{{ route('budget-lines.delete', $budget_line->id) }}">
                                        <span class="material-icons text-danger">delete</span>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--    Pagination  --}}
            {{ $budget_lines->links('finance.budget_line.partials.pagination') }}
        @endif
    </div>
@endsection

@section('footnote')
    <hr/>
    <table>
        <tr>
            <td class="text-center"><small><span class="material-icons text-info">mode_edit</span></small></td>
            <td><small>Edit</small></td>
        </tr>
        <tr>
            <td class="text-center"><small><span class="material-icons text-danger">delete</span></small></td>
            <td><small>Delete</small></td>
        </tr>
    </table>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script type="text/javascript">
        $(function () {
            let data = [];
            const url = 'http://{{ request()->getHost() . ':' . request()->getPort() }}/api/finance/fund-codes/active';

            $.ajax({
                type: "GET",
                url: url,
                dataType: "JSON",
                success: function (response) {
                    fund_codes_content = response.fund_codes;
                    for (i = 0; i < fund_codes_content.length; i++) {
                        fund_codes_content[i]['name'], fund_codes_content[i]['id'];

                        data.push(fund_codes_content[i]['name'], fund_codes_content[i]['id']);
                    }
                }
            });

            console.log(data)

            $("#fund-code").autocomplete({
                source: data,
                select: (event, ui) => {
                    console.log(ui);
                    {{--$(location).attr('href', 'http://{{ request()->getHost() . ':' . request()->getPort() }}/finance/budget-lines?bl=' + 'data');--}}
                }
            });
        });
    </script>
@endsection
