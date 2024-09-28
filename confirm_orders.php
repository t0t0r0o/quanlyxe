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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Confirm Orders</title>
</head>
<body>

<h1>Confirm Rental Orders</h1>

<table class="table" border="1">
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

    <?php if ($result->num_rows > 0): ?>
        <?php while ($order = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $order['rental_id']; ?></td>
                <td><?php echo $order['full_name']; ?></td>
                <td><?php echo $order['bike_type']; ?></td>
                <td><?php echo $order['document_type']; ?></td>
                <td><?php echo $order['document_number']; ?></td>
                <td><?php echo $order['total_price']; ?></td>
                <td><?php echo $order['deposit_paid']; ?></td>
                <td>
                    <form method='POST' action='confirm_order.php'>
                        <input type='hidden' name='rental_id' value='<?php echo $order['rental_id']; ?>'>
                        <input type='hidden' name='staff_id' value='<?php echo $_SESSION['user_id']; ?>'>
                        <button type='submit'>Confirm</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan='8'>Không có yêu cầu thuê.</td></tr>
    <?php endif; ?>
</table>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</html>

<?php
// Đóng kết nối
$conn->close();
?>

