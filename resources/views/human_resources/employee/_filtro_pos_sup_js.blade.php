<script type="text/javascript">
    var department = $('select[name=department]');
    var position = $('select[name=position]');
    var positions = $('select[name=position] option');
    var supervisor = $('select[name=supervisor]');
    var supervisors = $('select[name=supervisor] option');

    department.change(function (e) {
        position.val(-1);
        positions.each(function (index, item) {
            if ($(item).attr('department') == department.val()) {
                $(item).show();
            } else {
                $(item).hide();
            }
        });

        supervisor.val(-1);
        supervisors.each(function (index, item) {
            if ($(item).attr('department') == department.val()) {
                $(item).show();
            } else {
                $(item).hide();
            }
        });
    });
</script>
