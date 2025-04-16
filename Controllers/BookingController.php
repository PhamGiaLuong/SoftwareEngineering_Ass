<?php 

// Author: Gia Luong

require_once "./Models/users.php";
require_once "./Models/bookings.php";
require_once "./Models/rooms.php";

class BookingController {
    // Chức năng: hiển thị tab Đặt phòng
    public function index(){
        $bookingModel = new Bookings();
        $bookingList = $bookingModel->getAllBookings();
        $userModel = new Users();
        $roomModel = new Rooms();
        foreach($bookingList as &$booking) {
            $auth = $userModel->getUserByID($booking["user_id"]);
            $author = [
                "name" => $auth["name"],
                "image" => $auth["image"],
                "role" => $auth["role"]
            ];
            $booking["author"] = $author;
            $booking["room"] = $roomModel->GetRoomByID($booking["room_id"]);
        }
        require_once('./Views/booking.php');
    }
}

?>