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

<div class="container">
    <!-- Tab Navigation -->
    <div class="px-2" style="background-color: #c8d6e5;">
        <ul class="nav nav-underline d-flex flex-nowrap justify-content-evenly gap-3">
            <li class="nav-item">
                <a class="nav-link text-dark text-center active" data-bs-toggle="pill" href="#accountManage">
                    QUẢN LÝ TÀI KHOẢN
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark text-center" data-bs-toggle="pill" href="#issueManage">
                    SỰ CỐ VÀ BẢO TRÌ
                </a>
            </li>
        </ul>
    </div>

    <!-- Hiển thị thông báo thành công/thất bại nếu có -->
    <div class="alert alert-danger text-center m-3 d-flex align-items-center d-none col-12" role="alert" id="errorAlert">
        <div class="col-11 d-flex align-items-center gap-3">
            <i class="bi bi-exclamation-circle"></i>
            <p class="m-0" id="errorContent"></p>
        </div>
    </div>
    <div class="alert alert-success text-center m-3 d-flex align-items-center d-none col-12" role="alert" id="successAlert">
        <div class="col-11 d-flex align-items-center gap-3">
            <i class="bi bi-check-circle"></i>
            <p class="m-0" id="successContent"></p>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content mt-3 col-12">
        <!-- Quản lý tài khoản -->
        <div class="tab-pane fade show active" id="accountManage">
            <div class="d-flex justify-content-center col-12 mb-3">
                <h2>QUẢN LÝ TÀI KHOẢN</h2>
            </div>
            
            <!-- Nút chỉnh sửa tài khoản -->
            <div class="col-12 d-flex gap-2 justify-content-between align-items-center mb-2">
                <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    Thêm tài khoản
                </button>
                
                <div class="p-2 border rounded-3 text-center">
                    <strong><?= $_SESSION["userID"]?> - <?= $_SESSION["name"]?></strong>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark custom-thead">
                        <tr>
                            <!-- <th style="width: 50px;"><input type="checkbox" id="select-all" /></th> -->
                            <th style="width: 100px;">ID</th>
                            <th style="width: 200px;">Họ và tên</th>
                            <th style="width: 200px;">Email</th>
                            <th style="width: 100px;">Vai trò</th>
                            <th style="width: 100px;">Trạng thái</th>
                            <th style="width: 100px;">Ngày tạo</th>
                            <?php if ($_SESSION["Role"] == "admin"): ?>
                            <th style="width: 100px;">Hành động</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody id="userTableBody">
                        <!-- Dữ liệu sẽ được thêm vào đây bằng AJAX -->
                    </tbody>
                </table>
            </div>
            <!-- Hiển thị thanh phân trang -->
            <div id="loadUsers"></div>
            
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-report mb-3" data-bs-toggle="modal" data-bs-target="#reportAccountModal">
                    Báo cáo tài khoản vi phạm
                </button>
            </div>

        </div>

        <!-- Quản lý sự cố và bảo trì -->
        <div class="tab-pane fade" id="issueManage">
            <div class="d-flex justify-content-center col-12 mb-3">
                <h2>QUẢN LÝ SỰ CỐ VÀ BẢO TRÌ</h2>
            </div>

            <div class="col-12 d-flex flex-wrap justify-content-md-end justify-content-between gap-3 my-2"> 
                <!-- Nút báo cáo sự cố -->
                <div class="d-grid col-12 col-md-3">
                    <a type="button" class="btn btn-report" data-bs-toggle="modal" data-bs-target="#reportSpaceModal">
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

            <!-- Bảng danh sách sự cố -->
            <div class="overflow-x-auto">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-dark custom-thead">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th style="width: 300px;">Vấn đề</th>
                            <th style="width: 200px;">Phòng</th>
                            <th style="width: 300px;">Thời gian tạo</th>
                            <th style="width: 200px;">Trạng thái</th>
                            <th style="width: 100px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="issueTableBody">
                        <!-- Dữ liệu sẽ được load qua JS -->
                    </tbody>
                </table>
            </div>
            <!-- Hiển thị thanh phân trang -->
            <div id="loadIssues"></div>
        </div>
    </div>
</div>


<!-- Modal Khóa tài khoản -->
<div class="modal fade" id="lockConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 360px;">
        <div class="modal-content text-center" style="background-color: #444; color: white; border-radius: 16px;">
            <div class="modal-body py-5 py-4">
                <img src="https://cdn-icons-png.flaticon.com/512/565/565547.png" alt="Lock" width="60" class="mb-3" />
                <p id="confirmQuestion" style="font-size: 20px; font-weight: 700; color: white; margin-bottom: 20px;"></p>
                <div class="d-flex justify-content-center gap-3 mt-3">
                    <button type="reset" class="btn" style="background: #aaa; color: white; padding: 6px 20px;" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-warning px-4">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Thêm tài khoản -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="editSpaceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSpaceModalLabel" style="font-weight: bold; color: #030393;">Thêm tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control underline-input" name="name" placeholder="Fullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="accountRole" class="form-label">Vai trò</label>
                        <select class="form-select" name="role" required>
                            <option value="admin">Quản trị viên</option>
                            <option value="staff">Nhân viên</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="Date" class="form-label">Email</label>
                        <input type="email" class="form-control underline-input" name="email" placeholder="...@hcmut.edu.vn" required>
                    </div>
                    <div class="mb-3">
                        <label for="accountRole" class="form-label">Đơn vị</label>
                        <select class="form-select" name="faculty" required>
                            <option disabled selected>Lựa chọn đơn vị</option>
                            <option value="Trung tâm Dữ liệu và Công nghệ thông tin">Trung tâm Dữ liệu và Công nghệ thông tin</option>
                            <option value="Phòng Quản trị thiết bị">Phòng Quản trị thiết bị</option>
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


<!-- Modal báo cáo tình trạng không gian học tập -->
<div class="modal fade" id="reportSpaceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reportSpaceModalLabel" style="font-weight: bold; color: #030391;">Báo cáo tình trạng phòng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="reportRoomForm">
                    <div class="mb-3">
                        <label for="issueRoom" class="form-label">Người báo cáo</label>
                        <input type="text" class="form-control underline-input" name="userID" value="<?= $_SESSION["userID"] ?>" readonly>
                    </div>
                    <div class="col-12 my-2 room-select" id="issueRoom">
                        <label for="room2_id">Chọn phòng</label>
                        <select class="form-select" name="issueRoom" required>
                            <option value="---" disabled selected>Hãy chọn phòng</option>
                            <?php foreach($selfRoomList as $room): ?>
                                <option value="<?= $room["id"]; ?>">Phòng tự học - <?= $room["address"]; ?></option>
                            <?php endforeach; ?>
                            <?php foreach($dualRoomList as $room): ?>
                                <option value="<?= $room["id"]; ?>">Phòng học đôi - <?= $room["address"]; ?></option>
                            <?php endforeach; ?>
                            <?php foreach($groupRoomList as $room): ?>
                                <option value="<?= $room["id"]; ?>">Phòng học nhóm - <?= $room["address"]; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="stateDescription" class="form-label">Mô tả tình trạng</label>
                        <textarea id="issueDescription" class="form-control" name="content"></textarea>
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