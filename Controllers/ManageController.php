<!-- 
    Author: Gia Luong
 -->
<?php 
require_once "./Models/users.php";
require_once "./Models/notification.php";
require_once "./Models/mail.php";

class ManageController {
    // Chức năng: hiển thị tab Quản lý
    public function index(){
        $userModel = new Users();
        $StaffsList = $userModel->getStaffsList();
        $Notifications = null;

        require_once('./Views/manage.php');
    }

    // Chức năng: thêm người dùng mới và gửi mail thông báo
    public function addNewMember() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $userModel = new Users();
            $newUser = $userModel->addNewMember($_POST["name"], $_POST["role"], $_POST["image"], $_POST["email"], $_POST["faculty"]);
            if (isset($newUser)) {
                $mailer = new Mailer();
                // Tạo token ngẫu nhiên
                $token = random_int(100000, 99999999);
                $_SESSION["reset_token"] = $token;
                $_SESSION["DB"] = "Staff";

                $title = "Thông báo đổi mật khẩu lần đầu";
                $resetLink = "http://localhost/SE_Ass_Code/index.php?url=logIn/forgotPassword";
                $content = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>
                    <p>Xin chào <strong>{$newUser["name"]}</strong>,</p>
                    
                    <p>Chào mừng bạn đến với <strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong>!</p>
                    <p>Chúng tôi đã tạo tài khoản người dùng cho bạn với thông tin sau:</p>

                    <div style='background-color: #f8f9fa; padding: 10px; border-radius: 5px;'>
                        <p><strong>Tên tài khoản:</strong> {$newUser["name"]}</p>
                        <p><strong>ID:</strong> {$newUser["id"]}</p>
                        <p><strong>Đơn vị:</strong> {$newUser["faculty"]}</p>
                    </div>

                    <p>Vì lý do bảo mật, vui lòng đổi mật khẩu ngay sau khi đăng nhập lần đầu bằng cách nhấp vào nút bên dưới:</p>
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
                if ($mailer->sendEmail($newUser["email"], $title, $content)) {
                    $_SESSION["success"] = "Đã tạo tài khoản thành công.";
                    header("Location: /SE_Ass_Code/index.php?url=manage");
                } else {
                    $_SESSION["error"] = "Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập.";
                    header("Location: /SE_Ass_Code/index.php?url=logIn");
                }
            }
        }
    }

    // Chức năng: gọi Models/users.php đổi trạng thái tài khoản người dùng
    public function changeStatus($userID, $updateStatus, $reason, $time) {
        $userModel = new Users();
        $changeFlag = $userModel->changeStatus($userID, $updateStatus);

        if ($changeFlag) {
            $user = $userModel->getUserByID($userID);
            $status = [
                "active" =>"Đang hoạt động",
                "warning" => "Cảnh cáo",
                "inactive" => "Ngưng hoạt động",
                "other" => "Khác",
            ];
            $updateStatus = $status[$updateStatus];

            $title = "Thông báo thay đổi trạng thái tài khoản";
            $resetLink = "http://localhost/SE_Ass_Code/index.php?url=logIn/forgotPassword";
            $content = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>
                <p>Xin chào <strong>{$user["name"]}</strong>,</p>
                
                <p>
                    <strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong> xin thông báo đến bạn, 
                    tài khoản của bạn vừa bị thay đổi trạng thái hoạt động sang <strong>{$updateStatus}</strong> 
                    trong thời gian <strong>{$time}</strong> ngày.
                </p>
                <p>Với lý do:</p>
                <div style='background-color: #f8f9fa; padding: 10px; border-radius: 5px;'>
                    <p>{$reason}</p>
                </div>
                <hr style='border: 0; border-top: 1px solid #ddd; margin: 20px 0;'>
                <p>Trân trọng,</p>
                <p><strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong></p>
                <p style='font-size: 12px; color: #888;'><i>Đây là email tự động, vui lòng không trả lời email này.</i></p>
            </div>
            ";

            $mailer = new Mailer();
            if ($mailer->sendEmail($user["email"], $title, $content)) {
                $_SESSION["success"] = "Đã cập nhật trạng thái thành công.";
            } else {
                $_SESSION["error"] = "Không thể cập nhật trạng thái.";
            }
            header("Location: /SE_Ass_Code/index.php?url=manage");
        }
    }

    // Chức năng: thêm thông báo mới vào Thông báo chung
    public function addNewNotification($userID, $title, $content) {
        $noteModel = new Notifications();


    }

    // Chức năng: sửa thông báo đã đăng
    public function editNotification($title, $content) {
        $noteModel = new Notifications();


    }
}

?>