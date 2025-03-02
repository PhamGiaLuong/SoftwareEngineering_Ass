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
        <script src="/SE_Ass_Code/script.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery framework -->
    </head>
    <body style="background: 
       url('/SE_Ass_Code/Images/ThuVien.jpg'); background-repeat: no-repeat; background-size: cover; height: 100vh;">
       <!--linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3)), -->
        <div class="col-12 d-flex flex-wrap justify-content-center p-3 " style="margin-top: auto; margin-bottom: auto; height: 80vh;">
            <div class="col-11 d-flex justify-content-center align-items-center">
                <div class="col-11 rounded-5 my-5 sign-box d-flex flex-wrap" style="background-color: white;">
                    <div class="d-md-none col-12 d-flex flex-wrap justify-content-center pt-3 rounded-bottom-0 rounded-5" 
                            style="background-color: #222f3e;">
                        <div class="col-2">
                            <img src="/SE_Ass_Code/Images/logoVienTrang.png" 
                                alt="logo" class="img-fluid">
                        </div>
                        <h2 class="text-center col-12 mt-3" style="color: white;">
                            ĐỔI MẬT KHẨU
                        </h2>
                    </div>
                    <div class="col-6 d-none d-md-flex flex-wrap justify-content-center align-items-center pt-3 rounded-end-0 rounded-5" 
                            style="background-color: #222f3e;">
                        <div class="col-2 d-flex align-items-center">
                            <img src="/SE_Ass_Code/Images/logoVienTrang.png" 
                                alt="logo" class="img-fluid">
                        </div>
                        <h2 class="text-center col-12 mt-2" style="color: white;">
                            ĐỔI MẬT KHẨU
                        </h2>
                    </div>
                    <div class="col-md-6 col-12 rounded-5">
                    <?php if (isset($_SESSION["error"])): ?>
                        <div class="alert alert-danger text-center m-3" role="alert">
                            <p><?php echo $_SESSION["error"]; unset($_SESSION["error"]); ?></p>
                        </div>
                    <?php endif; ?>
                        <form action="/SE_Ass_Code/index.php?url=logIn/updatePassword" method="POST" class="mt-md-5 m-3"
                            onsubmit="return validatePassword(event)">
                            <div class="user-box">
                                <input type="text" id="token" name="token" required>
                                <label for="token">Nhập token</label>
                            </div>
                            <div class="user-box">
                                <input type="password" id="password" name="password" required>
                                <label for="password">Nhập mật khẩu mới</label>
                            </div>
                            <div class="user-box">
                                <input type="password" id="confirmPassword" name="confirmPassword" required>
                                <label for="confirmPassword">Nhập lại mật khẩu mới</label>
                            </div>
                            <p id="error-message" class="text-danger d-none">Mật khẩu không khớp!</p>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark">Đổi mật khẩu</button>
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
