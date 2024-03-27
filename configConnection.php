<?php
// Thông tin kết nối MySQL
$servername = "localhost"; // hoặc địa chỉ IP của máy chủ MySQL
$username = "root";
$password = "HoaiDuong@789";
$database = "ql_nhansu";

// Tạo kết nối đến MySQL
$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối đến MySQL thất bại: " . $conn->connect_error);
}
// echo "Kết nối đến MySQL thành công";
?>
