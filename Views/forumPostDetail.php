<!-- 
    Author: Gia Luong
 -->
<?php  
    // Điều hướng đến tab đăng nhập nếu chưa
    if (!isset($_SESSION["Role"])) {
        header("Location: /SE_Ass_Code/index.php?url=loginOption");
        exit();
    }
    include('header.php'); 
?>
<div class="container mt-3 d-flex flex-wrap justify-content-center">
    <div class="d-flex justify-content-center col-12 mb-3">
        <a href="/SE_Ass_Code/index.php?url=forum">
            <h2>DIỄN ĐÀN S3-MRS</h2>
        </a>
    </div>

    <!-- Hiển thị thông báo thành công/thất bại nếu có -->
    <div class="alert alert-danger text-center m-3 d-flex align-items-center d-none col-12 col-md-6" role="alert" id="errorAlert">
        <div class="col-11 d-flex align-items-center gap-3">
            <i class="bi bi-exclamation-circle"></i>
            <p class="m-0" id="errorContent"></p>
        </div>
    </div>
    <div class="alert alert-success text-center m-3 d-flex align-items-center d-none col-12 col-md-6" role="alert" id="successAlert">
        <div class="col-11 d-flex align-items-center gap-3">
            <i class="bi bi-check-circle"></i>
            <p class="m-0" id="successContent"></p>
        </div>
    </div>

    <!-- Thông tin của post -->
    <div class="col-12 d-flex flex-wrap justify-content-between">
        <h3 style="font-family: 'Asap', sans-serif;">Tiêu đề: <?= $post["title"];?> </h3>
        <div class="col-12 p-2 d-flex flex-wrap justify-content-sm-between justify-content-center border rounded-2">
            <div class="col-md-5 col-9 col-sm-7 d-flex">
                <a href="#" class="topic-link" data-post-id="topic" data-topic="<?= $post['topic'] ?>">
                    <i class="bi fs-5 bi-bookmarks"></i> <?= $post["topic"];?>
                </a>
            </div>
            <div class="col-sm-3 col-9 d-flex justify-content-sm-center">
                <a href="#postReplies">
                    <i class="bi fs-5 bi-box-arrow-in-down-right"></i> <span> <?= count($post['replies']);?> phản hồi</span>
                </a>
            </div>
            <div class="col-sm-4 col-9 d-flex justify-content-sm-end">
                <?php if ($post["status"] == "Đang mở"): ?>
                    <a href="<?php echo ($_SESSION["Role"] == "admin") ? "/SE_Ass_Code/index.php?url=forum/lockPost/". $post['id'] : "#"; ?>">
                    <i class="bi fs-5 bi-toggle-off"></i> 
                <?php else: ?>
                    <a href="<?php echo ($_SESSION["Role"] == "admin") ? "/SE_Ass_Code/index.php?url=forum/unlockPost/" .$post["id"] : "#"; ?>">
                    <i class="bi fs-5 bi-toggle-on"></i>
                <?php endif; ?>
                <?= $post["status"];?>
                </a>
            </div>
        </div>
    </div>

    
    <div class="collapse col-12" id="details-topic">
        <div class="overflow-x-auto col-12 my-2">
            <table class="table table-hover table-bordered mt-1" id="postList">
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
                </tbody>
            </table>
        </div>
        <!-- Hiển thị thanh phân trang -->
        <div id="pagination"></div>
    </div>

    <!-- Nội dung và replies của post -->
    <div class="col-12 d-flex flex-wrap justify-content-between my-2">
        <!-- Post -->
        <div class="col-12 border border-2 rounded-3 p-2">
            <!-- Thông tin author -->
            <div class="col-12 d-flex">
                <div class="col-12 rounded-circle overflow-hidden border"
                        style="width: 50px; height: 50px; background: url('<?= $post["author"]["image"]; ?>') center/cover no-repeat;">
                </div>
                <div class="col-10 px-3">
                    <p class="m-0">
                        <?php if (isset($_SESSION["name"])  && $_SESSION["name"] === $post["author"]["name"]): ?>
                            <a href="/SE_Ass_Code/index.php?url=account"> 
                        <?php else: ?>
                            <a href="/SE_Ass_Code/index.php?url=account/otherInfo/<?= ($post['author']['role'] == 'admin' || $post['author']['role'] == 'staff') ? $post['author']['id'] : $post['author']['BKNetID']; ?>"> 
                        <?php endif; ?>
                            <strong><?= $post["author"]["name"];?></strong> 
                        </a>
                        <i class="opacity-50 fs-6"><?php 
                            $roles = [
                                "student" => "Sinh viên",
                                "teacher" => "Giảng viên",
                                "staff"   => "Quản lý",
                                "admin"   => "Quản trị viên"
                            ];
                            echo $roles[$post["author"]["role"]] ?? "Không xác định"; 
                        ?></i>
                    </p>
                    <small class="m-0 opacity-50"> <?= $post["time"];?></small>
                </div>
            </div>
            <!-- Nội dung -->
            <div class="col-11 col-md-12 ms-3 ps-5 mt-2">
                <?php echo htmlspecialchars_decode($post["content"]);?>
            </div>
            <div class="col-12 mt-2 d-flex justify-content-end p-2">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-main" data-bs-toggle="modal" data-bs-target="#addNewReply"
                    <?php echo ($post["status"] == "Đã khóa") ? "disabled" : ""; ?>>
                <i class="bi fs-5 bi-reply-fill"></i> Phản hồi
                </button>
            </div>
        </div>
        <!-- Popup hỗ trợ thu thập dữ liệu phản hồi bài viết -->
        <div class="modal fade" id="addNewReply" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">GỬI PHẢN HỒI BÀI VIẾT</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addNewReplyForm" method="POST">
                            <input type="hidden" name="id" value="<?= $post['id']; ?>">
                            <input type="hidden" name="author" value="<?= $_SESSION['userID']; ?>">
                            <div class="col-12 my-2">
                                <label class="form-label" for="password">Tiêu đề</label>
                                <input class="form-control" type="text" name="title" id="title" required readonly value="<?= $post["title"];?>">
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
                </div>
            </div>
        </div>

        <!-- Replies -->
        <div class="col-12 d-flex flex-wrap justify-content-end gap-2 mt-2 fade-in" id="postReplies">
            <?php foreach($post['replies'] as $reply): ?>
                <div class="col-11 border border-2 rounded-3 p-2 fade-in">
                    <!-- Thông tin author -->
                    <div class="col-12 d-flex">
                        <div class="col-12 rounded-circle overflow-hidden border"
                                style="width: 50px; height: 50px; background: url('<?= $reply["author"]["image"]; ?>') center/cover no-repeat;">
                        </div>
                        <div class="col-10 px-3">
                            <p class="m-0">
                            <?php if (isset($_SESSION["name"])  && $_SESSION["name"] === $reply["author"]["name"]): ?>
                                <a href="/SE_Ass_Code/index.php?url=account"> 
                            <?php else: ?>
                                <a href="/SE_Ass_Code/index.php?url=account/otherInfo/<?= ($reply['author']['role'] == 'admin' || $reply['author']['role'] == 'staff') ? $reply['author']['id'] : $reply['author']['BKNetID']; ?>"> 
                            <?php endif; ?>
                                <strong><?= $reply["author"]["name"];?></strong> 
                            </a>
                                <i class="opacity-50 fs-6"><?php 
                                    $roles = [
                                        "student" => "Sinh viên",
                                        "teacher" => "Giảng viên",
                                        "staff"   => "Quản lý",
                                        "admin"   => "Quản trị viên"
                                    ];
                                    echo $roles[$reply["author"]["role"]] ?? "Không xác định"; 
                                ?></i>
                            </p>
                            <small class="m-0 opacity-50"> <?= $reply["time"];?></small>
                        </div>
                    </div>
                    <!-- Nội dung -->
                    <div class="col-11 col-md-12 ms-3 ps-5">
                        <?= $reply["content"];?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

    <!-- Hiển thị thông báo động cho người dùng -->
    <div id="toastBox" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
    </div>
<?php include('footer.php'); ?>