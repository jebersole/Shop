<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Snack Shop</title>

    <!-- Bootstrap core CSS -->
    <link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css" crossorigin="anonymous">

    <link rel="icon" href="/static/img/favicon.ico">

    <meta name="theme-color" content="#563d7c">

    <link href="/static/css/snacks.css" type="text/css" rel="stylesheet">
    <link href="/static/css/star-rating-svg.css" type="text/css" rel="stylesheet">

</head>

<body>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">Snack Shop</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2" href="/">Snacks</a>
            <?php $auth = new Middleware\Auth();
                if ($auth->isAuthorized()) { ?>
                    <?=ucfirst($auth->getUsername())?>: <a href="/cart"> See Cart</a>  or <a href="/logout"> Logout</a>
            <?php 
                } else { ?>
                    <a class="btn btn-outline-primary" href="/login">Login</a>
            <?php 
                } ?>
        </nav>
    </div>

    <div class="snacks-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">Snacks</h1>
        <p class="lead">Plenty of delicious snacks are available!</p>
    </div>