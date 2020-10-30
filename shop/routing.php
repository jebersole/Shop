<?php
require_once(__DIR__.'/autoload.php');
use Controllers\SnackController;
use Controllers\UserController;
use Controllers\CartController;
use Controllers\RatingController;


$reqUrl = $_SERVER['REQUEST_URI'];
if (preg_match('/^\/$/', $reqUrl)) {
    (new SnackController)->index();
} else if (preg_match('/^\/login$/', $reqUrl)) {
     (new UserController)->login();
} else if (preg_match('/^\/logout$/', $reqUrl)) {
      (new UserController)->logout();
} else if (preg_match('/^\/cart$/', $reqUrl)) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       (new CartController)->update();
   } else {
       (new CartController)->show();
   }
} else if (preg_match('/^\/checkout$/', $reqUrl)) {
      (new CartController)->checkout();
} else if (preg_match('/^\/rating$/', $reqUrl)) {
    (new RatingController)->rate();
} else {
    require $_SERVER['DOCUMENT_ROOT'] . '/shop/' . '/views/404.php';
}

?>