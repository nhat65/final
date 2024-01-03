<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hoten = $_POST['lastname'] . " " . $_POST['firstname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = 0;

    // Kiểm tra dữ liệu nhập vào
    if (empty($hoten) || empty($email) || empty($password)) {
        echo "Vui lòng điền đầy đủ thông tin.";
        exit;
    }
    // Kiểm tra xem email đã tồn tại chưa
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $checkStmt = $conn->prepare($checkEmailQuery);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "Email đã tồn tại. Vui lòng sử dụng email khác.";
        exit;
    }

    // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Chuẩn bị câu truy vấn SQL
    $sql = "INSERT INTO users (username, email, password, gender) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Lỗi trong quá trình chuẩn bị câu truy vấn: " . $conn->error;
        exit;
    }

    // Gán các tham số và thực thi câu truy vấn
    $stmt->bind_param("ssss", $hoten, $email, $hashedPassword, $gender);
    $stmt->execute();

    // Kiểm tra lỗi trong quá trình thực thi
    if ($stmt->errno) {
        echo "Lỗi trong quá trình thực thi: " . $stmt->error;
    } else {
        // Kiểm tra xem việc thêm dữ liệu có thành công không
        if ($stmt->affected_rows > 0) {
            header('location: index.php');
            exit;
        } else {
            echo "Đăng ký người dùng thất bại.";
        }
    }

    $stmt->close();  // Đóng statement
    $conn->close();  // Đóng kết nối
}
