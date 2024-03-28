<?php
	$conn = mysqli_connect("localhost","root","","db_fpt");



	$id =  $_POST['id'];
	$ten = $_POST['name'];
	$noidung = $_POST['content'];

	$query = "INSERT INTO danhgia (id_sanpham, ten, noidung) VALUES ('$id','$ten','$noidung')";

	$result = mysqli_query($conn, $query);
	
	// header('location:product.php');
?>
