<?php
// Kiểm tra xem người dùng có phải là nhân viên không
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    echo "Access denied. Only staff can access this page.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Thêm mới xe</title>
</head>

<body>
<?php include('menu.php')?>

<main class="container mt-4">
    <h1>Thêm mới xe</h1>

    <?php
    // Kết nối đến cơ sở dữ liệu
    $conn = mysqli_connect('localhost', 'root', 'Tru*ng0512', 'quanlyxe', '3306');
    if (!$conn) {
        die("Kết nối không thành công: " . mysqli_connect_error());
    }

    // Xử lý khi người dùng gửi biểu mẫu
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bike_type = mysqli_real_escape_string($conn, $_POST['bike_type']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $rental_price = mysqli_real_escape_string($conn, $_POST['rental_price']);
        $deposit = mysqli_real_escape_string($conn, $_POST['deposit']);

        // Truy vấn để thêm xe mới
        $sql = "INSERT INTO bikes (bike_type, description, rental_price, deposit) VALUES ('$bike_type', '$description', '$rental_price', '$deposit')";

        if (mysqli_query($conn, $sql)) {
            echo "<div class='alert alert-success'>Xe đã được thêm thành công!</div>";
        } else {
            echo "<div class='alert alert-danger'>Lỗi: " . mysqli_error($conn) . "</div>";
        }
    }
    ?>

    <form action="add_bike.php" method="POST">
        <div class="mb-3">
            <label for="bike_type" class="form-label">Loại xe:</label>
            <input type="text" id="bike_type" name="bike_type" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả:</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="rental_price" class="form-label">Giá thuê (theo giờ):</label>
            <input type="number" step="0.01" id="rental_price" name="rental_price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="deposit" class="form-label">Đặt cọc:</label>
            <input type="number" step="0.01" id="deposit" name="deposit" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Thêm</button>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>
