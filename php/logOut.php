<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa để hủy cookie
if (isset($_SESSION['user_id'])) {
    // Hủy cookie 'customer_id' và 'customer_name'
    setcookie('customer_id', '', time() - 3600, '/');
    setcookie('customer_name', '', time() - 3600, '/');

    session_destroy();
}

header("Location: index.php");
exit();
