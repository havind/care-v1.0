<script type="text/javascript">
    /**
     * Set Supervisor Select after loading.
     */
    $.get('{{ request()->secure() ? "https" : "http" }}://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/users/all', (rawData) => {
        console.log(rawData)
        $('#department-supervisor').empty();
        $('#department-supervisor').append('<option value="0">-- SELECT SUPERVISOR --</option>');
        $.each(data = rawData.data.data, (index, value) => {
            $('#department-supervisor').append('<option value="' + value.user_id + '" ' + (value.user_id === '{{ $department->supervisor_id }}' ? 'selected' : '') + '>' + value.user_first_name + ' ' + value.user_last_name + '</option>');
        });
    });
</script>
