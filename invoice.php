<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "Tru*ng0512";
$dbname = "quanlyxe";
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Truy vấn để lấy thông tin hóa đơn
$sql = "SELECT invoices.invoice_id, invoices.rental_id, invoices.staff_id, users.full_name AS staff_name, 
               invoices.total_price, invoices.deposit, invoices.created_at 
        FROM invoices 
        JOIN users ON invoices.staff_id = users.user_id";

$result = $conn->query($sql);

// In ra câu truy vấn (chỉ để kiểm tra, có thể xóa ở phiên bản cuối cùng)
// print_r($sql);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thông tin Hóa đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css"> <!-- Tùy chọn: Thêm CSS -->
</head>

<body>
    <?php include('menu.php'); ?>
    <div class="container">
        <h1 class="mt-4">Danh sách Hóa đơn</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Mã Hóa đơn</th>
                    <th>Mã Thuê</th>
                    <th>ID Nhân viên</th>
                    <th>Tên Nhân viên</th>
                    <th>Tổng tiền</th>
                    <th>Tiền đặt cọc</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($invoice = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($invoice['invoice_id']); ?></td>
                            <td><?php echo htmlspecialchars($invoice['rental_id']); ?></td>
                            <td><?php echo htmlspecialchars($invoice['staff_id']); ?></td>
                            <td><?php echo htmlspecialchars($invoice['staff_name']); ?></td>
                            <td><?php echo htmlspecialchars($invoice['total_price']); ?> VNĐ</td>
                            <td><?php echo htmlspecialchars($invoice['deposit']); ?> VNĐ</td>
                            <td><?php echo htmlspecialchars($invoice['created_at']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Không có hóa đơn</td>
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