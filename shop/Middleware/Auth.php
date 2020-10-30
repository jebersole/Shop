<?php
namespace Middleware;

use Entities\User;

class Auth {
    private $userId;
    
    public function __construct() 
    {
        session_start();
        if (!empty($_SESSION["user_id"])) $this->userId = $_SESSION["user_id"];
        session_write_close();
    }
    
    public function isAuthorized() 
    {
        return !empty($this->userId);
    }
    
    public function getUsername() 
    {
        return (new User)->getUsername($this->userId);
    }
    
    public function getId() {
        return $this->userId;
    }
    
    public function getBalance() {
        return (new User)->getBalance($this->userId);
    }
    
}