<?php include('header.php'); ?>

    <!-- Welcome image -->
    <div id="carouselExample" class="carousel slide" style="overflow: hidden;" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/SE_Ass_Code/Images/ThuVienA5.jpg"
                    class="d-block w-100" alt="Welcome image 1" style="object-fit: cover;">
            </div>
            <!-- <div class="carousel-item">
            <img src="https://cmsv2.yame.vn/uploads/15f52d53-26f9-4c7b-ab60-8246210b4bb4/Bo_suu_tap_Doraemon.png?quality=80&w=1280&h=0"
                class="d-block w-100" alt="Welcome image 2" style="object-fit: cover;">
            </div>
            <div class="carousel-item">
            <img src="https://cmsv2.yame.vn/uploads/f5a45bc2-1880-4adf-b4b3-640670a1bd3f/BST_THE_SEAFARER_TRANG_CH%e1%bb%a6.jpg?quality=80&w=1280&h=0"
                class="d-block w-100" alt="Welcome image 3" style="object-fit: cover;">
            </div> -->
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container p-2">
        <div>
            <h2>THÔNG BÁO CHUNG</h2>
        </div>
        <?php      
        // Thông tin đặt phòng
        $userID = 1111;
        $roomID = 112;
        $date = "12/3/2025";
        $time_start = "12:15";
        $time_end = "14:50";

        // Chuỗi JSON chứa thông tin
        $data = json_encode([
            "userID" => $userID,
            "roomID" => $roomID,
            "date" => $date,
            "time_start" => $time_start,
            "time_end" => $time_end
        ]);
        // $text = "xinchaocucdang";
        echo "<img src='https://quickchart.io/qr?text=" . urlencode($data) . "&size=200' alt='QR Code' />";

        ?>
    </div>

<?php include('footer.php'); ?>