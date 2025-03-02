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
        <div class="col-12 d-flex flex-wrap justify-content-center p-3 mb-5 mt-4">
            <div class="col-md-4 col-11 d-flex justify-content-center align-items-center my-5">
                <div class="col-11 rounded-5 my-5 sign-box pb-2" style="background-color: white;">
                    <div class="col-12 d-flex flex-wrap justify-content-center pt-3 rounded-bottom-0 rounded-5" style="background-color: #222f3e;">
                        <div class="col-2">
                            <img src="/SE_Ass_Code/Images/logoVienTrang.png" 
                                alt="logo" class="img-fluid">
                        </div>
                        <h1 class="text-center col-12 my-3" style="font-family: 'WindSong', san-serif; color: white;">
                            xin chào
                        </h1>
                    </div>
                    <div class="m-2">
                        <h5>
                        Xác thực với:
                        </h5>
                    </div>
                    <div class="m-2 text-center border py-1 rounded">
                        <a href="/SE_Ass_Code/index.php?url=login/HCMUT" class="text-dark">
                            <i class="bi fs-4 bi-person"></i> Tài khoản HCMUT
                        </a>
                    </div>
                    <div class="m-2 text-center border py-1 rounded">
                        <a href="/SE_Ass_Code/index.php?url=login/Staff" class="text-dark">
                            <i class="bi fs-4 bi-person-lock"></i> Tài khoản Staff/Admin
                        </a>
                    </div>
                    <div class="m-2 text-end py-1">
                        <a href="/SE_Ass_Code/index.php?url=home" class="text-dark">
                            <i class="bi fs-4 bi-box-arrow-left"></i> Về Trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
