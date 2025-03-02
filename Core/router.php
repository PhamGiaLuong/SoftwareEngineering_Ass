<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
class Router {
    public static function route($url) {
        // Nếu không có URL, mặc định vào trang chủ
        if (!$url) {
            $url = 'home/index';
        }

        // Tách URL thành mảng
        $urlParts = explode('/', trim($url, '/'));

        // Lấy tên Controller (chữ cái đầu viết hoa)
        $controllerName = ucfirst($urlParts[0]) . 'Controller';
        $method = $urlParts[1] ?? 'index'; // Nếu không có method, mặc định là 'index'
        $params = array_slice($urlParts, 2); // Lấy các tham số còn lại
        
        define('TAB', $urlParts[0]);
        // Kiểm tra file Controller có tồn tại không
        if (file_exists("Controllers/$controllerName.php")) {
            require_once "Controllers/$controllerName.php";
            $controller = new $controllerName();

            // Kiểm tra method có tồn tại trong Controller không
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                $_SESSION["Notify"] = "Lỗi: Phương thức '$method' không tồn tại trong '$controllerName'";
                require_once "./Views/notification.php";
            }
        } else if ($urlParts[0] == "loginOption") {
            require_once "Controllers/LogInController.php";
            $controller = new LogInController();
            $controller->Option();
        } else if ($urlParts[0] == "logout") {
            require_once "Controllers/LogInController.php";
            $controller = new LogInController();
            $controller->logout();
        } else {
            $_SESSION["Notify"] = "<strong>404 Not Found</strong> <br> Không tìm thấy trang";
            require_once "./Views/notification.php";
        }
    }
}
?>
