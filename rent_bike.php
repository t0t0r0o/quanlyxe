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

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    echo "Phải đăng nhập để thuê xe.";
    exit();
}

// Lấy bike_id từ URL
if (isset($_GET['bike_id'])) {
    $bike_id = $_GET['bike_id'];
} else {
    echo "Mã xe không hợp lệ.";
    exit();
}

// Xử lý khi form được gửi
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
    $total_price = $bike['rental_price']; // Chỉ lấy giá thuê cho một ngày, có thể thay đổi nếu cần
    $deposit_paid = $bike['deposit']; // Tiền đặt cọc

    // Thêm đơn thuê vào cơ sở dữ liệu
    $sql = "INSERT INTO rentals (user_id, bike_id, document_type, document_number, total_price, deposit_paid, status)
            VALUES ('$user_id', '$bike_id', '$document_type', '$document_number', '$total_price', '$deposit_paid', 'ongoing')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Thuê xe thành công.";
        header("Location: index.php"); // Chuyển hướng về trang dashboard
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Rent Bike</title>
</head>
<body>

<h1>Rent Bike</h1>

<form method="POST" action="rent_bike.php?bike_id=<?php echo $bike_id; ?>">
    <label for="document_type">Loại giấy tờ (e.g., CMND, GPLX):</label>
    <input type="text" id="document_type" name="document_type" required><br><br>

    <label for="document_number">Thông tin giấy tòw:</label>
    <input type="text" id="document_number" name="document_number" required><br><br>

    <button type="submit">Yêu cầu thuê xe</button>
</form>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</html>
