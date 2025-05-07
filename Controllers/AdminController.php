<?php 

// Author: Gia Luong

require_once "./Models/users.php";
require_once "./Models/rooms.php";

class AdminController {
    // Chức năng: hiển thị tab Quản trị
    public function index(){
        $roomModel = new Rooms();
        $selfRoomList = $roomModel->GetRoomList("self_study");
        $dualRoomList = $roomModel->GetRoomList("dual");
        $groupRoomList = $roomModel->GetRoomList("group");

        require_once('./Views/admin.php');
    }

    // Chức năng: trích xuất danh sách các phòng của khu tự học
    public function getStudySpace($roomType, $page) {
        $roomModel = new Rooms();

        if ($roomType == "self_study") $roomList = $roomModel->GetRoomList("self_study");
        else if ($roomType == "dual") $roomList = $roomModel->GetRoomList("dual");
        else $roomList = $roomModel->GetRoomList("group");
        
        // Phân trang dữ liệu
        $offset = ($page - 1) * 10;
        $paginatedList = array_slice($roomList, $offset, 10);

        // Trả về chuỗi json
        header('Content-Type: application/json');
        echo count($paginatedList) > 0 
            ? json_encode([
                'roomList' => $paginatedList,
                'totalPages' => ceil(count($roomList) / 10)
            ]) 
            : json_encode(["info" => "Không tìm thấy dữ liệu người dùng"]);
        // echo $result;
        exit;
    }

    // Chức năng: thêm phòng mới vào hệ thống
    public function addNewRoom() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $address = $_POST["building"] . "-".$_POST["room"];
            $name = $_POST["name"];
            $type = $_POST["type"];
            $total_seats = $_POST["capacity"];

            $roomModel = new Rooms();
            if ($roomModel->AddRoom($address, $name, $type, $total_seats)) {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => "Đã thêm phòng thành công!"
                ]);
                exit();
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Không thể thêm phòng!"
                ]);
                exit();
            }
        }
    }

    // Chức năng: yêu cầu Models/rooms.php khóa phòng
    public function lockRoom($roomID) {
        $roomModel = new Rooms();
        if ($roomModel->ChangeRoomStatus($roomID, "lock")) {
            header('Content-Type: application/json');
            echo json_encode([
                "success" => "Đã KHÓA phòng " . $roomID . ", người dùng KHÔNG thể đặt lịch cho phòng này nữa."
            ]);
            exit();
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                "error" => "Không tìm thấy phòng!"
            ]);
            exit();
        }
    }
    // Chức năng: yêu cầu Models/rooms.php mở khóa phòng
    public function unlockRoom($roomID) {
        $roomModel = new Rooms();
        if ($roomModel->ChangeRoomStatus($roomID, "available")) {
            header('Content-Type: application/json');
            echo json_encode([
                "success" => "Đã MỞ KHÓA phòng " . $roomID . ", người dùng CÓ thể đặt lịch cho phòng này."
            ]);
            exit();
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                "error" => "Không tìm thấy phòng!"
            ]);
            exit();
        }
    }

    // Chức năng: lấy danh sách sự cố cần giải quyết
    public function getIssues($page) {
        $roomModel = new Rooms();
        $issueList = $roomModel->GetIssueList();

        // Phân trang dữ liệu
        $offset = ($page - 1) * 10;
        $paginatedList = array_reverse($issueList); 
        $paginatedList = array_slice($paginatedList, $offset, 10);

        $userModel = new Users();
        foreach ($paginatedList as $key => $issue) {
            $user = $userModel->getUserByID($issue["reporter"]);
            $paginatedList[$key]["reporterName"] = $user["name"];

            $room = $roomModel->GetRoomByID($issue["room_id"]);
            $paginatedList[$key]["roomName"] = $room["name"] ." - ". $room["address"];
        }

        // Trả về chuỗi json
        header('Content-Type: application/json');
        echo count($paginatedList) > 0 
            ? json_encode([
                'issueList' => $paginatedList,
                'totalPages' => ceil(count($issueList) / 10)
            ]) 
            : json_encode(["info" => "Không tìm thấy dữ liệu người dùng"]);
        exit;
    }

    // Chức năng: giải quyết sự cố
    public function solveIssue($issueID) {
        $roomModel = new Rooms();
        if ($roomModel->SolveIssueByID($issueID)) {
            header('Content-Type: application/json');
            echo json_encode([
                "success" => "Đã giải quyết sự cố thành công!"
            ]);
            exit();
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                "error" => "Không tìm thấy sự cố!"
            ]);
            exit();
        }
    }
}

?>