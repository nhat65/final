<?php
// Thông tin kết nối CSDL
$host = 'localhost:3308'; // Thay đổi thành tên host của bạn
$dbname = 'travelWeb2'; // Thay đổi thành tên CSDL của bạn
$username = 'root'; // Thay đổi thành tên người dùng của bạn
$password = ''; // Thay đổi thành mật khẩu của bạn

try {
    // Tạo kết nối
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Thiết lập chế độ lỗi và chế độ Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Thiết lập bảng mã UTF-8
    $conn->exec("SET NAMES 'utf8mb4'");
} catch (PDOException $e) {
    // Xử lý lỗi nếu kết nối không thành công
    die("Lỗi kết nối đến CSDL: " . $e->getMessage());
}
