<script type="text/javascript">
    $(window).on('load', function (e) {
        $.get('{{ request()->secure() ? "https" : "http" }}://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/users/count', (rawData) => {
            console.log(rawData)
            if (rawData.data > 0) {
                let url = '{{ request()->secure() ? "https" : "http" }}://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/users/all/20';

                $('#users-available').removeClass("invisible");
                getData(url);
            } else {
                $('#users-available').hide()
                $('#no-users').removeClass("invisible");
                console.log('no records');
            }
        });


    });

    /**
     * Get All Data if pagination was not on.
     * If Pagination was available it will get the first page.
     * @type {string}
     */
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
                if (data.length >= 0) {
                    if (data.length === 0) {
                        $('#users').empty().html(noDataMessage);
                    } else {
                        $('#users').empty();
                        generateTable('#users');
                        $('#users table tbody').empty();
                        generateTableBody('#users', data);
                    }
                } else if (data.length === 0) {
                    $('#users').empty().html(noDataMessage);
                } else {
                    $('#users').empty();
                    generateTable('#users');
                    $('#users table tbody').empty();
                    generateTableBody('#users', data.data);
                    generateTablePagination('#users div.ib-pagination', data)
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
     * Make an array has unique values.
     * @param array
     * @returns {*}
     */
    function arrayUnique(array) {
        return array.filter(function (element, index, self) {
            return index === self.indexOf(element);
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
        output += '<th style="min-width: 15%; width: 15%;">Full name</th>';
        output += '<th>Position</th>';
        output += '<th>Department</th>';
        output += '<th>Emails</th>';
        output += '<th style="min-width: 13%; width: 13%;">Phone number</th>';
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
        $.each(tableData, (key, value) => {
                output += '<tr>';
                output += '<td class="align-middle text-center">';
                output += key + 1;
                output += '</td>';
                output += '<td class="align-middle">';
                output += '<a href="' + ('{{ route("a.human-resources.users.show", ":id") }}').replace(':id', value['user_id']) + '">';
                output += value['user_first_name'] + ' ' + value['user_last_name'];
                output += '</a>';
                output += '</td>';
                if (value['position_name'] == null) {
                    output += '<td class="align-middle text-center table-warning text-warning">Not Available</td>';
                } else {
                    output += '<td class="align-middle">';
                    output += '<a href="' + ('{{ route("a.human-resources.departments.positions.show", [":department_id", ":position_id"]) }}').replace(':department_id', value['department_id']).replace(':position_id', value['position_id']) + '">';
                    output += value['position_name'];
                    output += '</a>';
                    output += '</td>';
                }

                if (value['department_name'] == null) {
                    output += '<td class="align-middle text-center table-warning text-warning">Not Available</td>';
                } else {
                    output += '<td class="align-middle">';
                    output += '<a href="' + ('{{ route("a.human-resources.departments.show", ":department_id") }}').replace(':department_id', value['department_id']) + '">';
                    output += value['department_name'];
                    output += '</a>';
                    output += '</td>';
                }

                if (value['user_work_email'] == null) {
                    if (value['user_personal_email'] == null) {
                        output += '<td class="align-middle text-center table-warning text-warning">Not Available</td>';
                    } else {
                        output += '<td class="align-middle">';
                        output += value['user_personal_email'];
                        output += '</td>';
                    }
                } else {
                    output += '<td class="align-middle">';
                    output += value['user_work_email'];
                    output += '</td>';
                }

                if (value['user_work_phone'] == null) {
                    if (value['user_personal_email'] == null) {
                        output += '<td class="align-middle text-center table-warning text-warning">Not Available</td>';
                    } else {
                        output += '<td class="align-middle">';
                        output += '+' + value['user_personal_phone'];
                        output += '</td>';
                    }
                } else {
                    output += '<td class="align-middle">';
                    output += '+' + value['user_work_phone'];
                    output += '</td>';
                }

                output += '<td class="align-middle text-center">';
                @include('admin.human_resource.users.partials.index_actions')
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
        output += '<button class="page-link" onclick="updateTableBody(\'#content\', \'' + first_page_url + '\')">';
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
                    output += '<button class="page-link" onclick="updateTableBody(\'#content\', \'' + value.url + '\')">';
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
                    output += '<button class="page-link" onclick="updateTableBody(\'#content\', \'' + value.url + '\')">'
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
                    output += '<button class="page-link" onclick="updateTableBody(\'#content\', \'' + value.url + '\')">' + value.label + '</button>';
                    output += '</li>';
            }
        });
        if (current_page === last_page) {
            output += '<li class="page-item disabled">';
        } else {
            output += '<li class="page-item">';
        }
        output += '<button class="page-link" onclick="updateTableBody(\'#content\', \'' + last_page_url + '\')">Last</button>';
        output += '</li>';
        output += '</ul>';
        output += '</nav>';
        $(id).empty();
        $(id).html(output);

    }

    function updateTableBody(id, url) {
        $.ajax({
                type: 'GET',
                dataType: 'json',
                url: url,
                jsonpCallback: 'responseJSON',
                success: (data) => {
                    data = data.users;
                    let usersData = data.data;
                    $('#content table tbody').empty();
                    let output;

                    $.each(usersData, (key, value) => {
                        output += '<tr>';
                        output += '<td class="align-middle text-center">';
                        output += data.from + key;
                        output += '</td>';
                        output += '<td class="align-middle">';
                        output += '<a href="' + ('{{ route("a.human-resources.users.show", ":id") }}').replace(':id', value['id']) + '">';
                        output += value['first_name'] + ' ' + value['last_name'];
                        output += '</a>';
                        output += '</td>';
                        if (value['position_name'] == null) {
                            output += '<td class="align-middle text-center table-warning text-warning">Not Available</td>';
                        } else {
                            output += '<td class="align-middle">';
                            output += '<a href="' + ('{{ route("a.human-resources.departments.positions.show", [":department_id", ":position_id"]) }}').replace(':department_id', value['department_id']).replace(':position_id', value['position_id']) + '">';
                            output += value['position_name'];
                            output += '</a>';
                            output += '</td>';
                        }
                        if (value['department_name'] == null) {
                            output += '<td class="align-middle text-center table-warning text-warning">Not Available</td>';
                        } else {
                            output += '<td class="align-middle">';
                            output += '<a href="' + ('{{ route("a.human-resources.departments.show", ":department_id") }}').replace(':department_id', value['department_id']) + '">';
                            output += value['department_name'];
                            output += '</a>';
                            output += '</td>';
                        }

                        if (value['work_email'] == null) {
                            if (value['personal_email'] == null) {
                                output += '<td class="align-middle text-center table-warning text-warning">Not Available</td>';
                            } else {
                                output += '<td class="align-middle">';
                                output += value['personal_email'];
                                output += '</td>';
                            }
                        } else {
                            output += '<td class="align-middle">';
                            output += value['work_email'];
                            output += '</td>';
                        }

                        output += '</td>';

                        if (value['work_phone'] == null) {
                            if (value['personal_email'] == null) {
                                output += '<td class="align-middle text-center table-warning text-warning">Not Available</td>';
                            } else {
                                output += '<td class="align-middle">';
                                output += '+' + value['personal_phone'];
                                output += '</td>';
                            }
                        } else {
                            output += '<td class="align-middle">';
                            output += '+' + value['work_phone'];
                            output += '</td>';
                        }

                        output += '<td class="align-middle text-center">';
                        @include('admin.human_resource.users.partials.index_actions')
                            output += '</td>';
                        output += '</tr>';
                    });
                    $(id + ' table tbody').html(output);
                    generateTablePagination('#content div.ib-pagination', data)
                }
            }
        )
        ;
    }

</script>
