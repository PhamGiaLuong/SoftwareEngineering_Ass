<?php 

// Author: Gia Luong

require_once "./Models/users.php";
require_once "./Models/notification.php";
require_once "./Models/bookings.php";

class HomeController{
    // Chức năng: hiển thị tab Trang chủ
    public function index(){
        $bookingModel = new Bookings();
        $stat = $bookingModel->getTodayStatistic();
        
        $numOfAvailable = [
            "selfRoom" => 310 - $stat["self"]["using"],
            "dualRoom" => 16 - $stat["dual"]["using"],
            "groupRoom" => 9 - $stat["group"]["using"],
        ];
        require_once('./Views/home.php');
    }

    // Chức năng: lấy các thông báo chung gần nhất
    public function getGenNote () {
        $noteModel = new Notifications();
        $noteList = $noteModel->GetNearestAnnouncements();
        if (count($noteList) > 0) {
            $userModel = new Users();
            foreach ($noteList as &$note){
                $auth = $userModel->getUserByID($note["author"]);
                $author = [
                    "name" => $auth["name"],
                    "image" => $auth["image"],
                    "role" => $auth["role"]
                ];
                $note["author"] = $author;
            }
        }
        $pinnedList = $noteModel->GetPinAnnouncements();
        if (count($pinnedList) > 0) {
            $userModel = new Users();
            foreach ($pinnedList as &$note){
                $auth = $userModel->getUserByID($note["author"]);
                $author = [
                    "name" => $auth["name"],
                    "image" => $auth["image"],
                    "role" => $auth["role"]
                ];
                $author["id"] = ($auth["role"] == "staff" || $auth["role"] == "admin")
                    ? $auth["id"] : $auth["BKNetID"];
                $note["author"] = $author;
            }
        }

        // Trả về chuỗi json
        header('Content-Type: application/json');
        echo count($noteList) > 0 
            ? json_encode([
                'noteList' => $noteList,
                'pinnedList' => $pinnedList
            ]) 
            : json_encode(["info" => "Không tìm thấy dữ liệu!"]);
        exit;
    }

    // Chức năng: lấy các báo cáo chưa giải quyết
    public function getUnsolvedReports() {
        $bookingModel = new Bookings();
        $unsolvedReports = $bookingModel->getUnsolvedReports();
        if (count($unsolvedReports) > 0) {
            $userModel = new Users();
            $roomModel = new Rooms();
            foreach ($unsolvedReports as &$report){
                $auth = $userModel->getUserByID($report["user_id"]);
                $author = [
                    "name" => $auth["name"],
                    "image" => $auth["image"],
                    "role" => $auth["role"]
                ];
                $report["author"] = $author;
                $report["room"] = $roomModel->getRoomByID($report["room_id"]);
                
            }
        }

        // Trả về chuỗi json
        header('Content-Type: application/json');
        echo json_encode($unsolvedReports);
        exit;
    }

    // Chức năng: cập nhật trạng thái cho báo cáo
    public function updateBookingReportStatus() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Lấy dữ liệu từ JSON body
            $data = json_decode(file_get_contents("php://input"), true);

            $bookingModel = new Bookings();
            $updated = $bookingModel->updateReportStatus($data["booking_id"], $data["report_id"], $data["status"], $data["solver"]);
            if ($updated) {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => "Cập nhật trạng thái báo cáo thành công!",
                ]);
                exit();
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Cập nhật trạng thái báo cáo thất bại!",
                ]);
                exit();
            }
        }
    }

}
