<?php 

// Author: Tuan Lam

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "./Models/bookings.php";

class Rooms {
    private $Room_Self_Study = [
        ["id" => "101", "address" => "H1-113", "name" => "Phòng tự học số 1", "type" => "self_study", "total_seats" => 40, 
            "available_seats" => 40, "seats" => [], "status" => "available"],
        ["id" => "102", "address" => "H1-115", "name" => "Phòng tự học số 2", "type" => "self_study", "total_seats" => 50, 
            "available_seats" => 50, "seats" => [], "status" => "available"],
        ["id" => "103", "address" => "H1-215", "name" => "Phòng tự học số 3", "type" => "self_study", "total_seats" => 50, 
            "available_seats" => 50, "seats" => [], "status" => "available"],
        ["id" => "104", "address" => "H1-216", "name" => "Phòng tự học số 4", "type" => "self_study", "total_seats" => 40, 
            "available_seats" => 40, "seats" => [], "status" => "available"],
        ["id" => "105", "address" => "H1-313", "name" => "Phòng tự học số 5", "type" => "self_study", "total_seats" => 70, 
            "available_seats" => 70, "seats" => [], "status" => "available"],
        ["id" => "106", "address" => "H1-315", "name" => "Phòng tự học số 6", "type" => "self_study", "total_seats" => 60, 
            "available_seats" => 60, "seats" => [], "status" => "available"]
    ];
    private $Room_Study_Dual = [
        ["id" => "201", "address" => "H2-104A", "name" => "Phòng đôi số 1", "type" => "dual", "status" => "available"],
        ["id" => "202", "address" => "H2-104B", "name" => "Phòng đôi số 2", "type" => "dual", "status" => "available"],
        ["id" => "203", "address" => "H2-104C", "name" => "Phòng đôi số 3", "type" => "dual", "status" => "available"],
        ["id" => "204", "address" => "H2-104D", "name" => "Phòng đôi số 4", "type" => "dual", "status" => "available"],
        ["id" => "205", "address" => "H2-104E", "name" => "Phòng đôi số 5", "type" => "dual", "status" => "available"],
        ["id" => "206", "address" => "H2-104F", "name" => "Phòng đôi số 6", "type" => "dual", "status" => "available"],
        ["id" => "207", "address" => "H2-104G", "name" => "Phòng đôi số 7", "type" => "dual", "status" => "available"],
        ["id" => "208", "address" => "H2-104H", "name" => "Phòng đôi số 8", "type" => "dual", "status" => "available"],
        ["id" => "209", "address" => "H2-305A", "name" => "Phòng đôi số 9", "type" => "dual", "status" => "available"],
        ["id" => "210", "address" => "H2-305B", "name" => "Phòng đôi số 10", "type" => "dual", "status" => "available"],
        ["id" => "211", "address" => "H2-305C", "name" => "Phòng đôi số 11", "type" => "dual", "status" => "available"],
        ["id" => "212", "address" => "H2-305D", "name" => "Phòng đôi số 12", "type" => "dual", "status" => "available"],
        ["id" => "213", "address" => "H2-305E", "name" => "Phòng đôi số 13", "type" => "dual", "status" => "available"],
        ["id" => "214", "address" => "H2-305F", "name" => "Phòng đôi số 14", "type" => "dual", "status" => "available"],
        ["id" => "215", "address" => "H2-305G", "name" => "Phòng đôi số 15", "type" => "dual", "status" => "available"],
        ["id" => "216", "address" => "H2-305H", "name" => "Phòng đôi số 16", "type" => "dual", "status" => "available"]
    ];
    private $Room_Study_Group = [
        ["id" => "301", "address" => "H3-401", "name" => "Phòng nhóm số 1", "type" => "group", "status" => "available"],
        ["id" => "302", "address" => "H3-402", "name" => "Phòng nhóm số 2", "type" => "group", "status" => "available"],
        ["id" => "303", "address" => "H3-403", "name" => "Phòng nhóm số 3", "type" => "group", "status" => "available"],
        ["id" => "304", "address" => "H3-404", "name" => "Phòng nhóm số 4", "type" => "group", "status" => "available"],
        ["id" => "305", "address" => "H3-405", "name" => "Phòng nhóm số 5", "type" => "group", "status" => "available"],
        ["id" => "306", "address" => "H6-302", "name" => "Phòng nhóm số 6", "type" => "group", "status" => "available"],
        ["id" => "307", "address" => "H6-303", "name" => "Phòng nhóm số 7", "type" => "group", "status" => "available"],
        ["id" => "308", "address" => "H6-304", "name" => "Phòng nhóm số 8", "type" => "group", "status" => "available"],
        ["id" => "309", "address" => "H6-305", "name" => "Phòng nhóm số 9", "type" => "group", "status" => "available"]
    ];

    public function __construct() {
        if (isset($_SESSION["selfRoom"])){
            $this->Room_Self_Study = $_SESSION["selfRoom"];
        } else {
            foreach($this->Room_Self_Study as &$room){
                $seats = [];
                for ($i = 1; $i <= $room["total_seats"]; $i++) {
                    $seats[$i] = ["seat_address" => null, "status" => "available"];
                }
                $room["seats"] = $seats;
            }
            $_SESSION["selfRoom"] = $this->Room_Self_Study;
        }
        if (isset($_SESSION["dualRoom"])) {
            $this->Room_Study_Dual = $_SESSION["dualRoom"];
        }
        if (isset($_SESSION["groupRoom"])) {
            $this->Room_Study_Group = $_SESSION["groupRoom"];
        }
    }

    private function generateRoomId($type) {
        $prefix = $type == "self_study" ? "1" : ($type == "dual" ? "2" : "3");
        return $prefix . str_pad((count($this->GetRoomList($type)) + 1), 2, "0", STR_PAD_LEFT);
    }

    public function ChangeRoomStatus($id, $status) {
        foreach ([$this->Room_Self_Study, $this->Room_Study_Dual, $this->Room_Study_Group] as &$roomType) {
            foreach ($roomType as &$room) {
                if ($room['id'] == $id) {
                    $room['status'] = $status;
                    if ($room["type"] == "self_study") $_SESSION["selfRoom"] = $roomType;
                    else if ($room["type"] == "dual") $_SESSION["dualRoom"] = $roomType;
                    else $_SESSION["groupRoom"] = $roomType;
                    return true;
                }
            }
        }
        return false;
    }
    public function ChangeSeatStatus($roomId, $seatNumber, $status) {
        foreach ($this->Room_Self_Study as &$room) {
            if ($room['id'] == $roomId && isset($room['seats'][$seatNumber])) {
                $room['seats'][$seatNumber]['status'] = $status;
                $_SESSION["selfRoom"] = $this->Room_Self_Study;
                return true;
            }
        }
        return false;
    }

    public function AddRoom($address, $name, $type, $total_seats = null) {
        $id = $this->generateRoomId($type);
        $newRoom = [
            "id" => $id, "address" => $address, "name" => $name, "type" => $type, "status" => "available"
        ];

        if ($type == "self_study") {
            $newRoom["total_seats"] = $total_seats;
            $newRoom["available_seats"] = $total_seats;
            $newRoom["seats"] = array_fill(1, $total_seats, ["seat_address" => null, "status" => "available"]);
            $this->Room_Self_Study[] = $newRoom;
            $_SESSION["selfRoom"] = $this->Room_Self_Study;
        } elseif ($type == "dual") {
            $this->Room_Study_Dual[] = $newRoom;
            $_SESSION["dualRoom"] = $this->Room_Study_Dual;
        } elseif ($type == "group") {
            $this->Room_Study_Group[] = $newRoom;
            $_SESSION["groupRoom"] = $this->Room_Study_Group;
        } else {
            return false;
        }
        return true;
    }

    public function DeleteRoom($id) {
        foreach ([$this->Room_Self_Study, $this->Room_Study_Dual, $this->Room_Study_Group] as &$roomType) {
            foreach ($roomType as $key => $room) {
                if ($room['id'] == $id) {
                    unset($roomType[$key]);
                    return true;
                }
            }
        }
        return false;
    }

    public function GetRoomList($type) {
        return $type == "self_study" ? $this->Room_Self_Study : ($type == "dual" ? $this->Room_Study_Dual : ($type == "group" ? $this->Room_Study_Group : []));
    }
    public function GetAvailableRoomList($type) {
        $rooms = $this->GetRoomList($type);

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $today = date("d/m/Y");
        $now = date("H:i");

        $bookingModel = new Bookings();
        $bookingList = $bookingModel->getBookingsByDate($today);

        foreach ($bookingList as $booking)
            foreach ($rooms as &$room) {
                if ($booking["room_id"] != $room["id"]) continue;
                if ($booking["time_start"] < $now && $booking["time_end"] > $now) {
                    if ($booking["room_id"] < 200) {
                        $room["seats"][$booking["seat_number"]]["status"] = "using";
                    } else $room["status"] = "using";
                } else {
                    if ($booking["room_id"] < 200) {
                        $room["seats"][$booking["seat_number"]]["status"] = "available";
                    } else $room["status"] = "available";
                }
            }
        if ($type == "self_study") {
            $_SESSION["selfRoom"] = $rooms;
            return $rooms;
        }
        else if ($type == "dual") $_SESSION["dualRoom"] = $rooms;
        else if ($type == "group") $_SESSION["groupRoom"] = $rooms;

        return array_filter($rooms, function($room) {
            return $room['status'] === "available";
        });
    }
    public function GetRoomByID($roomID) {
        if ($roomID < 200) {
            foreach($this->Room_Self_Study as $room) {
                if ($room["id"] == $roomID) {
                    $result = [
                        "address" => $room["address"],
                        "name" => $room["name"],
                        "id" => $room["id"],
                    ];
                    return $result;
                }
            }
        } else if ($roomID < 300) {
            foreach($this->Room_Study_Dual as $room) {
                if ($room["id"] == $roomID)
                    return $room;
            }
        } else {
            foreach($this->Room_Study_Group as $room) {
                if ($room["id"] == $roomID)
                    return $room;
            }
        }
    }

    public function GetAvailableSeat($roomId) {
        foreach ($this->Room_Self_Study as $room) {
            if ($room["id"] == $roomId) 
                return $room["available_seats"];
        }
        return 0;
    }
}
