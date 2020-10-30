$("#pay").click(function() {
    let delivery;
    if ($('#ups').is(':checked')) {
        delivery = 2;
    } else if ($('#pick-up').is(':checked')) {
        delivery = 1;
    }
    if (delivery) {
        let messageDiv = $('#errors');
        let payBtn = $(this);
        let data = {
            delivery: delivery,
            total: (payBtn.data('total')).toFixed(2),
        };
        let url = payBtn.data('url') + '/checkout';
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(resp) {
                messageDiv.toggle();
                if (resp.errors) {
                    messageDiv.attr('class', 'alert alert-danger').text(resp.errors);
                } else {
                    messageDiv.attr('class', 'alert alert-success').text('Bill Paid. New balance: ' + resp.balance);
                }
            }
        });
    } else {
        alert('Please select a delivery method.');
    }
});