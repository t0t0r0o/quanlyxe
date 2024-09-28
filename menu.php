<?php
session_start(); // Bắt đầu phiên làm việc
// Giả sử bạn đã lưu vai trò người dùng trong session
$userRole = $_SESSION['role'] ?? 'customer'; // Mặc định là customer nếu không có vai trò
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Menu Điều hướng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">App thuê xe</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Trang chủ</a>
                    </li>
                    <?php if ($userRole == 'customer'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Đăng xuất</a>
                        </li>
                    <?php elseif ($userRole == 'staff'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/confirm_orders.php">Xác nhận thanh toán</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/invoice.php">Hóa đơn</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Đăng xuất</a>
                        </li>
                    <?php elseif ($userRole == 'manager'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/invoice.php">Hóa đơn</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="revenue.php">Báo cáo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Đăng xuất</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
