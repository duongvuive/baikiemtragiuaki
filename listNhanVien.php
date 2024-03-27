<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Nhân Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 2px solid #f00;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        img {
            width: 20px;
            height: 20px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            color: #007bff;
            text-decoration: none;
            padding: 8px 16px;
            border: 1px solid #007bff;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>

<?php
    // Kết nối đến CSDL
    require_once 'configConnection.php';

    // Xác định trang hiện tại
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

    // Số nhân viên mỗi trang
    $records_per_page = 5;

    // Tính toán offset
    $offset = ($page - 1) * $records_per_page;

    // Xử lý yêu cầu đăng xuất
    if (isset($_GET['logout'])) {
        // Hủy phiên làm việc của người dùng
        session_start();
        session_unset();
        session_destroy();

        // Chuyển hướng người dùng đến trang đăng nhập
        header('Location: login.php');
        exit;
    }

    // Truy vấn CSDL với giới hạn và phân trang
    $sql = "SELECT * FROM NHANVIEN LIMIT $offset, $records_per_page";
    $result = $conn->query($sql);
        
    // Kiểm tra và hiển thị dữ liệu
    if ($result->num_rows > 0) {
        // Hiển thị dữ liệu
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th colspan='6'>Thông Tin Nhân Viên</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Mã Nhân Viên</th>";
        echo "<th>Tên Nhân Viên</th>";
        echo "<th>Giới Tính</th>";
        echo "<th>Nơi Sinh</th>";
        echo "<th>Tên Phòng</th>";
        echo "<th>Lương</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["Ma_NV"] . "</td>";
            echo "<td>" . $row["Ten_NV"] . "</td>";
            echo "<td>";
            // Kiểm tra giới tính để chèn hình ảnh tương ứng
            if ($row["Phai"] == "NU") {
                echo "<img src='woman.png' alt='Woman'>";
            } else {
                echo "<img src='man.png' alt='Man'>";
            }
            echo "</td>";
            echo "<td>" . $row["Noi_Sinh"] . "</td>";
            echo "<td>" . $row["Ma_Phong"] . "</td>";
            echo "<td>" . $row["Luong"] . "</td>";
           
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        // Tạo link phân trang
        $sql = "SELECT COUNT(*) AS total FROM NHANVIEN";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $total_pages = ceil($row["total"] / $records_per_page);

        echo "<div class='pagination'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='?page=$i'>$i</a> ";
        }
        echo "</div>";
    } else {
        echo "Không có dữ liệu";
    }
  
    // Đóng kết nối
    $conn->close();
?>

<form id="logoutForm" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="logout" value="true">
    <input type="submit" value="Đăng xuất">
</form>

</body>
</html>
