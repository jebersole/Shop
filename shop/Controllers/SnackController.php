<?php
namespace Controllers;

use Middleware\Auth;
use Entities\Snack;
use Entities\Rating;

class SnackController {
    private $user;
    
    public function __construct() {
        $this->user = new Auth();
    }
    
    public function index() {
        $snacks = new Snack();
        $snackPrices = $snacks->getPrices();
        $units = $snacks->getUnitMap();
        if ($this->user->isAuthorized()) $ratings = (new Rating)->getRatings($this->user->getId());
        foreach ($ratings as $rating) {
            for ($i = 0; $i < count($snackPrices); $i++) {
                if ($snackPrices[$i]['id'] === $rating['snack_id']) {
                    $snackPrices[$i]['rating'] = $rating['rating'];
                    break;
                }
            }
        }
        require $_SERVER['DOCUMENT_ROOT'] . '/shop/' . '/views/index.php';
    }
    
}

?>