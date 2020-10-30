var url = $('.card-deck').data('url');

$(".card button").click(function() {
    let row = $(this).parents('.row');
    let messageDiv = row.next().find('.card-message');
    messageDiv.toggle();
    let input = row.find('input');
    let data = {
        id: input.attr('id'),
        val: input.val()
    };
    let cartUrl = url + '/cart';
    sendData(cartUrl, data, messageDiv);
});

function sendData(url, data, messageDiv) {
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: function(resp) {
            if (messageDiv) {
                messageDiv.toggle();
                if (resp.errors) {
                    messageDiv.attr('class', 'card-message alert alert-danger').text(resp.errors);
                } else {
                    messageDiv.attr('class', 'card-message alert alert-success').text('Cart updated.');
                }
            }
        }
    });
}

var loggedIn = $('.card-deck').data('auth');
$(".my-rating").starRating({
    readOnly: !loggedIn,
    starSize: 25,
    callback: function(rating, $el) {
        let snackId = $el.parents('.card-body').find('.row').first().find('input').attr('id');
        let data = {
            id: snackId,
            rating: rating
        };
        sendData(url + '/rating', data);
    }
});

$(".my-rating").each(function() {
     if ($(this).data('rating')) {
         $(this).starRating('setReadOnly', true);
     }
  });