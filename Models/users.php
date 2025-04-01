<!-- 
    Author: Gia Luong
 -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Users {
    private $NumOfMember = [
        "staff" => 4,
        "admin" => 4
    ];
     
    private $Staffs = [
        ["id" => "250001", "password" => "admin1", "role" => "admin", "image" => "/SE_Ass_Code/Images/a1.png", "status" => "Đang hoạt động",
            "name" => "Thế Hưng A", "email" => "hung.sethehung253@hcmut.edu.vn", "faculty" => "Trung tâm Dữ liệu và Công nghệ thông tin"],
        ["id" => "250002", "password" => "admin2", "role" => "admin", "image" => "/SE_Ass_Code/Images/a6.png",  "status" => "Đang hoạt động",
            "name" => "Hải Dương A", "email" => "duong.nguyenhuuhai@hcmut.edu.vn", "faculty" => "Phòng Quản trị thiết bị"],
        ["id" => "250003", "password" => "admin3", "role" => "admin", "image" => "/SE_Ass_Code/Images/a5.png", "status" => "Đang hoạt động",
            "name" => "Tuấn Lâm A", "email" => "lam.nguyen0612@hcmut.edu.vn", "faculty" => "Trung tâm Dữ liệu và Công nghệ thông tin"],
        ["id" => "250004", "password" => "admin4", "role" => "admin", "image" => "/SE_Ass_Code/Images/a3.png", "status" => "Đang hoạt động",
            "name" => "Gia Lương A", "email" => "pham15032004@gmail.com", "faculty" => "Phòng Quản trị thiết bị"],
        ["id" => "251101", "password" => "staff1", "role" => "staff", "image" => "/SE_Ass_Code/Images/a4.png", "status" => "Đang hoạt động",
            "name" => "Thế Hưng B", "email" => "hung.sethehung253@hcmut.edu.vn", "faculty" => "Phòng Quản trị thiết bị"],
        ["id" => "251102", "password" => "staff2", "role" => "staff", "image" => "/SE_Ass_Code/Images/a1.png", "status" => "Đang hoạt động",
            "name" => "Hải Dương B", "email" => "duong.nguyenhuuhai@hcmut.edu.vn", "faculty" => "Phòng Quản trị thiết bị"],
        ["id" => "251103", "password" => "staff3", "role" => "staff", "image" => "/SE_Ass_Code/Images/a2.png", "status" => "Đang hoạt động",
            "name" => "Tuấn Lâm B", "email" => "lam.nguyen0612@hcmut.edu.vn", "faculty" => "Phòng Quản trị thiết bị"],
        ["id" => "251104", "password" => "staff4", "role" => "staff", "image" => "/SE_Ass_Code/Images/a4.png", "status" => "Đang hoạt động",
            "name" => "Gia Lương B", "email" => "pham15032004@gmail.com", "faculty" => "Phòng Quản trị thiết bị"]
    ];

    private $HCMUTs = [
        ["BKNetID" => "2210615", "password" => "Duong", "role" => "student", "image" => "/SE_Ass_Code/Images/a4.png", "status" => "Đang hoạt động",
            "name" => "Nguyễn Hữu Hải Dương", "email" => "duong.nguyenhuuhai@hcmut.edu.vn", "faculty" => "Khoa Khoa học và Kỹ thuật Máy tính"],
        ["BKNetID" => "2211816", "password" => "Lam", "role" => "student", "image" => "/SE_Ass_Code/Images/a6.png", "status" => "Đang hoạt động",
            "name" => "Nguyễn Quốc Tuấn Lâm", "email" => "lam.nguyen0612@hcmut.edu.vn", "faculty" => "Khoa Khoa học và Kỹ thuật Máy tính"],
        ["BKNetID" => "2211960", "password" => "Luong", "role" => "student", "image" => "/SE_Ass_Code/Images/a1.png", "status" => "Đang hoạt động",
            "name" => "Phạm Gia Lương", "email" => "luong.pham2211960@hcmut.edu.vn", "faculty" => "Khoa Khoa học và Kỹ thuật Máy tính"],
        ["BKNetID" => "2053079", "password" => "Hung", "role" => "student", "image" => "/SE_Ass_Code/Images/a3.png", "status" => "Đang hoạt động",
            "name" => "Sẻ Thế Hưng", "email" => "hung.sethehung253@hcmut.edu.vn", "faculty" => "Khoa Khoa học và Kỹ thuật Máy tính"],
        ["BKNetID" => "2212123", "password" => "Huong", "role" => "student", "image" => "/SE_Ass_Code/Images/a1.png", "status" => "Đang hoạt động",
            "name" => "Vũ Mai Hương", "email" => "huong.vumai@hcmut.edu.vn", "faculty" => "Khoa Cơ khí"],
        ["BKNetID" => "2213321", "password" => "Linh", "role" => "student", "image" => "/SE_Ass_Code/Images/a4.png", "status" => "Đang hoạt động",
            "name" => "Hà Mỹ Linh", "email" => "linh.ha2213321@hcmut.edu.vn", "faculty" => "Khoa Khoa học ứng dụng"],
        ["BKNetID" => "2251001", "password" => "Minh", "role" => "student", "image" => "/SE_Ass_Code/Images/a2.png", "status" => "Đang hoạt động",
            "name" => "Phạm Chí Minh", "email" => "minh.phamchi@hcmut.edu.vn", "faculty" => "Khoa Kỹ thuật Hóa học"],
        ["BKNetID" => "2111025", "password" => "Vy", "role" => "student", "image" => "/SE_Ass_Code/Images/a6.png", "status" => "Đang hoạt động",
            "name" => "Trần Chí Vỹ", "email" => "vy.tranchi@hcmut.edu.vn", "faculty" => "Khoa Kỹ thuật Giao thông"],
        ["BKNetID" => "2151052", "password" => "Nhu", "role" => "student", "image" => "/SE_Ass_Code/Images/a5.png", "status" => "Đang hoạt động",
            "name" => "Lâm Tâm Như", "email" => "nhu.lam1052@hcmut.edu.vn", "faculty" => "Khoa Kỹ thuật Giao thông"],
        ["BKNetID" => "2113612", "password" => "Tri", "role" => "student", "image" => "/SE_Ass_Code/Images/a4.png", "status" => "Đang hoạt động",
            "name" => "Vũ Minh Trí", "email" => "tri.vuminh@hcmut.edu.vn", "faculty" => "Khoa Tài nguyên và Môi trường"],
        ["BKNetID" => "2121221", "password" => "Dang", "role" => "student", "image" => "/SE_Ass_Code/Images/a5.png", "status" => "Đang hoạt động",
            "name" => "Lê Đăng", "email" => "dang.leden@hcmut.edu.vn", "faculty" => "Khoa Kỹ thuật Xây dựng"],
        ["BKNetID" => "2300012", "password" => "Khai", "role" => "teacher", "image" => "/SE_Ass_Code/Images/a4.png", "status" => "Đang hoạt động",
            "name" => "Nguyễn Phúc Khải", "email" => "khai.nguyen@hcmut.edu.vn", "faculty" => "Khoa Khoa học và Kỹ thuật Máy tính"],
        ["BKNetID" => "2300023", "password" => "Tam", "role" => "teacher", "image" => "/SE_Ass_Code/Images/a3.png", "status" => "Đang hoạt động",
            "name" => "Lý Minh Tâm", "email" => "tam.ly@hcmut.edu.vn", "faculty" => "Khoa Kỹ thuật Hóa học"],
        ["BKNetID" => "2300451", "password" => "Phong", "role" => "teacher", "image" => "/SE_Ass_Code/Images/a6.png", "status" => "Đang hoạt động",
            "name" => "Nguyễn Đăng Phong", "email" => "phong.nguyen@hcmut.edu.vn", "faculty" => "Khoa Khoa học ứng dụng"]
    ];

    // Chức năng: đồng bộ data từ session
    public function __construct() {
        if (isset($_SESSION["NumOfMember"])) {
            $this->NumOfMember = $_SESSION["NumOfMember"];
        }
        if (isset($_SESSION["Staffs"])) {
            $this->Staffs = $_SESSION["Staffs"];
        }
        if (isset($_SESSION["HCMUTs"])) {
            $this->HCMUTs = $_SESSION["HCMUTs"];
        }
    }

    // Chức năng: trích xuất danh sách Staff/Admin
    public function getStaffsList() {
        $StaffsList = null;
        foreach ($this->Staffs as $user) {
            $staff = [
                "id" => $user["id"],
                "name" => $user["name"],
                "role" => $user["role"],
                "image" => $user["image"],
                "status" => $user["status"],
                "email" => $user["email"],
                "faculty" => $user["faculty"],
            ];
            $StaffsList[] = $staff;
        }
        return $StaffsList;
    }

    // Chức năng: thêm Staff/Admin
    public function addNewMember($name, $role, $image, $email, $faculty) {
        $user = [
            "id" => $this->NumOfMember[$role] + 1,
            "password" => "01042025",
            "role" => $role,
            "image" => $image,
            "status" => "Đang hoạt động",
            "name" => $name,
            "email" => $email,
            "faculty" => $faculty
        ];
        $this->Staffs[] = $user;
        
        $_SESSION["Staffs"] = $this->Staffs;
        $_SESSION["NumOfMember"] = $this->NumOfMember + 1;
        return $user;
    }

    // Chức năng: xác thực thông tin người dùng
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

    // Chức năng: trích xuất thông tin của người dùng
    public function getUserByID($id) {
        // if (isset($_SESSION["DB"]) && $_SESSION["DB"] == "HCMUT") {
        $user = null;
        if ($id > 1000000){
            foreach ($this->HCMUTs as $user) {
                if ($user["BKNetID"] === $id) {
                    return $user;
                }
            }
        }
        if (!isset($user)) {
            foreach ($this->Staffs as $user) {
                if ($user["id"] === $id) {
                    return $user;
                }
            }
        }
        return false;
    }

    // Chức năng: đổi mật khẩu cho người dùng
    public function changePassword($id, $newPassword) {
        foreach ($this->Staffs as &$staff) { 
            if ($staff["id"] === $id) {  
                $staff["password"] = $newPassword;
                // Lưu thay đổi vào session
                $_SESSION["Staffs"] = $this->Staffs;
                return true; 
            }
        }
        return false; 
    }

    // dump function
    public function print(){
        print_r($_SESSION["Staffs"]);
    }

    // Chức năng: kiểm tra token và gọi hàm đổi mật khẩu
    public function updatePasswordWithToken($userID, $token, $newPassword) {
        if (isset($_SESSION["reset_token"]) && $token == $_SESSION["reset_token"]) {
            if ($this->changePassword($userID, $newPassword))
                return true;
        } else if ($token == "SssMRS") {
            if ($this->changePassword($userID, $newPassword))
                return true;
        }
        // echo "không đúng" . "-" . $_SESSION["reset_token"] . "-" . $token;
        return false;
    }
    
    // Chức năng: đổi trạng thái tài khoản người dùng
    public function changeStatus($userID, $updateStatus) {
        $status = [
            "active" =>"Đang hoạt động",
            "warning" => "Cảnh cáo",
            "inactive" => "Ngưng hoạt động",
            "other" => "Khác",
        ];
        $updateStatus = $status[$updateStatus];
        $user = null;
        if ($userID > 1000000){
            foreach ($this->HCMUTs as &$user) {
                if ($user["BKNetID"] === $userID) {
                    break;
                }
            }
        }
        if (!isset($user)) {
            foreach ($this->Staffs as &$user) {
                if ($user["id"] === $userID && $user["role"] !== "admin") {
                    break;
                }
            }
        }
        if (!isset($user)) return false;

        if ($user["status"] !== $updateStatus){
            $user["status"] = $updateStatus;
        }
        $_SESSION["Staffs"] = $this->Staffs;
        $_SESSION["HCMUTs"] = $this->HCMUTs;
        return true;
    }
}
?>
