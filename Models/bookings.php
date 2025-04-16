<?php

// Author: Tuan Lam

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "./Models/rooms.php";

class Bookings {
    private $Bookings_Today = [
        [
            "booking_id" => "1106",   "user_id" => "2211816", "room_id" => "101",     "seat_number" => "22",
            "time_start" => "14:00",    "time_end" => "16:00",  "created_at" => "11:25","booking_date" => "16/04/2025",
            "status" => "completed",
            "report" => [
                "create_at" => "16/4/2025 14:30",
                "content" => "Các bạn ở dãy A đang nói chuyện rất ồn ào, anh/chị quản lý xử mấy bạn giúp em ạ.",
                "status" => "solved"
            ]
        ]
    ];
    private $Bookings_History = [    ];
  
    function generateFakeBookings($count = 10, $currentDate) {
        $fakeBookings = [];
        $statusList = ['completed', 'cancelled'];
        $userIds = ['2211816', '2211960', '2210615', '2053079', '2510322', '2121221',
                    '2212123', '2213321', '2251001', '2111025', '2151052', '2113612',
                    '2300012', '2300023', '2300451', '251101', '250004', '251103',
                ];
        $roomIds = ['101', '102', '103', '104', '105', '106',
                    '201', '202', '203', '204', '205', '206', '207', '208', '209', '210',
                    '211', '212', '213', '214', '215', '216',
                    '301', '302', '303', '304', '305', '306', '307', '308', '309'];
        $offset = count($this->Bookings_History);
    
        for ($i = 1; $i <= $count; $i++) {
            $startHour = rand(7, 19);
            $endHour = $startHour + rand(1, 4);
            $createdAtTime = rand(5, $startHour - 1);
            $createdAtMin = rand(1, 55);
    
            $booking = [
                "booking_id"   => 1000 + $i + $offset,
                "user_id"      => $userIds[array_rand($userIds)],
                "room_id"      => $roomIds[array_rand($roomIds)],
                "seat_number"  => null,
                "time_start"   => str_pad($startHour, 2, "0", STR_PAD_LEFT) . ":00",
                "time_end"     => str_pad($endHour, 2, "0", STR_PAD_LEFT) . ":00",
                "created_at"   => str_pad($createdAtTime, 2, "0", STR_PAD_LEFT) . ":" . str_pad($createdAtMin, 2, "0", STR_PAD_LEFT),
                "booking_date" => $currentDate,
                "status"       => $statusList[array_rand($statusList)],
                "report"       => []
            ];

            if ($booking["room_id"] < 200) {
                $seatNums = range(1, 40);
                $booking["seat_number"] = (string)$seatNums[array_rand($seatNums)];
            }
    
            $fakeBookings[] = $booking;
        }
    
        return $fakeBookings;
    }
    
    public function __construct() {
        if (isset($_SESSION["historyBooking"])) {
            $this->Bookings_History = $_SESSION["historyBooking"];
        } else {
            $date = ['16/2/2025', '19/2/2025', '20/2/2025', '25/2/2025', '27/2/2025', '28/2/2025',
                    '1/3/2025', '3/3/2025', '5/3/2025', '7/3/2025', '10/3/2025', '15/3/2025',
                    '17/3/2025', '19/3/2025', '20/3/2025', '22/3/2025', '25/3/2025', '27/3/2025',
                    '31/3/2025', '1/4/2025', '2/4/2025', '5/4/2025', '9/4/2025', '10/4/2025',
                    '12/4/2025', '13/4/2025', '14/4/2025', '15/4/2025', '16/4/2025'];
            foreach ($date as $d) {
                $dailyBookings = $this->generateFakeBookings(rand(2, 9), $d);
                $this->Bookings_History = array_merge($this->Bookings_History, $dailyBookings);
            }
            $_SESSION["historyBooking"] = $this->Bookings_History;
        }
        if (isset($_SESSION["todayBooking"])){
            $this->Bookings_Today = $_SESSION["todayBooking"];
        } else {
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $this->Bookings_Today = $this->generateFakeBookings(15, date("d/m/Y"));
            $_SESSION["todayBooking"] = $this->Bookings_Today;
        }

    }

    private function isTimeOverlap($start1, $end1, $start2, $end2) {
        // Chuyển các mốc thời gian thành timestamp
        $s1 = strtotime($start1);
        $e1 = strtotime($end1);
        $s2 = strtotime($start2);
        $e2 = strtotime($end2);
        if (($s1 < $s2 && $e1 <= $s2) || ($s2 < $e1 && $e2 <= $s1)) return false;
        return true;
    }
    
    public function findAvailableSeat($room_id, $start_time, $end_time) {
        $roomModel  = new Rooms();
        $total_seats = range(1, $roomModel->GetAvailableSeat($room_id));
        $used_seats = [];
    
        foreach ($this->Bookings_Today as $booking) {
            if (
                $booking['room_id'] === $room_id &&
                $this->isTimeOverlap($start_time, $end_time, $booking['time_start'], $booking['time_end']) &&
                $booking['status'] !== 'cancelled'
            ) {
                $used_seats[] = (int)$booking['seat_number'];
            }
        }
        $available_seats = array_diff($total_seats, $used_seats);
        if (empty($available_seats)) {
            return null;
        }
        return $available_seats[array_rand($available_seats)];
    }

    public function bookSelfStudy($user_id, $room_id, $start_time, $end_time, $seat_number = null) {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $booking_date = date("d/m/Y");
        // $seat_number = $this->findAvailableSeat($room_id, $start_time, $end_time);
        // if ($seat_number === null) {
        //     return false;
        // }
    
        $id = count($this->Bookings_History) + count($this->Bookings_Today);
        $booking = [
            "booking_id" => $id,
            "user_id" => $user_id,
            "room_id" => $room_id,
            "seat_number" => $seat_number,
            "time_start" => $start_time,
            "time_end" => $end_time,
            "booking_date" => $booking_date,
            "created_at" => date("H:i"),
            "status" => "waiting",
            "report" => []
        ];
    
        $this->Bookings_Today[] = $booking;
        $_SESSION["todayBooking"] = $this->Bookings_Today;
        return true;
    }
    public function isBookingConflict($room_id, $start_time, $end_time) {
        foreach($this->Bookings_Today as $booking) {
            if ($booking["room_id"] == $room_id) {
                if ($this->isTimeOverlap($start_time, $end_time, $booking["time_start"], $booking["time_end"]))
                    return true;
            }
        }
        return false;
    }
    // public function bookRoom($user_id, $room_id, $start_time, $end_time) {
    //     date_default_timezone_set("Asia/Ho_Chi_Minh");
    //     $booking_date = date("d/m/Y");
    //     // if ($this->isBookingConflict($room_id, $start_time, $end_time)) {
    //     //     return false;
    //     // }
    
    //     $id = count($this->Bookings_History) + count($this->Bookings_Today);
    //     $booking = [
    //         "booking_id" => $id,
    //         "user_id" => $user_id,
    //         "room_id" => $room_id,
    //         "time_start" => $start_time,
    //         "time_end" => $end_time,
    //         "booking_date" => $booking_date,
    //         "created_at" => date("H:i"),
    //         "status" => "waiting"
    //     ];
    
    //     $this->Bookings_Today[] = $booking;
    //     $_SESSION["todayBooking"] = $this->Bookings_Today;
    //     return true;
    // }

    public function getAllBookings() {
        $allBookings = array_merge($this->Bookings_History, $this->Bookings_Today);
        return $allBookings;
    }
    public function getBookingsByUser($user_id) {
        $userBookings = array_merge(
            array_filter($this->Bookings_History, fn($booking) => $booking["user_id"] === $user_id),
            array_filter($this->Bookings_Today, fn($booking) => $booking["user_id"] === $user_id)
        );
        return $userBookings;
    }
    public function getBookingsByDate($booking_date) {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $today = date("d/m/Y");
        if ($booking_date == $today) return $this->Bookings_Today;

        $dateBookings = 
            array_filter($this->Bookings_History, fn($booking) => $booking["booking_date"] === $booking_date);
        return $dateBookings;
    }
    public function updateBookingStatus($booking_id, $new_status) {
        foreach ($this->Bookings_Today as &$booking) {
            if ($booking["booking_id"] === $booking_id) {
                $booking["status"] = $new_status;
                $_SESSION["todayBooking"] = $this->Bookings_Today;
                return true;
            }
        }
        return false;
    }
    // public function cancelBookingToday($room_id, $booking_date) {
    //     foreach (array_merge($this->Bookings_Self_Study, $this->Bookings_Room) as &$booking) {
    //         if ($booking["room_id"] === $room_id && $booking["booking_date"] === $booking_date && $booking["status"] !== "used") {
    //             $booking["status"] = "cancelled";
    //             return true;
    //         }
    //     }
    //     return false;
    // }
    public function cancelBookingById($booking_id) {
        foreach ($this->Bookings_Today as &$booking) {
            if ($booking['booking_id'] === $booking_id) {
                if ($booking['status'] === 'used') {
                    return false;
                }
                $booking['status'] = 'cancelled';
                $_SESSION["todayBooking"] = $this->Bookings_Today;
                return true;
            }
        }
        return false;
    }
    
    public function editBookingById($booking_id, $start_time, $end_time, $room_id, $seat_number = null) {
        foreach ($this->Bookings_Today as &$booking) {
            if ($booking['booking_id'] === $booking_id) {
                if ($room_id < 200) {
                    // $seat = $booking["seat_number"];
                    $booking["seat_number"] = $seat_number;
                    // if ($booking["room_id"] == $room_id) {
                    //     $this->findAvailableSeat($room_id, $start_time, $end_time);
                    // }
                }
                $booking["room_id"] = $room_id;
                $booking["time_start"] = $start_time;
                $booking["time_end"] = $end_time;
                $_SESSION["todayBooking"] = $this->Bookings_Today;
                return true;
            }
        }
        return false;
    }




}

?>