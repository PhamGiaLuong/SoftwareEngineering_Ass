<!-- 
    Author: Gia Luong
 -->
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "./Models/users.php";
class AccountController {
    // Chức năng: hiển thị tab Thông tin tài khoản với thông tin (chi tiết) người dùng từ Models/users.php
    public function index(){
        if (!isset($_SESSION["DB"]) || !isset($_SESSION["userID"])) {
            header("Location: /SE_Ass_Code/index.php?url=loginOption");
            exit();
        }

        $userModel = new Users();
        $user = null;

        $user = $userModel->getUserByID($_SESSION["userID"]);
        
        if ($user === null) {
            header("Location: /SE_Ass_Code/index.php?url=loginOption");
            exit();
        }

        require_once('./Views/account.php');
    }

    // Chức năng: yêu cầu thông tin (chung) người dùng từ Models/users.php
    public function otherInfo($id) {
        $userModel = new Users();
        $user = null;

        $user = $userModel->getUserByID($id);
        $note = "other";
        require_once('./Views/account.php');
    }
}

?>