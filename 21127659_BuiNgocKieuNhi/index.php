<?php
// Bắt đầu session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kết nối DB và include các tệp cần thiết
require_once("config/config.php");
require_once("controllers/PaperController.php");

// Lấy action từ URL
$action = "";
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
}

// Routing
switch ($action) {
    case "list-papers":
        $controller = new PaperController();
        $controller->listAll();
        break;    
    case "home":
    default:
        $controller = new PaperController();
        $controller->home(); // trang chủ hiển thị 5 bài mới nhất theo topic
        break;
}
?>
