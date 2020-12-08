<?php
namespace Controllers;

use Entities\User;

class UserController
{
    
    public function login() 
    {

        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = filter_var($_POST["username"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_var($_POST["password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $user = new User();
            $userIdArr = $user->getId(['username', $username, 'password', $password]);
            session_start();
            if (!empty($_POST["new_acct"])) {
                // username is available
                if (!$userIdArr) {
                    $user->username = $username;
                    $user->password = $password;
                    $user->save();
                    $userIdArr = $user->getId(['username', $username, 'password', $password]);
                    $_SESSION["user_id"] = $userIdArr[0]['id'];
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['errors' => 'That username already exists. Please choose another.']);
                    die();
                }
            } else {
                // normal login
                if (!$userIdArr) {
                    header('Content-Type: application/json');
                	echo json_encode(['errors' => 'The username and password combination you entered was not found.']);
                    die();
                }
                $_SESSION["user_id"] = $userIdArr[0]['id'];
            }
            session_write_close();
            header('Content-Type: application/json');
            echo json_encode(['url' => "http://$_SERVER[HTTP_HOST]"]);
        } else {
            require $_SERVER['DOCUMENT_ROOT'] . '/views/login.php';
        }
    }
    
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location:' . "http://$_SERVER[HTTP_HOST]");
    }
    
}

?>