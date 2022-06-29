<script type="text/javascript">
    /**
     * Set Department Select after loading.
     */
    $.get('{{ request()->secure() ? "https" : "http" }}://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/departments/allActive', (rawData) => {
        $('#user-department').empty();
        $('#user-department').append('<option value="0" disabled>-- SELECT DEPARTMENT --</option>');
        $.each(data = rawData.data, (index, value) => {

            $('#user-department').append('<option value="' + value.id + '"' + (value.id === {{ $user->department_id }} ? 'selected' : '') + '>' + value.name + '</option>');
        });
    });

    /**
     * Set Positions Select after loading.
     */
    $.get('{{ request()->secure() ? "https" : "http" }}://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/departments/{{ $user->department_id }}/positions', (rawData) => {
        $('#user-position').empty();
        $('#user-position').append('<option value="0">-- SELECT POSITION --</option>');
        $.each(data = rawData.data, (index, value) => {
            $('#user-position').append('<option value="' + value.id + '"' + (value.id === {{ $user->position_id }} ? 'selected' : '') + '>' + value.name + '</option>');
        });
    });

    /**
     * Set Positions Select after Department is being selected.
     */
    $('#user-department').on('change', () => {
        $.get('{{ request()->secure() ? "https" : "http" }}://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/departments/' + $('#user-department').val() + '/positions', (rawData) => {
            $('#user-position').empty();
            $('#user-position').append('<option value="0" selected>-- SELECT POSITION --</option>');
            $.each(data = rawData.data, (index, value) => {

                $('#user-position').append('<option value="' + value.id + '"' + (value.id === {{ $user->position_id }} ? 'selected' : '') + '>' + value.name + '</option>');
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
