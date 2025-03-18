<?php include('header.php'); ?>


<div class="container mt-4">
  <h2 class="mb-3"> Quản lý người dùng </h2>

    <!-- Nút thêm tài khoản -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
        + Thêm tài khoản
    </button>

    <!-- Bảng danh sách tài khoản -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Họ Tên</th>
                <th>Email</th>
                <th>Vai Trò</th>
                <th>Trạng Thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody id="userTableBody">
            <!-- Dữ liệu sẽ được load từ JavaScript -->
        </tbody>
    </table>
</div>

<!-- Modal: Thêm/Sửa tài khoản -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalTitle">Thêm tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="userForm">
                    <input type="hidden" id="userId">
                    <div class="mb-3">
                        <label for="userName" class="form-label">Họ Tên</label>
                        <input type="text" id="userName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" id="userEmail" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Vai Trò</label>
                        <select id="userRole" class="form-select">
                            <option value="Quản trị viên">Quản trị viên</option>
                            <option value="Nhân viên">Nhân viên</option>
                            <option value="Người dùng">Người dùng</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="userStatus" class="form-label">Trạng Thái</label>
                        <select id="userStatus" class="form-select">
                            <option value="Hoạt động">Hoạt động</option>
                            <option value="Bị khóa">Bị khóa</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Lưu</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Xác nhận xóa -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa tài khoản này?</p>
                <input type="hidden" id="deleteUserId">
                <button class="btn btn-danger" onclick="deleteUser()">Xóa</button>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/admin.js"></script>


<?php include('footer.php'); ?>