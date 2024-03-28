<?php include './header.php'; ?>

<style>

</style>

<?php

    require_once './conn_qltk.php';

    $getid = $_POST['id'];
    // echo $getid;

    $getdb = "SELECT * FROM tbl_user WHERE id=$getid";



    $query = mysqli_query($conn, $getdb);

    $row = mysqli_fetch_assoc($query);

?>

<div class="themtk">
    <h1>Sửa tài khoản</h1>
    
    
    <form action="./suatttk.php" method="post">
        <h3>ID: <?php echo $row['id']; ?></h3>
        <input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>">
        <div class="form-group">
            <label for="">Họ và tên:</label>
            <input type="text" class="form-control" id="full_name" name="full_name" value="<?php echo $row['full_name']; ?>">
        </div>
        <div class="form-group">
            <label for="">Email:</label>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>">
        </div>
        <div class="form-group">
            <label for="">Số điện thoại:</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $row['phone']; ?>">
        </div>
        <div class="form-group">
            <label for="">Mật khẩu</label>
            <input type="text" class="form-control" id="password" name="password" >
        </div>
        <div class="form-group">
            <label for="">Phân quyền | <?php echo $row['role']; ?></label>
            <select class="" aria-label="Default select example" name="role">
                <option selected><?php echo $row['role']; ?></option>
                <option value="Super Admin">Quản trị viên</option>
                <option value="Nhan Vien">Nhân viên</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Kích hoạt | <?php echo $row['status']; ?></label>
            <select class="" aria-label="Default select example" name="status">
                <option selected>(Tuỳ chọn)</option>
                <option value="Active">Có</option>
                <option value="Inactive">Không</option>
            </select>
        </div>

        <button class="btn btn-sucsses bg-green">Sửa tài khoản</button>
    </form>
    <a href="./quanlytaikhoan.php" class="btn bg-black">Quay lại</a>
</div>
