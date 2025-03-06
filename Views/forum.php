<?php include('header.php'); ?>
<div class="container mt-3 d-flex flex-wrap justify-content-center">
    <div class="d-flex justify-content-center col-12 mb-3">
        <h2>DIỄN ĐÀN BK STUDY SPACE</h2>
    </div>

    <div class="col-12 d-flex flex-wrap justify-content-md-end justify-content-between gap-3">
        <div class="d-grid col-5 col-md-3">
            <select id="forumTopicFilter" class="form-select">
                <!-- <option disabled selected>Lựa chọn chủ đề</option> -->
                <option value="all" selected>Tất cả</option>
                <option value="mine">Của tôi</option>
                <option value="selfStudy">Phòng tự học</option>
                <option value="mentorring">Phòng học đôi</option>
                <option value="groupStudy">Phòng học nhóm</option>
                <option value="ctxh">Công tác xã hội và điểm rèn luyện</option>
                <option value="help">Hỗ trợ và giải đáp thắc mắc</option>
                <option value="studyDiscuss">Thảo luận học tập</option>
                <option value="findStudymate">Tìm bạn học chung</option>
                <option value="review">Review Không gian học tập</option>
                <option value="system">Góp ý về hệ thống</option>
                <option value="other">Khác</option>
            </select>
        </div>
        <div class="d-grid col-5 col-md-3">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-main" data-bs-toggle="modal" data-bs-target="#addNewPost">
                Tạo bài viết mới
            </button>
        </div>
    </div>

    <!-- Popup hỗ trợ thu thập dữ liệu bài viết mới -->
    <div class="modal fade" id="addNewPost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">TẠO BÀI VIẾT MỚI</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addNewPostForm" method="POST">
                        <input type="hidden" name="author" value="<?= $_SESSION["userID"]; ?>">
                        <div class="user-box">
                            <input type="text" name="title" id="title" required>
                            <label for="password">Tiêu đề</label>
                        </div>
                        <div class="col-12 my-2">
                            <label for="topic">Chủ đề</label>
                            <select class="form-select" id="topic" name="topic" aria-label="Default select example">
                                <option disabled selected>Lựa chọn chủ đề</option>
                                <option value="selfStudy">Phòng tự học</option>
                                <option value="mentorring">Phòng học đôi</option>
                                <option value="groupStudy">Phòng học nhóm</option>
                                <option value="help">Hỗ trợ và giải đáp thắc mắc</option>
                                <option value="studyDiscuss">Thảo luận học tập</option>
                                <option value="findStudymate">Tìm bạn học chung</option>
                                <option value="review">Review Không gian học tập</option>
                                <option value="system">Góp ý về hệ thống</option>
                                <option value="other">Khác</option>
                            </select>
                        </div>
                        <div class="col-12 my-2">
                            <label for="content">Nội dung</label>
                            <textarea id="form_content" name="content" placeholder="Nhập nội dung"></textarea>
                        </div>
                        <div class="col-12 d-flex flex-wrap justify-content-between mt-2">
                            <div class="col-5 d-grid">
                                <button type="reset" class="btn btn-outline-main">Nhập lại</button>
                            </div>
                            <div class="col-5 d-grid">
                                <button type="submit" class="btn btn-main">Gửi</button>
                            </div>

                        </div>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div> -->
            </div>
        </div>
    </div>

    <?php 
        $postsPerPage = 10; // Số bài viết trên mỗi trang
        $totalPages = ceil(count($posts) / $postsPerPage);
        // Xác định trang hiện tại
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, min($page, $totalPages)); // Đảm bảo giá trị trang hợp lệ

        // Đảo ngược thứ tự bài viết để lấy từ dưới lên
        $reversedPosts = array_reverse($posts);

        // Xác định vị trí bắt đầu lấy dữ liệu
        $offset = ($page - 1) * $postsPerPage;

        // Lấy danh sách bài viết của trang hiện tại từ dưới lên
        $postsToShow = array_slice($reversedPosts, $offset, $postsPerPage);

        // Lấy URL gốc
        $baseUrl = isset($_GET['url']) ? $_GET['url'] : 'forum/list'; // Mặc định là danh sách forum
    ?>
    <!-- Danh sách bài viết -->
    <div class="col-12 my-2" id="postList">
        <div class="overflow-x-auto">
            <table class="table table-hover mt-1">
                <thead class="table-dark custom-thead">
                    <tr>
                        <th style="width: 250px;">Tên bài viết</th>
                        <th style="width: 180px;">Chủ đề</th>
                        <th style="width: 150px;">Tác giả</th>
                        <th style="width: 120px;">Thời gian</th>
                        <th style="width: 100px;">Trạng thái</th>
                        <th style="width: 100px;">Phản hồi</th>
                        <?php if ($_SESSION["Role"] == "admin"): ?>
                        <th style="width: 10%;">Hành động</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($postsToShow as $post): ?>
                    <tr>
                        <td class="truncate-1"> <a href="/SE_Ass_Code/index.php?url=forum/detail/<?= $post['id']; ?>"> <?= $post['title']; ?> </a></td>
                        <td> <?= $post['topic']; ?></td>
                        <td> <?= $post['author']["name"]; ?></td>
                        <td> <?= $post['time']; ?></td>
                        <td> <?= $post['status']; ?></td>
                        <td onclick="toggleReplie(<?= $post['id']; ?>)" style="color: #030391;"> 
                            <?= count($post['replies']); ?> phản hồi
                        </td>
                        <?php if ($_SESSION["Role"] == "admin"): ?>
                        <td> 
                            <!-- <button type="submit" class="btn btn-main m-2" onclick="window.location.href='/SE_Ass_Code/index.php?url=forum/detail/<?= $post['id']; ?>'">
                                <i class="bi fs-5 bi-eye-fill"></i> Xem
                            </button> -->
                            <?php if ($post["status"] == "Đang mở"): ?>
                            <button type="submit" class="btn btn-main" onclick="window.location.href='/SE_Ass_Code/index.php?url=forum/lockPost/<?= $post['id']; ?>'">
                                <i class="bi fs-5 bi-lock-fill"></i> Khóa
                            </button>
                            <?php else: ?>
                            <button type="submit" class="btn btn-main" onclick="window.location.href='/SE_Ass_Code/index.php?url=forum/unlockPost/<?= $post['id']; ?>'">
                                <i class="bi fs-5 bi-unlock-fill"></i> Mở
                            </button>
                            <?php endif; ?>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <tr id="details-<?= $post['id']; ?>" class="collapse">
                        <td colspan="6">
                            <table class="table mb-0">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Tác giả</th>
                                        <th>Thời gian</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($post['replies'] as $reply): ?>
                                        <tr>
                                            <td><?= $reply['author']; ?></td>
                                            <td><?= $reply['time']; ?></td>
                                            <!-- <td><?= $item['status']; ?></td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Hiển thị thanh phân trang -->
            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?url=<?= $baseUrl ?>&page=<?= $page - 1 ?>">Trước</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?url=<?= $baseUrl ?>&page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?url=<?= $baseUrl ?>&page=<?= $page + 1 ?>">Tiếp</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    const userRole = "<?php echo $_SESSION['Role']; ?>"; // Lấy quyền từ PHP
</script>


<?php include('footer.php'); ?>