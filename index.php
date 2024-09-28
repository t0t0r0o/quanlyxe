<?php

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

// Lấy danh sách xe đạp từ cơ sở dữ liệu
$sql = "SELECT * FROM bikes WHERE availability = 1"; // Lấy các xe còn có sẵn
$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Dashboard</title>
</head>
<body>
    <?php include('menu.php'); ?>

    <div class="container mt-5">
        <h1>Thuê xe đạp</h1>

        <?php if (isset($_SESSION['username'])): ?>
            <p>Chào mừng, <?php echo htmlspecialchars($_SESSION['username']); ?>! Bạn đang đăng nhập với vai trò <?php echo htmlspecialchars($_SESSION['role']); ?>.</p>
        <?php else: ?>
            <p>Bạn chưa đăng nhập. <a href="login.php">Đăng nhập</a> để thuê xe.</p>
        <?php endif; ?>

        <h2>Danh sách xe</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Loại</th>
                    <th>Mô tả</th>
                    <th>Giá thuê</th>
                    <th>Giá cọc</th>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <th>Hành động</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($bike = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($bike['bike_id']); ?></td>
                            <td><?php echo htmlspecialchars($bike['bike_type']); ?></td>
                            <td><?php echo htmlspecialchars($bike['description']); ?></td>
                            <td><?php echo htmlspecialchars($bike['rental_price']); ?> VNĐ</td>
                            <td><?php echo htmlspecialchars($bike['deposit']); ?> VNĐ</td>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <td><a href='rent_bike.php?bike_id=<?php echo $bike['bike_id']; ?>' class='btn btn-primary'>Thuê</a></td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">Không có xe nào.</td></tr>
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

