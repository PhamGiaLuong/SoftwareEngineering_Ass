<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Users {
    private $Staffs = [
        ["id" => "250001", "password" => "admin1", "role" => "admin", "image" => "/SE_Ass_Code/Images/a1.png",
            "name" => "Thế Hưng A", "email" => "hung.sethehung253@hcmut.edu.vn", "faculty" => "Trung tâm Dữ liệu và Công nghệ thông tin"],
        ["id" => "250002", "password" => "admin2", "role" => "admin", "image" => "/SE_Ass_Code/Images/a6.png", 
            "name" => "Hải Dương A", "email" => "duong.nguyenhuuhai@hcmut.edu.vn", "faculty" => "Phòng Quản trị thiết bị"],
        ["id" => "250003", "password" => "admin3", "role" => "admin", "image" => "/SE_Ass_Code/Images/a5.png",
            "name" => "Tuấn Lâm A", "email" => "lam.nguyen0612@hcmut.edu.vn", "faculty" => "Trung tâm Dữ liệu và Công nghệ thông tin"],
        ["id" => "250004", "password" => "admin4", "role" => "admin", "image" => "/SE_Ass_Code/Images/a3.png",
            "name" => "Gia Lương A", "email" => "pham15032004@gmail.com", "faculty" => "Phòng Quản trị thiết bị"],
        ["id" => "251101", "password" => "staff1", "role" => "staff", "image" => "/SE_Ass_Code/Images/a4.png",
            "name" => "Thế Hưng B", "email" => "hung.sethehung253@hcmut.edu.vn", "faculty" => "Phòng Quản trị thiết bị"],
        ["id" => "251102", "password" => "staff2", "role" => "staff", "image" => "/SE_Ass_Code/Images/a1.png",
            "name" => "Hải Dương B", "email" => "duong.nguyenhuuhai@hcmut.edu.vn", "faculty" => "Phòng Quản trị thiết bị"],
        ["id" => "251103", "password" => "staff3", "role" => "staff", "image" => "/SE_Ass_Code/Images/a2.png",
            "name" => "Tuấn Lâm B", "email" => "lam.nguyen0612@hcmut.edu.vn", "faculty" => "Phòng Quản trị thiết bị"],
        ["id" => "251104", "password" => "staff4", "role" => "staff", "image" => "/SE_Ass_Code/Images/a4.png",
            "name" => "Gia Lương B", "email" => "pham15032004@gmail.com", "faculty" => "Phòng Quản trị thiết bị"]
    ];

    private $HCMUTs = [
        ["BKNetID" => "2210615", "password" => "Duong", "role" => "student", "image" => "/SE_Ass_Code/Images/a4.png",
            "name" => "Nguyễn Hữu Hải Dương", "email" => "duong.nguyenhuuhai@hcmut.edu.vn", "faculty" => "Khoa Khoa học và Kỹ thuật Máy tính"],
        ["BKNetID" => "2211816", "password" => "Lam", "role" => "student", "image" => "/SE_Ass_Code/Images/a6.png",
            "name" => "Nguyễn Quốc Tuấn Lâm", "email" => "lam.nguyen0612@hcmut.edu.vn", "faculty" => "Khoa Khoa học và Kỹ thuật Máy tính"],
        ["BKNetID" => "2211960", "password" => "Luong", "role" => "teacher", "image" => "/SE_Ass_Code/Images/a1.png",
            "name" => "Phạm Gia Lương", "email" => "luong.pham2211960@hcmut.edu.vn", "faculty" => "Khoa Khoa học và Kỹ thuật Máy tính"],
        ["BKNetID" => "2053079", "password" => "Hung", "role" => "teacher", "image" => "/SE_Ass_Code/Images/a3.png",
            "name" => "Sẻ Thế Hưng", "email" => "hung.sethehung253@hcmut.edu.vn", "faculty" => "Khoa Khoa học và Kỹ thuật Máy tính"]
    ];

    public function __construct() {
        if (isset($_SESSION["Staffs"])) {
            $this->Staffs = $_SESSION["Staffs"];
        }
    }

    // Xác thực tài khoản Staff/Admin
    public function authenticate($id, $password) {
        if (isset($_SESSION["DB"]) && $_SESSION["DB"] == "HCMUT") {
            foreach ($this->HCMUTs as $user) {
                if ($user["BKNetID"] === $id && $user["password"] === $password) {
                    return $user;
                }
            }
        } else if (isset($_SESSION["DB"]) && $_SESSION["DB"] == "Staff") {
            foreach ($this->Staffs as $user) {
                if ($user["id"] === $id && $user["password"] === $password) {
                    return $user;
                }
            }
        }
        return false;
    }

    public function getUserByBKNetID($id) {
        foreach ($this->HCMUTs as $user) {
            if ($user["BKNetID"] == $id) {
                return $user;
            }
        }
        return false;
    }

    public function getUserByID($id) {
        foreach ($this->Staffs as $user) {
            if ($user["id"] == $id) {
                return $user;
            }
        }
        return false;
    }

    public function changePassword($id, $newPassword) {
        foreach ($this->Staffs as &$staff) { 
            if ($staff["id"] === $id) {  
                $staff["password"] = $newPassword;
                $_SESSION["Staffs"] = $this->Staffs;
                return true; 
            }
        }
        return false; 
    }

    // private $resetTokens = [];
    public function print(){
        print_r($_SESSION["Staffs"]);
    }

    // public function storeResetToken($id, $token) {
    //     $this->resetTokens[$token] = $id;
    // }

    public function updatePasswordWithToken($token, $newPassword) {
        if (isset($_SESSION["reset_token"]) && $token == $_SESSION["reset_token"]) {
            if ($this->changePassword($_SESSION["reset_id"], $newPassword))
                return true;
        }
        // echo "không đúng" . "-" . $_SESSION["reset_token"] . "-" . $token;
        return false;
    }
    
}
?>
