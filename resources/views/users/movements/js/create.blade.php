<script type="text/javascript">
    /**
     * Window onload events
     * @param event
     */
    window.onload = (event) => {
        activate_editor('#mv-purpose')
    };

    /*
     * Adding CKEditor to Travel Purpose.
     */
    function activate_editor(id) {
        let allEditors = document.querySelectorAll(id)
        for (var i = 0; i < allEditors.length; i++) {
            ClassicEditor.create(allEditors[i], {
                toolbar: {
                    items: ['heading', '|',
                        'bold', 'italic', '|',
                        'link', '|',
                        'outdent', 'indent', '|',
                        'bulletedList', 'numberedList', '|',
                        'insertTable', '|',
                        'undo', 'redo'
                    ],
                    shouldNotGroupWhenFull: true
                }
            }).catch(error => {
                console.error(error);
            });
        }
    }

    // On load reset form.
    $(function () {
        $('#add-passenger').hide();
        $('#passengers-check').prop("checked", false);

        $('#items-check').prop("checked", false);
        $('#add-items').hide();

        $('#accommodation-enable').hide();

    });

    const fund_codes = (appendTo) => {
        const url = 'http://{{ request()->getHost() . ':' . request()->getPort() }}/api/finance/fund-codes/allActive';
        $.ajax({
            type: "GET",
            url: url,
            dataType: "JSON",
            success: function (rawData) {
                fund_codes_content = rawData.data;
                for (i = 0; i < fund_codes_content.length; i++) {
                    $(appendTo).append('<option value="' + fund_codes_content[i]['id'] + '">' + fund_codes_content[i]['name'] + '</option>');
                }
            }
        });
    }

    // Filtering Budget Lines according to the selected Fund Code.
    function budget_lines(name) {
        const bl_url = "http://{{ request()->getHost() . ':' . request()->getPort() }}/api/finance/budget-lines/budgetLinesFilteredByFundCode/" + $(name).val();

        $.ajax({
            type: "GET",
            url: bl_url,
            dataType: "JSON",
            success: function (rawData) {
                $(name.replace('fc', 'bl')).empty();
                $(name.replace('fc', 'bl')).append('<option value="0">-- SELECT --</option>')
                budget_lines_content = rawData.data;

                $.each(budget_lines_content, (index, value) => {
                    $(name.replace('fc', 'bl')).append('<option value="' + value['id'] + '">' + value['name'] + '</option>')
                    $(name.replace('fc', 'bl')).val(0);
                });
            }
        });
    }


    /**
     * Enable Passengers
     */
    $('#passengers-check').on('click', () => {
        status = $("#passengers-check:checked").length;
        let output;
        if (status == 1) {
            output = '';
            output += '<table id="passengers" class="table table-sm table-hover table-bordered">';
            output += '<thead>';
            output += '<tr class="text-center">';
            output += '<th class="align-middle">#</th>';
            output += '<th class="align-middle" style="width: 40%;">Full Name</th>';
            output += '<th>Financial Codes</th>';
            output += '<th class="align-middle">Actions</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            output += '<tr class="text-center item-row">';
            output += '<td class="align-middle">1</td>';
            output += '<td class="align-middle p-0">';
            output += '<select class="form-control border-0" id="pax-1-name" name="pax-1-name">';
            output += '<option value="0" selected>-- SELECT --</option>';
            @foreach($users as $user)
                output += '<option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>';
            @endforeach
                output += '</select>';
            output += '</td>';
            output += '<td class="p-0">';
            output += '<table class="table table-sm table-bordered m-0 p-0">';
            output += '<thead>';
            output += '<tr class="text-center">';
            output += '<th class="align-middle">Fund Codes</th>';
            output += '<th class="align-middle">Budget Lines</th>';
            output += '<th class="align-middle" style="width: 20%;">%</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            @for ($j = 1; $j <= 3; $j++)
                output += '<tr class="text-center">';
            output += '<th class="align-middle p-0">';
            output += '<select class="form-control border-0" onchange="budget_lines(\'#pax-1-fc-{{ $j }}\')" id="pax-1-fc-{{ $j }}" name="pax-1-fc-{{ $j }}">';
            output += '<option value="0" selected>-- SELECT --</option>';
            output += '</select>';
            output += '</th>';
            output += '<th class="align-middle p-0">';
            output += '<select class="form-control border-0" id="pax-1-bl-{{ $j }}" name="pax-1-bl-{{ $j }}">';
            output += '<option value="0" selected>-- SELECT --</option>';
            output += '</select></th>';
            output += '<th class="align-middle p-0">';
            output += '<input class="form-control border-0" type="number" min="0" max="100" value="0" id="pax-1-pr-{{ $j }}" name="pax-1-pr-{{ $j }}">';
            output += '</th>';
            output += '</tr>';
            fund_codes('#pax-1-fc-{{ $j }}');
            @endfor
                output += '</tbody>';
            output += '</table>';
            output += '</td>';
            output += '<th class="align-middle p-0">';
            output += '<a class="text-danger" href="javascript:clear(\'pax-1\')">';
            output += '<span class="material-icons">clear</span>';
            output += '</a>';
            output += '</td>';
            output += '</tr>';
            output += '</tbody>';
            output += '</table>';
            $('#passengers-content').append(output);
            $('#add-passenger').show();
            $('#accommodation-enable').show();
            $('#accommodation-check').prop("checked", false);
            $('#add-accommodation').hide();
        } else {
            $('#passengers-content').empty();
            $('#accommodation-enable').hide();
            $('#add-passenger').hide();
        }
    });


    /**
     * Enable Items
     */
    $('#items-check').on('click', () => {
        status = $("#items-check:checked").length;
        if (status == 1) {
            output = '';
            output += '<table class="table table-sm table-hover table-bordered" id="items">';
            output += '<thead>';
            output += '<tr class="text-center">';
            output += '<th class="align-middle">#</th>';
            output += '<th class="align-middle" style="width: 44%;">Items</th>';
            output += '<th>Financial Codes</th>';
            output += '<th class="align-middle" style="width: 6%;">Actions</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            output += '<tr class="text-center item-row">';
            output += '<td class="align-middle p-0">1</td>';
            output += '<td class="align-top p-0">';
            output += '<textarea class="form-control border-0 editor" id="itm-1-name" name="itm-1-name" rows="5" style="resize: none; users-focus: none;"></textarea>';
            output += '</td>';
            output += '<td class="p-0">';
            output += '<table class="table table-sm table-bordered m-0 p-0">';
            output += '<thead>';
            output += '<tr class="text-center">';
            output += '<th class="align-middle">Fund Codes</th>';
            output += '<th class="align-middle">Budget Lines</th>';
            output += '<th class="align-middle" style="width: 20%;">%</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            @for ($j = 1; $j <= 3; $j++)
                output += '<tr class="text-center">';
            output += '<th class="align-middle p-0">';
            output += '<select class="form-control border-0" onchange="budget_lines(\'#itm-1-fc-{{ $j }}\')" id="itm-1-fc-{{ $j }}" name="itm-1-fc-{{ $j }}">';
            output += '<option value="0" selected>-- SELECT --</option>';

            output += '</select>';
            output += '</th>';
            output += '<th class="align-middle p-0">';
            output += '<select class="form-control border-0"id = "itm-1-bl-{{ $j }}"name = "itm-1-bl-{{ $j }}">';
            output += '<option value="0" selected> --SELECT-- </option>';
            output += '</select></th>';
            output += '<th class="align-middle p-0">';
            output += '<input class="form-control border-0" type="number" min="0" max="100" value="0" id="itm-1-pr-{{ $j }}" name="itm-1-pr-{{ $j }}">';
            output += '</th>';
            output += '</tr>';
            fund_codes('#itm-1-fc-{{ $j }}');
            @endfor
                output += '</tbody>';
            output += '</table>';
            output += '</td>';
            output += '<th class="align-middle p-0">';
            output += '<a class="text-danger" href="javascript:clear(\'itm-1\')"><span class="material-icons">clear</span></a>';
            output += '</td>';
            output += '</tr>';
            output += '</tbody>';
            output += '</table>';
            $('#items-content').append(output);
            $('#add-items').show();
            activate_editor('#itm-1-name');
        } else {
            $('#items-content').empty();
            $('#add-items').hide();
        }
    })

    /**
     * Enable Accommodation
     */
    $('#accommodation-check').on('click', () => {
        status = $("#accommodation-check:checked").length;
        if (status == 1) {
            let output = '';
            output += '<table id="accommodation" class="table table-sm table-hover table-bordered">';
            output += '<thead>';
            output += '<tr class="text-center">';
            output += '<th class="align-middle">#</th>';
            output += '<th class="align-middle">Full Name</th>';
            output += '<th class="align-middle">City (Where to stay)</th>';
            output += '<th class="align-middle">Check-In</th>';
            output += '<th class="align-middle">Check-Out</th>';
            output += '<th>Financial Codes</th>';
            output += '<th class="align-middle">Actions</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            output += '<tr class="text-center item-row">';
            output += '<td class="align-middle p-0">1</td>';
            output += '<td class="align-middle p-0">';
            output += '<select class="form-control border-0" id="acm-1-name" name="acm-1-name">';
            output += '<option value="0" selected>-- SELECT --</option>';
            @foreach($users as $user)
                output += '<option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>';
            @endforeach
                output += '</select>';
            output += '</td>';
            output += '<td class="align-middle p-0">';
            output += '<select class="form-control border-0" id="acm-1-location" name="acm-1-location">';
            output += '<option value="0" selected>-- SELECT --</option>';
            @foreach($locations as $location)
                @if ($location->is_accommodation == 1)
                output += '<option value="{{ $location->id }}">{{ $location->name }}</option>';
            @endif
                @endforeach
                output += '</select>';
            output += '</td>';
            output += '<td class="align-middle p-0">';
            {{--output += '<input class="form-control border-0" id="acm-1-check-in" min="{{ date('Y-m-d') }}" onchange="setMinDate(\'acm\', 1)" name="acm-1-check-in" type="date">';--}}
                output += '<input class="form-control border-0" id="acm-1-check-in" name="acm-1-check-in" type="date">';
            output += '</td>';
            output += '<td class="align-middle p-0">';
            output += '<input class="form-control border-0" id="acm-1-check-out" name="acm-1-check-out" type="date">';
            output += '</td>';
            output += '<td class="align-middle p-0">';
            output += '<table class="table table-sm table-bordered m-0 p-0">';
            output += '<thead>';
            output += '<tr class="text-center">';
            output += '<th class="align-middle">Fund Codes</th>';
            output += '<th class="align-middle">Budget Lines</th>';
            output += '<th class="align-middle" style="width: 20%;">%</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            @for ($j = 1; $j <= 3; $j++)
                output += '<tr class="text-center">';
            output += '<th class="align-middle p-0">';
            output += '<select class="form-control border-0" onchange="budget_lines(\'#acm-1-fc-{{ $j }}\')" id="acm-1-fc-{{ $j }}" name="acm-1-fc-{{ $j }}">';
            output += '<option value="0" selected>-- SELECT --</option>';
            output += '</select>';
            output += '</th>';
            output += '<th class="align-middle p-0">';
            output += '<select class="form-control border-0" id="acm-1-bl-{{ $j }}" name="acm-1-bl-{{ $j }}">';
            output += '<option value="0" selected>-- SELECT --</option>';
            output += '</select>';
            output += '</th>';
            output += '<th class="align-middle p-0">';
            output += '<input class="form-control border-0" type="number" min="0" max="100" value="0" id="acm-1-pr-{{ $j }}" name="acm-1-pr-{{ $j }}">';
            output += '</th>';
            output += '</tr>';
            fund_codes('#acm-1-fc-{{ $j }}');
            @endfor
                output += '</tbody>';
            output += '</table>';
            output += '</td>';
            output += '<th class="align-middle p-0">';
            output += '<a class="text-danger" href="javascript:clear(\'acm-1\')"><span class="material-icons">clear</span></a>';
            output += '</td>';
            output += '</tr>';
            output += '</tbody>';
            output += '</table>';

            $('#accommodation-content').append(output);
            $('#add-accommodation').show();
        } else {
            $('#accommodation-content').empty();
            $('#add-accommodation').hide();
        }
    });

    /**
     * Add new Passengers
     */
    $('#add-passenger').on('click', () => {
        // Count number of rows.
        counter = $('#passengers tbody tr.item-row').length + 1;

        if (counter <= 6) {
            let output = '';
            output += '<tr class="text-center item-row">';
            output += '<td class="align-middle">' + counter + '</td>';
            output += '<td class="align-middle p-0">';
            output += '<select class="form-control border-0" id="pax-' + counter + '-name" name="pax-' + counter + '-name">';
            output += '<option value="0" selected>-- SELECT --</option>';
            @foreach($users as $user)
                output += '<option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>';
            @endforeach
                output += '</select>';
            output += '</td>';
            output += '<td class="p-0">';
            output += '<table class="table table-sm table-bordered m-0 p-0">';
            output += '<thead>';
            output += '<tr class="text-center">';
            output += '<th class="align-middle">Fund Codes</th>';
            output += '<th class="align-middle">Budget Lines</th>';
            output += '<th class="align-middle" style="width: 20%;">%</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            @for ($j = 1; $j <= 3; $j++)
                output += '<tr class="text-center">';
            output += '<th class="align-middle p-0">';
            output += '<select class="form-control border-0" onchange="budget_lines(\'#pax-' + counter + '-fc-{{ $j }}\')" id="pax-' + counter + '-fc-{{ $j }}" name="pax-' + counter + '-fc-{{ $j }}">';
            output += '<option value="0" selected>-- SELECT --</option>';
            output += '</select>';
            output += '</th>';
            output += '<th class="align-middle p-0">';
            output += '<select class="form-control border-0" id="pax-' + counter + '-bl-{{ $j }}" name="pax-' + counter + '-bl-{{ $j }}">';
            output += '<option value="0" selected>-- SELECT --</option>';
            output += '</select>';
            output += '</th>';
            output += '<th class="align-middle p-0">';
            output += '<input class="form-control border-0" type="number" min="0" max="100" value="0" id="pax-' + counter + '-pr-{{ $j }}" name="pax-' + counter + '-pr-{{ $j }}">';
            output += '</th>';
            output += '</tr>';
            fund_codes('#pax-' + counter + '-fc-{{ $j }}');
            @endfor
                output += '</tbody>';
            output += '</table>';
            output += '</td>';
            output += '<th class="align-middle p-0">';
            output += '<a class="text-danger" href="javascript:clear(\'pax-' + counter + '\')"><span class="material-icons">clear</span></a>';
            output += '</td>';
            output += '</tr>';
            $('#passengers tbody tr.item-row:last').after(output)
            if (counter == 6) {
                $('#add-passenger').hide();
            }
        }
    });

    /**
     * Add new Item
     */
    $('#add-items').on('click', () => {
        // Count number of rows.
        counter = $('#items tbody tr.item-row').length + 1;

        if (counter <= 15) {
            output = '';
            output += '<tr class="text-center item-row">';
            output += '<td class="align-middle p-0">' + counter + '</td>';
            output += '<td class="align-middle p-0">';
            output += '<textarea class="form-control border-0" id="itm-' + counter + '-name" name="itm-' + counter + '-name" rows="5" style="resize: none; users-focus: none;"></textarea>';
            output += '</td>';
            output += '<td class="p-0">';
            output += '<table class="table table-sm table-bordered m-0 p-0">';
            output += '<thead>';
            output += '<tr class="text-center">';
            output += '<th class="align-middle">Fund Codes</th>';
            output += '<th class="align-middle">Budget Lines</th>';
            output += '<th class="align-middle" style="width: 20%;">%</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            @for ($j = 1; $j <= 3; $j++)
                output += '<tr class="text-center">';
            output += '<th class="align-middle p-0">';
            output += '<select class="form-control border-0"  onchange="budget_lines(\'#itm-' + counter + '-fc-{{ $j }}\')"  id="itm-' + counter + '-fc-{{ $j }}" name="itm-' + counter + '-fc-{{ $j }}">';
            output += '<option value="0" selected>-- SELECT --</option>';
            output += '</select>';
            output += '</th>';
            output += '<th class="align-middle p-0">';
            output += '<select class="form-control border-0" id="itm-' + counter + '-bl-{{ $j }}" name="itm-' + counter + '-bl-{{ $j }}">';
            output += '<option value="0" selected>-- SELECT --</option>';
            output += '</select>';
            output += '</th>';
            output += '<th class="align-middle p-0">';
            output += '<input class="form-control border-0" type="number" min="0" max="100" value="0" id="itm-' + counter + '-pr-{{ $j }}" name="itm-' + counter + '-pr-{{ $j }}">';
            output += '</th>';
            output += '</tr>';
            fund_codes('#itm-' + counter + '-fc-{{ $j }}');
            @endfor
                output += '</tbody>';
            output += '</table>';
            output += '</td>';
            output += '<th class="align-middle p-0">';
            output += '<a class="text-danger" href="javascript:clear(\'itm-' + counter + '\')"><span class="material-icons">clear</span></a>';
            output += '</td>';
            output += '</tr>';
            $('#items tbody tr.item-row:last').after(output);
            activate_editor('#itm-' + counter + '-name');

            if (counter == 15) {
                $('#add-items').hide();
            }
        }
    });

    /**
     * Add new Itinerary
     */
    $('#add-itinerary').on('click', () => {
        // Count number of rows.
        counter = $('#itinerary tbody tr').length + 1;

        // Check if rows are reached 15 rows.
        if (counter < 15) {

        } else {
            $('#add-itinerary').hide();
        }

        output = '';
        output += '<tr class="text-center">';
        output += '<td class="align-middle p-0">' + counter + '</td>';
        output += '<td class="align-middle p-0">';
        output += '<select class="form-control border-0" id="iti-' + counter + '-from-location" name="iti-' + counter + '-from-location">';
        output += '<option value="0" selected>-- SELECT --</option>';
        @foreach($locations as $location)
            output += '<option value="{{ $location->id }}">{{ $location->name }}</option>';
        @endforeach
            output += '</select>';
        output += '</td>';
        output += '<td class="align-middle p-0">';
        output += '<input class="form-control border-0" min="{{ date('Y-m-d') }}" id="iti-' + counter + '-from-date" onchange="setMinDate(\'iti\', counter)" name="iti-' + counter + '-from-date" type="date">';
        output += '</td>';
        output += '<td class="align-middle p-0">';
        output += '<input class="form-control border-0" id="iti-' + counter + '-from-time" name="iti-' + counter + '-from-time" type="time">';
        output += '</td>';
        output += '<td class="align-middle p-0">';
        output += '<select class="form-control border-0" id="iti-' + counter + '-to-location" name="iti-' + counter + '-to-location">';
        output += '<option value="0" selected>-- SELECT --</option>';
        @foreach($locations as $location)
            output += '<option value="{{ $location->id }}">{{ $location->name }}</option>';
        @endforeach
            output += '</select>';
        output += '</td>';
        output += '<td class="align-middle p-0">';
        output += '<input type="date" class="form-control border-0" id="iti-' + counter + '-to-date" name="iti-' + counter + '-to-date">';
        output += '</td>';
        output += '<td class="align-middle p-0">';
        output += '<input type="time" class="form-control border-0" id="iti-' + counter + '-to-time" name="iti-' + counter + '-to-time">';
        output += '</td>';
        output += '<th class="align-middle p-0">';
        output += '<a class="text-danger" href="javascript:clear(\'iti-' + counter + '\')"><span class="material-icons">clear</span></a>';
        output += '</td>';
        output += '</tr>';

        $('#itinerary tbody').append(output);
    });

    /**
     * Add new Accommodation
     */
    $('#add-accommodation').on('click', () => {
        // Count number of rows.
        counter = $('#accommodation tbody tr.item-row').length + 1;

        if (counter <= 6) {
            let output = '';
            output += '<tr class="text-center item-row">';
            output += '<td class="align-middle p-0">' + counter + '</td>';
            output += '<td class="align-middle p-0">';
            output += '<select class="form-control border-0" id="acm-' + counter + '-name" name="acm-' + counter + '-name">';
            output += '<option value="0" selected>-- SELECT --</option>';
            @foreach($users as $user)
                output += '<option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>';
            @endforeach
                output += '</select>';
            output += '</td>';
            output += '<td class="align-middle p-0">';
            output += '<select class="form-control border-0" id="acm-' + counter + '-location" name="acm-' + counter + '-location">';
            output += '<option value="0" selected>-- SELECT --</option>';
            @foreach($locations as $location)
                @if ($location->is_accommodation == 1)
                output += '<option value="{{ $location->id }}">{{ $location->name }}</option>';
            @endif
                @endforeach
                output += '</select>';
            output += '</td>';
            output += '<td class="align-middle p-0">';
            output += '<input class="form-control border-0" onchange="setMinDate(\'acm\', ' + counter + ')" id="acm-' + counter + '-check-in" name="acm-' + counter + '-check-in" type="date">';
            output += '</td>';
            output += '<td class="align-middle p-0">';
            output += '<input class="form-control border-0" id="acm-' + counter + '-check-out" name="acm-' + counter + '-check-out" type="date">';
            output += '</td>';
            output += '<td class="align-middle p-0">';
            output += '<table class="table table-sm table-bordered m-0 p-0">';
            output += '<thead>';
            output += '<tr class="text-center">';
            output += '<th class="align-middle">Fund Codes</th>';
            output += '<th class="align-middle">Budget Lines</th>';
            output += '<th class="align-middle" style="width: 20%;">%</th>';
            output += '</tr>';
            output += '</thead>';
            output += '<tbody>';
            @for ($j = 1; $j <= 3; $j++)
                output += '<tr class="text-center">';
            output += '<th class="align-middle p-0">';
            output += '<select class="form-control border-0" onchange="budget_lines(\'#acm-' + counter + '-fc-{{ $j }}\')" id="acm-' + counter + '-fc-{{ $j }}" name="acm-' + counter + '-fc-{{ $j }}">';
            output += '<option value="0" selected>-- SELECT --</option>';
            output += '</select>';
            output += '</th>';
            output += '<th class="align-middle p-0">';
            output += '<select class="form-control border-0" id="acm-' + counter + '-bl-{{ $j }}" name="acm-' + counter + '-bl-{{ $j }}">';
            output += '<option value="0" selected>-- SELECT --</option>';
            output += '</select>';
            output += '</th>';
            output += '<th class="align-middle p-0">';
            output += '<input class="form-control border-0" type="number" min="0" max="100" value="0" id="acm-' + counter + '-pr-{{ $j }}" name="acm-' + counter + '-pr-{{ $j }}">';
            output += '</th>';
            output += '</tr>';
            fund_codes('#acm-' + counter + '-fc-{{ $j }}');
            @endfor
                output += '</tbody>';
            output += '</table>';
            output += '</td>';
            output += '<th class="align-middle p-0">';
            output += '<a class="text-danger" href="javascript:clear(\'acm-' + counter + '\')"><span class="material-icons">clear</span></a>';
            output += '</td>';
            output += '</tr>';
            $('#accommodation tbody tr.item-row:last').after(output);
            if (counter == 6) {
                $('#add-accommodation').hide();
            }
        }
    });


    /**
     * Clear Itinerary record
     */
    function clear(id) {
        console.log(id)
        switch (id) {
            // Passengers
            case String(id.match(/^pax-\d{1,2}/gm)):
                $('#' + id + '-name').val(0);
                for (i = 1; i <= 3; i++) {
                    $('#' + id + '-fc-' + i).val(0);
                    $('#' + id + '-bl-' + i).val(0);
                    $('#' + id + '-pr-' + i).val(0);
                }
                break;

            // Items
            case String(id.match(/^itm-\d{1,2}/gm)):
                $('#' + id + '-name').val('');
                for (i = 1; i <= 3; i++) {
                    $('#' + id + '-fc-' + i).val(0);
                    $('#' + id + '-bl-' + i).val(0);
                    $('#' + id + '-pr-' + i).val(0);
                }
                break;

            // Itinerary
            case String(id.match(/^iti-\d{1,2}/gm)):
                $('#' + id + '-from-location').val(0);
                $('#' + id + '-from-date').val(0);
                $('#' + id + '-from-time').val(0);
                $('#' + id + '-to-location').val(0);
                $('#' + id + '-to-date').val(0);
                $('#' + id + '-to-time').val(0);
                break;

            // Itinerary
            case String(id.match(/^acm-\d{1,2}/gm)):
                $('#' + id + '-name').val(0);
                $('#' + id + '-location').val(0);
                $('#' + id + '-check-in').val(0);
                $('#' + id + '-check-out').val(0);
                for (i = 1; i <= 3; i++) {
                    $('#' + id + '-fc-' + i).val(0);
                    $('#' + id + '-bl-' + i).val(0);
                    $('#' + id + '-pr-' + i).val(0);
                }
                break;

        }
    }

    /**
     * Set To date field
     */
    function setMinDate(type, id) {
        if (type == 'iti') {
            $('#iti-' + String(id) + '-to-date').attr('min', $('#iti-' + String(id) + '-from-date').val());
        } else if (type == 'acm') {
            $('#acm-' + String(id) + '-check-out').attr('min', $('#acm-' + String(id) + '-check-in').val());
        }
    }

    /********************************
     ********************************
     **                            **
     **     NO CODE BELOW HERE     **
     **                            **
     **  VALIDATION PURPOSES ONLY  **
     **                            **
     ********************************
     ********************************/

    /**
     * Movement Request Form validation
     */


    // END - Travel Purpose validation


    // Itinerary
    function validate_itinerary(id) {
        if ($('#iti-' + id + '-from-location').val() > 0) {
            $('#iti-' + id + '-from-location').removeClass('is-invalid');
            $('#iti-' + id + '-from-location').addClass('is-valid');
        } else {
            $('#iti-' + id + '-from-location').removeClass('is-valid');
            $('#iti-' + id + '-from-location').addClass('is-invalid');
        }
        if ($('#iti-' + id + '-from-date').val() != '') {
            $('#iti-' + id + '-from-date').removeClass('is-invalid');
            $('#iti-' + id + '-from-date').addClass('is-valid');
        } else {
            $('#iti-' + id + '-from-date').removeClass('is-valid');
            $('#iti-' + id + '-from-date').addClass('is-invalid');
        }
        if ($('#iti-' + id + '-from-time').val() != '') {
            $('#iti-' + id + '-from-time').removeClass('is-invalid');
            $('#iti-' + id + '-from-time').addClass('is-valid');
        } else {
            $('#iti-' + id + '-from-time').removeClass('is-valid');
            $('#iti-' + id + '-from-time').addClass('is-invalid');
        }
        if ($('#iti-' + id + '-to-location').val() > 0) {
            $('#iti-' + id + '-to-location').removeClass('is-invalid');
            $('#iti-' + id + '-to-location').addClass('is-valid');
        } else {
            $('#iti-' + id + '-to-location').removeClass('is-valid');
            $('#iti-' + id + '-to-location').addClass('is-invalid');
        }
        if ($('#iti-' + id + '-to-date').val() != '') {
            $('#iti-' + id + '-to-date').removeClass('is-invalid');
            $('#iti-' + id + '-to-date').addClass('is-valid');
        } else {
            $('#iti-' + id + '-to-date').removeClass('is-valid');
            $('#iti-' + id + '-to-date').addClass('is-invalid');
        }
        if ($('#iti-' + id + '-to-time').val() != '') {
            $('#iti-' + id + '-to-time').removeClass('is-invalid');
            $('#iti-' + id + '-to-time').addClass('is-valid');
        } else {
            $('#iti-' + id + '-to-time').removeClass('is-valid');
            $('#iti-' + id + '-to-time').addClass('is-invalid');
        }
    }

</script>
