<?php
namespace Entities;

use Entities\Entity;

class Rating extends Entity
{
    
    public function __construct()
    {
        parent::__construct('ratings');
    }
    
    public function getRatings($userId)
    {
        return $this->get(['snack_id', 'rating'], ['user_id', $userId]);
    }
}