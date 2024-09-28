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

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$bike_id = isset($_GET['bike_id']) ? (int)$_GET['bike_id'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $document_type = $conn->real_escape_string($_POST['document_type']);
    $document_number = $conn->real_escape_string($_POST['document_number']);
    $user_id = $_SESSION['user_id'];
    
    // Lấy thông tin xe để tính giá
    $sql = "SELECT rental_price, deposit FROM bikes WHERE bike_id = $bike_id";
    $result = $conn->query($sql);
    $bike = $result->fetch_assoc();

    if (!$bike) {
        echo "Không tìm thấy xe.";
        exit();
    }

    // Tính toán tổng số tiền cho thuê
    $total_price = $bike['rental_price']; // Chỉ lấy giá thuê cho một ngày
    $deposit_paid = $bike['deposit']; // Tiền đặt cọc

    // Thêm đơn thuê vào cơ sở dữ liệu
    $sql = "INSERT INTO rentals (user_id, bike_id, document_type, document_number, total_price, deposit_paid, status)
            VALUES ('$user_id', '$bike_id', '$document_type', '$document_number', '$total_price', '$deposit_paid', 'ongoing')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Thuê xe thành công.";
        header("Location: index.php"); // Chuyển hướng về trang dashboard
        exit();
    } else {
        echo "Có lỗi xảy ra: " . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Thuê Xe</title>
</head>
<body>
<?php include('menu.php'); ?>

<div class="container mt-5">
    <h1>Thuê Xe</h1>

    <form method="POST" action="rent_bike.php?bike_id=<?php echo $bike_id; ?>">
        <div class="mb-3">
            <label for="document_type" class="form-label">Loại giấy tờ (e.g., CMND, GPLX):</label>
            <input type="text" id="document_type" name="document_type" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="document_number" class="form-label">Thông tin giấy tờ:</label>
            <input type="text" id="document_number" name="document_number" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Yêu cầu thuê xe</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
