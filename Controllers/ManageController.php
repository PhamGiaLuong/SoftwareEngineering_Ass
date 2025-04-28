<?php 

// Author: Gia Luong

require_once "./Models/users.php";
require_once "./Models/bookings.php";
require_once "./Models/notification.php";
require_once "./Models/mail.php";

class ManageController {
    // Chức năng: hiển thị tab Quản lý
    public function index(){
        
        $bookingModel = new Bookings();
        $stat = $bookingModel->getTodayStatistic();

        require_once('./Views/manage.php');
    }


    // Chức năng: sắp xếp mảng theo trường
    public function sortArrayByField(array $data, string $field, string $order = 'asc'): array {
        usort($data, function ($a, $b) use ($field, $order) {
            if (!isset($a[$field]) || !isset($b[$field])) {
                return 0; // Nếu không tồn tại trường, giữ nguyên vị trí
            }
            $result = strcmp($a[$field], $b[$field]);
            return $order === 'asc' ? $result : -$result;
        });
        return $data;
    }

    // Chức năng: trích xuất danh sách Staff/Admin
    public function getUsers($page) {
        $userModel = new Users();
        $userList = $userModel->getStaffsList();
        // Sắp xếp danh sách theo tên
        $userList = $this->sortArrayByField($userList, "id", "asc");

        // Phân trang dữ liệu
        $offset = ($page - 1) * 10;
        $paginatedList = array_slice($userList, $offset, 10);

        // Trả về chuỗi json
        header('Content-Type: application/json');
        echo count($paginatedList) > 0 
            ? json_encode([
                'userList' => $paginatedList,
                'totalPages' => ceil(count($userList) / 10)
            ]) 
            : json_encode(["info" => "Không tìm thấy dữ liệu người dùng"]);
        // echo $result;
        exit;
    }

    // Chức năng: thêm người dùng mới và gửi mail thông báo
    public function addNewMember() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $userModel = new Users();
            $newUser = $userModel->addNewMember($_POST["name"], $_POST["role"], $_POST["email"], $_POST["faculty"]);
            if (isset($newUser)) {
                $mailer = new Mailer();
                // Tạo token ngẫu nhiên
                $token = random_int(100000, 99999999);
                $_SESSION["reset_token"] = $token;
                $_SESSION["DB"] = "Staff";

                $title = "Announcement for the first time password reset";
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
                    header('Content-Type: application/json');
                    echo json_encode([
                        "success" => "Đã thêm người dùng " . $newUser["id"] . " thành công!"
                    ]);
                    exit();
                } else {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "error" => "Không thể thêm người dùng!"
                    ]);
                    exit();
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Không thể thêm người dùng!"
                ]);
                exit();
            }
        }
    }

    // Chức năng: gọi Models/users.php đổi trạng thái tài khoản người dùng
    public function changeUserStatus($updateStatus, $userID) {
        $userModel = new Users();
        $changeFlag = $userModel->changeStatus($userID, $updateStatus);

        if ($changeFlag) {
            $user = $userModel->getUserByID($userID);
            $status = [
                "unlock" =>"Đang hoạt động",
                "warning" => "Cảnh cáo",
                "lock" => "Ngưng hoạt động",
                "other" => "Khác",
            ];
            $updateStatus = $status[$updateStatus];

            $title = "Account's status changed";
            $content = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>
                <p>Xin chào <strong>{$user["name"]}</strong>,</p>
                
                <p>
                    <strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong> xin thông báo đến bạn, 
                    tài khoản của bạn vừa bị thay đổi trạng thái hoạt động sang <strong>{$updateStatus}</strong>.
                </p>

                <p>Để đảm bảo quyền lợi của bạn, vui lòng liên hệ với quản trị viên để biết thêm thông tin chi tiết.</p>

                <hr style='border: 0; border-top: 1px solid #ddd; margin: 20px 0;'>
                <p>Trân trọng,</p>
                <p><strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong></p>
                <p style='font-size: 12px; color: #888;'><i>Đây là email tự động, vui lòng không trả lời email này.</i></p>
            </div>
            ";

            $mailer = new Mailer();
            if ($mailer->sendEmail($user["email"], $title, $content)) {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => "Đã thay đổi trạng thái của người dùng " . $userID . " thành công!"
                ]);
                exit();
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Không thể thay đổi trạng thái của người dùng " . $userID . "!"
                ]);
                exit();
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                "error" => "Không thể thay đổi trạng thái của người dùng " . $userID . "!"
            ]);
            exit();
        }
    }

    // Chức năng: lấy danh sách thông báo từ Models/notification.php
    public function getAnnouncementsList($page) {
        $noteModel = new Notifications();
        $Announcements = $noteModel->GetAllAnnouncements();
        // Sắp xếp danh sách theo ngày
        // $Announcements = $this->sortArrayByField($Announcements, "created_at", "desc");
        $Announcements = array_reverse($Announcements);

        // Phân trang dữ liệu
        $offset = ($page - 1) * 10;
        $paginatedList = array_slice($Announcements, $offset, 10);

        $userModel = new Users();
        // Lấy thông tin tác giả cho từng thông báo
        foreach($paginatedList as &$note){
            $auth = $userModel->getUserByID($note["author"]);
            $author = [
                "name" => $auth["name"],
                "image" => $auth["image"],
                "role" => $auth["role"]
            ];
            $note["author"] = $author;
        }

        // Trả về chuỗi json
        header('Content-Type: application/json');
        echo count($paginatedList) > 0 
            ? json_encode([
                'announcementsList' => $paginatedList,
                'totalPages' => ceil(count($Announcements) / 10)
            ]) 
            : json_encode(["info" => "Không tìm thấy dữ liệu thông báo"]);
        exit;
    }

    // Chức năng: thêm thông báo mới vào Thông báo chung
    public function addNewAnnouncement() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $title = $_POST["title"];
            $type = $_POST["type"];
            $pin = $_POST["pin"];
            $content = $_POST["content"];
            $author = $_SESSION["userID"];

            $noteModel = new Notifications();
            $newNote = $noteModel->addAnnouncement($title, $type, $author, $content, $pin);
            if (isset($newNote)) {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => "Đã thêm thông báo thành công!"
                ]);
                exit();
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Không thể thêm thông báo!"
                ]);
                exit();
            }
        }
    }

    // Chức năng: sửa thông báo đã đăng
    public function editAnnouncement() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $title = $_POST["titleEdit"];
            $type = $_POST["typeEdit"];
            $pin = $_POST["pinEdit"];
            $content = $_POST["contentEdit"];
            $editor = $_SESSION["userID"];
            $annID = $_POST["announcementID"];

            $noteModel = new Notifications();
            $newNote = $noteModel->editAnnouncementByID($annID, $title, $type, $editor, $content, $pin);
            if (isset($newNote)) {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => "Đã sửa thông báo thành công!"
                ]);
                exit();
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Không thể sửa thông báo!"
                ]);
                exit();
            }
        }
    }

    // Chức năng: lấy toàn bộ report từ người dùng
    public function getAllBookingReports($page) {
        $bookingModel = new Bookings();
        $allReports = $bookingModel->getAllReports();
        $totalPages = ceil(count($allReports) / 10);

        if (count($allReports) > 0) {
            $userModel = new Users();
            $roomModel = new Rooms();
            foreach ($allReports as &$report){
                $auth = $userModel->getUserByID($report["user_id"]);
                $author = [
                    "name" => $auth["name"],
                    "image" => $auth["image"],
                    "role" => $auth["role"]
                ];
                $report["author"] = $author;
                if ($report["solver_id"] != "---") {
                    $solver = $userModel->getUserByID($report["solver_id"]);
                    $solver = [
                        "name" => $solver["name"],
                        "image" => $solver["image"],
                        "role" => $solver["role"]
                    ];
                    $report["solver"] = $solver;
                } else {
                    $report["solver"] = [
                        "name" => "---",
                        "image" => "---",
                        "role" => "---"
                    ];
                }
                $report["room"] = $roomModel->getRoomByID($report["room_id"]);
            }
            
            $allReports = array_reverse($allReports);

            // Phân trang dữ liệu
            $offset = ($page - 1) * 10;
            $allReports = array_slice($allReports, $offset, 10);
        }

        // Trả về chuỗi json
        header('Content-Type: application/json');
        echo count($allReports) > 0 
            ? json_encode([
                'reportsList' => $allReports,
                'totalPages' => $totalPages
            ]) 
            : json_encode(["info" => "Không tìm thấy dữ liệu về báo cáo"]);
        exit;
    }

    // Chức năng: lấy danh sách booking theo loại phòng
    public function getBookingListByRoomType($roomType, $page) {
        $bookingModel = new Bookings();
        $bookingList = $bookingModel->getAllBookings();
        // Lọc theo loại phòng dựa trên room_id
        $filteredList = array_filter($bookingList, function ($booking) use ($roomType) {
            if (!isset($booking["room_id"])) return false;
            $roomId = (int)$booking["room_id"];

            if ($roomType === "self_study") {
                return $roomId < 200;
            } else if ($roomType === "dual") {
                return $roomId >= 200 && $roomId < 300;
            } else if ($roomType === "group") {
                return $roomId >= 300;
            }
            return false;
        });
        $filteredList = array_reverse($filteredList);
        $totalPages = ceil(count($filteredList) / 20);

        if (count($filteredList) > 0) {
            // Phân trang dữ liệu
            $offset = ($page - 1) * 20;
            $filteredList = array_slice($filteredList, $offset, 20);

            $userModel = new Users();
            $roomModel = new Rooms();
            foreach ($filteredList as &$booking){
                $auth = $userModel->getUserByID($booking["user_id"]);
                if (is_array($auth)) {
                    $author = [
                        "name" => $auth["name"],
                        "image" => $auth["image"],
                        "role" => $auth["role"]
                    ];
                    $booking["author"] = $author;
                }
                if ($booking["report"] != null) {
                    foreach ($booking["report"] as &$rpt) {
                        if ($rpt["solver_id"] != "---") {
                            $solver = $userModel->getUserByID($rpt["solver_id"]);
                            $rpt["solver"] = [
                                "name" => $solver["name"],
                                "image" => $solver["image"],
                                "role" => $solver["role"]
                            ];
                        } else {
                            $rpt["solver"] = [
                                "name" => "---",
                                "image" => "---",
                                "role" => "---"
                            ];
                        }
                    }
                } 
                $booking["room"] = $roomModel->getRoomByID($booking["room_id"]);
            }
        }

        // Trả về chuỗi json
        header('Content-Type: application/json');
        echo count($bookingList) > 0 
            ? json_encode([
                'bookingList' => $filteredList,
                'totalPages' => $totalPages
            ]) 
            : json_encode(["info" => "Không tìm thấy dữ liệu về báo cáo"]);
        exit;
    }
}

?>