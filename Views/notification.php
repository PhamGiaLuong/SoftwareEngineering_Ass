<!-- 
    Author: Gia Luong 
 -->
<?php include('header.php'); ?>
<div class="container "
    style="background: url('/SE_Ass_Code/Images/Notify.png'); background-repeat: no-repeat; background-size: 80vw; height: 55vh; background-position:right;">
    
    <div class="col-12 d-flex flex-wrap justify-content-center">
        <!-- Hiển thị thông báo thành công/thất bại nếu có -->
        <?php if (isset($_SESSION["Notify"])): ?>
            <div class="alert alert-primary text-center m-3 d-flex align-items-center gap-3" role="alert">
                <i class="bi bi-info-circle fs-4"></i>
                <p class="m-0"><?php echo $_SESSION["Notify"]; unset($_SESSION["Notify"]); ?></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
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
    </div>
    <div class="d-flex align-items-end justify-content-center h-25">
        <a class="btn btn-dark" href="/SE_Ass_Code/index.php?url=home" role="button">
            <i class="bi fs-5 bi-box-arrow-left"></i> Về Trang chủ
        </a>
    </div>
</div>

<?php include('footer.php'); ?>