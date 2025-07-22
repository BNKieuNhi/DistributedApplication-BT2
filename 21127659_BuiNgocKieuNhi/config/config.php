<?php
    function connect() {
        $host = 'localhost';
        $username = 'root';        
        $password = '';            
        $dbname = 'paper_management'; 

        // Kết nối CSDL
        $conn = new mysqli($host, $username, $password, $dbname);

        // Kiểm tra lỗi kết nối
        if ($conn->connect_error) {
            die("❌ Kết nối CSDL MySQL thất bại: " . $conn->connect_error);
        }
        // echo "Kết nối CSDL MySQL thành công.";
        // Thiết lập charset
        $conn->set_charset("utf8");
        return $conn;
    }
?>
