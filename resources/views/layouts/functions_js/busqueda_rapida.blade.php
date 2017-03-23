$('#search_field').keyup(function (e) {
    var str = $(this).val().trim().toLowerCase();

    if (str != '') {
        $('#reports .col-xs-3').each(function (index, value) {
            var tag = $(value);
            var text = $(tag.children('div').children('div').children('div').children('div')[1]).text().trim();

            if (text.toLowerCase().indexOf(str) >= 0) {
                tag.show('slow');
            } else {
                tag.hide('slow');
            }
        });
    } else {
        $('#reports .col-xs-3').each(function (index, value) {
            $(value).show('slow');
        });
    }
});
