<?php
$rootUrl = "http://$_SERVER[HTTP_HOST]";
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/shop/' . '/layouts/header.php'); ?>

    <div class="container">
        <div class="card-deck mb-3 text-center" data-url="<?=$rootUrl?>" data-auth="<?=$auth->isAuthorized()?>">
        <?php foreach ($snackPrices as $snack) { ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal"><?=ucfirst($snack['name'])?></h4>
                </div>
                <div class="card-body">
                    <h2 class="card-title snacks-card-title">$<?=$snack['price']?> <small class="text-muted">/ <?=$units[$snack['name']]?></small></h2>
                    <div class="row">
                        <div class="col">
                            <input class="form-control" id="<?=$snack['id']?>" type="number" min="0" placeholder="Quantity"/>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-sm btn-block btn-outline-primary form-control">Update cart</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="container">
                            <div class="card-message" role="alert"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col rating-txt">Your rating:</div>
                    </div>
                    <div class="row">
                        <div class="col my-rating" data-rating="<?=isset($snack['rating']) ? $snack['rating'] : ''?>"></div>
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>

<script src="/static/js/jquery-3.4.1.min.js"></script>
<script src="/static/js/jquery.star-rating-svg.js"></script>
<script src="/static/js/snacks.js"></script>
                
<?php include($_SERVER['DOCUMENT_ROOT'] . '/shop/' . '/layouts/footer.php'); ?>

