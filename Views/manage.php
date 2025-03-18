<?php include('header.php'); ?>

<!-- Quản lý không gian học tập -->
<div class="container mt-4">
    <h2 class="mb-3">Quản lý không gian học tập</h2>
    
    <!-- Nút Thêm không gian -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSpaceModal">
        + Thêm không gian học tập
    </button>

    <!-- Bảng danh sách không gian học tập -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID phòng</th>
                <th>Tên phòng</th>
                <th>Loại phòng</th>
                <th>Tình trạng</th>
                <th>Sức chứa</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody id="spaceTableBody">
            <!-- Dữ liệu sẽ được load qua JS -->
        </tbody>
    </table>
</div>

<!-- Modal: Thêm/Sửa không gian -->
<div class="modal fade" id="addSpaceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="spaceModalTitle">Thêm không gian học tập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="spaceForm">
                    <input type="hidden" id="spaceId">
                    <div class="mb-3">
                        <label for="spaceName" class="form-label">Tên phòng</label>
                        <input type="text" id="spaceName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="spaceType" class="form-label">Loại phòng</label>
                        <select id="spaceType" class="form-select">
                            <option value="Phòng học">Phòng học</option>
                            <option value="Phòng họp">Phòng họp</option>
                            <option value="Thư viện">Thư viện</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="spaceCapacity" class="form-label">Sức chứa</label>
                        <input type="number" id="spaceCapacity" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="spaceStatus" class="form-label">Tình trạng</label>
                        <select id="spaceStatus" class="form-select">
                            <option value="Hoạt động">Hoạt động</option>
                            <option value="Đang bảo trì">Đang bảo trì</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Quản lý sự cố và bảo trì -->
<div class="container mt-4">
    <h2 class="mb-3">Quản lý sự cố và bảo trì</h2>
    
    <!-- Nút Thêm sự cố -->
    <button class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#reportIssueModal">
        + Báo cáo sự cố
    </button>

    <!-- Bảng danh sách sự cố -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã sự cố</th>
                <th>Vấn đề</th>
                <th>Phòng liên quan</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody id="issueTableBody">
            <!-- Dữ liệu sẽ được load qua JS -->
        </tbody>
    </table>
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
                <form id="issueForm">
                    <div class="mb-3">
                        <label for="issueDescription" class="form-label">Mô tả sự cố</label>
                        <textarea id="issueDescription" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="issueRoom" class="form-label">Phòng liên quan</label>
                        <select id="issueRoom" class="form-select">
                            <option value="Phòng 101">Phòng 101</option>
                            <option value="Phòng 102">Phòng 102</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning">Gửi báo cáo</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/manage.js"></script>


<?php include('footer.php'); ?>