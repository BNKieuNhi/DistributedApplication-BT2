<?php
require_once 'models/UserModel.php';

class UserController {

    // Hiển thị trang đăng nhập
    public function showLogin() {
        require 'views/user/login.php';
    }

    // Xử lý đăng nhập
    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $model = new UserModel();
        $user = $model->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];
            header('Location: index.php');
        } else {
            $error = "Invalid username or password.";
            require 'views/user/login.php';
        }
    }

    // Đăng xuất
    public function logout() {
        session_destroy();
        header('Location: index.php');
    }

    // Hiển thị trang hồ sơ
    public function showProfile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            return;
        }

        $model = new UserModel();
        $user = $model->getUserById($_SESSION['user_id']);
        $author = $model->getAuthorById($_SESSION['user_id']);
        require 'views/authors/profile.php';
    }

    // Hiển thị form cập nhật hồ sơ
    public function showEditForm() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            return;
        }

        $model = new UserModel();
        $user = $model->getUserById($_SESSION['user_id']);
        $author = $model->getAuthorById($_SESSION['user_id']);
        require 'views/authors/edit-profile.php';
    }

    // Xử lý cập nhật hồ sơ
    public function updateProfile() {
        $full_name = $_POST['full_name'] ?? '';
        $website = $_POST['website'] ?? '';
        $profile = $_POST['profile'] ?? '';
        $image_path = $_POST['image_path'] ?? '';

        $model = new UserModel();
        $model->updateAuthor($_SESSION['user_id'], $full_name, $website, $profile, $image_path);

        header("Location: index.php?action=profile");
    }
}
?>