<?php include('header.php'); ?>
<div class="container d-flex flex-wrap justify-content-center mt-3">
    <div class="d-flex justify-content-center col-12 mb-3">
        <h2>THÔNG TIN TÀI KHOẢN</h2>
    </div>
    <div class="d-flex flex-wrap align-items-center justify-content-center col-md-8 col-lg-6 col-12 border rounded-5 mb-2">
        <div class="col-12 m-2 d-flex flex-wrap justify-content-center align-items-center">
            <div class="col-md-3 col-12 rounded-circle overflow-hidden border"
                style="width: 100px; height: 100px; background: url('<?php echo $user["image"]; ?>') center/cover no-repeat;">
            </div>
            <div class="col-md-8 justify-content-center text-md-start text-center col-12 px-3">
                <h2 class="my-1"> <?php echo $user["name"]; ?> </h2>
                <p class="m-0"> <?= $user["status"] ?></p>
            </div>
        </div>
        <div class="col-10 m-2">
            <div class="col-12 d-flex flex-wrap px-3 my-2">
                <?php if (!isset($note)): ?>
                <div class="col-3">
                    <strong>ID</strong>
                </div>
                <div class="col-9">
                    <?php 
                        echo ($_SESSION["DB"] == "HCMUT") ? $user["BKNetID"] : 
                            (($_SESSION["DB"] == "Staff") ? $user["id"] : "");
                    ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-12 d-flex flex-wrap px-3 my-2">
                <div class="col-3">
                    <strong>Email</strong>
                </div>
                <div class="col-9">
                    <?php echo $user["email"];?>
                </div>
            </div>
            <div class="col-12 d-flex flex-wrap px-3 my-2">
                <div class="col-3">
                    <strong>Vai trò</strong>
                </div>
                <div class="col-9">
                    <?php 
                        $roles = [
                            "student" => "Sinh viên",
                            "teacher" => "Giảng viên",
                            "staff"   => "Quản lý",
                            "admin"   => "Quản trị viên"
                        ];
                        echo $roles[$user["role"]] ?? "Không xác định"; 
                    ?>
                </div>
            </div>
            <div class="col-12 d-flex flex-wrap px-3 my-2">
                <div class="col-3">
                    <strong>Đơn vị</strong>
                </div>
                <div class="col-9">
                    <?php echo $user["faculty"];?>
                </div>
            </div>
        </div>
    </div>
    <?php if (!isset($note)): ?>
    <div class="d-flex flex-wrap align-items-center justify-content-center col-12">
        <?php if ($_SESSION["Role"] == "staff" || $_SESSION["Role"] == "admin"): ?>
        <div class="col-md-3 col-5 d-flex flex-wrap align-items-center justify-content-center">
            <a class="btn btn-secondary" href="/SE_Ass_Code/index.php?url=logIn/forgotPassword" role="button">Đổi mật khẩu</a>
        </div>
        <?php endif; ?>
        <div class="col-md-3 col-5 d-flex flex-wrap align-items-center justify-content-center">
            <a class="btn btn-secondary" href="/SE_Ass_Code/index.php?url=history" role="button">Lịch sử đặt phòng</a>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include('footer.php'); ?>