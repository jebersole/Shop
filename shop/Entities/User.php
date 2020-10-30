<?php
namespace Entities;

use Entities\Entity;

class User extends Entity
{
    
    public function __construct()
    {
        parent::__construct('users');
    }
    
    public function getUsername($userId) 
    {
        $userQuery = $this->get(['username'], ['id', $userId]);
        return $userQuery ? $userQuery[0]['username'] : null;
    }
    
    public function getBalance($userId)
    {
        $userQuery = $this->get(['balance'], ['id', $userId]);
        return $userQuery ? $userQuery[0]['balance'] : null;
    }
}