<?php

// Author: Tuan Lam

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "./Models/users.php";

class Notifications {
    private $NotificationList = [
        [
            "id" => "noti_1",
            "receiver_id" => "2211960",
            "title" => "Đặt phòng thành công",
            "type" => "booking_success",
            "message" => "Bạn đã đặt Phòng tự học số 1 (H1-113) vào lúc 14:00 ngày 10/04/2025, số ghế 15.",
            "data" => [
                "room_id" => "101",
                "seat-number" => "15",
                "name" => "Phòng tự học số 1",
                "address" => "H1-113", 
                "time" => "14:00", 
                "date" => "20/04/2025"
            ],
            "is_read" => false,
            "created_at" => "10/4/2025 10:00"
        ],
        [
            "id" => "noti_2",
            "receiver_id" => "2211960",
            "title" => "Bạn đang trễ giờ đặt chỗ!",
            "type" => "booking_late_reminder",
            "message" => "Bạn đã trễ 10 phút so với thời gian đặt Phòng tự học số 1 (H1-113) lúc 14:00 ngày 20/04/2025. Vui lòng đến đúng giờ để tránh bị hủy chỗ.",
            "is_read" => false,
            "created_at" => "10/4/2025 14:10"
        ],
        
    ];

    private $GeneralNotification = [
        [
            "id" => "1",
            "title" => "Thông báo tạm dừng hoạt động, sửa chữa khu tự học H2",
            "type" => "repair",
            "author" => "250003",
            "pin" => false,
            "content" => "
                        <p>🔹 Quản trị viên xin thông báo về sự thay đổi thời gian hoạt động của khu tự học tại tòa H2:</p>
                        <ul>
                            <li><strong>Ngày dừng hoạt động:</strong> 5/3/2025</li>
                            <li><strong>Ngày hoạt động trở lại:</strong> 10/3/2025</li>
                        </ul>
                        <p>📌 Mong các bạn sắp xếp thời gian hợp lý để tránh ảnh hưởng đến kế hoạch học tập.</p>
                        <p>📩 Mọi thắc mắc vui lòng liên hệ với quản trị viên hoặc gửi phản hồi qua hệ thống.</p>
                        <p>Xin cảm ơn sự hợp tác của các bạn! 🙏</p>",
            "created_at" => "1/3/2025 14:33",
            "edit_at" => false
        ],
        [
            "id" => "2",
            "title" => "🎉 Vòng quay may mắn dành cho sinh viên đặt chỗ ngày 20/3!",
            "type" => "event",
            "author" => "250002",
            "pin" => false,
            "content" => "
                <p>🎁 Một cơ hội hấp dẫn đến từ doanh nghiệp đồng hành cùng khu tự học!</p>
                <p>🔹 Vào ngày <strong>20/3/2025</strong>, tất cả sinh viên <strong>có đặt chỗ hợp lệ</strong> sẽ được tham gia <strong>vòng quay may mắn</strong> với nhiều phần quà thú vị:</p>
                <ul>
                    <li>☕ Phiếu giảm giá tại căng-tin</li>
                    <li>🎧 Tai nghe Bluetooth</li>
                    <li>🎓 Voucher học bổng kỹ năng</li>
                    <li>🎉 Và nhiều phần quà khác đang chờ đón bạn!</li>
                </ul>
                <p>📌 Đừng quên đặt chỗ trước và đến đúng giờ để không bỏ lỡ cơ hội!</p>
                <p>📩 Mọi thắc mắc vui lòng liên hệ với quản trị viên hoặc gửi phản hồi qua hệ thống.</p>
                <p>Chúc bạn may mắn! 🍀</p>
            ",
            "created_at" => "18/3/2025 09:00",
            "edit_at" => false
        ],
        [
            "id" => "3",
            "title" => "📢 Tạm dừng khu tự học tầng 3 tòa H6 sáng ngày 27/3 để tổ chức phỏng vấn, tư vấn CV",
            "type" => "event",
            "author" => "250002",
            "pin" => true,
            "content" => "
                <p>🔹 Quản trị viên xin thông báo về việc <strong>tạm dừng hoạt động khu tự học tầng 3 tòa H6</strong> vào buổi sáng ngày <strong>27/3/2025</strong> để tổ chức sự kiện:</p>
                <ul>
                    <li>💼 <strong>Phỏng vấn thử và tư vấn CV</strong> dành cho sinh viên năm cuối</li>
                    <li>📍 Khu vực ảnh hưởng: <strong>tất cả các phòng học nhóm tầng 3 - tòa H6</strong></li>
                </ul>
                <p>🕑 <strong>Buổi chiều cùng ngày khu tự học hoạt động bình thường trở lại</strong>.</p>
                <p>📌 Mong các bạn thông cảm và sắp xếp kế hoạch học tập phù hợp.</p>
                <p>📩 Mọi thắc mắc vui lòng liên hệ với quản trị viên hoặc gửi phản hồi qua hệ thống.</p>
                <p>Xin cảm ơn sự hợp tác của các bạn! 🙏</p>
            ",
            "created_at" => "25/3/2025 08:45",
            "edit_at" => "25/3/2025 9:15"
        ],
        [
            "id" => "4",
            "title" => "😄 [Thông báo khẩn] Tòa H1 sẽ được thay bằng tàu không gian!",
            "type" => "fun",
            "author" => "250001",
            "pin" => false,
            "content" => "
                <p>🚀 Theo thông báo mới nhận từ Bộ phận Không gian & Giải trí HCMUT, <strong>tòa nhà H1</strong> sẽ được thay thế bằng một <strong>tàu không gian đa năng</strong> nhằm phục vụ nhu cầu học tập trong môi trường không trọng lực.</p>
                <p>👨‍🚀 Sinh viên tham gia lớp học tại tòa H1 vui lòng chuẩn bị:</p>
                <ul>
                    <li>🌌 Quần áo phi hành gia</li>
                    <li>🥤 Nước uống đóng túi</li>
                    <li>🔗 Tinh thần sẵn sàng để học tập trong điều kiện... bay lơ lửng</li>
                </ul>
                <p>📌 Thời gian triển khai: 01/04/2025 – đến khi tỉnh lại 😄</p>
                <p>🎉 Chúc các bạn một ngày học tập thật vui vẻ và nhiều tiếng cười!</p>
                <p>🧠 Ghi chú: Đừng tin mọi thứ bạn đọc hôm nay nhé, <strong>April Fool's Day!</strong> 😜</p>
            ",
            "created_at" => "01/4/2025 07:30",
            "edit_at" => false
        ],
        [
            "id" => "5",
            "title" => "📚 Hội sách sinh viên tại khu tự học tầng 1 – tòa H1!",
            "type" => "event",
            "author" => "250002",
            "pin" => false,
            "content" => "
                <p>📢 Kính mời các bạn sinh viên đến tham gia <strong>Hội sách sinh viên</strong> được tổ chức tại <strong>khu tự học tầng 1, tòa H1</strong>.</p>
                <ul>
                    <li>🗓 <strong>Thời gian:</strong> 8:00 – 17:00, ngày <strong>5/4/2025</strong></li>
                    <li>📍 <strong>Địa điểm:</strong> Khu tự học tầng 1 – Tòa nhà H1</li>
                    <li>📘 <strong>Hoạt động:</strong> trao đổi sách cũ, mua sách giảm giá, giao lưu với tác giả, tặng bookmark handmade...</li>
                </ul>
                <p>🎁 Đặc biệt: Mỗi bạn check-in tại hội sách sẽ nhận được 1 phần quà nhỏ xinh từ BTC!</p>
                <p>📌 Hãy cùng lan tỏa văn hóa đọc và chia sẻ tri thức nhé!</p>
                <p>📩 Mọi chi tiết vui lòng theo dõi tại bảng thông báo hoặc liên hệ trực tiếp quản trị viên.</p>
            ",
            "created_at" => "05/4/2025 09:00",
            "edit_at" => false
        ],        
        [
            "id" => "6",
            "title" => "Thông báo lịch nghỉ 30/4 và 1/5 năm 2025",
            "type" => "close",
            "author" => "250004",
            "pin" => true,
            "content" => "
                        <p>🔹 Quản trị viên xin thông báo về Lịch nghỉ lễ 30/4 Giải phóng miền Nam thống nhất đất nước và Quốc tế Lao động 1/5:</p>
                        <ul>
                            <li><strong>Thời gian nghỉ:</strong> Từ thứ Tư 30/4 đến hết Chủ nhật 3/5</li>
                            <li><strong>Ngày hoạt động trở lại:</strong> 4/5/2025</li>
                        </ul>
                        <p>📌 Chúc các bạn có kỳ nghỉ lễ an lành bên gia đình.</p>
                        <p>📩 Mọi thắc mắc vui lòng liên hệ với quản trị viên hoặc gửi phản hồi qua hệ thống.</p>
                        <p>Xin cảm ơn sự hợp tác của các bạn! 🙏</p>
                        <strong>VIỆT NAM QUANG VINH - MUÔN NĂM</strong>",
            "created_at" => "20/4/2025 14:33",
            "edit_at" => false
        ],

    ];


    public function AddNotificationForAllUsers(string $type, string $title, string $message, array $data = []): array {
        if (empty($type) || empty($title) || empty($message)) {
            return [];
        }
        $users = new Users();  
        $receiverIds = [];
        $staffs = $users->getStaffsList();
        foreach ($staffs as $staff) {
            if (!empty($staff["id"])) {
                $receiverIds[] = $staff["id"];
            }
        }
        $reflection = new ReflectionClass($users);
        $property = $reflection->getProperty("HCMUTs");
        $property->setAccessible(true);
        $hcmutUsers = $property->getValue($users);
        foreach ($hcmutUsers as $user) {
            if (!empty($user["BKNetID"])) {
                $receiverIds[] = $user["BKNetID"];
            }
        }
        $receiverIds = array_unique($receiverIds);
        $newNotifications = [];
        foreach ($receiverIds as $receiverUserId) {
            $id = uniqid("noti_");
            $newNoti = [
                "id" => $id,
                "receiver_user_id" => $receiverUserId,
                "type" => $type,
                "title" => $title,
                "message" => $message,
                "data" => $data,
                "is_read" => false,
                "created_at" => date("Y-m-d H:i:s")
            ];
            $this->NotificationList[] = $newNoti;
            $newNotifications[] = $newNoti;
        }
        return $newNotifications;
    }
    
    public function __construct() {
        if (isset($_SESSION["Notification"])) {
            $this->NotificationList = $_SESSION["Notification"];
        }
        if (isset($_SESSION["GenNote"])) {
            $this->GeneralNotification = $_SESSION["GenNote"];
        }
    }

    // NotificationList
    public function AddNotification(string $receiverUserId, string $type, string $title, string $message, array $data = []) {
        if (empty($receiverUserId) || empty($type) || empty($title) || empty($message)) {
            return false;
        }

        $id = uniqid("noti_");
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $newNoti = [
            "id" => $id,
            "receiver_id" => $receiverUserId,
            "type" => $type,
            "title" => $title,
            "message" => $message,
            "data" => $data,
            "is_read" => false,
            "created_at" =>  date("d/m/Y H:i")
        ];
        $this->NotificationList[] = $newNoti;
        $_SESSION["Notification"] =$this->NotificationList;
        return $newNoti;
    }

    public function GetNotificationsByReceiver(string $receiverUserId): array {
        $result = [];
        foreach ($this->NotificationList as $noti) {
            if (isset($noti["receiver_id"]) && $noti["receiver_id"] === $receiverUserId) {
                $result[] = $noti;
            }
        }
        return $result;
    }

    public function GetUnreadNotificationsByReceiver(string $receiverUserId): array {
        $unread = [];
        foreach ($this->NotificationList as $noti) {
            if (isset($noti["receiver_id"], $noti["is_read"]) &&
                $noti["receiver_id"] === $receiverUserId &&
                $noti["is_read"] === false) 
            {
                $unread[] = $noti;
            }
        }
        return $unread;
    }

    public function GetUnreadCount(string $receiverUserId): int {
        $count = 0;
        foreach ($this->NotificationList as $noti) {
             if (isset($noti["receiver_id"], $noti["is_read"]) &&
                 $noti["receiver_id"] === $receiverUserId &&
                 $noti["is_read"] === false) {
                $count++;
            }
        }
        return $count;
    }

    public function MarkAsRead(string $notificationId): bool {
        foreach ($this->NotificationList as &$noti) {
            if (isset($noti["id"]) && $noti["id"] === $notificationId) {
                if (isset($noti["is_read"]) && $noti["is_read"] === false) {
                    $noti["is_read"] = true;
                }
                $_SESSION["Notification"] =$this->NotificationList;
                return true;
            }
        }
        unset($noti);
        return false;
    }

    public function MarkAllAsRead(string $receiverUserId): bool {
        $updated = false;
        foreach ($this->NotificationList as &$noti) {
            if (isset($noti["receiver_id"], $noti["is_read"]) &&
                $noti["receiver_id"] === $receiverUserId &&
                $noti["is_read"] === false) {
                $noti["is_read"] = true;
                $updated = true;
            }
        }
        $_SESSION["Notification"] =$this->NotificationList;
        unset($noti);
        return $updated;
    }

    public function DeleteNotification(string $notificationId, string $receiverUserId): bool {
        foreach ($this->NotificationList as $index => $noti) {
            if (isset($noti["id"], $noti["receiver_id"]) &&
                $noti["id"] === $notificationId &&
                $noti["receiver_id"] === $receiverUserId) {
                unset($this->NotificationList[$index]);
                $_SESSION["Notification"] =$this->NotificationList;
                return true;
            }
        }
        return false;
    }
    public function GetAllNotifications(): array {
        return $this->NotificationList;
    }
    public function DeleteAllNotificationsForReceiver(string $receiverUserId): bool {
        $initialCount = count($this->NotificationList);
        $this->NotificationList = array_filter($this->NotificationList, function($noti) use ($receiverUserId) {
             return !(isset($noti["receiver_id"]) && $noti["receiver_id"] === $receiverUserId);
        });
        $_SESSION["Notification"] =$this->NotificationList;
        return count($this->NotificationList) < $initialCount;
    }


    // GeneralNotification
    public function AddGenNotification (string $title, string $type, string $author, string $content) {
        $id = count($this->GeneralNotification);
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $newNoti = [
            "id" => $id + 1,
            "type" => $type,
            "title" => $title,
            "content" => $content,
            "author" => $author,
            "pin" => false,
            "is_read" => false,
            "edit_at" => null,
            "created_at" =>  date("d/m/Y H:i")
        ];
        $this->GeneralNotification[] = $newNoti;
        $_SESSION["GenNote"] =$this->GeneralNotification;
        return true;
    }

    public function GetAllGenNotification () {
        return $this->GeneralNotification;
    }

    public function GetNearestGenNotification () {
        $reversed = array_reverse($this->GeneralNotification);
        $reversed = array_slice($reversed, 0, 5);
        $firstNearest = [];
        foreach ($reversed as $note) {
            if ($note["pin"] == false)
                $firstNearest[] = $note;
        }
        return $firstNearest;
    }

    public function GetGenNotificationByID (string $noteID) {
        foreach ($this->GeneralNotification as $note) {
            if ($note["id"] == $noteID) {
                return $note;
            }
        }
        return false;
    }

    public function GetPinGenNotification () {
        $pinnedList = [];
        foreach ($this->GeneralNotification as $note) {
            if ($note["pin"] == true) {
                $pinnedList[] = $note;
            }
        }
        $pinnedList = array_reverse($pinnedList);
        return $pinnedList;
    }

    public function EditGenNotificationByID (string $noteID, string $title, string $type, string $content) {
        foreach ($this->GeneralNotification as &$note) {
            if ($note["id"] == $noteID) {
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                $note["title"] = $title;
                $note["type"] = $type;
                $note["content"] = $content;
                $note["edit_at"] = date("d/m/Y H:i");
                $_SESSION["GenNote"] =$this->GeneralNotification;
                return true;
            }
        }
        return false;
    }

    public function PinGenNotificationByID (string $noteID) {
        foreach ($this->GeneralNotification as &$note) {
            if ($note["id"] == $noteID) {
                $note["pin"] = true;
                $_SESSION["GenNote"] =$this->GeneralNotification;
                return true;
            }
        }
        return false;
    }
    public function UnpinGenNotificationByID (string $noteID) {
        foreach ($this->GeneralNotification as &$note) {
            if ($note["id"] == $noteID) {
                $note["pin"] = false;
                $_SESSION["GenNote"] =$this->GeneralNotification;
                return true;
            }
        }
        return false;
    }
}

?>