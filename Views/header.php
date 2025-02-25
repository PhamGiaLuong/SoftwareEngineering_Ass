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
    <body>
        <!-- Navigation bar -->
        <div class="navbar nbar navbar-light fixed-top navbar-expand-lg" style="font-family: 'Signika Negative';">
            <div class="container-fluid">
                <div class="col-3">
                    <a class="col-12 d-flex navbar-brand" href="/SE_Ass_Code/index.php">
                        <div> 
                            <img src="/se_ass_code/Images/logoVienTrang.png" alt="Logo" width="50px">
                        </div>
                        <div class="col-11 d-flex flex-wrap fs-6 text-white">
                            <div class="col-12 ps-2">HỆ THỐNG QUẢN LÝ VÀ ĐẶT CHỖ</div>
                            <div class="col-12 ps-2">KHÔNG GIAN TỰ HỌC THÔNG MINH</div>
                        </div>
                    </a>
                </div>
                
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                    aria-labelledby="offcanvasDarkNavbarLabel" >
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">BK STUDY SPACE</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link nlink active px-2" aria-current="page" href="" data-tab="home">TRANG CHỦ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nlink px-2" href="" data-tab="statistic">THỐNG KÊ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nlink px-2" href="" data-tab="booking">ĐẶT PHÒNG</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nlink px-2" href="" data-tab="chat">
                                    <span class="material-icons-round">forum</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle text-white" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-icons-round">account_circle</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="" data-tab="account">
                                                Tài khoản
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="" data-tab="account">
                                                Lịch sử đặt phòng
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="" data-tab="account">
                                                Đăng nhập
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
                    aria-controls="offcanvasDarkNavbar" style="border: none;">
                    <span class="material-icons-round" style="color: white;">menu</span>
                </button>
            </div>
        </div>