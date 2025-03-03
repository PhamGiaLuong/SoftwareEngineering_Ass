<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "./Models/users.php";
class AccountController {
    public function index(){
        $userModel = new Users();
        if($_SESSION["DB"] == "Staff"){
            $user = $userModel->getUserByID($_SESSION["userID"]);
        }else{
            $user = $userModel->getUserByBKNetID($_SESSION["userID"]);
        }  
        require_once('./Views/account.php');
    }
}

?>