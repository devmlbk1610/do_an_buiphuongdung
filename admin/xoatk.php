<?php

    require_once './conn_qltk.php';

    $id = $_POST['id'];

    $query = "DELETE FROM tbl_user WHERE id=$id";

    // echo $query;
    if (mysqli_query($conn, $query)) {
        header('location:./quanlytaikhoan.php');
    }




?>