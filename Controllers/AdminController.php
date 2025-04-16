<?php 

// Author: Gia Luong

require_once "./Models/users.php";
require_once "./Models/rooms.php";

class AdminController {
    // Chức năng: hiển thị tab Quản trị
    public function index(){
        require_once('./Views/admin.php');
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
        $userList = $this->sortArrayByField($userList, "name", "asc");

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
}

?>