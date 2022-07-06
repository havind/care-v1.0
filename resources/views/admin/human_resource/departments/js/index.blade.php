<script type="text/javascript">
    $(window).on('load', function (e) {
        $.get('{{ request()->secure() ? "https" : "http" }}://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/departments/count', (rawData) => {
            if (rawData.data > 0) {
                let url = '{{ request()->secure() ? "https" : "http" }}://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/departments/all/20';
                $('#departments-available').removeClass("invisible");
                getData(url);
            } else {
                $('#departments-available').hide()
                $('#no-departments').removeClass("invisible");
            }
        });
    });

    function getData(url) {
        return $.ajax({
            "type": 'GET',
            "dataType": 'json',
            "url": url,
            "jsonpCallback": 'responseJSON',
            "success": (rawData) => {
                data = rawData.data;
                // Message to be shown when no data is returned.
                let noDataMessage = `<div class="alert alert-info" role="alert">
                                        No data is available.
                                    </div>`;

                // If pagination not used.
                if (data.data.length >= 0) {
                    if (data.length === 0) {
                        $('#departments').empty().html(noDataMessage);
                    } else {
                        $('#departments').empty();
                        generateTable('#departments');
                        $('#departments table tbody').empty();
                        generateTableBody('#departments', data);
                    }
                } else if (data.length === 0) {
                    $('#departments').empty().html(noDataMessage);
                } else {
                    $('#departments').empty();
                    generateTable('#departments');
                    $('#departments table tbody').empty();
                    generateTableBody('#departments', data.data);
                    generateTablePagination('#departments div.ib-pagination', data)
                }

            },
            "beforeSend": () => {
                $('#page-content').hide();
                $('#ib-loading').show();
            },
            "complete": () => {
                $('#ib-loading').remove();
                $('#page-content').show();
            }
        });
    }

    /**
     * Generate Basic Table Stucture.
     * @param id
     */
    function generateTable(id) {
        let output;
        output = '<table class="table table-sm table-striped table-bordered">';
        output += '<thead>';
        output += '<tr class="text-center">';
        output += '<th style="positions: sticky">#</th>';
        output += '<th style="min-width: 15%; width: 15%;">Department Name</th>';
        output += '<th>Supervisor</th>';
        output += '<th style="min-width: 11%; width: 11%;">Actions</th>';
        output += '</tr>';
        output += '</thead>';
        output += '<tbody></tbody>';
        output += '</table>';
        output += '<div class="ib-pagination"></div>';
        $(id).html(output);
    }

    function generateTableBody(id, tableData) {
        let output = '';
        let i = 0;
        $.each(tableData.data, (key, value) => {
                output += '<tr>';
                output += '<td class="align-middle text-center">';
                output += key + 1;
                output += '</td>';
                output += '<td class="align-middle">';
                output += '<a href="' + ('{{ route("a.human-resources.departments.show", ":department_id") }}').replace(':department_id', value.department_id) + '">';
                output += value.department_title;
                output += '</a>';
                output += '</td>';
                output += '<td>';
                output += '<a href="' + ('{{ route("a.human-resources.users.show", ":supervisor_id") }}').replace(':supervisor_id', value.supervisor_id) + '">';
                output += value.supervisor_first_name + ' ' + value.supervisor_last_name;
                output += '</a>';
                output += '</td>';


                output += '<td class="align-middle text-center">';
                output += '<ul class="list-inline" style="margin-bottom: unset !important;">';
                output += '<li class="list-inline-item">';
                output += '<a href="' + ('{{ route("a.human-resources.departments.positions.index", ":department_id") }}').replace(':department_id', value.department_id) + '">';
                output += '<span class="material-icons">cases</span>';
                output += '</a>';
                output += '</li>';
                output += '<li class="list-inline-item">';
                output += '<a href="' + ('{{ route("a.human-resources.departments.edit", ":department_id") }}').replace(':department_id', value.department_id) + '">';
                output += '<span class="material-icons text-info">mode_edit</span>';
                output += '</a>';
                output += '</li>';
                output += '<li class="list-inline-item">';
                output += '<a href="' + ('{{ route("a.human-resources.departments.delete", ":department_id") }}').replace(':department_id', value.department_id) + '">';
                output += '<span class="material-icons text-danger">delete</span>';
                output += '</a>';
                output += '</li>';
                output += '</ul>';
                output += '</td>';
                output += '</tr>';
                i++;
            }
        )
        ;
        $(id + ' table tbody').html(output);
    }

    function generateTablePagination(id, tableData) {
        let current_page = tableData.current_page;
        let first_page_url = tableData.first_page_url;
        let from = tableData.from;
        let last_page = tableData.last_page;
        let last_page_url = tableData.last_page_url;
        let next_page_url = tableData.next_page_url;
        let path = tableData.path;
        let per_page = tableData.per_page;
        let prev_page_url = tableData.prev_page_url;
        let to = tableData.to;
        let total = tableData.total;
        let links = tableData.links;

        let output = '<nav aria-label="Page navigation example">';
        output += '<ul class="pagination justify-content-center">';
        if (current_page === 1) {
            output += '<li class="page-item disabled">';
        } else {
            output += '<li class="page-item">';
        }
        output += '<button class="page-link" onclick="updateTableBody(\'#departments\', \'' + first_page_url + '\')">';
        output += 'First';
        output += '</button>';
        output += '</li>';
        $.each(links, (key, value) => {
            switch (key) {
                case 0:
                    if (current_page === 1) {
                        output += '<li class="page-item disabled">';
                    } else {
                        output += '<li class="page-item">';
                    }
                    output += '<button class="page-link" onclick="updateTableBody(\'#departments\', \'' + value.url + '\')">';
                    output += value.label
                    output += '</button>';
                    output += '</li>';
                    break;
                case (links.length - 1):
                    if (current_page === last_page) {
                        output += '<li class="page-item disabled">';
                    } else {
                        output += '<li class="page-item">';
                    }
                    output += '<button class="page-link" onclick="updateTableBody(\'#departments\', \'' + value.url + '\')">'
                    output += value.label
                    output += '</button>';
                    output += '</li>';
                    break;
                default:
                    if (value.active !== true) {
                        output += '<li class="page-item">';
                    } else {
                        output += '<li class="page-item disabled">';
                    }
                    output += '<button class="page-link" onclick="updateTableBody(\'#departments\', \'' + value.url + '\')">' + value.label + '</button>';
                    output += '</li>';
            }
        });
        if (current_page === last_page) {
            output += '<li class="page-item disabled">';
        } else {
            output += '<li class="page-item">';
        }
        output += '<button class="page-link" onclick="updateTableBody(\'#departments\', \'' + last_page_url + '\')">Last</button>';
        output += '</li>';
        output += '</ul>';
        output += '</nav>';
        $(id).empty();
        $(id).html(output);

    }

    function savedata(data) {
        const url = "http://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/departments/store";
        $.ajax({
            type: "post",
            url: url,
            dataType: "json",
            data: data,
            success: (success) => {
                console.log(success)
            },

        });
    }
</script>
