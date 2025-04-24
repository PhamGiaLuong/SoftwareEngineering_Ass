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

    <!-- Thanh hoạt động -->
    <div class="col-12 d-flex flex-wrap justify-content-md-end justify-content-between gap-2">
        <div class="d-grid col-12 col-md-3">
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
        <div class="d-grid col-12 col-md-3">
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

    <!-- Danh sách bài viết -->
    <div class="col-12 my-2" id="postList">
        <div class="overflow-x-auto col-12">
            <table class="table table-hover table-bordered mt-1">
                <thead class="table-dark custom-thead">
                    <tr>
                        <th style="width: 300px;">Tên bài viết</th>
                        <th style="width: 200px;">Chủ đề</th>
                        <th style="width: 200px;">Tác giả</th>
                        <th style="width: 150px;">Thời gian</th>
                        <th style="width: 150px;">Trạng thái</th>
                        <th style="width: 150px;">Phản hồi</th>
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
</div>


    <!-- Hiển thị thông báo động cho người dùng -->
    <div id="toastBox" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
    </div>
<?php include('footer.php'); ?>