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
    <h2><p class="text-center fs-1 bg-success">Danh sách các loại xe cho thuê</p></h2>
    <main>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">Mã phương tiện </th>
                <th scope="col">Biển số xe</th>
                <th scope="col">Model</th>
                <th scope="col">Năm sản xuất</th>
                <th scope="col">Kiểu ô tô</th>
                <th scope="col">Giá cho thuê theo ngày</th>
                <th scope="col">Giá cho thuê theo tuần</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Sửa dữ liệu</th>
                <th scope="col">Xoá dữ liệu</th>
                </tr>
            </thead>
            <tbody>
               
                <?php 
                    $conn = mysqli_connect('localhost', 'root', '', 'quanlyxe','3306');
                    if(!$conn){
                        die("Kết nối không thành công");
                    }
    
                    $sql = "select * from Cars";
                    $result = mysqli_query($conn,$sql);
    
                    if(mysqli_num_rows($result)>0)
                    {
                      while($row= mysqli_fetch_assoc($result))
                      {
                        echo '<tr>';
                        echo '<td>'.$row['vehicle_id'].'</td>';
                        echo '<td>'.$row['license_no'].'</td>';
                        echo '<td>'.$row['model'].'</td>';
                        echo '<td>'.$row['year'].'</td>';
                        echo '<td>'.$row['ctype'].'</td>';
                        echo '<td>'.$row['drate'].'</td>';
                        echo '<td>'.$row['wrate'].'</td>';
                        echo '<td>'.$row['status'].'</td>';
                        echo '<td><a href="edit.php?id='.$row['vehicle_id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                      </svg></a></td>';
                        echo '<td><a href="delete.php?id='.$row['vehicle_id'].'"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                        <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z"/>
                      </svg></a></td>';
                        echo '</tr>';
                      }
                    }
                ?>
            
               
                
            </tbody>
        </table>
        <p class="text-center btn-success"><a href="add.php" class="text-white fw-bolder">Thêm dữ liệu</a></p>
    </main>
<?php
    mysqli_close($conn);
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>