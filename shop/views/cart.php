<?php
$rootUrl = "http://$_SERVER[HTTP_HOST]";
$total = 0;
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/layouts/header.php'); ?>

    <div class="container">
        <?php if (!empty($snacks)) { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($snacks as $snack) { ?>
                    <tr>
                        <td><?=ucfirst($snack['name'][0])?></td>
                        <td><?php
                            $qty = $snack['qty'];
                            if ($snack['name'][1] !== 'unit') $qty .= ' x ' . $snack['name'][1];
                            echo $qty; ?>
                        </td>
                        <td><?php
                            $subtotal = $snack['qty'] * $snack['price'];
                            $total += $subtotal;
                            echo '$'.number_format($subtotal, 2); ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="font-weight: bold;">Total</td>
                </tr>
                <tr>
                    <td style="border-top: none;"></td>
                    <td style="border-top: none;"></td>
                    <td style="border-top: none;"><?='$'.number_format($total, 2)?></td>
                </tr>
            </tbody>
        </table>
        <?php } else { ?>
            <div>Your cart is empty. Please <a href="/">add snacks</a>!</div>
        <?php } ?>
        <div class="row">
            <div class="col">
                Your balance: $<?=$auth->getBalance()?>
            </div>
        </div>
        <div class="row">
            <div class="col-auto">
                <button type="submit" id="pay" class="btn btn-primary mb-2" data-url="<?=$rootUrl?>" data-total="<?=$total?>" style="margin-top: 10px;">Pay</button>
            </div>
            <div class="form-check mb-2" style="margin-top: 15px;">
                <label class="form-check-label" style="margin-right: 10px;">
                    <input type="radio" class="form-check-input" name="optradio" id="pick-up">Pick up
                </label>
            </div>
            <div class="form-check" style="margin-top: 15px;">
                <label class="form-check-label">
                    <input type="radio" class="form-check-input" name="optradio" id="ups">UPS
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-auto">
                <div class="alert alert-danger" role="alert" id="errors" style="display: none; margin-top: 10px;"></div>
            </div>
        </div>
    </div>

<script src="/static/js/jquery-3.4.1.min.js"></script>
<script src="/static/js/cart.js"></script>
                
<?php include($_SERVER['DOCUMENT_ROOT'] . '/layouts/footer.php'); ?>

