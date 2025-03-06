<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "./Models/users.php";

class Forums {
    private $Forums = [
        [
            "id" => "1",
            "title" => "Trải nghiệm phòng học nhóm tại thư viện",
            "topic" => "Phòng học nhóm",
            "author" => "2211960",
            "time" => "14/2/2025 16:45",
            "status" => "Đang mở",
            "content" => "<p>Hôm nay nhóm mình có dịp sử dụng phòng học nhóm trong thư viện và mình muốn chia sẻ trải nghiệm cho mọi người! 📚👥</p>
                          <p><strong>Không gian:</strong> Phòng khá rộng, có thể chứa từ 5-10 người, bàn ghế sắp xếp linh hoạt, có bảng trắng để ghi chú rất tiện lợi. 📝</p>
                          <p><strong>Tiện ích:</strong> Wifi ổn định, có điều hòa mát mẻ, cách âm khá tốt nên có thể trao đổi thoải mái mà không lo làm phiền người khác. 🔇</p>
                          <p><strong>Điểm trừ:</strong> Phòng khá hot, phải đặt trước nếu không sẽ hết chỗ nhanh. Ngoài ra, có một số phòng ánh sáng hơi yếu. 😅</p>
                          <p><strong>Đánh giá chung:</strong> 8.5/10. Rất phù hợp cho nhóm bạn nào cần không gian riêng để thảo luận bài tập hoặc làm project! 💡</p>",
            "replies" => [
                ["author" => "2212123", "time" => "15/2/2025 14:30", "content" => "Mình thấy rất ok, nhưng mong có thêm khu vực yên tĩnh hơn!"],
                ["author" => "2211816", "time" => "17/2/2025 21:12", "content" => "Đúng rồi! Hôm trước nhóm mình cũng phải đặt trước 2 ngày mới có phòng."]
            ]
        ],        
        [
            "id" => "2",
            "title" => "con bò ăn cỏ",
            "topic" => "Hỗ trợ và giải đáp thắc mắc",
            "author" => "2211960",
            "time" => "20/2/2025 13:05",
            "status" => "Đang mở",
            "content" => '
                    <p>Hôm nay đi học <strong>mình thấy</strong> con bò đang ăn cỏ</p>
                    <img src="https://nuoibo.vn/wp-content/uploads/2022/09/hinh-anh-con-bo-cuoi-dep_024431472.jpg" alt="Hình ảnh con bò" width="90%">
                ',
            "replies" => [
                ["author" => "2211816", "time" => "5/3/2025 14:05", "content" => "Bò nhà ai thế?"],
                ["author" => "2210615", "time" => "5/3/2025 17:33", "content" => "Bò ăn cỏ là chuyện bình thường."]
            ]
        ],
        [
            "id" => "3",
            "title" => "Review phòng học tự học mới tại tòa H6",
            "topic" => "Review Không gian học tập",
            "author" => "2113612",
            "time" => "21/2/2025 11:35",
            "status" => "Đang mở",
            "content" => "<p>Hôm nay mình vừa trải nghiệm phòng học tự học mới ở tòa B và muốn chia sẻ một chút cảm nhận! 📚✨</p>
                          <p><strong>Không gian:</strong> Rộng rãi, sáng sủa, có nhiều bàn ghế thoải mái. Mỗi bàn còn có ổ cắm điện nên rất tiện cho việc sử dụng laptop. 😍</p>
                          <p><strong>Tiện ích:</strong> Có điều hòa, wifi mạnh, nước uống miễn phí. Đặc biệt, phòng khá yên tĩnh, phù hợp để tập trung học tập. 📖</p>
                          <p><strong>Điểm trừ:</strong> Vì phòng mới nên hơi đông, đôi khi khó tìm được chỗ ngồi nếu đến trễ. 😅</p>
                          <p><strong>Đánh giá chung:</strong> 9/10. Rất đáng để thử! Nếu bạn nào đang tìm không gian học tập lý tưởng thì có thể ghé qua nhé. 🏫</p>",
            "replies" => [
                ["author" => "2151052", "time" => "27/2/2025 17:46", "content" => "Mình cũng thấy phòng này khá tốt, nhưng hơi đông vào buổi tối!"]
            ]
        ],        
        [
            "id" => "4",
            "title" => "Tuyển cộng tác viên trực vệ sinh Tầng 3 - Tòa H6",
            "topic" => "Công tác xã hội và điểm rèn luyện",
            "author" => "250002",
            "time" => "25/2/2025 14:03",
            "status" => "Đang mở",
            "content" => '
                <p>Gửi các bạn sinh viên, </p>
                <p>
                    Nhằm giữ gìn môi trường học tập sạch đẹp và nâng cao ý thức bảo vệ không gian chung,
                    Phòng Quản trị thiết bị thông báo tuyển cộng tác viên trực vệ sinh Tầng 3 - Tòa H6 với thông tin như sau:
                </p>
                <ul>
                    <li>Ca 1 (7h - 10h, ngày 28/2/2025): 3 sinh viên</li>
                    <li>Ca 2 (10h - 13h, ngày 28/2/2025): 3 sinh viên</li>
                    <li>Ca 3 (13h - 16h, ngày 28/2/2025): 3 sinh viên</li>
                    <li>Ca 4 (16h - 19h, ngày 28/2/2025): 3 sinh viên</li>
                </ul>
                <p>Quyền lợi: 0.5 ngày CTXH và 5 ddieermd rèn luyện cho một ca</p>
                <p>Cách đăng ký: phản hồi ngay dưới bài viết với cú pháp <strong>"MSSV - Ca"</strong></p>
                <p>Trân trọng!</p>
            ',
            "replies" => [
                ["author" => "2211816", "time" => "25/2/2025 14:20", "content" => "2211816 - Ca 1,3"],
                ["author" => "2211960", "time" => "25/2/2025 14:35", "content" => "2211960 - Ca 2,4"],
                ["author" => "2210615", "time" => "25/2/2025 14:20", "content" => "2210615 - Ca 1,3"],
                ["author" => "2053079", "time" => "25/2/2025 15:15", "content" => "2053079 - Ca 2,4"],
                ["author" => "2213321", "time" => "26/2/2025 6:35", "content" => "2213321 - Ca 3,4"],
                ["author" => "2251001", "time" => "26/2/2025 7:45", "content" => "2251001 - Ca 1,2"]
            ]
        ],
        [
            "id" => "5",
            "title" => "Âm nhạc khơi nguồn cảm xúc",
            "topic" => "Khác",
            "author" => "2211816",
            "time" => "28/2/2025 8:25",
            "status" => "Đang mở",
            "content" => '
                <h3>Để xóa tan mệt mỏi sau giờ học, mình cùng nghe nhạc nha</h3>
                <div style="max-width: 650px;" data-ephox-embed-iri="https://youtu.be/HsuvwJrCs2g?si=RXYruJ3iMSzshzNn">
                    <div style="position: relative; width: 100%; height: 0; padding-bottom: 56.25%;">
                        <iframe 
                            src="https://www.youtube.com/embed/I4CewvvhLgc?rel=0" 
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" 
                            scrolling="no" 
                            allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
                <p>Chúc các bạn một ngày mới tốt lành sành điệu</p>
            ',
            "replies" => [
                ["author" => "2053079", "time" => "5/3/2025", "content" => "Cảm ơn bạn nhé, nhạc hay quá!"]
            ]
        ],
        [
            "id" => "6",
            "title" => "Tìm bạn học",
            "topic" => "Tìm bạn học chung",
            "author" => "2121221",
            "time" => "28/2/2025 10:00",
            "status" => "Đang mở",
            "content" => "<p>Việc học một mình đôi khi có thể khiến chúng ta cảm thấy chán nản và kém hiệu quả. 
                            Vì thế, mình muốn tìm một người bạn để học chung, cùng nhau giải quyết bài tập, 
                            thảo luận kiến thức và giữ động lực học tập lâu dài. 📖✨</p>
                          <p><strong>Bạn có đang tìm kiếm một người đồng hành trong việc học không?</strong> Nếu có, 
                          hãy cùng nhau lập nhóm, trao đổi tài liệu và giúp đỡ nhau để đạt kết quả tốt hơn nhé! 😃</p>",
            "replies" => [
                ["author" => "2053079", "time" => "28/2/2025 10:26", "content" => "Ý tưởng hay đó! Mình cũng đang tìm người cùng học, chúng ta có thể lập nhóm không?"]
            ]
        ],        
        [
            "id" => "7",
            "title" => "cây hướng dương nở hoa",
            "topic" => "Khác",
            "author" => "2053079",
            "time" => "1/3/2025 13:05",
            "status" => "Đang mở",
            "content" => "<p>Lúc nãy mình thấy một cây hướng dương nở ra hoa hồng</p>",
            "replies" => [] // Không có phản hồi nào
        ],
        [
            "id" => "8",
            "title" => "Tuyển cộng tác viên quản lý khu tự học",
            "topic" => "Công tác xã hội và điểm rèn luyện",
            "author" => "250004",
            "time" => "4/3/2025 12:31",
            "status" => "Đã khóa",
            "content" => '
                <p>Gửi các bạn sinh viên, </p>
                <p>
                    Vì lý do thiếu nhân sự, hiện tại Phòng Quản trị thiết bị mở đăng kí cho sinh viên đang theo học tại trường
                    đăng kí làm nhân viên Quản lý của khu tự học Tầng 1 - Tòa H1 với thông tin như sau:
                </p>
                <ul>
                    <li>Ca 1 (6h - 11h, ngày 6/3/2025): 2 sinh viên</li>
                    <li>Ca 2 (12h - 17h, ngày 6/3/2025): 2 sinh viên</li>
                    <li>Ca 3 (17h - 20h, ngày 6/3/2025): 2 sinh viên</li>
                    <li>Ca 4 (6h - 11h, ngày 7/3/2025): 2 sinh viên</li>
                </ul>
                <p>Quyền lợi: 0.5 ngày CTXH/ca</p>
                <p>Cách đăng ký: phản hồi ngay dưới bài viết với cú pháp <strong>"MSSV - Ca"</strong></p>
                <p>Trân trọng!</p>
            ',
            "replies" => [
                ["author" => "2211816", "time" => "4/3/2025 13:05", "content" => "2211816 - Ca 1,2,4"],
                ["author" => "2151052", "time" => "4/3/2025 13:10", "content" => "2210615 - Ca 2,3,4"],
                ["author" => "2211960", "time" => "4/3/2025 13:12", "content" => "2211960 - Ca 1,3"]
            ]
        ],
        [
            "id" => "9",
            "title" => "Review khu tự học Tòa H1 - Trải nghiệm thực tế",
            "topic" => "Review Không gian học tập",
            "author" => "251102",
            "time" => "5/3/2025 10:00",
            "status" => "Đang mở",
            "content" => '
                <p>Xin chào các bạn sinh viên,</p>
                <p>
                    Hôm nay mình muốn chia sẻ một chút trải nghiệm của mình khi sử dụng khu tự học tại Tòa H1.
                    Đây là một không gian học tập khá lý tưởng, nhưng vẫn có một số điểm cần cải thiện.
                </p>
                <h4>⭐ Ưu điểm:</h4>
                <ul>
                    <li>Không gian rộng rãi, bàn ghế thoải mái.</li>
                    <li>Có ổ cắm điện ở nhiều vị trí.</li>
                    <li>Wifi mạnh, phù hợp làm việc nhóm hoặc nghiên cứu.</li>
                    <li>Có nhân viên quản lý hỗ trợ khi cần.</li>
                </ul>
                <h4>⚠️ Nhược điểm:</h4>
                <ul>
                    <li>Đôi khi hơi ồn do một số nhóm sinh viên nói chuyện lớn.</li>
                    <li>Một số bàn ghế có dấu hiệu xuống cấp, cần bảo trì.</li>
                    <li>Thời gian mở cửa hơi hạn chế, nếu mở đến 22h thì tốt hơn.</li>
                </ul>
                <p>
                    Các bạn đã từng học ở đây chưa? Nếu có góp ý hay đề xuất gì, hãy để lại phản hồi ngay dưới bài viết nhé!
                </p>
                <p>Trân trọng!</p>
            ',
            "replies" => [
                ["author" => "2212123", "time" => "5/3/2025 14:30", "content" => "Mình thấy rất ok, nhưng mong có thêm khu vực yên tĩnh hơn!"],
                ["author" => "2121221", "time" => "5/3/2025 14:45", "content" => "Ghế hơi cứng, nếu có đệm lót sẽ tốt hơn."],
                ["author" => "2251001", "time" => "5/3/2025 15:00", "content" => "Chỗ này khá đẹp, nhưng đông quá thì hơi ồn."]
            ]
        ],
        [
            "id" => "10",
            "title" => "Trải nghiệm học tập tại Phòng học đôi - Có đáng thử?",
            "topic" => "Phòng học đôi",
            "author" => "2211816",
            "time" => "5/3/2025 11:15",
            "status" => "Đang mở",
            "content" => '
                <p>Xin chào các bạn sinh viên,</p>
                <p>
                    Nếu bạn đã từng muốn có một không gian yên tĩnh hơn để học tập mà không bị ảnh hưởng bởi đám đông,
                    thì Phòng học đôi có thể là một lựa chọn tuyệt vời. Hôm nay, mình sẽ chia sẻ một số trải nghiệm khi sử dụng loại phòng này.
                </p>
                <h4>✅ Ưu điểm:</h4>
                <ul>
                    <li>Không gian riêng tư, phù hợp cho các cặp bạn thân hoặc nhóm nhỏ làm việc.</li>
                    <li>Bàn ghế thoải mái, có đủ chỗ cho laptop, sách vở.</li>
                    <li>Có ổ cắm điện ngay tại bàn.</li>
                    <li>Đăng ký trước giúp đảm bảo chỗ ngồi, không lo hết chỗ.</li>
                </ul>
                <h4>⚠️ Nhược điểm:</h4>
                <ul>
                    <li>Thời gian sử dụng bị giới hạn, cần đăng ký trước.</li>
                    <li>Số lượng phòng ít, dễ hết chỗ vào giờ cao điểm.</li>
                    <li>Không thích hợp với những ai muốn học một mình hoàn toàn yên tĩnh.</li>
                </ul>
                <p>
                    Nếu bạn đã từng sử dụng Phòng học đôi, hãy chia sẻ cảm nhận của bạn nhé! Liệu đây có phải là không gian học tập lý tưởng cho bạn không?
                </p>
                <p>Trân trọng!</p>
            ',
            "replies" => [
                ["author" => "2113612", "time" => "6/3/2025 10:45", "content" => "Mình thấy khá tiện, nhưng nếu có thể đặt trước online thì tốt hơn!"],
                ["author" => "2251001", "time" => "6/3/2025 11:00", "content" => "Hơi ít phòng quá, có hôm mình đăng ký mà không còn chỗ."],
                ["author" => "2212123", "time" => "6/3/2025 11:15", "content" => "Không gian đẹp, nhưng nên có thêm điều hòa cho mùa hè."]
            ]
        ],
        [
            "id" => "11",
            "title" => "Công tác xã hội có ảnh hưởng thế nào đến điểm rèn luyện?",
            "topic" => "Công tác xã hội và điểm rèn luyện",
            "author" => "250002",
            "time" => "6/3/2025 18:30",
            "status" => "Đang mở",
            "content" => "<p>Nhiều bạn sinh viên thắc mắc liệu tham gia công tác xã hội có giúp cải thiện điểm rèn luyện không? Câu trả lời là <strong>CÓ!</strong> 🎉</p>
                          <p><strong>1. Công tác xã hội là gì?</strong> 🏥🌱</p>
                          <p>Công tác xã hội bao gồm các hoạt động tình nguyện như giúp đỡ trẻ em có hoàn cảnh khó khăn, bảo vệ môi trường, hiến máu nhân đạo hoặc hỗ trợ các chương trình của Đoàn – Hội.</p>
                          <p><strong>2. Ảnh hưởng đến điểm rèn luyện 📊</strong></p>
                          <p>Tham gia các hoạt động này giúp bạn đạt điểm cao hơn trong phần <em>Ý thức tham gia hoạt động chung</em>. Ngoài ra, nếu bạn là thành viên tích cực hoặc ban tổ chức, điểm rèn luyện còn tăng thêm!</p>
                          <p><strong>3. Lợi ích khác ngoài điểm số 🤝</strong></p>
                          <p>Bạn sẽ học được kỹ năng làm việc nhóm, giao tiếp, quản lý thời gian, và đặc biệt là có thêm nhiều mối quan hệ mới. ❤️</p>
                          <p><strong>Kết luận:</strong> Nếu có cơ hội, hãy tham gia ngay một hoạt động công tác xã hội! Vừa giúp ích cho cộng đồng, vừa cải thiện điểm rèn luyện của bạn! 💪</p>",
            "replies" => [
                ["author" => "2251001", "time" => "6/3/2025 19:02", "content" => "Mình từng tham gia chương trình hiến máu và được cộng điểm rèn luyện nè!"],
                ["author" => "2121221", "time" => "6/3/2025 21:22", "content" => "Hoạt động tình nguyện ở trường khá thú vị, mình thấy còn giúp phát triển kỹ năng cá nhân nữa."],
                ["author" => "2212123", "time" => "6/3/2025 6:17", "content" => "Có danh sách cụ thể các hoạt động nào được cộng điểm rèn luyện không nhỉ?"],
                ["author" => "2111025", "time" => "7/3/2025 11:35", "content" => "Tham gia công tác xã hội còn giúp mở rộng mối quan hệ, rất có lợi cho tương lai."],
                ["author" => "2210615", "time" => "7/3/2025 13:51", "content" => "Mình từng là ban tổ chức của chiến dịch Mùa Hè Xanh, được cộng nhiều điểm lắm 😁."],
                ["author" => "2113612", "time" => "8/3/2025 22:30", "content" => "Không chỉ giúp tăng điểm, tham gia công tác xã hội còn là cơ hội trải nghiệm thực tế đáng quý."]
            ]
        ],
        [
            "id" => "12",
            "title" => "Âm nhạc tiếp thêm năng lượng",
            "topic" => "Khác",
            "author" => "2211960",
            "time" => "7/3/2025 10:00",
            "status" => "Đang mở",
            "content" => '
                <h3>Âm nhạc tiếp thêm năng lượng</h3>
                <p>💙 Đôi khi, một giai điệu hay có thể làm bừng sáng cả một ngày dài.</p>
                <p>🌿 Sau những giờ học căng thẳng, hãy cùng nhau thư giãn với một bản nhạc nhẹ nhàng nhé!</p>
                <div style="max-width: 650px;" data-ephox-embed-iri="https://youtu.be/pZh-Q8wfwU8?si=4CcCKrY6r55kALHV">
                    <div style="position: relative; width: 100%; height: 0; padding-bottom: 56.25%;">
                        <iframe 
                            src="https://www.youtube.com/embed/pZh-Q8wfwU8?rel=0" 
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" 
                            scrolling="no" 
                            allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
                <p>🎵 <strong>Âm nhạc không chỉ giúp chúng ta thư giãn mà còn khơi dậy cảm hứng học tập, sáng tạo.</strong> Hãy thử vừa học vừa nghe nhạc để cảm nhận sự khác biệt!</p>
                <p>📢 Bạn có bài hát nào yêu thích không? Chia sẻ cùng mọi người nhé!</p>
            ',
            "replies" => [
                ["author" => "2151052", "time" => "7/3/2025 11:13", "content" => "Nhạc chill quá, cảm ơn bạn!"],
                ["author" => "2213321", "time" => "7/3/2025 12:34", "content" => "Mình hay nghe khi ôn tập, rất tập trung!"]
            ]
        ]
        
    ];   
    
    
    public function __construct() {
        if (isset($_SESSION["Forums"])) {
            $this->Forums = $_SESSION["Forums"];
        }
    }

    public function addNewPost($post) {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $post["id"] = count($this->Forums) + 1;
        $post["time"] = date("d/m/Y H:i");
        $post["status"] = "Đang mở";
        $post["replies"] = [];

        $this->Forums[] = $post;
        $_SESSION["Forums"] = $this->Forums;
        return true;
    }

    public function addNewReply($reply) {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $newRep = [
            "time" => date("d/m/Y H:i"),
            "author" => $reply["author"],
            "content" => $reply["content"]
        ];

        foreach ($this->Forums as &$post) {
            if ($post["id"] == $reply["id"]) {
                $post["replies"][] = $newRep;
                $_SESSION["Forums"] = $this->Forums;
                return true;
            }
        }
        return false;
    }

    public function getAllPosts() {
        if (isset($_SESSION["Forums"])) {
            $this->Forums = $_SESSION["Forums"];
        }
        $result = $this->Forums;
        $user = new Users(); 

        foreach ($result as &$post) {
            $post["author"] = $user->getUserByID($post["author"]);
        }
    
        return $result;
    }

    public function getMyOwnPosts() {
        if (isset($_SESSION["Forums"])) {
            $this->Forums = $_SESSION["Forums"];
        }
        $result = null;
        $user = new Users(); 
        $author = $user->getUserByID($_SESSION["userID"]);
        foreach ($this->Forums as $post) {
            if ($post["author"] == $_SESSION["userID"]){
                $post["author"] = $author;
                $result [] = $post;
            }
        }
    
        return $result;
    }

    public function getPostByID($ID) {
        foreach ($this->Forums as &$post) {
            if ($post["id"] == $ID){
                $user = new Users(); 
                $post["author"] = $user->getUserByID($post["author"]);
                return $post;
            }
        }
        return null;
    }

    public function getPostsByTopic($topic) {
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

        if ($topic === "all") {
            return json_encode($this->getAllPosts());
        }

        if ($topic === "mine") {
            return json_encode($this->getMyOwnPosts());
        }

        $topicName = $topic;
        if (isset($topics[$topic])) {
            $topicName = $topics[$topic];
        }

        $result = [];
        $user = new Users(); 
        foreach ($this->Forums as $post) {
            if ($post["topic"] === $topicName) {
                $post["author"] = $user->getUserByID($post["author"]);
                $result[] = $post;
            }
        }
    
        return count($result) > 0 ? json_encode($result) : json_encode(["error" => "Không có bài viết về chủ đề này"]);
    }
    

    public function getPostDetail($postID) {
        $result = null;
        foreach ($this->Forums as $post) {
            if ($post["id"] == $postID){
                $result = $post;

                $user = new Users();
                $result["author"] = $user->getUserByID($post["author"]);

                // Cập nhật replies
                foreach ($result["replies"] as $key => $reply) {
                    $user = new Users();
                    $result["replies"][$key]["author"] = $user->getUserByID($reply["author"]);
                }

                return $result;
            }
        }
        return null;
    }

    public function lockPost($postID) {
        foreach ($this->Forums as &$post) {
            if ($post["id"] == $postID) {
                $post["status"] = "Đã khóa";
                $_SESSION["Forums"] = $this->Forums;
                return true;
            }
        }
        return false;
    }
    public function unlockPost($postID) {
        foreach ($this->Forums as &$post) {
            if ($post["id"] == $postID) {
                $post["status"] = "Đang mở";
                $_SESSION["Forums"] = $this->Forums;
                return true;
            }
        }
        return false;
    }

}

?>