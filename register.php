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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nhận dữ liệu từ form
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $address = $conn->real_escape_string($_POST['address']);
    $role = 'customer'; // Mặc định người dùng đăng ký sẽ là 'customer'
    
    // Kiểm tra xem username đã tồn tại chưa
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $error = "Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.";
    } else {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Thêm người dùng mới vào cơ sở dữ liệu
        $sql = "INSERT INTO users (username, password, full_name, email, phone_number, address, role) 
                VALUES ('$username', '$hashed_password', '$full_name', '$email', '$phone_number', '$address', '$role')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "Đăng ký thành công. Bạn có thể đăng nhập ngay.";
            header("Location: login.php"); // Chuyển hướng đến trang đăng nhập sau khi đăng ký thành công
            exit();
        } else {
            $error = "Có lỗi xảy ra: " . $conn->error;
        }
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
    <title>Đăng Ký</title>
</head>
<body class="container mt-5">

<h1>Đăng Ký</h1>

<?php if (isset($error)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<form method="POST" action="register.php">
    <div class="mb-3">
        <label for="username" class="form-label">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu:</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="full_name" class="form-label">Họ và Tên:</label>
        <input type="text" id="full_name" name="full_name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="phone_number" class="form-label">Số điện thoại:</label>
        <input type="text" id="phone_number" name="phone_number" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">Địa chỉ:</label>
        <textarea id="address" name="address" class="form-control" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Đăng Ký</button>
</form>

<p class="mt-3">Bạn đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p> <!-- Thêm đường dẫn đến trang đăng nhập -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
