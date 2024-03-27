<?php
// Kiểm tra xem người dùng đã đăng nhập chưa và có phải là admin không
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Xử lý yêu cầu thêm nhân viên khi nhấn nút "Thêm"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Xử lý dữ liệu và thêm nhân viên vào cơ sở dữ liệu
    // Đoạn code xử lý thêm nhân viên vào cơ sở dữ liệu ở đây

    // Sau khi thêm thành công, chuyển hướng đến trang danh sách nhân viên hoặc trang chính của admin
    header('Location: employee_list.php');
    exit;
}

// Xử lý yêu cầu đăng xuất
if (isset($_GET['logout'])) {
    // Hủy phiên làm việc của người dùng
    session_unset();
    session_destroy();

    // Chuyển hướng người dùng đến trang đăng nhập
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhân viên</title>
</head>
<body>
    <h2>Thêm Nhân viên</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <!-- Định dạng biểu mẫu để nhập thông tin nhân viên -->
        <label for="name">Họ và Tên:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" required><br>

        <!-- Thêm các trường dữ liệu khác cần thiết cho nhân viên -->

        <input type="submit" value="Thêm">
    </form>
    
    <!-- Form đăng xuất -->
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="logout" value="true">
        <input type="submit" value="Đăng xuất">
    </form>
</body>
</html>
