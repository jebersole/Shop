<?php
$rootUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/shop/' . '/layouts/header.php'); ?>

<div class="container">
    <div class="form-row align-items-center">
        <div class="col-auto offset-md-2">
            <label class="sr-only" for="inlineFormInput">Username</label>
            <input type="text" class="form-control mb-2" id="username" placeholder="Username">
        </div>
        <div class="col-auto">
            <label class="sr-only" for="inlineFormInputGroup">Password</label>
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="password" placeholder="Password">
            </div>
        </div>
        <div class="col-auto">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="new-acct">
                <label class="form-check-label" for="autoSizingCheck">
                    New account
                </label>
            </div>
        </div>
        <div class="col-auto">
            <button type="submit" id="login" class="btn btn-primary mb-2" data-url="<?=$rootUrl?>">Login</button>
        </div>
    </div>
    <div class="row offset-md-2">
        <div class="alert alert-danger" role="alert" id="errors" style="display: none;"></div>
    </div>
</div>

<script src="/static/js/jquery-3.4.1.min.js"></script>
<script src="/static/js/login.js"></script>
        
<?php include($_SERVER['DOCUMENT_ROOT'] . '/shop/' . '/layouts/footer.php'); ?>
