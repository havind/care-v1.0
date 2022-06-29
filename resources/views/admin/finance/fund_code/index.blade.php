@extends('admin.layouts.app')

@section('content')
    <table class="table table-sm">
        <thead>
        <tr class="text-center">
            <th>
                <input type="checkbox">
            </th>
            <th>{{ Str::upper('Name') }}</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(window).on('load', function (e) {
            url = 'http://emails.lara:8888/api/get_all_users';
            getData(url);
        });

        /**
         * Get All Data if pagination was not on.
         * If Pagination was available it will get the first page.
         * @type {string}
         */
        function getData(url) {
            return $.ajax({
                type: 'GET',
                dataType: 'json',
                url: url,
                jsonpCallback: 'responseJSON',
                success: (data) => {
                    data = data.users;

                    // Message to be shown when no data is returned.
                    var noDataMessage = '<div class="alert alert-info" role="alert">' +
                        'No data is aviable.' +
                        '</div>';

                    // If pagination not used.
                    if (data.length >= 0) {
                        if (data.length === 0) {
                            $('#content').empty();
                            $('#content').html(noDataMessage);
                        } else {
                            $('#content').empty();
                            generateTable('#content');
                            generateTableHeader('#content', data);
                            $('#content table tbody').empty();
                            generateTableBody('#content', data);
                        }
                    } else {
                        if (data.data.length == 0) {
                            $('#content').empty();
                            $('#content').html(noDataMessage);
                        } else {
                            $('#content').empty();
                            generateTable('#content');
                            generateTableHeader('#content', data.data);
                            $('#content table tbody').empty();
                            generateTableBody('#content', data.data);
                            generateTablePagination('#content div.ib-pagination', data)
                        }
                    }
                }
            });
        }

    </script>
@endsection
