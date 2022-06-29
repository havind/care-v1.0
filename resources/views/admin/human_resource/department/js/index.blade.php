<script type="text/javascript">

    $(window).on('load', () => {
        getdata();
    });

    function getdata() {
        const url = "http://{{ request()->getHost() . ':' . request()->getPort() }}/api/human-resources/departments/all";
        $.ajax({
            type: "get",
            url: url,
            dataType: "json",
            success: (response) => {
                console.log(response);
            },
            error: () => {
                console.log('FAILED TO GET DEPARTMENT.');
            }
        })
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
