<?php  
    // Điều hướng đến tab đăng nhập nếu chưa
    if (!isset($_SESSION["Role"])) {
        header("Location: /SE_Ass_Code/index.php?url=loginOption");
        exit();
    }
    include('header.php'); 
?>

<div class="container">
    <!-- Tab Navigation -->
    <div class="px-2" style="background-color: #c8d6e5;">
        <ul class="nav nav-underline d-flex flex-nowrap justify-content-evenly gap-3">
            <li class="nav-item">
                <a class="nav-link text-dark text-center active" data-bs-toggle="pill" href="#spaceManage">
                    QUẢN LÝ KHÔNG GIAN HỌC TẬP
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark text-center" data-bs-toggle="pill" href="#issueManage">
                    QUẢN LÝ SỰ CỐ VÀ BẢO TRÌ
                </a>
            </li>
        </ul>
    </div>

    <!-- Hiển thị thông báo thành công/thất bại nếu có -->
    <div class="alert alert-error text-center m-3 d-flex align-items-center d-none col-12 col-md-6" role="alert" id="errorAlert">
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
    <?php if (isset($_SESSION["error"])): ?>
        <div class="alert alert-danger text-center m-3 d-flex align-items-center gap-3" role="alert">
            <i class="bi bi-exclamation-circle"></i>
            <p class="m-0"><?php echo $_SESSION["error"]; unset($_SESSION["error"]); ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION["success"])): ?>
        <div class="alert alert-success text-center m-3 d-flex align-items-center gap-3" role="alert">
            <i class="bi bi-check-circle"></i>
            <p class="m-0"><?php echo $_SESSION["success"]; unset($_SESSION["success"]); ?></p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Tab Content -->
    <div class="tab-content mt-3 col-12">
        <!-- Quản lý không gian học tập -->
        <div class="tab-pane fade show active" id="spaceManage">
            <div class="d-flex justify-content-center col-12 mb-3">
                <h2>QUẢN LÝ KHÔNG GIAN HỌC TẬP</h2>
            </div>

            <div class="col-12 d-flex flex-wrap justify-content-md-end justify-content-between gap-2 my-2">
                <div class="d-grid col-12 col-md-3">
                    <select id="roomFilter" class="form-select">
                        <!-- <option disabled selected>Lựa chọn chủ đề</option> -->
                        <option value="self_study" selected>Phòng tự học</option>
                        <option value="dual">Phòng học đôi</option>
                        <option value="group">Phòng học nhóm</option>
                    </select>
                </div>
                <!-- Nút báo cáo tình trạng -->
                <div class="d-grid col-12 col-md-3">
                    <a type="button text-center" class="btn btn-report" data-bs-toggle="modal" data-bs-target="#reportSpaceModal">
                        Báo cáo tình trạng không gian học tập
                    </a>
                </div>
                <!-- Nút chỉnh sửa không gian -->
                <div class="d-grid col-12 col-md-3">
                    <a type="button text-center" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#editSpaceModal">
                        Thêm phòng
                    </a>
                </div>
            </div>
            <!-- Bảng danh sách không gian học tập -->
            <div class="overflow-x-auto">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark custom-thead">
                        <tr>
                            <th style="width: 100px;">ID phòng</th>
                            <th style="width: 200px;">Tên phòng</th>
                            <th style="width: 100px;">Vị trí</th>
                            <th style="width: 100px;">Sức chứa</th>
                            <th style="width: 150px;">Tình trạng</th>
                            <th style="width: 150px;">Tình trạng sử dụng</th>
                            <th style="width: 200px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="spaceTableBody">
                        <!-- Dữ liệu sẽ được load qua JS -->
                         
                    </tbody>
                </table>
            </div>
            <!-- Hiển thị thanh phân trang -->
            <div id="pagination"></div>
            
            <!-- <div class="col-12 d-flex flex-wrap justify-content-md-end justify-content-between gap-2 my-2"> 
                Nút báo cáo tình trạng
                <div class="d-grid col-12 col-md-3">
                    <a type="button text-center" class="btn btn-report" data-bs-toggle="modal" data-bs-target="#reportSpaceModal">
                        Báo cáo tình trạng không gian học tập
                    </a>
                </div>
                Nút chỉnh sửa không gian
                <div class="d-grid col-12 col-md-3">
                    <a type="button text-center" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#editSpaceModal">
                        Chỉnh sửa không gian học tập
                    </a>
                </div>
            </div> -->
        </div>
        
        <!-- Quản lý sự cố và bảo trì -->
        <div class="tab-pane fade" id="issueManage">
            <div class="d-flex justify-content-center col-12 mb-3">
                <h2>QUẢN LÝ SỰ CỐ VÀ BẢO TRÌ</h2>
            </div>

            <!-- Bảng danh sách sự cố -->
            <div class="overflow-x-auto">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark custom-thead">
                        <tr>
                            <th style="width: 100px;">ID sự cố</th>
                            <th style="width: 200px;">Vấn đề</th>
                            <th style="width: 100px;">Phòng liên quan</th>
                            <th style="width: 150px;">Thời gian</th>
                            <th style="width: 100px;">Trạng thái</th>
                            <th style="width: 100px;">Phản hồi</th>
                            <th style="width: 200px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="issueTableBody">
                        <!-- Dữ liệu sẽ được load qua JS -->
                        <tr>
                            <td>1111</td>
                            <td>Chủ đề số 1</td>
                            <td>Trần Văn A</td>
                            <td>5/3/2025 9:32</td>
                            <td>Đang mở</td>
                            <td>3 phản hồi</td>
                            <td>
                                <button class="btn btn-custom btn-warning">Mở</button>
                                <button class="btn btn-custom btn-danger">Khóa</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Hiển thị thanh phân trang -->
            <div id="pagination"></div>

            <div class="col-12 d-flex flex-wrap justify-content-md-end justify-content-between gap-3 my-2"> 
                <!-- Nút báo cáo sự cố -->
                <div class="d-grid col-12 col-md-3">
                    <a type="button" class="btn btn-report" data-bs-toggle="modal" data-bs-target="#reportIssueModal">
                        Báo cáo sự cố
                    </a>
                </div>
                <!-- Nút thêm sự cố -->
                <div class="d-grid col-12 col-md-3">
                    <a type="button" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#updateIssueModal">
                        Cập nhật tình trạng
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Chỉnh sửa không gian -->
<div class="modal fade" id="editSpaceModal" tabindex="-1" aria-labelledby="editSpaceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSpaceModalLabel" style="font-weight: bold; color: #030391;">Chỉnh sửa không gian học tập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSpaceForm">
                    <!-- <div class="mb-3">
                        <label for="roomId" class="form-label">ID phòng</label>
                        <input type="text" class="form-control underline-input" id="roomId" placeholder="Nhập ID phòng" required>
                    </div> -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên phòng</label>
                        <input type="text" class="form-control underline-input" name="name" placeholder="Nhập tên phòng" required>
                    </div>
                    <div class="mb-3">
                        <label for="building" class="form-label">Tòa nhà</label>
                        <input type="text" class="form-control underline-input" name="building" placeholder="Nhập tòa nhà" required>
                    </div>
                    <div class="mb-3">
                        <label for="room" class="form-label">Số phòng</label>
                        <input type="text" class="form-control underline-input" name="room" placeholder="Nhập số phòng" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Loại phòng</label>
                        <select class="form-select" name="type" required>
                            <option value="self_study">Phòng tự học</option>
                            <option value="dual">Phòng học đôi</option>
                            <option value="group">Phòng học nhóm</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Sức chứa</label>
                        <input type="number" class="form-control underline-input" name="capacity" placeholder="Nhập sức chứa" required>
                    </div>
                    <!-- <div class="mb-3">
                        <label for="status" class="form-label">Tình trạng</label>
                        <select class="form-select" id="status" required>
                            <option value="available">Hoạt động</option>
                            <option value="maintenance">Đang bảo trì</option>
                        </select>
                    </div> -->
                    <!-- <div class="mb-3">
                        <label for="roomUsageStatus" class="form-label">Tình trạng sử dụng</label>
                        <select class="form-select" id="roomUsageStatus" required>
                            <option value="Đang sử dụng">Đang sử dụng</option>
                            <option value="Chưa sử dụng">Đang khoá</option>
                        </select>
                    </div> -->
                    <!-- <div class="mb-3">
                        <label for="roomAction" class="form-label">Hành động</label>
                        <select class="form-select" id="roomAction" required>
                            <option value="Cập nhật">Cập nhật</option>
                            <option value="Hủy">Hủy</option>
                        </select>
                    </div> -->
                    <div class="col-12 d-flex flex-wrap justify-content-between mt-2">
                        <div class="col-5 d-grid">
                            <button type="reset" class="btn btn-outline-main">Nhập lại</button>
                        </div>
                        <div class="col-5 d-grid">
                            <button type="submit" class="btn btn-success">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal báo cáo tình trạng không gian học tập -->
<div class="modal fade" id="reportSpaceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportSpaceModalLabel" style="font-weight: bold; color: #030391;">Báo cáo tình trạng không gian học tập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="stateForm">
                    <div class="mb-3">
                        <label for="issueRoom" class="form-label">ID phòng</label>
                        <select id="stateRoom" class="form-select">
                            <option value="1201">1201</option>
                            <option value="1202">1202</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="stateDescription" class="form-label">Mô tả tình trạng</label>
                        <textarea id="issueDescription" class="form-control"></textarea>
                    </div>
                    <div class="col-12 d-flex flex-wrap justify-content-between mt-2">
                        <div class="col-5 d-grid">
                            <button type="reset" class="btn btn-outline-main">Nhập lại</button>
                        </div>
                        <div class="col-5 d-grid">
                            <button type="submit" class="btn btn-success">Gửi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal cập nhật tình trạng sự cố -->
<div class="modal fade" id="updateIssueModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: bold; color: #030391;">Cập nhật tình trạng sự cố</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form id="editSpaceForm">
                    <div class="mb-3">
                        <label for="issueId" class="form-label">ID sự cố</label>
                        <select id="issueid" class="form-select" placeholder="ID sự cố">
                            <option value="Phòng 101">1111</option>
                            <option value="Phòng 102">1112</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="problem" class="form-label">Vấn đề</label>
                        <input type="text" class="form-control underline-input" id="problem" placeholder="Vấn đề" required>
                    </div>
                    <div class="mb-3">
                        <label for="roomRoom" class="form-label">Phòng liên quan</label>
                        <select id="relateRoom" class="form-select" placeholder="ID phòng" required>
                            <option value="Phòng 101">1201</option>
                            <option value="Phòng 102">1202</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="initDay" class="form-label">Ngày xảy ra sự cố</label>
                        <input type="day" class="form-control underline-input" id="roomCapacity" placeholder="Ngày/Tháng/Năm" required>
                    </div>
                    <div class="mb-3">
                        <label for="issueStatus" class="form-label">Tình trạng</label>
                        <select class="form-select" id="issueStatus" required>
                            <option value="Hoạt động">Hoạt động</option>
                            <option value="Đang bảo trì">Đang bảo trì</option>
                            <option value="Đã sửa chữa">Đã sửa chữa</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="roomAction" class="form-label">Hành động</label>
                        <select class="form-select" id="roomAction" required>
                            <option value="Mở">Mở</option>
                            <option value="Khoá">Khoá</option>
                        </select>
                    </div>
                    <div class="col-12 d-flex flex-wrap justify-content-between mt-2">
                        <div class="col-5 d-grid">
                            <button type="reset" class="btn btn-outline-main">Nhập lại</button>
                        </div>
                        <div class="col-5 d-grid">
                            <button type="submit" class="btn btn-success">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal báo cáo sự cố -->
<div class="modal fade" id="reportIssueModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: bold; color: #030391;">Báo cáo sự cố</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="stateForm">
                    <div class="mb-3">
                        <label for="issue" class="form-label">ID sự cố</label>
                        <select id="issueid" class="form-select" placeholder="ID sự cố">
                            <option value="Phòng 101">1111</option>
                            <option value="Phòng 102">1112</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="NumFB" class="form-label">Số lượng phản hồi: 1 (phản hồi)</label>
                    </div>
                    <div class="mb-3">
                        <label for="stateDescription" class="form-label">Mô tả sự cố</label>
                        <textarea id="issueDescription" class="form-control"></textarea>
                    </div>
                    <div class="col-12 d-flex flex-wrap justify-content-between mt-2">
                        <div class="col-5 d-grid">
                            <button type="reset" class="btn btn-outline-main">Nhập lại</button>
                        </div>
                        <div class="col-5 d-grid">
                            <button type="submit" class="btn btn-success">Gửi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include('footer.php'); ?>