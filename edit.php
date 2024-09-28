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
    <h2><p class="text-center fs-1 bg-success">Sữa dữ liệu xe cho thuê</p></h2>
    <?php
        $masoxe = $_GET['id'];
        $conn = mysqli_connect('localhost', 'root', '', 'quanlyxe','3306');
        if(!$conn){
            die("Kết nối không thành công");
        }
    
        $sql = "select * from bikes where bike_id=$masoxe";
        $result = mysqli_query($conn,$sql);
    
        if(mysqli_num_rows($result)>0)
        {
          while($row= mysqli_fetch_assoc($result))
          {
              $bike_id  = $row['bike_id'];
              $bike_type  = $row['bike_type'];
              $description  = $row['description'];
              $rental_price  = $row['rental_price'];
              $deposit  = $row['deposit'];
              $availability  = $row['availability'];
          }
        }
    ?>
    <main class="container">
        <form action ="edit_bike.php" method="post">
            <div class="mb-3">
                <label for="bike_type" class="form-label">Loại xe</label>
                <input type="text" class="form-control" id="bike_type" name="bike_type" value="<?php echo $bike_type;  ?>">
            
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <input type="text" class="form-control" id="description" name = "description" value="<?php echo $description;  ?>">
            </div>
            <div class="mb-3">
                <label for="rental_price" class="form-label">Giá thuê (giờ)</label>
                <input type="number" class="form-control" id="rental_price" name = "rental_price"  value="<?php echo $rental_price;  ?>">
            </div>
            <div class="mb-3">
                <label for="deposit" class="form-label">Tiền cọc</label>
                <input type="number" class="form-control" id="deposit" name = "deposit"  value="<?php echo  $deposit;  ?>">
            </div>
            <div class="mb-3">
                <label for="availability" class="form-label">Trạng thái</label>
                <input type="text" class="form-control" id="availability" name = "availability"  value="<?php echo  $availability;  ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    
    </main>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>