<?php

// Author: Tuan Lam

use LDAP\Result;

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
                "status" => "solved",
                "solver_id" => "2211816",
                "solved_at" => "16/4/2025 15:00"
            ]
        ]
    ];
    private $Bookings_History = [    ];
  
    function generateFakeBookings($count = 10, $currentDate) {
        $fakeBookings = [];
        $statusList = ['completed', 'cancelled', 'expired'];
        $userIds = ['2211816', '2211960', '2210615', '2053079', '2510322', '2121221',
                    '2212123', '2213321', '2251001', '2111025', '2151052', '2113612',
                    '2300012', '2300023', '2300451', '251001', '250004', '251003',
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
                $dailyBookings = $this->generateFakeBookings(rand(3, 17), $d);
                $this->Bookings_History = array_merge($this->Bookings_History, $dailyBookings);
            }
            $_SESSION["historyBooking"] = $this->Bookings_History;
        }
        if (isset($_SESSION["todayBooking"])){
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $today = date("d/m/Y");
            $updatedTodayBooking = []; // Booking đúng ngày hôm nay sẽ được giữ lại
            foreach ($_SESSION["todayBooking"] as $booking) {
                if ($booking["booking_date"] != $today) {
                    // Chuyển booking cũ qua lịch sử
                    $_SESSION["historyBooking"][] = $booking;
                } else {
                    // Giữ lại booking đúng ngày hôm nay
                    $updatedTodayBooking[] = $booking;
                }
            }

            // Cập nhật lại danh sách todayBooking
            $_SESSION["todayBooking"] = $updatedTodayBooking;
            $this->Bookings_Today = $_SESSION["todayBooking"];
            $this->Bookings_History = $_SESSION["historyBooking"];
        } else {
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            $this->Bookings_Today = $this->generateFakeBookings(29, date("d/m/Y"));
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

    public function makeBooking($user_id, $room_id, $start_time, $end_time, $seat_number = null) {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $booking_date = date("d/m/Y");
    
        $id = 1000 + count($this->Bookings_History) + count($this->Bookings_Today) + 1;
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
        return $id;
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
    
    public function addReportByBookingID($bookingID, $content) {
        foreach ($this->Bookings_Today as &$booking) {
            if ($booking["booking_id"] == $bookingID) {
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                $report = [
                    "id" => count($booking["report"]) + 1,
                    "created_at" => date("d/m/Y H:i"),
                    "content" => $content,
                    "status" => "waiting",
                    "solver_id" => "---",
                    "solved_at" => "---"
                ];
                $booking["report"][] = $report;
                $_SESSION["todayBooking"] = $this->Bookings_Today;
                return true;
            }
        }
        return false;
    }

    public function getUnsolvedReports() {
        $unsolvedReports = [];
        foreach ($this->Bookings_Today as &$booking) {
            if ($booking["report"] == null) continue;

            foreach ($booking["report"] as &$report) {
                if ($report["status"] == "waiting") {
                    $unsolvedReports[] = [
                        "booking_id" => $booking["booking_id"],
                        "user_id" => $booking["user_id"],
                        "room_id" => $booking["room_id"],
                        "seat_number" => $booking["seat_number"],
                        "report_id" => $report["id"],
                        "created_at" => $report["created_at"],
                        "content" => $report["content"],
                        "solver_id" => $report["solver_id"],
                        "solved_at" => $report["solved_at"]
                    ];
                }
            }
        }
        return $unsolvedReports;
    }

    public function updateReportStatus($bookingID, $reportID, $status, $solver) {
        foreach ($this->Bookings_Today as &$booking) {
            if ($booking["booking_id"] == $bookingID) {
                foreach ($booking["report"] as &$report) {
                    if ($report["id"] == $reportID) {
                        date_default_timezone_set("Asia/Ho_Chi_Minh");

                        $report["status"] = $status;
                        $report["solver_id"] = $solver;
                        $report["solved_at"] = date("d/m/Y H:i");
                        $_SESSION["todayBooking"] = $this->Bookings_Today;
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function getAllReports() {
        $allReports = [];
        foreach ($this->Bookings_History as &$booking) {
            if ($booking["report"] == null) continue;
            foreach ($booking["report"] as &$report) {
                $allReports[] = [
                    "booking_id" => $booking["booking_id"],
                    "user_id" => $booking["user_id"],
                    "room_id" => $booking["room_id"],
                    "seat_number" => $booking["seat_number"],
                    "report_id" => $report["id"],
                    "created_at" => $report["created_at"],
                    "content" => $report["content"],
                    "status" => $report["status"],
                    "solver_id" => $report["solver_id"],
                    "solved_at" => $report["solved_at"]
                ];
            }
        }
        foreach ($this->Bookings_Today as &$booking) {
            if ($booking["report"] == null) continue;
            foreach ($booking["report"] as &$report) {
                $allReports[] = [
                    "booking_id" => $booking["booking_id"],
                    "user_id" => $booking["user_id"],
                    "room_id" => $booking["room_id"],
                    "seat_number" => $booking["seat_number"],
                    "report_id" => $report["id"],
                    "created_at" => $report["created_at"],
                    "content" => $report["content"],
                    "status" => $report["status"],
                    "solver_id" => $report["solver_id"],
                    "solved_at" => $report["solved_at"]
                ];
            }
        }
        return $allReports;
    }

    public function getReminderForUser($user_id) {
        $reminders = [];
        foreach ($this->Bookings_Today as &$booking) {
            if ($booking["user_id"] == $user_id && ($booking["status"] == "waiting" || $booking["status"] == "overdue")) {
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                $a = strtotime($booking["time_start"]);
                $b = strtotime(date("H:i"));
                $diff = ($a - $b) / 60; // Chênh lệch thời gian tính bằng phút

                $rmd= [
                    "booking_id" => $booking["booking_id"],
                    "room_id" => $booking["room_id"],
                    "time_start" => $booking["time_start"],
                    "time_end" => $booking["time_end"],
                    "seat_number" => $booking["seat_number"],
                    "diff" => $diff,
                ];

                if ($diff <= 10 && $diff > 0) {
                    $rmd["status"] = "upcoming";
                    $reminders[] = $rmd;
                } else if ($diff <= 0 && $diff >= -10) {
                    $rmd["status"] = "overdue";
                    $reminders[] = $rmd;
                } else if ($diff < -10 && $booking["status"] != "using") {
                    $rmd["status"] = "expired";
                    $booking["status"] = "expired";
                    $reminders[] = $rmd;
                }
            }
        }
        $_SESSION["todayBooking"] = $this->Bookings_Today;
        return $reminders;
    }

    public function getTodayStatistic() {
        $statistic = [
            "self" => ["completed" => 0, "using" => 0, "scheduled" => 0, "cancelled" => 0, "overdue" => 0, "expired" => 0, "total" => 0],
            "dual" => ["completed" => 0, "using" => 0, "scheduled" => 0, "cancelled" => 0, "overdue" => 0, "expired" => 0, "total" => 0],
            "group" => ["completed" => 0, "using" => 0, "scheduled" => 0, "cancelled" => 0, "overdue" => 0, "expired" => 0, "total" => 0],
        ];
    
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $now = date("H:i");
        $nowTimestamp = strtotime($now);
    
        foreach ($this->Bookings_Today as &$booking) {
            $start = strtotime($booking["time_start"]);
            $end = strtotime($booking["time_end"]);
            $expired = $nowTimestamp - $start;
    
            $type = "group";
            if ($booking["room_id"] < 200) $type = "self";
            else if ($booking["room_id"] < 300) $type = "dual";
    
            switch ($booking["status"]) {
                case "cancelled":
                    $statistic[$type]["cancelled"]++;
                    break;
                case "completed":
                    $statistic[$type]["completed"]++;
                    break;
                case "expired":
                    $statistic[$type]["expired"]++;
                    break;
                case "overdue":
                    if ($expired > 600) { // quá 10 phút
                        $statistic[$type]["expired"]++;
                        $booking["status"] = "expired";
                    }
                    break;
                case "waiting":
                    if ($start <= $nowTimestamp && $end > $nowTimestamp) {
                        $statistic[$type]["overdue"]++;
                        $booking["status"] = "overdue";
                    } else if ($start > $nowTimestamp) {
                        $statistic[$type]["scheduled"]++;
                    }
                    break;
                case "using":
                    if ($end < $nowTimestamp) {
                        $statistic[$type]["completed"]++;
                        $booking["status"] = "completed";
                    } else {
                        $statistic[$type]["using"]++;
                    }
                    break;
                default:
                    break;
            }
        }
        $_SESSION["todayBooking"] = $this->Bookings_Today;
        
        $roomModel = new Rooms();

        $statistic["dual"]["total"] = count(array_filter($roomModel->GetRoomList("dual"), function ($room) {
            return isset($room["status"]) && strtolower($room["status"]) !== "lock";
        }));

        $statistic["group"]["total"] = count(array_filter($roomModel->GetRoomList("group"), function ($room) {
            return isset($room["status"]) && strtolower($room["status"]) !== "lock";
        }));

        foreach (array_filter($roomModel->GetRoomList("self_study"), function ($room) {
            return isset($room["status"]) && strtolower($room["status"]) !== "lock";
        }) as $room) {
            $statistic["self"]["total"] += $room["available_seats"];
        }

        return $statistic;
    }

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
    public function getTodayBookingsByUser($user_id) {
        $userBookings = 
            array_filter($this->Bookings_Today, fn($booking) => $booking["user_id"] === $user_id);
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
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $now = strtotime(date("H:i"));

        foreach ($this->Bookings_Today as &$booking) {
            if ($booking["booking_id"] == $booking_id) {
                $timeStart = strtotime($booking["time_start"]);

                // Kiểm tra: nếu còn hơn 5 phút nữa mới tới giờ đặt thì từ chối
                if ($timeStart - $now > 300) {
                    return false;
                }

                $booking["status"] = $new_status;
                $_SESSION["todayBooking"] = $this->Bookings_Today;
                return true;
            }
        }
        return false;
    }

    public function cancelBookingById($booking_id) {
        foreach ($this->Bookings_Today as &$booking) {
            if ($booking['booking_id'] == $booking_id) {
                
                $result = [
                    "userID" => $booking["user_id"],
                    "roomID" => $booking["room_id"],
                    "startTime" => $booking["time_start"],
                    "endTime" => $booking["time_end"]
                ];
                  
                if (!$this->updateBookingStatus($booking_id, "cancelled")) {
                    return false;
                }
                // $_SESSION["todayBooking"] = $this->Bookings_Today;
                return $result;
            }
        }
        return false;
    }
    
    public function editBookingById($booking_id, $start_time, $end_time, $room_id, $seat_number = null) {
        foreach ($this->Bookings_Today as &$booking) {
            if ($booking['booking_id'] == $booking_id) {
                $booking["seat_number"] = $seat_number;
                $booking["room_id"] = $room_id;
                $booking["time_start"] = $start_time;
                $booking["time_end"] = $end_time;

                $_SESSION["todayBooking"] = $this->Bookings_Today;
                return $booking;
            }
        }
        return false;
    }




}

?>