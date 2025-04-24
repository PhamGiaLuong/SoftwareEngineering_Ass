<?php 

// Author: Gia Luong

require_once "./Models/users.php";
require_once "./Models/bookings.php";
require_once "./Models/rooms.php";

class HistoryController {
    // Chức năng: hiển thị tab Lịch sử đặt phòng
    public function index(){
        require_once('./Views/history.php');
    }

    // Chức năng: lấy danh sách đặt phòng của chính người dùng 
    public function getMyBooking($userID, $page=1) {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $bookingModel = new Bookings();
        $result = $bookingModel->getBookingsByUser($userID);
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
}

?>