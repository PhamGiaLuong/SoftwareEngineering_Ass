<?php 

// Author: Gia Luong

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "./Models/users.php";
require_once "./Models/mail.php";

class LogInController {
    // Chức năng: hiển thị tab nhập thông tin đăng nhập
    public function index() {
        require_once "./Views/logIn.php";
    }

    // Chức năng: hiển thị tab lựa chọn loại hình đăng nhập
    public function option() {
        require_once "./Views/logInOption.php";
    }

    // Chức năng: chuyển đến tab đăng nhập cho Sinh viên/Giảng viên
    public function HCMUT() {
        $_SESSION['DB'] = "HCMUT";
        require_once "./Views/logIn.php";
    }

    // Chức năng: chuyển đến tab đăng nhập cho Staff/Admin
    public function Staff() {
        $_SESSION['DB'] = "Staff";
        require_once "./Views/logIn.php";
    }
    
    // Chức năng: gửi yêu cầu xác thực đến Models/users.php
    public function authenticate() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST["id"] ?? "";
            $password = $_POST["password"] ?? "";

            $userModel = new Users();
            $user = $userModel->authenticate($id, $password);
            $_SESSION["name"] = $user["name"];
            $_SESSION["avatar"] = $user["image"];

            if ($user) {
                $_SESSION["userID"] = (isset($_SESSION["DB"]) && $_SESSION["DB"] == "HCMUT") ? $user["BKNetID"]: 
                                    ((isset($_SESSION["DB"]) && $_SESSION["DB"] == "Staff") ? $user["id"] : "");
                $_SESSION['Role'] = isset($_SESSION["DB"]) ? $user["role"] : "";
                header("Location: /SE_Ass_Code/index.php?url=home"); // Chuyển về trang chủ
                exit();
            } else {
                $_SESSION["error"] = "ID hoặc mật khẩu không đúng!";
                header("Location: /SE_Ass_Code/index.php?url=logIn");
                exit();
            }
        }
    }

    // Chức năng: chuyển đến tab nhập thông tin quên mật khẩu
    public function forgotPassword() {
        require_once "./Views/forgotPassword.php";
    }
    
    // Chức năng: gửi yêu cầu thực hiện đổi mật khẩu đến Models/users.php và gửi mail xác thực
    public function resetPasswordRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            
            $userModel = new Users();
            $user = $userModel->getUserByID($id);
            if (!$user) {
                $_SESSION["error"] = "Không tìm thấy ID!";
                header("Location: /SE_Ass_Code/index.php?url=logIn/forgotPassword");
                exit();
            }

            // Tạo token ngẫu nhiên
            $token = random_int(100000, 99999999);
            $_SESSION["reset_token"] = $token;
            $_SESSION["DB"] = "Staff";
            // $_SESSION["reset_id"] = $user["id"];

            $mailer = new Mailer();
            $IP = $mailer->getUserIP();
            // Tạo đường dẫn đặt lại mật khẩu
            $resetLink = "http://" . $IP . ":80/SE_Ass_Code/index.php?url=logIn/resetPassword";
            $title = "Reset password";
            $content = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>
                    <p>Xin chào <strong>{$user["name"]}</strong>,</p>
                    
                    <p>Hệ thống <strong>Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong> đã nhận được yêu cầu đổi mật khẩu tài khoản của bạn.</p>
                    <p>Để đặt lại mật khẩu cho tài khoản của bạn (<strong>ID: {$user["id"]}</strong>), vui lòng nhấp vào đường dẫn dưới đây:</p>
                    <p style='text-align: center;'>
                        <a href='$resetLink' style='display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; font-weight: bold; border-radius: 5px;'>Đặt lại mật khẩu</a>
                    </p>

                    <p>Hoặc bạn có thể quét mã QR sau bằng thiết bị di động:</p>
                    <p style='text-align: center;'>
                        <img src='https://quickchart.io/qr?text=" . urlencode($resetLink) . "&size=200' alt='QR Code' style='border: 1px solid #ddd; border-radius: 5px;'>
                    </p>
                    <p>Trường hợp hệ thống yêu cầu mã xác thực, vui lòng nhập mã sau:</p>
                    <h2 style='text-align: center; color: #d9534f; font-weight: bold;'>{$token}</h2>
                    <p style='color: red; font-weight: bold;'>Lưu ý: Vui lòng không chia sẻ mã này với bất kỳ ai để đảm bảo an toàn tài khoản của bạn.</p>
                    <hr style='border: 0; border-top: 1px solid #ddd; margin: 20px 0;'>
                    <p>Trân trọng,</p>
                    <p><strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong></p>
                    <p style='font-size: 12px; color: #888;'><i>Đây là email tự động, vui lòng không trả lời email này.</i></p>
                </div>
            ";

            // Gửi email đặt lại mật khẩu
            if ($mailer->sendEmail($user["email"], $title, $content)) {
                $_SESSION["Notify"] = "Link đổi mật khẩu đã được gửi đến email của bạn!";
                require_once "./Views/notification.php";
            } else {
                echo "Lỗi khi gửi email!";
            }
        }
    }

    // Chức năng: chuyển đến tab thực hiện đổi mật khẩu mới
    public function resetPassword() {
        require_once "./Views/resetPassword.php";
    }

    // Chức năng: yêu cầu Models/users.php xác thực token và đổi mật khẩu nếu hợp lệ
    public function updatePassword() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userID = $_POST["userID"];
            $token = $_POST["token"];
            $newPassword = $_POST["password"];//password_hash($_POST["password"], PASSWORD_DEFAULT);

            $userModel = new Users();
            if ($userModel->updatePasswordWithToken($userID, $token, $newPassword)) {
                $_SESSION["success"] = "Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập.";
                header("Location: /SE_Ass_Code/index.php?url=logIn");
            } else {
                $_SESSION["error"] = "Token không hợp lệ hoặc đã hết hạn.";
                header("Location: /SE_Ass_Code/index.php?url=logIn/resetPassword");
            }
        }
    }

    // Chức năng: thực hiện đăng xuất, xóa session
    public function logout() {
        session_destroy();
        header("Location: /SE_Ass_Code/index.php?url=loginOption");
        exit();
    }
}
?>
