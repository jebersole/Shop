<div class="container">
    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-6 col-md">
                <h5>Snacks</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="/">Snack list</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h5>Shopping Cart</h5>
                <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="/cart">See shopping cart</a></li>
                </ul>
            </div>
            <div class="col-6 col-md">
                <h5>Account</h5>
                <ul class="list-unstyled text-small">
                    <?php 
                        if ($auth->isAuthorized()) { ?>
                            <li><a class="text-muted" href="/logout">Logout</a></li>
                    <?php
                        } else { ?>
                    <li><a class="text-muted" href="/login">Login</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </footer>
</div>
</body>
</html>