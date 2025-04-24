<?php 

// Author: Gia Luong

require_once "./Models/users.php";
require_once "./Models/bookings.php";
require_once "./Models/rooms.php";
require_once "./Models/mail.php";

class BookingController {
    // Chức năng: hiển thị tab Đặt phòng
    public function index(){
        $bookingModel = new Bookings();
        $stat = $bookingModel->getTodayStatistic();
        
        $roomModel = new Rooms();
        $selfRoomList = array_filter($roomModel->GetRoomList("self_study"), function ($room) {
            return isset($room['status']) && strtolower($room['status']) !== 'lock';
        });
        
        $dualRoomList = array_filter($roomModel->GetRoomList("dual"), function ($room) {
            return isset($room['status']) && strtolower($room['status']) !== 'lock';
        });
        
        $groupRoomList = array_filter($roomModel->GetRoomList("group"), function ($room) {
            return isset($room['status']) && strtolower($room['status']) !== 'lock';
        });
        
        
        $numOfAvailable = [
            "selfRoom" => $stat["self"]["using"] ." - ". $stat["self"]["scheduled"] ." - ". $stat["self"]["cancelled"] ." - ". $stat["self"]["total"],
            "dualRoom" => $stat["dual"]["using"] ." - ". $stat["dual"]["scheduled"] ." - ". $stat["dual"]["cancelled"] ." - ". $stat["dual"]["total"],
            "groupRoom" => $stat["group"]["using"] ." - ". $stat["group"]["scheduled"] ." - ". $stat["group"]["cancelled"] ." - ". $stat["group"]["total"],
        ];
        require_once('./Views/booking.php');
    }

    // Chức năng: lấy danh sách đặt phòng của chính người dùng trong hôm nay 
    public function getMyBookingToday($userID, $page=1) {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $bookingModel = new Bookings();
        $result = $bookingModel->getTodayBookingsByUser($userID);
        // $result = $bookingModel->getBookingsByDate("17/04/2025");;
        $userModel = new Users();
        $roomModel = new Rooms();
        foreach($result as &$booking) {
            $auth = $userModel->getUserByID($booking["user_id"]);
            $author = [
                "name" => $auth["name"],
                "image" => $auth["image"],
                "role" => $auth["role"]
            ];
            $booking["author"] = $author;
            $booking["room"] = $roomModel->GetRoomByID($booking["room_id"]);
        }

        $result = array_reverse($result);
        $paginated = array_slice($result, $offset, $limit);

        header('Content-Type: application/json');
        echo count($paginated) > 0 
            ? json_encode([
                'bookingList' => $paginated,
                'totalPages' => ceil(count($result) / $limit)
            ]) 
            : json_encode(["error" => "Không có dữ liệu đặt phòng"]);
        exit;
    }

    // Chức năng: tìm ghế còn trống
    public function getAvailableSeat() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Lấy dữ liệu từ JSON body
            $data = json_decode(file_get_contents("php://input"), true);

            $bookingModel = new Bookings();
            $seat_num = $bookingModel->findAvailableSeat($data["room_id"], $data["start_time"], $data["end_time"]);
            if (isset($seat_num)) {
                header('Content-Type: application/json');
                echo json_encode([
                    "seat_number" => $seat_num
                ]);
                exit();
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Không còn ghế trống, hãy thực hiện lựa chọn khác!"
                ]);
                exit();
            }
        }
    }

    // Chức năng: đặt chỗ cho phòng tự học
    public function bookSelfStudySeat() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $bookingModel = new Bookings();
            $bookingID = $bookingModel->makeBooking($_POST["userID"], $_POST["room_id"], $_POST["start_time"], 
                                                    $_POST["end_time"], $_POST["seat_number"]);
            $userModel = new Users();
            $user = $userModel->getUserByID($_POST["userID"]);
            $roomModel = new Rooms();
            $room = $roomModel->GetRoomByID($_POST["room_id"]);
            if (isset($bookingID)) {
                $mailer = new Mailer();

                $title = "Self-study Room Booking Successfull";
                $qrContent = "bookingID: {$bookingID}\n"
                            . "roomID: {$_POST["room_id"]}\n"
                            . "seat: {$_POST['seat_number']}\n"
                            . "userID: {$_POST["userID"]}";
                $content = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>
                    <p>Xin chào <strong>{$user["name"]}</strong>,</p>
                    
                    <p>Bạn đã đặt chỗ thành công trên <strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong>!</p>
                    <p>Thông tin đặt phòng của bạn như sau:</p>

                    <div style='background-color: #f8f9fa; padding: 10px; border-radius: 5px;'>
                        <p><strong>Tên tài khoản:</strong> {$user["name"]}</p>
                        <p><strong>Mã đặt phòng:</strong> {$bookingID}</p>
                        <p><strong>Loại phòng:</strong> {$room["name"]}</p>
                        <p><strong>Vị trí:</strong> {$room["address"]}</p>
                        <p><strong>Số ghế:</strong> {$_POST["seat_number"]}</p>
                        <p><strong>Thời gian sử dụng:</strong> {$_POST["start_time"]} - {$_POST["end_time"]}</p>
                    </div>

                    <p>Khi nhận ghế, hãy quét mã bên dưới vào đầu đọc:</p>
                    <p style='text-align: center;'>
                        <img src='https://quickchart.io/qr?text=" . urlencode($qrContent) . "&size=200' alt='QR Code' style='border: 1px solid #ddd; border-radius: 5px;'>
                    </p>

                    <p>Trường hợp mã QR bị lỗi, bạn có thể dùng thẻ sinh viên để thay thế.</p>
                    <strong>Bạn vui lòng nhận ghế đúng giờ, hệ thống sẽ tự động hủy lịch nếu trễ quá 10 phút không nhận phòng.</strong>
                    <p style='color: red; font-weight: bold;'>Lưu ý: Vui lòng không chia sẻ mã này với bất kỳ ai để đảm bảo an toàn tài khoản của bạn.</p>
                    
                    <hr style='border: 0; border-top: 1px solid #ddd; margin: 20px 0;'>
                    <p>Trân trọng,</p>
                    <p><strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong></p>
                    <p style='font-size: 12px; color: #888;'><i>Đây là email tự động, vui lòng không trả lời email này.</i></p>
                </div>
                ";

                // Gửi email xác nhận
                if ($mailer->sendEmail($user["email"], $title, $content)) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "success" => "Bạn đã đặt ghế thành công, thông tin sẽ được gửi qua email của bạn!"
                    ]);
                    exit();
                } else {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "error" => "Không thể gửi email!"
                    ]);
                    exit();
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Không thể đặt ghế!"
                ]);
                exit();
            }
        }
    }

    // Chức năng: tìm phòng còn trống
    public function getAvailableRoom() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Lấy dữ liệu từ JSON body
            $data = json_decode(file_get_contents("php://input"), true);

            $bookingModel = new Bookings();
            $result = $bookingModel->isBookingConflict($data["room_id"], $data["start_time"], $data["end_time"]);
            if (!$result) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "yes"
                ]);
                exit();
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "no"
                ]);
                exit();
            }
        }
    }

    // Chức năng: đặt phòng cho phòng đôi/nhóm
    public function bookRoom() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if ($_POST["roomType"] == "dual") $roomID = $_POST["room2d_id"];
            else $roomID = $_POST["room2g_id"];

            $bookingModel = new Bookings();
            $bookingID = $bookingModel->makeBooking($_POST["userID"], $roomID, $_POST["start_room"], 
                                                    $_POST["end_room"], null);
            $userModel = new Users();
            $user = $userModel->getUserByID($_POST["userID"]);
            $roomModel = new Rooms();
            $room = $roomModel->GetRoomByID($roomID);
            if (isset($bookingID)) {
                $mailer = new Mailer();

                if ($_POST["roomType"] == "dual")
                    $title = "Mentoring Room Booking Successfull";
                else $title = "Group Room Booking Successfull";
                $qrContent = "bookingID: {$bookingID}\n"
                            . "roomID: {$room['id']}\n"
                            . "userID: {$_POST["userID"]}";
                $content = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>
                    <p>Xin chào <strong>{$user["name"]}</strong>,</p>
                    
                    <p>Bạn đã đặt phòng thành công trên <strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong>!</p>
                    <p>Thông tin đặt phòng của bạn như sau:</p>

                    <div style='background-color: #f8f9fa; padding: 10px; border-radius: 5px;'>
                        <p><strong>Tên tài khoản:</strong> {$user["name"]}</p>
                        <p><strong>Mã đặt phòng:</strong> {$bookingID}</p>
                        <p><strong>Loại phòng:</strong> {$room["name"]}</p>
                        <p><strong>Vị trí phòng:</strong> {$room["address"]}</p>
                        <p><strong>Thời gian sử dụng:</strong> {$_POST["start_room"]} - {$_POST["end_room"]}</p>
                    </div>

                    <p>Khi nhận phòng, hãy quét mã bên dưới vào đầu đọc:</p>
                    <p style='text-align: center;'>
                        <img src='https://quickchart.io/qr?text=" . urlencode($qrContent) . "&size=200' alt='QR Code' style='border: 1px solid #ddd; border-radius: 5px;'>
                    </p>

                    <p>Trường hợp mã QR bị lỗi, bạn có thể dùng thẻ sinh viên để thay thế.</p>
                    <strong>Bạn vui lòng nhận phòng đúng giờ, hệ thống sẽ tự động hủy lịch nếu trễ quá 10 phút không nhận phòng.</strong>
                    <p style='color: red; font-weight: bold;'>Lưu ý: Vui lòng không chia sẻ mã này với bất kỳ ai để đảm bảo an toàn tài khoản của bạn.</p>
                    
                    <hr style='border: 0; border-top: 1px solid #ddd; margin: 20px 0;'>
                    <p>Trân trọng,</p>
                    <p><strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong></p>
                    <p style='font-size: 12px; color: #888;'><i>Đây là email tự động, vui lòng không trả lời email này.</i></p>
                </div>
                ";

                // Gửi email xác nhận
                if ($mailer->sendEmail($user["email"], $title, $content)) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "success" => "Bạn đã đặt phòng thành công, thông tin sẽ được gửi qua email của bạn!"
                    ]);
                    exit();
                } else {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "error" => "Không thể gửi email!"
                    ]);
                    exit();
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Không thể đặt phòng!"
                ]);
                exit();
            }
        }
    }
    
    // Chức năng: hủy lịch đặt phòng
    public function cancelBooking() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $bookingModel = new Bookings();
            $cancel = $bookingModel->cancelBookingById($_POST["cancelBookingID"]);
            
            if ($cancel) {
                $userModel = new Users();
                $user = $userModel->getUserByID($cancel["userID"]);
                $roomModel = new Rooms();
                $room = $roomModel->GetRoomByID($cancel["roomID"]);

                $mailer = new Mailer();

                $title = "Cancel Booking Announcement";
                $content = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>
                    <p>Xin chào <strong>{$user["name"]}</strong>,</p>
                    
                    <p>Bạn vừa thực hiện hủy lịch đặt trên <strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong>!</p>
                    <p>Thông tin đặt phòng của bạn như sau:</p>

                    <div style='background-color: #f8f9fa; padding: 10px; border-radius: 5px;'>
                        <p><strong>Tên tài khoản:</strong> {$user["name"]}</p>
                        <p><strong>Mã đặt phòng:</strong> {$_POST["cancelBookingID"]}</p>
                        <p><strong>Loại phòng:</strong> {$room["name"]}</p>
                        <p><strong>Vị trí phòng:</strong> {$room["address"]}</p>
                        <p><strong>Thời gian sử dụng:</strong> {$cancel["startTime"]} - {$cancel["endTime"]}</p>
                    </div>

                    <strong>Lịch đặt phòng trên đã bị hủy, bạn không dùng lại lịch này. Trong trường hợp cần thiết, bạn hãy đặt lịch mới.</strong>
                    <p style='color: red; font-weight: bold;'>Lưu ý: Vui lòng không chia sẻ mã này với bất kỳ ai để đảm bảo an toàn tài khoản của bạn.</p>
                    
                    <hr style='border: 0; border-top: 1px solid #ddd; margin: 20px 0;'>
                    <p>Trân trọng,</p>
                    <p><strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong></p>
                    <p style='font-size: 12px; color: #888;'><i>Đây là email tự động, vui lòng không trả lời email này.</i></p>
                </div>
                ";

                // Gửi email xác nhận
                if ($mailer->sendEmail($user["email"], $title, $content)) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "success" => "Bạn đã hủy lịch đặt phòng thành công, thông tin sẽ được gửi qua email của bạn!"
                    ]);
                    exit();
                } else {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "error" => "Không thể gửi email!"
                    ]);
                    exit();
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Không thể hủy lịch đặt phòng!"
                ]);
                exit();
            }
        }
    }

    // Chức năng: Thêm báo cáo cho booking
    public function reportBooking() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $bookingModel = new Bookings();
            $report = $bookingModel->addReportByBookingID($_POST["reportID"], $_POST["content"]);
            
            if ($report) {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => "Bạn đã gửi báo cáo thành công!"
                ]);
                exit();
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Không thể gửi báo cáo!"
                ]);
                exit();
            }
        }
    }
    
    // Chức năng: sửa/đổi lịch đặt phòng
    public function editBooking() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $roomID = 0;
            if ($_POST["typeEdit"] == "self") $roomID = $_POST["roomSEdit_id"];
            else if ($_POST["typeEdit"] == "dual") $roomID = $_POST["roomDEdit_id"];
            else if ($_POST["typeEdit"] == "group") $roomID = $_POST["roomGEdit_id"];

            $seat_number = null;
            if ($_POST["seatNum"] !== "" )
                $seat_number = $_POST["seatNum"];
            
            $bookingModel = new Bookings();
            $editBooking = $bookingModel->editBookingById($_POST["bookingID"], $_POST["startEdit"], $_POST["endEdit"], $roomID, $seat_number);
            
            if ($editBooking) {
                $userModel = new Users();
                $user = $userModel->getUserByID($editBooking["user_id"]);

                $roomModel = new Rooms();
                $room = $roomModel->GetRoomByID($roomID);

                $mailer = new Mailer();
                $seat = "";
                if (isset($_POST["seat_number"]))
                    $seat = "<p><strong>Số ghế:</strong> {$_POST["seat_number"]}</p>";

                $title = "Booking's Information Changed Announcement";
                $qrContent = "bookingID: {$_POST["bookingID"]}\n"
                            . "roomID: {$room['id']}\n";
                $content = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;'>
                    <p>Xin chào <strong>{$user["name"]}</strong>,</p>
                    
                    <p>Bạn vừa thực hiện sửa đổi lịch đặt trên <strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong>!</p>
                    <p>Thông tin đặt phòng của bạn như sau:</p>

                    <div style='background-color: #f8f9fa; padding: 10px; border-radius: 5px;'>
                        <p><strong>Tên tài khoản:</strong> {$user["name"]}</p>
                        <p><strong>Mã đặt phòng:</strong> {$_POST["bookingID"]}</p>
                        <p><strong>Loại phòng:</strong> {$room["name"]}</p>
                        <p><strong>Vị trí phòng:</strong> {$room["address"]}</p>
                        {$seat}
                        <p><strong>Thời gian sử dụng:</strong> {$editBooking["time_start"]} - {$editBooking["time_end"]}</p>
                    </div>

                    <p>Khi nhận phòng, hãy quét mã bên dưới vào đầu đọc:</p>
                    <p style='text-align: center;'>
                        <img src='https://quickchart.io/qr?text=" . urlencode($qrContent) . "&size=200' alt='QR Code' style='border: 1px solid #ddd; border-radius: 5px;'>
                    </p>

                    <p>Trường hợp mã QR bị lỗi, bạn có thể dùng thẻ sinh viên để thay thế.</p>
                    <strong>Bạn vui lòng nhận phòng đúng giờ, hệ thống sẽ tự động hủy lịch nếu trễ quá 10 phút không nhận phòng.</strong>
                    <p style='color: red; font-weight: bold;'>Lưu ý: Vui lòng không chia sẻ mã này với bất kỳ ai để đảm bảo an toàn tài khoản của bạn.</p>
                    
                    <hr style='border: 0; border-top: 1px solid #ddd; margin: 20px 0;'>
                    <p>Trân trọng,</p>
                    <p><strong>Hệ thống Quản lý và Đặt chỗ Không gian Học tập Thông minh (S3-MRS)</strong></p>
                    <p style='font-size: 12px; color: #888;'><i>Đây là email tự động, vui lòng không trả lời email này.</i></p>
                </div>
                ";

                // Gửi email xác nhận
                if ($mailer->sendEmail($user["email"], $title, $content)) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "success" => "Bạn đã thay đổi thông tin lịch đặt phòng thành công, thông tin sẽ được gửi qua email của bạn!"
                    ]);
                    exit();
                } else {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "error" => "Không thể gửi email!"
                    ]);
                    exit();
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Không thể thay đổi lịch đặt phòng!"
                ]);
                exit();
            }
        }
    }

    // Chức năng: Lấy các reminder cho người dùng
    public function getUserReminders($userID) {
        $bookingModel = new Bookings();
        $reminders = $bookingModel->getReminderForUser($userID);

        $roomModel = new Rooms();
        foreach($reminders as &$reminder) {
            $room = $roomModel->GetRoomByID($reminder["room_id"]);
            $reminder["room"] = $room;
        }

        header('Content-Type: application/json');
        echo count($reminders) > 0 
            ? json_encode([
                'remindersList' => $reminders,
                'reminderCount' => count($reminders)
            ]) 
            : json_encode(['reminderCount' => 0]);
        exit;
    }

    // Chức năng: Thực hiện nhận phòng
    public function checkinBooking() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $bookingModel = new Bookings();
            $checkin = $bookingModel->updateBookingStatus($_POST["checkinID"], "using");
            
            if ($checkin) {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => "Bạn đã check-in thành công!"
                ]);
                exit();
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Chưa đến giờ check-in! Bạn có thể check-in sớm nhất 5 phút trước giờ đặt phòng."
                ]);
                exit();
            }
        }
    }

}

?>