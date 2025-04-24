<!-- 
    Author: Gia Luong
 -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>BK Study Space</title>
        <meta charset="utf-8">
        <meta name="description" content="Assignment">
        <meta name="keywords" content="study space HCMUT">
        <meta name="author" content="PhamGiaLuong">
        <meta name="copyright" content="CSE HCMUT 2024">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Bootstrap framework -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> <!--icon bootstrap-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet"> <!--icon google-->
        <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@400;700&display=swap" rel="stylesheet"> <!--font Signika Negative-->
        <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;700&display=swap" rel="stylesheet"> <!--font Asap-->
        <link href="https://fonts.googleapis.com/css2?family=WindSong:wght@400;700&display=swap" rel="stylesheet"> <!-- font WindSong -->
        <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet"> <!-- font Dancing Script -->
        <link href="/se_ass_code/style.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery framework -->
    </head>
    <body style="background: 
       url('/SE_Ass_Code/Images/ThuVien.jpg'); background-repeat: no-repeat; background-size: cover; height: 100vh;">
       <!--linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3)), -->
        <div class="col-12 d-flex flex-wrap justify-content-center p-3 " style="margin-top: auto; margin-bottom: auto; height: 80vh;">
            <div class="col-11 d-flex justify-content-center align-items-center">
                <div class="col-11 rounded-5 my-5 sign-box d-flex flex-wrap" style="background-color: white;">
                    <div class="d-md-none col-12 d-flex flex-wrap justify-content-center pt-3 rounded-bottom-0 rounded-5" style="background-color: #222f3e;">
                        <div class="col-2">
                            <img src="/SE_Ass_Code/Images/logoVienTrang.png" 
                                alt="logo" class="img-fluid">
                        </div>
                        <h1 class="text-center col-12 my-3" style="font-family: 'WindSong', san-serif; color: white;">
                            xin chào
                        </h1>
                    </div>
                    <div class="col-6 d-none d-md-flex flex-wrap justify-content-center pt-3 rounded-end-0 rounded-5" style="background-color: #222f3e;">
                        <div class="col-2 d-flex align-items-center">
                            <img src="/SE_Ass_Code/Images/logoVienTrang.png" 
                                alt="logo" class="img-fluid">
                        </div>
                        <h2 class="text-center col-12 mt-3" style="color: white;">
                            HỆ THỐNG XÁC THỰC TẬP TRUNG HCMUT_SSO
                        </h2>
                    </div>
                    <div class="col-md-6 col-12 rounded-5 pt-md-4">
                        <!-- Hiển thị thông báo thành công/thất bại nếu có -->
                        <?php if (isset($_SESSION["error"])): ?>
                            <div class="alert alert-danger text-center m-3 d-flex align-items-center gap-3" role="alert">
                                <i class="bi bi-exclamation-circle"></i>
                                <p class="m-0"><?php echo $_SESSION["error"]; unset($_SESSION["error"]); ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION["success"])): ?>
                            <div class="alert alert-success text-center m-3 d-flex align-items-center gap-3" role="alert">
                                <i class="bi bi-check-circle"></i>
                                <p class="m-0"><?php echo $_SESSION["success"]; unset($_SESSION["success"]); ?></p>
                            </div>
                        <?php endif; ?>
                        <form action="/SE_Ass_Code/index.php?url=logIn/authenticate" method="POST" class="mt-md-5 m-3">
                            <div class="user-box">
                                <input type="text" id="id" name="id" required>
                                <label for="id"><?php 
                                    if (isset($_SESSION["DB"]) && $_SESSION["DB"] == "HCMUT") echo "BKNetID"; 
                                    else {
                                        $_SESSION["DB"] = "Staff";
                                        echo "ID";
                                    }  
                                ?></label>
                            </div>
                            <div class="user-box mb-md-5">
                                <input type="password" id="password" name="password" required>
                                <label for="password">Mật Khẩu</label>
                            </div>
                            <?php if(isset($_SESSION["DB"]) && $_SESSION["DB"] == "Staff"): ?>
                            <div class="text-end mb-2 mt-md-5">
                                <a href="/SE_Ass_Code/index.php?url=logIn/forgotPassword">Quên mật khẩu?</a>
                            </div>
                            <?php endif ?>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark">Đăng Nhập</button>
                            </div>
                            <div class="m-2 text-end py-1">
                                <a href="/SE_Ass_Code/index.php?url=home" class="text-dark">
                                    <i class="bi fs-5 bi-box-arrow-left"></i> Về Trang chủ
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
