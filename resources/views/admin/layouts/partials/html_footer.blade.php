<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js') }}" defer></script>

<script type="application/javascript">

    // Set Content Body Height.
    $(window).on('load', () => {
        let hasContentActions = $('.ib-content-actions').hasClass('ib-content-actions');
        let hasContentFooter = $('.ib-content-footer').hasClass('ib-content-footer');

        if (hasContentActions === true && hasContentFooter === true) {
            $('.ib-content-body').addClass('ib-content-body-all')
        } else if (hasContentActions === true) {
            $('.ib-content-body').addClass('ib-content-body-actions')
        } else if (hasContentFooter === true) {
            $('.ib-content-body').addClass('ib-content-body-footer')
        } else {
            $('.ib-content-body').addClass('ib-content-body')
        }
    });

    $('#navbar-collapse').on('click', () => {
        if ($('.ib-navbar').hasClass('ib-navbar-open') === true) {

            $('.ib-navbar').animate({width: "50px"}, 500);
            $('.ib-content').animate({left: "50px"}, 500);

            $('#navbar-collapse .material-icons').text('chevron_right');

            $('.ib-content').removeClass('ib-content-open');
            $('.ib-content').addClass('ib-content-collapsed');


            $('.ib-navbar ul').removeClass('ib-open');
            $('.ib-navbar ul').addClass('ib-collapsed');

            $('.ib-navbar ul li span.title').hide();

            $('.nav-category').hide();

            $('.ib-navbar').removeClass('ib-navbar-open');
            $('.ib-navbar').addClass('ib-navbar-collapsed');
        } else {
            $('.ib-navbar').animate({width: "200px"}, 250);
            $('.ib-content').animate({left: "200px"}, 250);

            $('#navbar-collapse .material-icons').text('chevron_left');

            $('.ib-content').removeClass('ib-content-collapsed');
            $('.ib-content').addClass('ib-content-open');

            $('.ib-navbar ul').removeClass('ib-collapsed');
            $('.ib-navbar ul').addClass('ib-open');

            $('.ib-navbar ul li span.title').show();

            $('.nav-category').show();

            $('.ib-navbar').removeClass('ib-navbar-collapsed');
            $('.ib-navbar').addClass('ib-navbar-open');
        }

    });
</script>


@yield('scripts')
