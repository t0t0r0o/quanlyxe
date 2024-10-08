<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    echo "Chỉ có quản lý mới xem được.";
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
    <title>Document</title>
</head>

<body>
    <?php include('menu.php')?>
    <main class="container mt-4">
        <h1>Danh sách xe đạp</h1>
        
        <a href="add.php" class="btn btn-primary mb-3">Thêm mới xe</a> <!-- Nút chuyển hướng -->

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Loại xe</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Giá thuê (giờ)</th>
                    <th scope="col">Đặt cọc</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $conn = mysqli_connect('localhost', 'root', 'Tru*ng0512', 'quanlyxe', '3306');
                if (!$conn) {
                    die("Kết nối không thành công");
                }

                $sql = "SELECT * FROM bikes";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['bike_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                        echo "<td>" . number_format($row['rental_price'], 2) . " VND</td>";
                        echo "<td>" . number_format($row['deposit'], 2) . " VND</td>";
                        echo "<td>" . ($row['availability'] ? 'Available' : 'Rented') . "</td>";
                        echo "<td class='action-links'>
                            <a href='edit.php?bike_id=" . $row['bike_id'] . "'>Edit</a>
                            <a href='delete_bike.php?bike_id=" . $row['bike_id'] . "' onclick=\"return confirm('Are you sure you want to delete this bike?');\">Delete</a>
                          </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Không có xe nào</td></tr>";
                }
                ?>

            </tbody>
        </table>
    </main>
    <?php
    mysqli_close($conn);
    ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>
