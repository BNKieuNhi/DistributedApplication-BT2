<?php
require_once 'models/UserModel.php';

class UserController {

    // Hiển thị trang đăng nhập
    public function showLogin() {
        require 'views/user/login.php';
    }

    // Xử lý đăng nhập
    public function handleLogin() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            echo "Please enter both username and password.";
            return;
        }

        $user = UserModel::getUserByUsername($username);

        if ($user && $password === $user['password']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];
            header("Location: index.php");
            exit;
        } else {
            echo "Invalid username or password.";
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
            exit;
        }

        $user_id = $_SESSION['user_id'];

        $user = UserModel::getUserById($user_id);
        $author = AuthorModel::find($user_id);
        $papers = UserModel::getPapersByUserId($user_id);

        if (!$user) {
            echo "User not found.";
            return;
        }

        require 'views/authors/profile.php';
    }

    // Hiển thị form cập nhật hồ sơ
    public function showEditForm() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            return;
        }

        $user_id = $_SESSION['user_id'];

        $author = AuthorModel::find($user_id);
        $user = UserModel::getUserById($user_id);
        $profile = json_decode($author->profile_json_text, true);
        require 'views/authors/edit-profile.php';
    }

    // Xử lý cập nhật hồ sơ
    public function updateProfile() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?action=login");
            return;
        }

        $user_id = $_SESSION['user_id'];
        $email = $_POST['email'] ?? '';
        $fullname = $_POST['fullname'] ?? '';
        $website = $_POST['website'] ?? '';
        $bio = $_POST['bio'] ?? '';
        $interests = $_POST['interests'] ?? '';
        $education = $_POST['education'] ?? '';
        $experience = $_POST['experience'] ?? '';

        // Xử lý ảnh đại diện
        $image_path = null;
        if (isset($_FILES['upload-photo']) && $_FILES['upload-photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/images/';
            $filename = basename($_FILES['upload-photo']['name']);
            $targetFile = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['upload-photo']['tmp_name'], $targetFile)) {
                $image_path = '/images/' . $filename; // lưu path tương đối từ assets
            }
        }

        // Cập nhật users
        UserModel::updateEmail($user_id, $email);

        // Chuẩn bị profile JSON
        $profile = [
            "bio" => $bio,
            "interests" => array_map('trim', explode(',', $interests)),
            "education" => $education,
            "experience" => $experience
        ];
        $profile_json = json_encode($profile, JSON_UNESCAPED_UNICODE);

        // Cập nhật authors
        AuthorModel::updateAuthor($user_id, $fullname, $website, $profile_json, $image_path);

        // Chuyển về trang profile
        header("Location: index.php?action=profile");
        exit;
    }
}
?>