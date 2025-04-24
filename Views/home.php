<!-- 
    Author: Gia Luong
 -->
<?php include('header.php'); ?>

<!-- Welcome image -->
<div id="carouselExample" class="carousel slide" style="overflow: hidden;" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/SE_Ass_Code/Images/ThuVienA5.jpg"
                class="d-block w-100" alt="Welcome image 1" style="object-fit: cover;">
        </div>
        <div class="carousel-item">
        <img src="/SE_Ass_Code/Images/H6.jpg"
            class="d-block w-100" alt="Welcome image 2" style="object-fit: cover;">
        </div>
        <div class="carousel-item">
        <img src="/SE_Ass_Code/Images/NhaTheThao.jpg"
            class="d-block w-100" alt="Welcome image 3" style="object-fit: cover;">
        </div>
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

<div class="container p-2 fade-in d-flex flex-wrap justify-content-between">
    
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
    
    <!-- Thông báo chung -->
    <div class="col-12 <?php echo (isset($_SESSION["Role"]) && ($_SESSION["Role"] == "staff" || $_SESSION["Role"] == "admin")) ? "col-md-7" : ""; ?> mb-4">
        <h2>THÔNG BÁO CHUNG</h2>

        <!-- Danh sách thông báo chung -->
        <div class="col-12 d-flex flex-wrap gap-3" id="generalNoteBox">
        </div>
    </div>

    <!-- Báo cáo từ người dùng -->
    <div class="<?php echo (isset($_SESSION["Role"]) && ($_SESSION["Role"] == "staff" || $_SESSION["Role"] == "admin")) ? "col-12 col-md-4 border border-2 rounded-4" : "d-none"; ?>">
        <div class="col-12 rounded-top-4 p-2 text-center" style="background-color: #030391;">
            <h2 class="text-white m-0">BÁO CÁO</h2>
        </div>
        <div class="col-12 overflow-y-auto" id="reportBox">
        </div>
    </div>
        
    <!-- Không gian học tập -->
     <div class="col-12 mt-4 fade-in">
        <h2>KHÔNG GIAN HỌC TẬP</h2>
        <div class="col-12 d-flex flex-wrap justify-content-md-evenly justify-content-center gap-3">
            <!-- Phòng tự học -->
            <div class="col-md-5 col-10 rounded-3 border border-2 p-2 d-flex flex-wrap justify-content-end fade-in">   
                <div class="col-5 d-flex flex-wrap justify-content-center">
                    <div class="col-12 overflow-hidden border"
                        style="width: 100px; height: 100px; background: url('/SE_Ass_Code/Images/R1.jpg') center/cover no-repeat;">
                    </div>        
                    <h5 class="col-12 d-flex justify-content-center">Phòng tự học</h5>
                </div>
                <div class="col-7 m-0">
                    <p class="m-0"><strong>Sức chứa</strong> 50 SV/phòng</p>
                    <p class="m-0"><strong>Cơ sở vật chất</strong> Đèn bàn, máy tính bàn, ổ cấm, máy lạnh, bàn ghế cá nhân</p>
                    <p class="m-0"><strong>Đặc điểm</strong> Học tập cá nhân</p>
                </div>
                <div class="d-grid col-7">
                    <button type="button" class="btn btn-outline-blue" onclick="window.location.href='/SE_Ass_Code/index.php?url=booking'">
                        Còn <strong><?= $stat["self"]["total"] - $stat["self"]["using"]; ?></strong> chỗ, đặt ngay
                    </button>
                </div>
            </div>
            <!-- Phòng học đôi -->
            <div class="col-md-5 col-10 rounded-3 border border-2 p-2 d-flex flex-wrap justify-content-end fade-in">   
                <div class="col-5 d-flex flex-wrap justify-content-center">
                    <div class="col-12 overflow-hidden border"
                        style="width: 100px; height: 100px; background: url('/SE_Ass_Code/Images/R2.jpg') center/cover no-repeat;">
                    </div>        
                    <h5 class="col-12 d-flex justify-content-center">Phòng học đôi</h5>
                </div>
                <div class="col-7 m-0">
                    <p class="m-0"><strong>Sức chứa</strong> 2 SV/phòng</p>
                    <p class="m-0"><strong>Cơ sở vật chất</strong> Đèn bàn, máy tính bàn, ổ cấm, máy lạnh, bàn ghế đôi</p>
                    <p class="m-0"><strong>Đặc điểm</strong> Học tập 1-1, mentorring</p>
                </div>
                <div class="d-grid col-7">
                    <button type="button" class="btn btn-outline-blue" onclick="window.location.href='/SE_Ass_Code/index.php?url=booking'">
                        Còn <strong><?= $stat["dual"]["total"] - $stat["dual"]["using"]; ?></strong> phòng, đặt ngay
                    </button>
                </div>
            </div>
            <!-- Phòng học nhóm -->
            <div class="col-md-5 col-10 rounded-3 border border-2 p-2 d-flex flex-wrap justify-content-end fade-in">   
                <div class="col-5 d-flex flex-wrap justify-content-center">
                    <div class="col-12 overflow-hidden border"
                        style="width: 100px; height: 100px; background: url('/SE_Ass_Code/Images/R3.jpg') center/cover no-repeat;">
                    </div>        
                    <h5 class="col-12 d-flex justify-content-center">Phòng học nhóm</h5>
                </div>
                <div class="col-7 m-0">
                    <p class="m-0"><strong>Sức chứa</strong> 10 SV/phòng</p>
                    <p class="m-0"><strong>Cơ sở vật chất</strong> Đèn, TV, ổ cấm, máy lạnh, bàn họp, bảng trắng,...</p>
                    <p class="m-0"><strong>Đặc điểm</strong> Học tập nhóm từ 3-10 SV</p>
                </div>
                <div class="d-grid col-7">
                    <button type="button" class="btn btn-outline-blue" onclick="window.location.href='/SE_Ass_Code/index.php?url=booking'">
                        Còn <strong><?= $stat["group"]["total"] - $stat["group"]["using"]; ?></strong> phòng, đặt ngay
                    </button>
                </div>
            </div>
        </div>
     </div>

</div>
    <!-- Hiển thị thông báo động cho người dùng -->
    <div id="toastBox" class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
    </div>
<?php include('footer.php'); ?>