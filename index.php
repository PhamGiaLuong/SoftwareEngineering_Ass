<?php
    require_once 'Core/router.php';
    $url = $_GET['url'] ?? '';
    Router::route($url);
