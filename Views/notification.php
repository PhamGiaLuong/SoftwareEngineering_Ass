<?php include('header.php'); ?>
<div class="container "
    style="background: url('/SE_Ass_Code/Images/Notify.png'); background-repeat: no-repeat; background-size: 80vw; height: 55vh; background-position:right;">
    
    <div class="d-flex h-75">
        <h1 class=" m-5">
            <?php 
                if (isset($_SESSION["Notify"])) {
                    echo $_SESSION["Notify"]; 
                }
            ?>
        </h1>
    </div>
    <div class="d-flex align-items-end justify-content-center h-25">
        <a class="btn btn-dark" href="/SE_Ass_Code/index.php?url=home" role="button">
            <i class="bi fs-5 bi-box-arrow-left"></i> Về Trang chủ
        </a>
    </div>
</div>

<?php include('footer.php'); ?>