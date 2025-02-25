<?php
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

        // Kiểm tra file Controller có tồn tại không
        if (file_exists("app/controllers/$controllerName.php")) {
            require_once "app/controllers/$controllerName.php";
            $controller = new $controllerName();

            // Kiểm tra method có tồn tại trong Controller không
            if (method_exists($controller, $method)) {
                call_user_func_array([$controller, $method], $params);
            } else {
                echo "Lỗi: Phương thức '$method' không tồn tại trong '$controllerName'";
            }
        } else {
            echo "Lỗi: Controller '$controllerName' không tồn tại";
        }
    }
}
?>
