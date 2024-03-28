<?php include './header.php'; ?>

<style>

</style>

<div class="themtk">
    <h1>Thêm tài khoản</h1>
    <form action="./themtk.php" method="post">
        <div class="form-group">
            <label for="">Họ và tên:</label>
            <input type="text" class="form-control" id="full_name" name="full_name">
        </div>
        <div class="form-group">
            <label for="">Email:</label>
            <input type="text" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="">Số điện thoại:</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>
        <div class="form-group">
            <label for="">Mật khẩu</label>
            <input type="text" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="">Phân quyền</label>
            <select class="" aria-label="Default select example" name="role">
                <option selected>(Tuỳ chọn)</option>
                <option value="Super Admin">Quản trị viên</option>
                <option value="Nhan Vien">Nhân viên</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Kích hoạt</label>
            <select class="" aria-label="Default select example" name="status">
                <option selected>(Tuỳ chọn)</option>
                <option value="Active">Có</option>
                <option value="Inactive">Không</option>
            </select>
        </div>

        <button class="btn btn-sucsses bg-green">Thêm tài khoản</button>
    </form>
    <a href="./quanlytaikhoan.php" class="btn bg-black">Quay lại</a>
</div>
