<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "./Models/user.php";
require_once "./Models/mail.php";

class LogInController {
    public function index() {
        require_once "./Views/logIn.php"; // Hiển thị giao diện đăng nhập
    }

    public function option() {
        require_once "./Views/logInOption.php";
    }

    public function HCMUT() {
        $_SESSION['DB'] = "HCMUT";
        require_once "./Views/logIn.php";
    }
    public function Staff() {
        $_SESSION['DB'] = "Staff";
        require_once "./Views/logIn.php";
    }
    
    public function authenticate() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST["id"] ?? "";
            $password = $_POST["password"] ?? "";

            $userModel = new User();
            $user = $userModel->authenticate($id, $password);

            if ($user) {
                $_SESSION["userID"] = (isset($_SESSION["DB"]) && $_SESSION["DB"] == "HCMUT") ? $user["BKNetID"]: 
                                    ((isset($_SESSION["DB"]) && $_SESSION["DB"] == "Staff") ? $user["id"] : "");
                $_SESSION['Role'] = isset($_SESSION["DB"]) ? $user["role"] : "";
                header("Location: /SE_Ass_Code/index.php?url=home"); // Chuyển về trang chủ
                exit();
            } else {
                $_SESSION["error"] = "Tên ID hoặc mật khẩu không đúng!";
                header("Location: /SE_Ass_Code/index.php?url=logIn");
                exit();
            }
        }
    }

    public function forgotPassword() {
        require_once "./Views/forgotPassword.php";
    }
    public function resetPasswordRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $id = $_POST["id"];
            
            $userModel = new User();
            $user = $userModel->getUserByID($id);
            if (!$user) {
                $_SESSION["error"] = "Không tìm thấy ID!";
                header("Location: /SE_Ass_Code/index.php?url=logIn/forgotPassword");
                exit();
            }

            // Tạo token ngẫu nhiên
            $token = random_int(100000, 99999999);
            $_SESSION["reset_token"] = $token;
            $_SESSION["reset_id"] = $user["id"];

            $mailer = new Mailer();
            // Tạo đường dẫn đặt lại mật khẩu
            $resetLink = "http://localhost/SE_Ass_Code/index.php?url=logIn/resetPassword";
            $title = "Reset password";
            $content = "
                <p>Xin chào <strong>{$user["name"]}</strong>,</p>
                <p>Hệ thống quản lý và đặt chỗ không gian tự học thông minh (<strong>BK Study Space</strong>) đã nhận yêu cầu đổi mật khẩu tài khoản của bạn.</p>
                <p>Để thực hiện thay đổi mật khẩu cho tài khoản (<strong>ID = {$user["id"]}</strong>), bạn vui lòng truy cập đường dẫn này: 
                    <a href='$resetLink' style='color: #007bff; text-decoration: none; font-weight: bold;'>Link</a>, và nhập
                </p>
                <h3><strong>{$token}</strong></h3>
                <p><em>Vì lý do bảo mật, vui lòng không chia sẻ mã trên cho bất kỳ ai.</em></p>
                <p>Trân trọng,</p>
                <p><strong>BK Study Space</strong></p>
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

    public function resetPassword() {
        require_once "./Views/resetPassword.php";
    }

    public function updatePassword() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $token = $_POST["token"];
            $newPassword = $_POST["password"];//password_hash($_POST["password"], PASSWORD_DEFAULT);

            $userModel = new User();
            if ($userModel->updatePasswordWithToken($token, $newPassword)) {
                $_SESSION["success"] = "Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập.";
                header("Location: /SE_Ass_Code/index.php?url=logIn");
            } else {
                $_SESSION["error"] = "Token không hợp lệ hoặc đã hết hạn.";
                header("Location: /SE_Ass_Code/index.php?url=logIn/resetPassword");
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /SE_Ass_Code/index.php?url=loginOption");
        exit();
    }
}
?>
