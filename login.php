<?php
require_once 'configConnection.php';
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['username'])) {
    header('Location: listNhanVien.php');
    exit;
}

// Kiểm tra xem có dữ liệu được gửi từ form đăng nhập không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối đến cơ sở dữ liệu
    require_once 'configConnection.php';

    // Lấy thông tin đăng nhập từ form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Tìm kiếm người dùng trong cơ sở dữ liệu
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Kiểm tra mật khẩu
        if ($password === $user['password']) { // So sánh mật khẩu trực tiếp
            // Đăng nhập thành công, lưu thông tin người dùng vào session và chuyển hướng đến trang chính
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: themNhanVien.php");
            exit;
        } else {
            $error_message = "Sai tên đăng nhập hoặc mật khẩu.";
        }
    } else {
        $error_message = "Sai tên đăng nhập hoặc mật khẩu.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        form {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }
        
        h2 {
            text-align: center;
            color: #333333;
            margin-top: 0;
        }
        
        label {
            color: #555555;
            display: block;
            margin-bottom: 5px;
        }
        
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #cccccc;
            border-radius: 3px;
            box-sizing: border-box;
            font-size: 16px;
        }
        
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        p.error {
            color: red;
            text-align: center;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Đăng nhập</h2>
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Đăng nhập">
    </form>

    <?php
    // Hiển thị thông báo lỗi nếu có
    if (isset($error_message)) {
        echo "<p class='error'>$error_message</p>";
    }
    ?>
</body>
</html>

