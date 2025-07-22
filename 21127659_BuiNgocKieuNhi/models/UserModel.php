<?php
require_once 'config/config.php';

class UserModel {

    // Lấy người dùng theo username
    public function getUserByUsername($username) {
        global $conn;
        $sql = "SELECT * FROM USERS WHERE username = ? AND status = 'active'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Lấy người dùng theo ID
    public function getUserById($user_id) {
        global $conn;
        $sql = "SELECT * FROM USERS WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Lấy thông tin tác giả (AUTHOR) theo user_id
    public function getAuthorById($user_id) {
        global $conn;
        $sql = "SELECT * FROM AUTHORS WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Cập nhật thông tin tác giả
    public function updateAuthor($user_id, $full_name, $website, $profile, $image_path) {
        global $conn;
        $sql = "UPDATE AUTHORS SET full_name = ?, website = ?, profile_json_text = ?, image_path = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $full_name, $website, $profile, $image_path, $user_id);
        $stmt->execute();
    }
}
?>