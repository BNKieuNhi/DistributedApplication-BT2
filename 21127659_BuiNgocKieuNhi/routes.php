<?php
session_start();

// Kết nối CSDL
require_once 'config/config.php';

// Lấy action từ URL, mặc định là 'home'
$action = $_GET['action'] ?? 'home';

// Bộ định tuyến
switch ($action) {
    // ----- Trang chưa đăng nhập -----
    case 'home':
        require_once 'controllers/PaperController.php';
        $controller = new PaperController();
        $controller->home();
        break;

    // ----- Đăng nhập -----
    case 'login':
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        $controller->showLogin();
        break;

    case 'do-login':
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        $controller->login();
        break;

    case 'logout':
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        $controller->logout();
        break;

    // ----- Trang tìm kiếm -----
    case 'search':
        require_once 'controllers/SearchController.php';
        $controller = new SearchController();
        $controller->showSearchPage();
        break;

    case 'do-search':
        require_once 'controllers/SearchController.php';
        $controller = new SearchController();
        $controller->search();
        break;

    // ----- Trang danh sách bài báo -----
    case 'list':
        require_once 'controllers/PaperController.php';
        $controller = new PaperController();
        $controller->list();
        break;

    // ----- Thêm bài báo -----
    case 'add-paper':
        require_once 'controllers/PaperController.php';
        $controller = new PaperController();
        $controller->showAddForm();
        break;

    case 'do-add-paper':
        require_once 'controllers/PaperController.php';
        $controller = new PaperController();
        $controller->addPaper();
        break;

    // ----- Chi tiết bài báo -----
    case 'paper-detail':
        require_once 'controllers/PaperController.php';
        $controller = new PaperController();
        $controller->showDetail();
        break;

    // ----- Trang người dùng (profile) -----
    case 'profile':
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        $controller->showProfile();
        break;

    case 'edit-profile':
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        $controller->showEditForm();
        break;

    case 'do-edit-profile':
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        $controller->updateProfile();
        break;

    // ----- Xử lý thêm author vào paper -----
    case 'add-author-to-paper':
        require_once 'controllers/PaperController.php';
        $controller = new PaperController();
        $controller->addAuthorToPaper();
        break;

    case 'remove-author-from-paper':
        require_once 'controllers/PaperController.php';
        $controller = new PaperController();
        $controller->removeAuthorFromPaper();
        break;

    // ----- Mặc định nếu không khớp -----
    default:
        echo "<h2>404 - Page not found</h2>";
        break;
}
?>
