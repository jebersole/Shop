$("#login").click(function() {
    $('#errors').css('display', 'none');
    let url = $(this).data('url');
    let data = {
       username: $('#username').val(),
       password: $('#password').val(),
       new_acct: $('#new-acct').is(':checked') ? 1 : 0
    };
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(resp) {
            if (resp.errors) {
                $('#errors').text(resp.errors).css('display', 'block');
            } else {
                window.location = resp.url;
            }
        }
    });
});
