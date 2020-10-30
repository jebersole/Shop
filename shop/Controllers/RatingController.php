<?php
namespace Controllers;

use Entities\Rating;
use Middleware\Auth;

class RatingController {
    private $user;
    
    public function __construct()
    {
        $this->user = new Auth();
    }
    
    public function rate()
    {
        if (!$this->user->isAuthorized()) {
            header('Content-Type: application/json');
            echo json_encode(['errors' => 'Please login to rate.']);
            die();
        }
        if (empty($_POST['rating']) || empty($_POST['id']) || !preg_match('/^\d+$/', $_POST['rating']) || !preg_match('/^\d+$/', $_POST['id'])) {
            header('Content-Type: application/json');
            echo json_encode(['errors' => 'Please select submit a valid rating.']);
            die();
        }
        $stars = $_POST['rating'];
        $snack_id = $_POST['id'];
        $rating = new Rating();
        $isRated = $rating->getId(['id'], ['user_id', $this->user->getId(), 'snack_id', $snack_id]);
        if ($isRated) {
            header('Content-Type: application/json');
            echo json_encode(['errors' => 'You have already rated this snack.']);
            die();
        }
        $rating->snack_id = $snack_id;
        $rating->rating = $stars;
        $rating->user_id = $this->user->getId();
        $rating->save();
    }
}

?>