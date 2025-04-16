<?php 

// Author: Gia Luong

require_once "./Models/users.php";
require_once "./Models/notification.php";

class HomeController{
    // Chức năng: hiển thị tab Trang chủ
    public function index(){
        require_once('./Views/home.php');
    }

    // Chức năng: lấy các thông báo chung gần nhất
    public function getGenNote () {
        $noteModel = new Notifications();
        $noteList = $noteModel->GetNearestGenNotification();
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
        $pinnedList = $noteModel->GetPinGenNotification();
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


}
