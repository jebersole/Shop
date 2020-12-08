<?php
namespace Controllers;

use Entities\Snack;
use Entities\User;
use Middleware\Auth;

class CartController
{
    private $user;
    
    public function __construct()
    {
        $this->user = new Auth();
    }
    
    public function show()
    {
        if (!$this->user->isAuthorized()) {
            require $_SERVER['DOCUMENT_ROOT'] . '/views/login.php';
            die();
        }
        
        if (!empty($_SESSION['snacks'])) {
            $snacks = (new Snack())->getWithJoin(['snacks.id', 'snacks.name', 'snacks.price', 'units.name'],
                ['units', 'units.id', 'snacks.unit_id'], ['snacks.id', implode(',', array_keys($_SESSION['snacks']))]);
            
            // count the quantity of each snack
            for ($i = 0; $i < count($snacks); $i++) {
                $snacks[$i]['qty'] = $_SESSION['snacks'][$snacks[$i]['id']];
            }
        }
        
        require $_SERVER['DOCUMENT_ROOT'] . '/views/cart.php';
    }
    
    public function update()
    {
        if (!$this->user->isAuthorized()) {
            require $_SERVER['DOCUMENT_ROOT'] . '/views/login.php';
            die();
        }
        if (empty($_POST['id']) || empty($_POST['val'])) {
            header('Content-Type: application/json');
            echo json_encode(['errors' => 'Please choose a valid number of snacks.']);
            die();
        }
        $id = $_POST['id'];
        $val = $_POST['val'];
        if (!preg_match('/^\d+$/', $id) || !preg_match('/^\d+$/', $val)) {
            header('Content-Type: application/json');
            echo json_encode(['errors' => 'Please choose a valid number of snacks.']);
            die();
        }
        session_start();
        if (!isset($_SESSION['snacks'])) $_SESSION['snacks'] = [];
        $_SESSION['snacks'][$id] = $val;
        session_write_close();
    }
    
    public function checkout()
    {
        if (!$this->user->isAuthorized()) {
            require $_SERVER['DOCUMENT_ROOT'] . '/views/login.php';
            die();
        }
        header('Content-Type: application/json');
        if (empty($_POST['delivery']) || !preg_match('/^\d{1}$/', $_POST['delivery'])) {
            echo json_encode(['errors' => 'Please choose a delivery method.']);
            die();
        }
        if (!isset($_POST['total']) || !preg_match('/^\d+\.\d{2}$/', $_POST['total'])) {
            echo json_encode(['errors' => 'Please request a valid dollar amount.']);
            die();
        }
        $user = (new User)->find($this->user->getId());
        if (!$user) {
            echo json_encode(['errors' => 'User not found.']);
            die();
        }        
        $total = floatval($_POST['total']);
        if ($_POST['delivery'] == 2) {
            // ups
            $total += 5.00;
        }
        $newBalance = $user->balance - $total;
        if ($newBalance < 0) {
            echo json_encode(['errors' => 'Insufficient funds.']);
            die();
        }
        $user->balance = $newBalance;
        $user->save();
        session_start();
        unset($_SESSION['snacks']);
        session_write_close();
        echo json_encode(['balance' => number_format((float) $newBalance, 2, '.', '')]);
    }
        
}

?>