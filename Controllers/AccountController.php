<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "./Models/users.php";
class AccountController {
    public function index(){
        if (!isset($_SESSION["DB"]) || !isset($_SESSION["userID"])) {
            header("Location: /SoftwareEngineering_Ass/index.php?url=loginOption");
            exit();
        }

        $userModel = new Users();
        $user = null;

        $user = $userModel->getUserByID($_SESSION["userID"]);
        
        if ($user === null) {
            header("Location: /SoftwareEngineering_Ass/index.php?url=loginOption");
            exit();
        }

        require_once('./Views/account.php');
    }

    public function otherInfo($id) {
        $userModel = new Users();
        $user = null;

        $user = $userModel->getUserByID($id);
        $note = "other";
        require_once('./Views/account.php');
    }
}

?>