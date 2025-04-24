<!-- 
    Author: Hai Duong
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
        <h2>ĐẶT PHÒNG</h2>
    </div>

    <!-- Thông tin người đặt phòng -->
    <div class="col-12 d-flex justify-content-md-end justify-content-center">
        <div class="col-11 col-lg-3 col-md-5 p-2 border rounded-3 text-center mb-3">
            <strong><?= $_SESSION["userID"]?> - <?= $_SESSION["name"]?></strong>
        </div>
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

    <!-- Lựa chọn đặt phòng -->
    <div class="col-12 d-flex flex-wrap justify-content-between gap-5">

        <!-- Phòng cá nhân -->
        <div class="col-md-5 col-12">
            <div class="room-item">
                <div class="room-image-wrapper">
                    <img src="/Se_Ass_Code/Images/canhan.jpg" alt="Phòng cá nhân">
                </div>
                <div class="room-details">
                    <div class="room-desc">Không gian rộng với nhiều bàn học riêng biệt, mang lại môi trường yên tĩnh, lý tưởng để tập trung học tập cá nhân.</div>
                    <div class="room-desc">Còn trống: <strong><?= $stat["self"]["total"] - $stat["self"]["using"]; ?></strong> chỗ</div>
                    <div class="col-12 d-flex justify-content-end mt-auto">
                        <!-- Button trigger modal -->
                        <button type="button" class="room-btn" data-bs-toggle="modal" data-bs-target="#selfStudyBooking">
                            Đặt phòng
                        </button>
                    </div>
                </div>
            </div>
            <div class="room-name">Phòng tự học cá nhân</div>
        </div>

        <!-- Phòng học đôi -->
        <div class="col-md-5 col-12">
            <div class="room-item">
                <div class="room-image-wrapper">
                    <img src="/Se_Ass_Code/Images/hainguoi.jpg" alt="Phòng học đôi">
                </div>
                <div class="room-details">
                    <div class="room-desc">Không gian mở với các bàn học đôi, phù hợp cho học nhóm nhỏ hoặc gặp gỡ, trao đổi giữa giảng viên và sinh viên.</div>
                    <div class="room-desc">Còn trống: <strong><?= $stat["dual"]["total"] - $stat["dual"]["using"]; ?></strong> phòng</div>
                    <div class="col-12 d-flex justify-content-end mt-auto">
                        <!-- Button trigger modal -->
                        <button type="button" class="room-btn" data-bs-toggle="modal" data-bs-target="#roomBooking">
                            Đặt phòng
                        </button>
                    </div>
                </div>
            </div>
            <div class="room-name">Phòng học đôi</div>
        </div>

        <!-- Phòng nhóm -->
        <div class="col-md-5 col-12">
            <div class="room-item">
                <div class="room-image-wrapper">
                    <img src="/Se_Ass_Code/Images/nhom10.jpg" alt="Phòng nhóm 10 người">
                </div>
                <div class="room-details">
                    <div class="room-desc">Gồm nhiều phòng nhỏ, mỗi phòng chứa tối đa 10 người, thuận tiện cho làm việc nhóm, thảo luận hoặc chuẩn bị bài thuyết trình.</div>
                    <div class="room-desc">Còn trống: <strong><?= $stat["group"]["total"] - $stat["group"]["using"]; ?></strong> phòng</div>
                    <div class="col-12 d-flex justify-content-end mt-auto">
                        <!-- Button trigger modal -->
                        <button type="button" class="room-btn" data-bs-toggle="modal" data-bs-target="#roomBooking">
                            Đặt phòng
                        </button>
                    </div>
                </div>
            </div>
            <div class="room-name">Phòng học nhóm</div>
        </div>  

    </div>

    <!-- Popup booking cho phòng tự học -->
    <div class="modal fade" id="selfStudyBooking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">THÔNG TIN ĐẶT CHỖ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <form id="selfStudyBookingForm" method="POST">
                        <div class="mb-3">
                            <label for="userID" class="form-label">ID</label>
                            <input class="form-control" type="text" name="userID" value="<?= $_SESSION["userID"]; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="userName" class="form-label">Họ tên</label>
                            <input class="form-control" type="text" name="userName" value="<?= $_SESSION["name"]; ?>" readonly>
                        </div>
                        <div class="col-12 my-2">
                            <label for="room_id">Chọn phòng</label>
                            <select class="form-select" id="room_id" name="room_id" aria-label="Default select example">
                                <option value="---" disabled selected>Hãy chọn phòng</option>
                                <?php foreach($selfRoomList as $room): ?>
                                    <option value="<?= $room["id"]; ?>">Phòng tự học - <?= $room["address"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 mt-2 d-flex justify-content-between">
                            <div class="mb-3 col-5">
                                <label for="start" class="form-label">Thời gian bắt đầu</label>
                                <input class="form-control" type="time" name="start_time" value="06:00"  min="00:00" max="23:59" required>
                            </div>
                            <div class="mb-3 col-5">
                                <label for="end" class="form-label">Thời gian kết thúc</label>
                                <input class="form-control" type="time" name="end_time" value="07:00" min="00:30" max="23:59" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="seat_number" class="form-label">Số ghế</label>
                            <input class="form-control bg-info-subtle" type="text" name="seat_number" id="seat_number" 
                                    value="Hãy điển đủ thông tin phía trên!" readonly>
                        </div>

                        <div class="col-12 d-flex flex-wrap justify-content-between mt-2">
                            <div class="col-5 d-grid">
                                <button type="reset" class="btn btn-outline-main">Nhập lại</button>
                            </div>
                            <div class="col-5 d-grid">
                                <button id="submitBtn1" type="submit" class="btn btn-main" disabled>Đặt ngay</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Popup booking cho phòng học đôi/nhóm -->
    <div class="modal fade" id="roomBooking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">THÔNG TIN ĐẶT CHỖ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <form id="roomBookingForm" method="POST">
                        <div class="mb-3">
                            <label for="userID" class="form-label">ID</label>
                            <input class="form-control" type="text" name="userID" value="<?= $_SESSION["userID"]; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="userName" class="form-label">Họ tên</label>
                            <input class="form-control" type="text" name="userName" value="<?= $_SESSION["name"]; ?>" readonly>
                        </div>
                        <div class="mb-3 d-flex justify-content-between">
                            <div class="form-check col-5">
                                <input class="form-check-input" type="radio" name="roomType" id="ra1" value="dual" checked>
                                <label class="form-check-label" for="ra1">
                                    Phòng học đôi
                                </label>
                            </div>
                            <div class="form-check col-5">
                                <input class="form-check-input" type="radio" name="roomType" id="ra2" value="group">
                                <label class="form-check-label" for="ra2">
                                    Phòng học nhóm
                                </label>
                            </div>
                        </div>
                        <!-- Select cho phòng học đôi -->
                        <div class="col-12 my-2 room-select" id="dualRoomSelect">
                            <label for="room2_id">Chọn phòng học đôi</label>
                            <select class="form-select" name="room2d_id">
                                <option value="---" disabled selected>Hãy chọn phòng</option>
                                <?php foreach($dualRoomList as $room): ?>
                                    <option value="<?= $room["id"]; ?>">Phòng học đôi - <?= $room["address"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Select cho phòng học nhóm -->
                        <div class="col-12 my-2 room-select d-none" id="groupRoomSelect">
                            <label for="room2_id">Chọn phòng học nhóm</label>
                            <select class="form-select" name="room2g_id">
                                <option value="---" disabled selected>Hãy chọn phòng</option>
                                <?php foreach($groupRoomList as $room): ?>
                                    <option value="<?= $room["id"]; ?>">Phòng học nhóm - <?= $room["address"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 mt-2 d-flex justify-content-between">
                            <div class="mb-3 col-5">
                                <label for="start" class="form-label">Thời gian bắt đầu</label>
                                <input class="form-control" type="time" name="start_room" value="06:00" min="06:00" max="23:59" required>
                            </div>
                            <div class="mb-3 col-5">
                                <label for="end" class="form-label">Thời gian kết thúc</label>
                                <input class="form-control" type="time" name="end_room" value="07:00" min="06:30" max="23:59" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="roomState" class="form-label">Trạng thái</label>
                            <input class="form-control bg-info-subtle" type="text" name="roomState" id="roomState" 
                                    value="Hãy điển đủ thông tin phía trên!" readonly>
                        </div>

                        <div class="col-12 d-flex flex-wrap justify-content-between mt-2">
                            <div class="col-5 d-grid">
                                <button type="reset" class="btn btn-outline-main">Nhập lại</button>
                            </div>
                            <div class="col-5 d-grid">
                                <button id="submitBtn" type="submit" class="btn btn-main" disabled>Đặt ngay</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Popup sửa thông tin booking -->
    <div class="modal fade" id="editBooking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">CHỈNH SỬA THÔNG TIN ĐẶT CHỖ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <form id="editBookingForm" method="POST">
                        <div class="mb-3">
                            <label for="userID" class="form-label">ID</label>
                            <input class="form-control" type="text" name="userID" value="<?= $_SESSION["userID"]; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="userName" class="form-label">Họ tên</label>
                            <input class="form-control" type="text" name="userName" value="<?= $_SESSION["name"]; ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="userName" class="form-label">Mã đặt phòng</label>
                            <input class="form-control" type="text" name="bookingID" id="bookingIDEdit" value="1000" readonly>
                        </div>
                        <input class="form-check-input" type="hidden" name="seatNum" value="">
                        <div class="mb-3 d-flex flex-wrap justify-content-between">
                            <div class="form-check col-5">
                                <input class="form-check-input" type="radio" name="typeEdit" id="e1" value="self" checked>
                                <label class="form-check-label" for="ra0">
                                    Phòng tự học
                                </label>
                            </div>
                            <div class="form-check col-5">
                                <input class="form-check-input" type="radio" name="typeEdit" id="e2" value="dual">
                                <label class="form-check-label" for="ra1">
                                    Phòng học đôi
                                </label>
                            </div>
                            <div class="form-check col-5">
                                <input class="form-check-input" type="radio" name="typeEdit" id="e3" value="group">
                                <label class="form-check-label" for="ra2">
                                    Phòng học nhóm
                                </label>
                            </div>
                        </div>
                        <!-- Select cho phòng tự học -->
                        <div class="col-12 my-2 room-select " id="selfRoomEditSelect">
                            <label for="roomEdit_id">Chọn phòng tự học</label>
                            <select class="form-select" name="roomSEdit_id">
                                <option value="---" disabled selected>Hãy chọn phòng</option>
                                <?php foreach($selfRoomList as $room): ?>
                                    <option value="<?= $room["id"]; ?>">Phòng tự học - <?= $room["address"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Select cho phòng học đôi -->
                        <div class="col-12 my-2 room-select d-none " id="dualRoomEditSelect">
                            <label for="roomEdit_id">Chọn phòng học đôi</label>
                            <select class="form-select" name="roomDEdit_id">
                                <option value="---" disabled selected>Hãy chọn phòng</option>
                                <?php foreach($dualRoomList as $room): ?>
                                    <option value="<?= $room["id"]; ?>">Phòng học đôi - <?= $room["address"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Select cho phòng học nhóm -->
                        <div class="col-12 my-2 room-select d-none " id="groupRoomEditSelect">
                            <label for="roomEdit_id">Chọn phòng học nhóm</label>
                            <select class="form-select" name="roomGEdit_id">
                                <option value="---" disabled selected>Hãy chọn phòng</option>
                                <?php foreach($groupRoomList as $room): ?>
                                    <option value="<?= $room["id"]; ?>">Phòng học nhóm - <?= $room["address"]; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12 mt-2 d-flex justify-content-between">
                            <div class="mb-3 col-5">
                                <label for="start" class="form-label">Thời gian bắt đầu</label>
                                <input class="form-control" type="time" name="startEdit" value="06:00" required>
                            </div>
                            <div class="mb-3 col-5">
                                <label for="end" class="form-label">Thời gian kết thúc</label>
                                <input class="form-control" type="time" name="endEdit" value="07:00" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="roomState" class="form-label">Trạng thái</label>
                            <input class="form-control bg-info-subtle" type="text" name="roomEditState" id="roomEditState" 
                                    value="Hãy điển đủ thông tin phía trên!" readonly>
                        </div>

                        <div class="col-12 d-flex flex-wrap justify-content-between mt-2">
                            <div class="col-5 d-grid">
                                <button type="reset" class="btn btn-outline-main">Nhập lại</button>
                            </div>
                            <div class="col-5 d-grid">
                                <button id="submitEditBtn" type="submit" class="btn btn-main" disabled>Sửa ngay</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Popup xác nhận cancel -->
    <div class="modal fade" id="cancelBooking" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">XÁC NHẬN HỦY LỊCH</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <form id="cancelBookingForm" method="POST">
                        <input type="hidden" name="cancelBookingID">
                        <div class="col-12 d-flex flex-wrap justify-content-center mt-2">
                            <h3>Bạn có chắc muốn hủy lịch đặt?</h3>
                            <div class="col-12 d-flex flex-wrap justify-content-center mt-2">
                                <p class="text-center col-12" id="bookingID">Mã đặt phòng: <strong></strong></p>
                                <i class="bi bi-x-octagon" style="font-size: 150px"></i>
                            </div>
                        </div>
                        <div class="col-12 d-flex flex-wrap justify-content-end mt-2">
                            <div class="col-5 d-grid">
                                <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Popup QR code cho đơn đặt phòng -->
    <div class="modal fade" id="qrCode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body py-3">
                    <form id="checkinQRForm" method="POST">
                        <input type="hidden" name="checkinID" value="">
                        <div class="col-12 d-flex flex-wrap justify-content-center mt-2 gap-5">
                            <strong>Hãy quét mã QR này trên máy đọc khi nhận phòng!</strong>
                            <img src='https://quickchart.io/qr?text=bookingID1046-roomID303&size=200' alt='QR Code' style='border: 1px solid #ddd; border-radius: 5px;'>
                        </div>
                        <div class="col-12 d-flex flex-wrap justify-content-between mt-5">
                            <div class="col-5 d-grid">
                                <button type="reset" class="btn btn-outline-main" data-bs-dismiss="modal">Đóng</button>
                            </div>
                            <div class="d-grid col-5">
                                <button type="submit" class="btn btn-success">Nhận phòng</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Popup gửi báo cáo -->
    <div class="modal fade" id="bookingReport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">GỬI BÁO CÁO</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <form id="reportBookingForm" method="POST">
                        <div class="mb-3">
                            <label for="userName" class="form-label">Mã đặt phòng</label>
                            <input class="form-control" type="text" name="reportID" value="" readonly>
                        </div>
                        <div class="col-12 my-2">
                            <label for="content">Nội dung</label>
                            <textarea id="form_content" name="content" placeholder="Nhập nội dung"></textarea>
                        </div>
                        <div class="col-12 d-flex flex-wrap justify-content-between mt-5">
                            <div class="d-grid col-12">
                                <button type="submit" class="btn btn-success">Gửi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách phòng đã đặt trong ngày -->
    <div id="todayBookingList" class="overflow-x-auto d-none my-3">
        <hr>
        <div class="my-3 text-center">
            <strong>CÁC LỊCH BẠN ĐÃ ĐẶT TRONG HÔM NAY</strong>
        </div>
        <table class="table table-hover table-bordered text-center">
            <thead class="table-dark custom-thead">
                <tr>
                    <th style="width: 100px;">Mã đặt phòng</th>
                    <th style="width: 100px;">Thời gian</th>
                    <th style="width: 150px;">Phòng</th>
                    <th style="width: 50px;">Số ghế</th>
                    <th style="width: 100px;">Giờ bắt đầu</th>
                    <th style="width: 100px;">Giờ kết thúc</th>
                    <th style="width: 100px;">Trạng thái</th>
                    <th style="width: 200px;">Hành động</th>
                </tr>
            </thead>
            <tbody id="todayBookingBody">
            </tbody>
        </table>
    </div>
    <!-- Hiển thị thanh phân trang -->
    <div id="pagination"></div>
</div>

    <!-- Hiển thị thông báo động cho người dùng -->
    <div id="toastBox" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
    </div>
<?php include('footer.php'); ?>
