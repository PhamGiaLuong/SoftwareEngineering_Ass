<!-- 
    Author: The Hung
 -->
<?php 
    // Điều hướng đến tab đăng nhập nếu chưa
    if (!isset($_SESSION["Role"])) {
        header("Location: /SE_Ass_Code/index.php?url=loginOption");
        exit();
    }
    include('header.php'); 
?>

<!-- Nội dung chính -->
<div class="container">
    <!-- Tab Navigation -->
    <div class="px-2" style="background-color: #c8d6e5;">
        <ul class="nav nav-underline d-flex flex-nowrap justify-content-evenly gap-3">
            <li class="nav-item">
                <a class="nav-link text-dark text-center active" data-bs-toggle="pill" href="#bookingManage">
                    DANH SÁCH ĐẶT PHÒNG
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark text-center" data-bs-toggle="pill" href="#announcementManage">
                    THÔNG BÁO CHUNG
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark text-center" data-bs-toggle="pill" href="#activityManage">
                    BÁO CÁO HOẠT ĐỘNG
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Hiển thị thông báo thành công/thất bại nếu có -->
    <div class="alert alert-danger text-center m-3 d-flex align-items-center d-none col-11" role="alert" id="errorAlert">
        <div class="col-11 d-flex align-items-center gap-3">
            <i class="bi bi-exclamation-circle"></i>
            <p class="m-0" id="errorContent"></p>
        </div>
    </div>
    <div class="alert alert-success text-center m-3 d-flex align-items-center d-none col-11" role="alert" id="successAlert">
        <div class="col-11 d-flex align-items-center gap-3">
            <i class="bi bi-check-circle"></i>
            <p class="m-0" id="successContent"></p>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content mt-3 col-12">
        <!-- Quản lý danh sách đặt phòng -->
        <div class="tab-pane fade show active" id="bookingManage">
            <div class="d-flex justify-content-center col-12 mb-3 text-center">
                <h2>DANH SÁCH ĐẶT PHÒNG</h2>
            </div>

            <!-- Thống kê -->
            <div class="col-12 d-flex flex-wrap justify-content-between gap-3 my-2">
                <div class="col-md-5 col-lg-3 col-12 border border-2 rounded-3 p-2 d-flex flex-wrap bg-opacity-25">
                    <div class="col-4 bg-secondary d-flex flex-wrap gap-1 justify-content-center align-items-center text-white">
                        <i class="bi bi-clipboard-data fs-3"></i>
                    </div>
                    <div class="col-8 px-2 d-flex flex-wrap align-items-center">
                        <div class="col-12"><strong>THỐNG KÊ SỬ DỤNG PHÒNG TRONG HÔM NAY</strong></div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-3 col-12 border rounded-3 p-2 d-flex flex-wrap bg-success bg-opacity-25">
                    <div class="col-4 bg-success d-flex flex-wrap gap-1 justify-content-center align-items-center text-white">
                        <i class="bi bi-calendar-check fs-3"></i><strong class="col-12 text-center">Hoàn thành</strong>
                    </div>
                    <div class="col-8 px-2 d-flex flex-wrap align-items-center">
                        <div class="col-12"><strong>Phòng tự học</strong> <?= $stat["self"]["completed"]?></div>
                        <div class="col-12"><strong>Phòng học đôi</strong> <?= $stat["dual"]["completed"]?></div>
                        <div class="col-12"><strong>Phòng học nhóm</strong> <?= $stat["group"]["completed"]?></div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-3 col-12 border rounded-3 p-2 d-flex flex-wrap bg-primary bg-opacity-25">
                    <div class="col-4 bg-primary d-flex flex-wrap gap-1 justify-content-center align-items-center text-white">
                        <i class="bi bi-people fs-3"></i><strong class="col-12 text-center">Đang dùng</strong>
                    </div>
                    <div class="col-8 px-2 d-flex flex-wrap align-items-center">
                        <div class="col-12"><strong>Phòng tự học</strong> <?= $stat["self"]["using"]?></div>
                        <div class="col-12"><strong>Phòng học đôi</strong> <?= $stat["dual"]["using"]?></div>
                        <div class="col-12"><strong>Phòng học nhóm</strong> <?= $stat["group"]["using"]?></div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-3 col-12 border rounded-3 p-2 d-flex flex-wrap bg-info bg-opacity-25">
                    <div class="col-4 bg-info d-flex flex-wrap gap-1 justify-content-center align-items-center text-white">
                        <i class="bi bi-calendar fs-3"></i><strong class="col-12 text-center">Đã đặt</strong>
                    </div>
                    <div class="col-8 px-2 d-flex flex-wrap align-items-center">
                        <div class="col-12"><strong>Phòng tự học</strong> <?= $stat["self"]["scheduled"]?></div>
                        <div class="col-12"><strong>Phòng học đôi</strong> <?= $stat["dual"]["scheduled"]?></div>
                        <div class="col-12"><strong>Phòng học nhóm</strong> <?= $stat["group"]["scheduled"]?></div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-3 col-12 border rounded-3 p-2 d-flex flex-wrap bg-danger bg-opacity-25">
                    <div class="col-4 bg-danger d-flex flex-wrap gap-1 justify-content-center align-items-center text-white">
                        <i class="bi bi-stopwatch fs-3"></i><strong class="col-12 text-center">Quá hạn</strong>
                    </div>
                    <div class="col-8 px-2 d-flex flex-wrap align-items-center">
                        <div class="col-12"><strong>Phòng tự học</strong> <?= $stat["self"]["expired"]?></div>
                        <div class="col-12"><strong>Phòng học đôi</strong> <?= $stat["dual"]["expired"]?></div>
                        <div class="col-12"><strong>Phòng học nhóm</strong> <?= $stat["group"]["expired"]?></div>
                    </div>
                </div>
                <div class="col-md-5 col-lg-3 col-12 border rounded-3 p-2 d-flex flex-wrap bg-warning bg-opacity-25">
                    <div class="col-4 bg-warning d-flex flex-wrap gap-1 justify-content-center align-items-center text-white">
                        <i class="bi bi-calendar-x fs-3"></i><strong class="col-12 text-center">Đã hủy</strong>
                    </div>
                    <div class="col-8 px-2 d-flex flex-wrap align-items-center">
                        <div class="col-12"><strong>Phòng tự học</strong> <?= $stat["self"]["cancelled"]?></div>
                        <div class="col-12"><strong>Phòng học đôi</strong> <?= $stat["dual"]["cancelled"]?></div>
                        <div class="col-12"><strong>Phòng học nhóm</strong> <?= $stat["group"]["cancelled"]?></div>
                    </div>
                </div>
            </div>
        
            <div class="col-12 d-flex flex-wrap gap-2 justify-content-end align-items-center mb-2">
                <div class="p-2 border rounded-3 text-center">
                    <strong><?= $_SESSION["userID"]?> - <?= $_SESSION["name"]?></strong>
                </div>
                
                <div class="d-grid col-12 col-md-3">
                    <select id="bookingFilter" class="form-select">
                        <!-- <option disabled selected>Lựa chọn chủ đề</option> -->
                        <option value="self_study" selected>Phòng tự học</option>
                        <option value="dual">Phòng học đôi</option>
                        <option value="group">Phòng học nhóm</option>
                    </select>
                </div>
            </div>

            <!-- Bảng danh sách đặt phòng -->
            <div class="overflow-x-auto">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark custom-thead">
                        <tr>
                            <th style="width: 100px;">Mã đặt phòng</th>
                            <th style="width: 100px;">Thời gian</th>
                            <th style="width: 150px;">Người đặt</th>
                            <th style="width: 100px;">Vị trí</th>
                            <th style="width: 50px;">Số ghế</th>
                            <th style="width: 100px;">Giờ bắt đầu</th>
                            <th style="width: 100px;">Giờ kết thúc</th>
                            <th style="width: 100px;">Trạng thái</th>
                            <th style="width: 100px;">Báo cáo</th>
                        </tr>
                    </thead>
                    <tbody id="bookingTableBody">
                        <!-- Dữ liệu sẽ được thêm vào đây bằng AJAX -->
                    </tbody>
                </table>
            </div>
            <!-- Hiển thị thanh phân trang -->
            <div id="pagination"></div>

        </div>

        <!-- Quản lý thông báo chung -->
        <div class="tab-pane fade" id="announcementManage">
            <div class="d-flex justify-content-center col-12 mb-3">
                <h2>QUẢN LÝ THÔNG BÁO CHUNG</h2>
            </div>
        
            <div class="col-12 d-flex gap-2 justify-content-between align-items-center mb-2">
                <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
                    Tạo thông báo
                </button>
                
                <div class="p-2 border rounded-3 text-center">
                    <strong><?= $_SESSION["userID"]?> - <?= $_SESSION["name"]?></strong>
                </div>
            </div>

            <!-- Bảng danh sách thông báo chung -->
            <div class="overflow-x-auto">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark custom-thead">
                        <tr>
                            <!-- <th style="width: 50px;"><input type="checkbox" id="select-all" /></th> -->
                            <th style="width: 50px;">ID</th>
                            <th style="width: 250px;">Tiêu đề</th>
                            <th style="width: 200px;">Tác giả</th>
                            <th style="width: 100px;">Chủ đề</th>
                            <th style="width: 100px;">Ngày đăng</th>
                            <th style="width: 100px;">Chỉnh sửa</th>
                            <th style="width: 100px;">Ghim</th>
                        </tr>
                    </thead>
                    <tbody id="announcementTableBody">
                        <!-- Dữ liệu sẽ được thêm vào đây bằng AJAX -->
                    </tbody>
                </table>
            </div>
            <!-- Hiển thị thanh phân trang -->
            <div id="pagination"></div>
        </div>

        <!-- Quản lý báo cáo hoạt động -->
        <div class="tab-pane fade" id="activityManage">
            <div class="d-flex justify-content-center col-12 mb-3">
                <h2>QUẢN LÝ BÁO CÁO HOẠT ĐỘNG</h2>
            </div>

            <!-- Nút cho các chức năng Xem, Cập nhật, Xóa -->
            <div id="report-action-buttons" style="display: none; margin-bottom: 20px;">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewReportModal" id="view-button" disabled>Xem</button>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateStatusModal" id="update-button" disabled>Cập nhật</button>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmModal" id="delete-button">Xóa</button>
            </div>
            <div class="col-12 d-flex gap-2 justify-content-end align-items-center mb-2">
                <div class="p-2 border rounded-3 text-center">
                    <strong><?= $_SESSION["userID"]?> - <?= $_SESSION["name"]?></strong>
                </div>
            </div>

            <!-- Bảng danh sách về báo cáo hoạt động -->
            <div class="overflow-x-auto">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark custom-thead">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th style="width: 100px;">Người gửi</th>
                            <th style="width: 150px;">Nội dung</th>
                            <th style="width: 100px;">Thời gian gửi</th>
                            <th style="width: 100px;">Trạng thái</th>
                            <th style="width: 200px;">Người xử lý</th>
                            <th style="width: 150px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="reportTableBody">
                        <!-- Dữ liệu sẽ được thêm vào đây bằng AJAX -->
                    </tbody>
                </table>
            </div>
            <!-- Hiển thị thanh phân trang -->
            <div id="pagination"></div>
        
        </div>
    </div>
</div>

    <!-- Modal Báo cáo tài khoản vi phạm -->
    <div class="modal fade" id="reportAccountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content" style="background-color: #fff; color: #000; border-radius: 16px; font-family: 'Alexandria', sans-serif;">
                <div class="modal-body py-4 px-4">
                    <h5 class="text-center mb-3" style="font-weight: 700;">Báo cáo tài khoản vi phạm</h5>

                    <form id="reportForm">
                        <div class="mb-3">
                            <label for="reporter" class="form-label">Người gửi</label>
                            <input type="text" class="form-control" id="reporter" name="reporter" placeholder="Nhập tên bạn..." required>
                        </div>

                        <div class="mb-3">
                            <label for="reason" class="form-label">Lý do báo cáo</label>
                            <textarea class="form-control" id="reason" name="reason" rows="4" placeholder="Nhập nội dung báo cáo..." required></textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn" style="background: #ccc; color: #000;" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Gửi báo cáo</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tạo Thông Báo -->
    <div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content" style="background-color: #fff; color: #000; border-radius: 16px; font-family: 'Alexandria', sans-serif;">
                <div class="modal-body py-4 px-4">
                    <h5 class="text-center mb-3" style="font-weight: 700;">Tạo thông báo mới</h5>
                    <form id="addAnnouncementForm">
                        <input type="hidden" name="userID" value="<?= $_SESSION["userID"]; ?>" readonly>
                        <div class="mb-3">
                            <label for="notice-title" class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" id="notice-title" name="title" placeholder="Nhập tiêu đề..." required>
                        </div>
                        <div class="mb-3">
                            <label for="notice-title" class="form-label">Chủ đề</label>
                            <select class="form-select" name="type" required>
                                <option disabled selected>Lựa chọn chủ đề</option>
                                <option value="Sự kiện">Sự kiện</option>
                                <option value="Dừng hoạt động">Dừng hoạt động</option>
                                <option value="Thông báo nghỉ lễ">Thông báo nghỉ lễ</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check col-5">
                                <input class="form-check-input" type="radio" name="pin" value="none-pin" checked>
                                <label class="form-check-label" for="ra1">
                                    Không ghim
                                </label>
                            </div>
                            <div class="form-check col-5">
                                <input class="form-check-input" type="radio" name="pin" value="pin">
                                <label class="form-check-label" for="ra2">
                                    Ghim
                                </label>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <label for="content">Nội dung</label>
                            <textarea id="form_content" name="content" placeholder="Nhập nội dung"></textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="reset" class="btn" style="background: #ccc; color: #000;" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Tạo thông báo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 

    <!-- Popup sửa thông báo -->
    <div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">CHỈNH SỬA THÔNG BÁO</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <form id="editAnnouncementForm" method="POST">
                        <div class="mb-3">
                            <label for="userID" class="form-label">ID</label>
                            <input class="form-control" type="text" name="userID" value="<?= $_SESSION["userID"]; ?>" readonly>
                        </div>
                        <input class="form-control" type="hidden" name="announcementID" value="0000" readonly>
                        <div class="mb-3">
                            <label for="userName" class="form-label">Họ tên</label>
                            <input class="form-control" type="text" name="userName" value="<?= $_SESSION["name"]; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="userName" class="form-label">Tiêu đề</label>
                            <input class="form-control" type="text" name="titleEdit" id="" value="1000">
                        </div>
                        <div class="mb-3">
                            <label for="notice-title" class="form-label">Chủ đề</label>
                            <select class="form-select" name="typeEdit" required>
                                <option disabled selected>Lựa chọn chủ đề</option>
                                <option value="Sự kiện">Sự kiện</option>
                                <option value="Dừng hoạt động">Dừng hoạt động</option>
                                <option value="Thông báo nghỉ lễ">Thông báo nghỉ lễ</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check col-5">
                                <input class="form-check-input" type="radio" name="pinEdit" value="none-pin" checked>
                                <label class="form-check-label" for="ra1">
                                    Không ghim
                                </label>
                            </div>
                            <div class="form-check col-5">
                                <input class="form-check-input" type="radio" name="pinEdit" value="pin">
                                <label class="form-check-label" for="ra2">
                                    Ghim
                                </label>
                            </div>
                        </div>
                        <div class="col-12 my-2">
                            <label for="content">Nội dung</label>
                            <textarea id="form_content" name="contentEdit" placeholder="Nhập nội dung"></textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="reset" class="btn" style="background: #ccc; color: #000;" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Sửa thông báo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include('footer.php'); ?>