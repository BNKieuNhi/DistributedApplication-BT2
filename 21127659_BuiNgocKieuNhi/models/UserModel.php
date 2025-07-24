<?php
require_once 'config/config.php';

class UserModel {

    // Lấy người dùng theo username
    public static function getUserByUsername($username) {
        $conn = connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $conn->close();
        return $user;
    }

    // Lấy người dùng theo ID
    public static function getUserById($user_id) {
        $conn = connect();
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $conn->close();
        return $user;
    }
    public static function getPapersByUserId($user_id) {
        $conn = connect();
        $query = "
            SELECT p.* 
            FROM papers p
            WHERE p.user_id = ?
            ORDER BY p.paper_id DESC
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $papers = [];

        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $papers;
    }
    public static function updateEmail($user_id, $email) {
        $conn = connect();
        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE user_id = ?");
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

}
?>