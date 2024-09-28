<?php
// Kiểm tra xem người dùng có phải là nhân viên không
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    echo "Access denied. Only staff can access this page.";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "Tru*ng0512";
$dbname = "quanlyxe";
// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý yêu cầu lọc
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$vehicleType = isset($_POST['vehicle_type']) ? $_POST['vehicle_type'] : '';

// Chuẩn bị câu truy vấn
$query = "
    SELECT 
        b.bike_type,
        DATE(r.start_time) AS rental_date,
        SUM(i.total_price) AS total_revenue
    FROM 
        rentals r
    JOIN 
        bikes b ON r.bike_id = b.bike_id
    JOIN 
        invoices i ON r.rental_id = i.rental_id";

// Chuẩn bị statement
$stmt = $connection->prepare($query);
$stmt->bind_param("ss", $start_date, $end_date);

// Thực thi truy vấn
$stmt->execute();
$result = $stmt->get_result();

if ($startDate && $endDate) {
    $sql .= " WHERE invoices.created_at BETWEEN ? AND ? ";
}


$sql .= " GROUP BY 
        b.bike_type, rental_date
    ORDER BY 
        rental_date, b.bike_type";


$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tổng hợp Doanh thu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include('menu.php'); ?>
    <div class="container mt-4">
        <h1>Tổng hợp Doanh thu</h1>
        
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="start_date" class="form-label">Ngày bắt đầu</label>
                <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo htmlspecialchars($startDate); ?>">
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">Ngày kết thúc</label>
                <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo htmlspecialchars($endDate); ?>">
            </div>
            <div class="mb-3">
                <label for="vehicle_type" class="form-label">Loại xe</label>
                <input type="text" name="vehicle_type" id="vehicle_type" class="form-control" value="<?php echo htmlspecialchars($vehicleType); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Loại xe</th>
                    <th>Tổng doanh thu</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['vehicle_type']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($row['total_revenue'], 2)); ?> VNĐ</td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="text-center">Không có doanh thu nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>