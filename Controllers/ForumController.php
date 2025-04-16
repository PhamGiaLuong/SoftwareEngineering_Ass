<?php 

// Author: Gia Luong

require_once "./Models/users.php";
require_once "./Models/forums.php";

class ForumController {
    // Chức năng: hiển thị tab Forum
    public function index(){
        $forum = new Forums();
        $posts = $forum->getAllPosts();

        require_once('./Views/forum.php');
    }

    // Chức năng: gửi yêu cầu tạo bài viết mới đến Models/forums.php
    public function addNewPost(){
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $topics = [
                "selfStudy" =>"Phòng tự học",
                "mentorring" => "Phòng học đôi",
                "groupStudy" => "Phòng học nhóm",
                "ctxh" => "Công tác xã hội và điểm rèn luyện",
                "help" => "Hỗ trợ và giải đáp thắc mắc",
                "studyDiscuss" => "Thảo luận học tập",
                "findStudymate" => "Tìm bạn học chung",
                "review" => "Review Không gian học tập",
                "system" => "Góp ý về hệ thống",
                "other" => "Khác",
            ];
            $post = [
                "title" => $_POST["title"],
                "topic" => $topics[$_POST["topic"]],
                "author" => $_POST["author"],
                "content" => $_POST["content"]
            ];

            $forum = new Forums();
            if ($forum->addNewPost($post)) {
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => "Đã thêm bài viết mới thành công!"
                ]);
                exit();
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Không thể thêm bài viết mới!"
                ]);
                exit();
            }
        }
    }

    // Chức năng: gửi yêu cầu tạo phản hồi mới cho bài viết đến Models/forums.php
    public function addNewReply(){
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $reply = [
                "id" => $_POST["id"],  
                "author" => $_POST["author"],
                "content" => $_POST["content"]
            ];

            $forum = new Forums();
            $result = $forum->addNewReply($reply);
            if (isset($result)) {
                $userModel = new Users();
                $author = $userModel->getUserByID($reply["author"]);
                header('Content-Type: application/json');
                echo json_encode([
                    "success" => "Đã thêm phản hồi thành công!",
                    "reply" => $result,
                    "author" => $author
                ]);
                exit();
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "Không thể thêm phản hồi!"
                ]);
                exit();
            }
        }
    }

    // Chức năng: yêu cầu Models/forums.php trích xuất danh sách bài viết cho topic (ajax)
    public function getTopic($topic, $page, $limit){
        $offset = ($page - 1) * $limit;

        $forum = new Forums();
        $result = $forum->getPostsByTopic($topic);

        $result = array_reverse($result);
        $paginatedPosts = array_slice($result, $offset, $limit);

        header('Content-Type: application/json');
        echo count($paginatedPosts) > 0 
            ? json_encode([
                'posts' => $paginatedPosts,
                'totalPages' => ceil(count($result) / $limit)
            ]) 
            : json_encode(["error" => "Không có bài viết về chủ đề này"]);
        // echo $result;
        exit;
    }


    // Chức năng: yêu cầu Models/forums.php trích xuất nội dung bài viết
    public function detail($postID) {
        $forum = new Forums();
        $post = $forum->getPostDetail($postID);
        require_once "./Views/forumPostDetail.php";
    }

    // Chức năng: yêu cầu Models/forums.php khóa bài viết 
    public function lockPost($postID) {
        $forum = new Forums();
        if ($forum->lockPost($postID)) {
            header('Content-Type: application/json');
            echo json_encode(["success" => "Đã KHÓA bài viết, người dùng KHÔNG thể phản hồi bài viết này."]);
            exit();
        } else {
            header('Content-Type: application/json');
            echo json_encode(["error" => "Không tìm thấy bài viết!"]);
            exit();
        }
    }
    // Chức năng: yêu cầu Models/forums.php mở khóa bài viết 
    public function unlockPost($postID) {
        $forum = new Forums();
        if ($forum->unlockPost($postID)) {
            header('Content-Type: application/json');
            echo json_encode(["success" => "Đã MỞ KHÓA bài viết, người dùng Có thể phản hồi bài viết này."]);
            exit();
        } else {
            header('Content-Type: application/json');
            echo json_encode(["error" => "Không tìm thấy bài viết!"]);
            exit();
        }
    }
}

?>