<?php

    require_once './conn_qltk.php';
    // Nhận dữ liệu từ form
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    $md5pass = md5($password);

    // echo $full_name;
    // echo $email;
    // echo $phone;
    // echo $md5pass;
    // echo $role;
    // echo $status;

    $query = "INSERT INTO tbl_user (full_name, email, phone, password, photo, role, status) VALUES ('$full_name', '$email', '$phone', '$md5pass', '', '$role', '$status')";

    echo $query;
    if (mysqli_query($conn, $query)) {
        header('location:./quanlytaikhoan.php');
    }
    
?>