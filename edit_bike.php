<?php
    $bike_id  = $_POST['bike_id'];
    $bike_type  = $_POST['bike_type'];
    $description  = $_POST['description'];
    $rental_price = (float) $_POST['rental_price'];
    $deposit = (float) $_POST['deposit'];
    $availability = isset($_POST['availability']) ? 1 : 0; 

    $conn = mysqli_connect('localhost', 'root', '', 'quanlyxe','3306');
    if(!$conn){
        die("Kết nối không thành công");
    }

    $sql = "UPDATE bikes 
            SET bike_type = '$bike_type', description = '$description', rental_price = $rental_price, deposit = $deposit, availability = $availability 
            WHERE bike_id = $bike_id";
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