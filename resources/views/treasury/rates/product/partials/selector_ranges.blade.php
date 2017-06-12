$('select[name=content]').change(function () {
    var field = $('.ranges');

    if ($(this).val() == 'R') {
        field.show('fast');
    } else {
        field.hide('fast');
    }
});
