<?php 
require_once "./Models/users.php";
require_once "./Models/forums.php";

class ForumController {
    public function index(){
        $forum = new Forums();
        $posts = $forum->getAllPosts();

        require_once('./Views/forum.php');
    }

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
                header("Location: ./Views/forum.php");
                exit();
            } else {
                echo "Lỗi: Không tìm thấy bài viết!";
            }
        }
    }

    public function addNewReply(){
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $reply = [
                "id" => $_POST["id"],  
                "author" => $_POST["author"],
                "content" => $_POST["content"]
            ];

            $forum = new Forums();
            if ($forum->addNewReply($reply)) {
                header("Location: /SE_Ass_Code/index.php?url=forum/detail/" . $_POST["post_id"]);
                exit();
            } else {
                $_SESSION["error"] = "Không tìm thấy bài viết!";
                header("Location: /SE_Ass_Code/index.php?url=forum");
                exit();
            }
        }
    }

    public function getTopic($topic){
        $forum = new Forums();
        // $posts = $forum->getPostsByTopic($topic);
        // return $posts;
        $result = $forum->getPostsByTopic($topic);

        header('Content-Type: application/json');
        echo $result;
        exit;
    }

    public function showPostsByTopic($topic) {
        $forum = new Forums();
        $posts = json_decode($forum->getPostsByTopic($topic), true); 
    
        if (isset($posts["error"])) {
            echo "<h2>" . $posts["error"] . "</h2>";
            return;
        }
    
        include "./Views/forum.php"; 
    }

    public function detail($postID) {
        $forum = new Forums();
        $post = $forum->getPostDetail($postID);
        require_once "./Views/forumPostDetail.php";
    }

    public function lockPost($postID) {
        $forum = new Forums();
        if ($forum->lockPost($postID)) {
            header("Location: /SE_Ass_Code/index.php?url=forum");
            exit();
        } else {
            $_SESSION["error"] = "Không tìm thấy bài viết!";
            header("Location: /SE_Ass_Code/index.php?url=forum");
            exit();
        }
    }
    public function unlockPost($postID) {
        $forum = new Forums();
        if ($forum->unlockPost($postID)) {
            header("Location: /SE_Ass_Code/index.php?url=forum");
            exit();
        } else {
            $_SESSION["error"] = "Không tìm thấy bài viết!";
            header("Location: /SE_Ass_Code/index.php?url=forum");
            exit();
        }
    }
}

?>