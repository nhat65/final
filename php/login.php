<?php
include 'connection.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedHashedPassword = password_hash($row['password'], PASSWORD_DEFAULT);

        if (password_verify($password, $storedHashedPassword)) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['fName'] = $row['firstName'];
            $_SESSION['lName'] = $row['lastName'];
            $_SESSION['user_id'] = $row['id'];
            header('location: home.php');
            exit;
        } else {
            echo "Sai mật khẩu!";
        }
    } else {
        echo "Người dùng không tồn tại!";
    }
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Lấy thông tin khách hàng từ kết quả truy vấn
        mysqli_stmt_bind_result($stmt, $customer_id, $customer_name);
        mysqli_stmt_fetch($stmt);

        // Lưu thông tin khách hàng vào cookie (với thời gian sống là 1 giờ)
        setcookie('customer_id', $customer_id, time() + 3600 * 24, '/');
        setcookie('customer_name', $customer_name, time() + 3600 * 24, '/');

        // chuyển về trang trước đó
        if (isset($_SERVER['HTTP_REFERER'])) {
            $previousPage = $_SERVER['HTTP_REFERER'];
            header('Location: ' . $previousPage);
        } else {
            // Nếu không có trang trước đó, chuyển hướng về một trang index
            header('Location: index.php');
        }
    }

    $stmt->close();
    $conn->close();
}
?>
<?php
// session_start();
// ob_start();
?>

<?php
// include 'connection.php';
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $email = $_POST["email"];
//     $password = $_POST["password"];
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("ss", $email, $password);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // $stmt = mysqli_prepare($conn, $sql);
    // mysqli_stmt_bind_param($stmt, 'ss', $email, $password);
    // mysqli_stmt_execute($stmt);
    // mysqli_stmt_store_result($stmt);
// else {  
//       echo 'thất bại';

//   }
    // if ($result->num_rows > 0) {
    //     header("Location: home.php");
    // } else {
    //     echo "sai eamil password"; 
    // }
// }
