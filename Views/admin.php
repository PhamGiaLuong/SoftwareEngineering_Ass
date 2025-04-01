<?php include('header.php'); ?>

<!-- Quản lý không gian học tập -->
<div class="container mt-4">
    <h2 class="mb-3">Quản lý không gian học tập</h2>
    
    <!-- Nút chỉnh sửa không gian -->
    <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#editSpaceModal">
        Chỉnh sửa không gian học tập
    </button>

    <!-- Bảng danh sách không gian học tập -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID phòng</th>
                <th>Tên phòng</th>
                <th>Loại phòng</th>
                <th>Sức chứa</th>
                <th>Tình trạng</th>
                <th>Tình trạng sử dụng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody id="spaceTableBody">
            <!-- Dữ liệu sẽ được load qua JS -->
            <tr>
            <td>1201</td>
            <td>Green</td>
            <td>Lớn</td>
            <td>30</td>
            <td class="text-warning">Đang bảo trì</td>
            <td>Đang khoá</td>
            <td>
                <button class="btn btn-custom btn-warning">Mở</button>
                <button class="btn btn-custom btn-danger">Khóa</button>
            </td>
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
    <button class="btn btn-report mb-3" data-bs-toggle="modal" data-bs-target="#reportSpaceModal">
        Báo cáo<br>tình trạng không gian học tập
    </button>
    </div>
</div>

<!-- Modal: Chỉnh sửa không gian -->
<div class="modal fade" id="editSpaceModal" tabindex="-1" aria-labelledby="editSpaceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSpaceModalLabel" style="font-weight: bold; color: #003366;">Chỉnh sửa không gian học tập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSpaceForm">
                    <div class="mb-3">
                        <label for="roomId" class="form-label">ID phòng</label>
                        <input type="text" class="form-control underline-input" id="roomId" placeholder="Nhập ID phòng" required>
                    </div>
                    <div class="mb-3">
                        <label for="roomName" class="form-label">Tên phòng</label>
                        <input type="text" class="form-control underline-input" id="roomName" placeholder="Nhập tên phòng" required>
                    </div>
                    <div class="mb-3">
                        <label for="roomType" class="form-label">Loại phòng</label>
                        <input type="text" class="form-control underline-input" id="roomType" placeholder="Nhập loại phòng" required>
                    </div>
                    <div class="mb-3">
                        <label for="roomCapacity" class="form-label">Sức chứa</label>
                        <input type="number" class="form-control underline-input" id="roomCapacity" placeholder="Nhập sức chứa" required>
                    </div>
                    <div class="mb-3">
                        <label for="roomStatus" class="form-label">Tình trạng</label>
                        <select class="form-select" id="roomStatus" required>
                            <option value="Hoạt động">Hoạt động</option>
                            <option value="Đang bảo trì">Đang bảo trì</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="roomUsageStatus" class="form-label">Tình trạng sử dụng</label>
                        <select class="form-select" id="roomUsageStatus" required>
                            <option value="Đang sử dụng">Đang sử dụng</option>
                            <option value="Chưa sử dụng">Đang khoá</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="roomAction" class="form-label">Hành động</label>
                        <select class="form-select" id="roomAction" required>
                            <option value="Cập nhật">Cập nhật</option>
                            <option value="Hủy">Hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-30">Lưu</button>
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
                <h5 class="modal-title">Báo cáo tình trạng không gian học tập</h5>
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
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Quản lý sự cố và bảo trì -->
<div class="container mt-4">
    <h2 class="mb-3">Quản lý sự cố và bảo trì</h2>
    
    <!-- Nút Thêm sự cố -->
    <button class="btn btn-custom mb-3" data-bs-toggle="modal" data-bs-target="#updateIssueModal">
        Cập nhật tình trạng
    </button>

    <!-- Bảng danh sách sự cố -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID sự cố</th>
                <th>Vấn đề</th>
                <th>Phòng liên quan</th>
                <th>Ngày xảy ra sự cố</th>
                <th>Trạng thái</th>
                <th>Phản hồi</th>
                <th>Hành động</th>
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
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        <button class="btn btn-report mb-3" data-bs-toggle="modal" data-bs-target="#reportIssueModal">
            Báo cáo<br>sự cố
        </button>
    </div>
</div>

<!-- Modal cập nhật tình trạng sự cố -->
<div class="modal fade" id="updateIssueModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cập nhật tình trạng sự cố</h5>
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
                    <button type="submit" class="btn btn-success w-30">Lưu</button>
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
                <h5 class="modal-title">Báo cáo sự cố</h5>
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
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/admin.js"></script>


<?php include('footer.php'); ?>