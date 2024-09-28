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
    <h2>
        <p class="text-center fs-1 bg-success">Thêm xe cho thuê</p>
    </h2>
    <main class="container">
        <h1>Add New Bike</h1>
        <form action="add_bike.php" method="POST">
            <label for="bike_type">Loại xe:</label>
            <input type="text" id="bike_type" name="bike_type" required><br><br>

            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" required></textarea><br><br>

            <label for="rental_price">Giá thuê (theo giờ):</label>
            <input type="number" step="0.01" id="rental_price" name="rental_price" required><br><br>

            <label for="deposit">Đặt cọc:</label>
            <input type="number" step="0.01" id="deposit" name="deposit" required><br><br>

            <button type="submit">Thêm</button>
        </form>

    </main>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>