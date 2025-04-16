<?php 

// Author: Gia Luong

    require_once 'Core/router.php';
    $url = $_GET['url'] ?? '';
    Router::route($url);
