<?php
// Bắt đầu session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kết nối DB và include các tệp cần thiết
require_once("config/config.php");
require_once("models/AuthorModel.php");
require_once("models/PaperModel.php");

require_once("controllers/UserController.php");
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
    case "filter":
        $controller = new PaperController();
        $topic_id = $_REQUEST["topic_id"];
        $controller->filter($topic_id);
        break;
    case "search-form":
        $authors = AuthorModel::getAll();
        $conferences = PaperModel::getAllConferences();
        $topics = PaperModel::getAllTopics();
        $controller = new PaperController();
        $controller->showSearchForm();
        break;
    case "search":
        $controller = new PaperController();
        $controller->search();
        break;
    case "login":
        $controller = new UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->handleLogin();
        } else {
            $controller->showLogin();
        }
        break;
    case 'logout':
        $controller = new UserController();
        $controller->logout();
        break;   
    case 'profile':
        $controller = new UserController();
        $controller->showProfile();
        break;  
    case 'edit-profile':
        $controller = new UserController();
        $controller->showEditForm();
        break;  
    case "update-profile":
        $controller = new UserController();
        $controller->updateProfile();
        break;
    case "add-paper":
        $controller = new PaperController();
        $controller->addNewPaper();
        break;

    case "home":
    default:
        $controller = new PaperController();
        $controller->home(); // trang chủ hiển thị 5 bài mới nhất theo topic
        break;
}
?>
