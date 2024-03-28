<?php

    require_once './conn_qltk.php';
    // Nhận dữ liệu từ form
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    $md5pass = md5($password);

    // echo $id;   
    // echo $full_name;
    // echo $email;
    // echo $phone;
    // echo $md5pass;
    // echo $role;
    // echo $status;

    $query = "UPDATE tbl_user SET full_name='$full_name', email='$email', phone='$hone', password='$password', role='$role', status='$status' WHERE id='$id'";

    echo $query;
    if (mysqli_query($conn, $query)) {
        // echo "Thành Công!";
        header('location:./quanlytaikhoan.php');
    }
    
?>