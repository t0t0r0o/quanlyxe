<?php
// Kiểm tra xem người dùng có phải là nhân viên không
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    echo "Access denied. Only staff can access this page.";
    exit();
}

    $maxe =$_GET['bike_id'];
   
    $conn = mysqli_connect('localhost', 'root', 'Tru*ng0512', 'quanlyxe','3306');
    if(!$conn){
        die("Kết nối không thành công");
    }

    $sql = "delete from bikes where bike_id=$maxe";
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