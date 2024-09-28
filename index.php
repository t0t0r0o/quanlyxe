<?php
session_start();

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

<h1>Thuê xe đạp</h1>

<?php if (isset($_SESSION['username'])): ?>
    <p>Chào mừng, <?php echo $_SESSION['username']; ?>! Bạn đang đăng nhập với <?php echo $_SESSION['role']; ?>.</p>
<?php else: ?>
    <p>Bạn chưa đăng nhập. <a href="login.php">Đăng nhập</a> để thuê xe.</p>
<?php endif; ?>

<h2>Danh sách xe</h2>

<table class="table" border="1">
    <tr>
        <th>ID</th>
        <th>Loại</th>
        <th>Mô tả</th>
        <th>Giá thuê</th>
        <th>Giá cọc</th>
        <?php if (isset($_SESSION['user_id'])): // Chỉ hiển thị nếu người dùng đã đăng nhập ?>
            <th>Hành động</th>
        <?php endif; ?>
    </tr>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($bike = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $bike['bike_id']; ?></td>
                <td><?php echo $bike['bike_type']; ?></td>
                <td><?php echo $bike['description']; ?></td>
                <td><?php echo $bike['rental_price']; ?></td>
                <td><?php echo $bike['deposit']; ?></td>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <td><a href='rent_bike.php?bike_id=<?php echo $bike['bike_id']; ?>'>Thuê</a></td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="5">Không có xe.</td></tr>
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

