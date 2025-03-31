/*
 * Author: Tuan Lam
 */

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Rooms {
    public $Room_Self_Study = [
        ["id" => "101", "address" => "H1-113", "name" => "Phòng tự học số 1", "type" => "self_study", "total_seats" => 40, 
         "available_seats" => 40, "seats" => array_fill(1, 40, ["seat_address" => null, "status" => "available"]),
         "status" => "available"],
        ["id" => "102", "address" => "H6-115", "name" => "Phòng tự học số 2", "type" => "self_study", "total_seats" => 40, 
         "available_seats" => 40, "seats" => array_fill(1, 40, ["seat_address" => null, "status" => "available"]),
         "status" => "available"]
    ];
    public $Room_Study_Dual = [
        ["id" => "201", "address" => "H2-101", "name" => "Phòng đôi số 1", "type" => "dual", "status" => "available"],
        ["id" => "202", "address" => "H3-405", "name" => "Phòng đôi số 2", "type" => "dual", "status" => "available"],
        ["id" => "203", "address" => "H6-703", "name" => "Phòng đôi số 3", "type" => "dual", "status" => "available"],
        ["id" => "204", "address" => "H2-504", "name" => "Phòng đôi số 4", "type" => "dual", "status" => "available"],
        ["id" => "205", "address" => "H1-505", "name" => "Phòng đôi số 5", "type" => "dual", "status" => "available"],
    ];
    public $Room_Study_Group = [
        ["id" => "301", "address" => "H1-401", "name" => "Phòng nhóm số 1", "type" => "group", "status" => "available"],
        ["id" => "302", "address" => "H2-302", "name" => "Phòng nhóm số 2", "type" => "group", "status" => "available"],
        ["id" => "303", "address" => "H3-603", "name" => "Phòng nhóm số 3", "type" => "group", "status" => "available"],
        ["id" => "304", "address" => "H6-604", "name" => "Phòng nhóm số 4", "type" => "group", "status" => "available"],
        ["id" => "305", "address" => "H2-412", "name" => "Phòng nhóm số 5", "type" => "group", "status" => "available"]
    ];

    private function generateRoomId($type) {
        $prefix = $type == "self_study" ? "1" : ($type == "dual" ? "2" : "3");
        return $prefix . str_pad((count($this->GetRoomList($type)) + 1), 2, "0", STR_PAD_LEFT);
    }

    public function ChangeRoomStatus($id, $status) {
        foreach ([$this->Room_Self_Study, $this->Room_Study_Dual, $this->Room_Study_Group] as &$roomType) {
            foreach ($roomType as &$room) {
                if ($room['id'] == $id) {
                    $room['status'] = $status;
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
        } elseif ($type == "dual") {
            $this->Room_Study_Dual[] = $newRoom;
        } elseif ($type == "group") {
            $this->Room_Study_Group[] = $newRoom;
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
        return array_filter($rooms, function($room) {
            return $room['status'] === "available";
        });
    }
}
