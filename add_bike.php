<?php
// Kiểm tra xem người dùng có phải là nhân viên không
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    echo "Access denied. Only staff can access this page.";
    exit();
}

    $bike_type = $_POST['bike_type'];
    $description  = $_POST['description'];
    $rental_price = (float) $_POST['rental_price'];
    $deposit  = (float) $_POST['deposit'];

     
    $conn = mysqli_connect('localhost', 'root', 'Tru*ng0512', 'quanlyxe','3306');
    if(!$conn){
        die("Kết nối không thành công");
    }

    $sql = "INSERT INTO bikes (bike_type, description, rental_price, deposit) 
            VALUES ('$bike_type', '$description', $rental_price, $deposit)";

    $result = mysqli_query($conn,$sql);

    if($result>0)
    {
        header('location:quanlyxe.php');
    }
    else
    {
        header('location:error.php');
    }
?>