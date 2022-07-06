<script type="text/javascript">
    /**
     * Set Department Select after loading.
     */
    $.get('{{ request()->secure() ? "https" : "http" }}://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/departments/allActive', (rawData) => {
        $('#user-departments').empty();
        $('#user-departments').append('<option value="0" disabled>-- SELECT DEPARTMENT --</option>');
        $.each(data = rawData.data, (index, value) => {

            $('#user-departments').append('<option value="' + value.id + '"' + (value.id === {{ $user->department_id }} ? 'selected' : '') + '>' + value.name + '</option>');
        });
    });

    /**
     * Set Positions Select after loading.
     */
    $.get('{{ request()->secure() ? "https" : "http" }}://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/departments/{{ $user->department_id }}/positions', (rawData) => {
        $('#user-positions').empty();
        $('#user-positions').append('<option value="0">-- SELECT POSITION --</option>');
        $.each(data = rawData.data, (index, value) => {
            $('#user-positions').append('<option value="' + value.id + '"' + (value.id === {{ $user->position_id }} ? 'selected' : '') + '>' + value.name + '</option>');
        });
    });

    /**
     * Set Positions Select after Department is being selected.
     */
    $('#user-departments').on('change', () => {
        $.get('{{ request()->secure() ? "https" : "http" }}://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/departments/' + $('#user-departments').val() + '/positions', (rawData) => {
            $('#user-positions').empty();
            $('#user-positions').append('<option value="0" selected>-- SELECT POSITION --</option>');
            $.each(data = rawData.data, (index, value) => {

                $('#user-positions').append('<option value="' + value.id + '"' + (value.id === {{ $user->position_id }} ? 'selected' : '') + '>' + value.name + '</option>');
            });
        });
    });

    /**
     * Set Supervisor Select after loading.
     */
    $.get('{{ request()->secure() ? "https" : "http" }}://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/users/allActive', (rawData) => {
        $('#user-supervisor').empty();
        $('#user-supervisor').append('<option value="0">-- SELECT SUPERVISOR --</option>');
        $.each(data = rawData.data, (index, value) => {
            $('#user-supervisor').append('<option value="' + value.id + '" ' + (value.id === {{ $user->supervisor_id }} ? 'selected' : '') + '>' + value.first_name + ' ' + value.last_name + '</option>');
        });
    });


</script>
