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
        <h2>LỊCH SỬ ĐẶT PHÒNG</h2>
    </div>

    <div class="col-12 d-flex flex-wrap justify-content-md-end justify-content-between gap-3 mb-2">
        <div class="p-2 border rounded-3 text-center">
            <strong><?= $_SESSION["userID"]?> - <?= $_SESSION["name"]?></strong>
        </div>
        <div class="d-grid col-5 col-md-3">
            <!-- Button trigger modal -->
            <a type="button" class="btn btn-main" href="/SE_Ass_Code/index.php?url=booking">
                Đặt phòng mới
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-hover table-bordered text-center">
            <thead class="table-dark custom-thead">
                <tr>
                    <th style="width: 100px;">Mã đặt phòng</th>
                    <th style="width: 100px;">Thời gian</th>
                    <th style="width: 150px;">Phòng</th>
                    <th style="width: 100px;">Vị trí</th>
                    <th style="width: 50px;">Số ghế</th>
                    <th style="width: 100px;">Giờ bắt đầu</th>
                    <th style="width: 100px;">Giờ kết thúc</th>
                    <th style="width: 100px;">Trạng thái</th>
                    <th style="width: 100px;">Báo cáo</th>
                </tr>
            </thead>
            <tbody id="bookingHistoryBody">
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
