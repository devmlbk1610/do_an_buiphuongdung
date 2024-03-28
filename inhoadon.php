<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In hóa đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <h2>In hóa đơn cho sản phẩm:</h2>
    <h4><?php echo $_POST['name']; ?></h4>
    <table border="1" class="table">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Loại</th>
                <th>Màu</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Tổng giá</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $_POST['name']; ?></td>
                <td><?php echo $_POST['size']; ?></td>
                <td><?php echo $_POST['color']; ?></td>
                <td><?php echo $_POST['quan']; ?></td>
                <td><?php echo $_POST['unit']; ?> đ</td>
                <td><?php echo $_POST['tong']; ?> đ</td>
            </tr>
        </tbody>
    </table>
    <button onclick="window.print()" class="btn d-print-none" type="button" id="printBTN">In hóa đơn</button>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>