<?php
session_start();

// Kiểm tra xem người dùng có phải là nhân viên không
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    echo "Access denied. Only staff can access this page.";
    exit();
}

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "Tru*ng0512";
$dbname = "quanlyxe";
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra xem form đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['rental_id']) && isset($_POST['staff_id'])) {
    $rental_id = $_POST['rental_id'];
    $staff_id = $_POST['staff_id'];

    // Cập nhật trạng thái của đơn hàng
    $sql = "UPDATE rentals SET status = 'completed', staff_id = '$staff_id' WHERE rental_id = $rental_id";
    if ($conn->query($sql) === TRUE) {
        // Lấy thông tin hóa đơn từ bảng rentals
        $sql = "SELECT total_price, deposit_paid FROM rentals WHERE rental_id = $rental_id";
        $result = $conn->query($sql);
        $rental = $result->fetch_assoc();

        // Tạo hóa đơn
        $total_price = $rental['total_price'];
        $deposit_paid = $rental['deposit_paid'];

        $sql = "INSERT INTO invoices (rental_id, staff_id, total_price, deposit) 
                VALUES ('$rental_id', '$staff_id', '$total_price', '$deposit_paid')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Xác nhận và tạo hóa đơn thành công.";
            header("Location: confirm_orders.php"); // Chuyển hướng lại trang xác nhận đơn hàng
            exit();
        } else {
            echo "Error creating invoice: " . $conn->error;
        }
    } else {
        echo "Error updating rental status: " . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>
