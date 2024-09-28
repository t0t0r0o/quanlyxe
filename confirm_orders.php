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

// Lấy danh sách các đơn hàng đang chờ xác nhận
$sql = "SELECT rentals.rental_id, rentals.user_id, rentals.bike_id, rentals.document_type, rentals.document_number, 
        rentals.total_price, rentals.deposit_paid, rentals.status, users.full_name, bikes.bike_type 
        FROM rentals 
        JOIN users ON rentals.user_id = users.user_id 
        JOIN bikes ON rentals.bike_id = bikes.bike_id 
        WHERE rentals.status = 'ongoing'";

$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Xác nhận thuê xe</title>
</head>
<body>
    <?php include('menu.php'); ?>
    <div class="container mt-5">
        <h1>Xác nhận thuê xe</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên người thuê</th>
                    <th>Loại xe</th>
                    <th>Loại giấy tờ</th>
                    <th>Thông tin giấy tờ</th>
                    <th>Giá thuê</th>
                    <th>Tiền cọc</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($order = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['rental_id']); ?></td>
                            <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($order['bike_type']); ?></td>
                            <td><?php echo htmlspecialchars($order['document_type']); ?></td>
                            <td><?php echo htmlspecialchars($order['document_number']); ?></td>
                            <td><?php echo htmlspecialchars($order['total_price']); ?></td>
                            <td><?php echo htmlspecialchars($order['deposit_paid']); ?></td>
                            <td>
                                <form method='POST' action='confirm_order.php' style="display:inline;">
                                    <input type='hidden' name='rental_id' value='<?php echo $order['rental_id']; ?>'>
                                    <input type='hidden' name='staff_id' value='<?php echo $_SESSION['user_id']; ?>'>
                                    <button type='submit' class='btn btn-success'>Xác nhận</button>
                                </form>
                                <form method='POST' action='delete_order.php' style="display:inline;">
                                    <input type='hidden' name='rental_id' value='<?php echo $order['rental_id']; ?>'>
                                    <input type='hidden' name='staff_id' value='<?php echo $_SESSION['user_id']; ?>'>
                                    <button type='submit' class='btn btn-danger'>Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan='8'>Không có yêu cầu thuê.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>