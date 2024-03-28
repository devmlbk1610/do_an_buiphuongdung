<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Quản lý tài khoản</h1>
		<a href="./them_qltk.php" class="btn bg-green">Thêm</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th>ID</th>
								<th width="150">Họ tên</th>
								<th width="150">Email</th>
								<th width="150">Số điện thoại</th>
								<th width="150">Phân quyền</th>
								<th width="150">Trạng thái</th>
								<th width="150">Hành động</th>
							</tr>
						</thead>
						<tbody>
							<?php
								require_once './conn_qltk.php';
								$check = "SELECT * FROM tbl_user order by id, full_name, email, phone, password, role, status";

								$query = mysqli_query($conn, $check);

								while ($row = mysqli_fetch_assoc($query)) {
									
							?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo $row['full_name']; ?></td>
								<td><?php echo $row['email']; ?></td>
								<td><?php echo $row['phone']; ?></td>
								<td><?php echo $row['role']; ?></td>
								<td><?php echo $row['status']; ?></td>
								<td>
									<form action="suatk.php" method="post">
										<input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>">
										<button>Sửa</button>
									</form>
									<form action="xoatk.php" method="post">
										<input type="hidden" id="id" name="id" value="<?php echo $row['id']; ?>">
										<button>Xoá</button>
									</form>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>



<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure want to delete this item?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-ok">Delete</a>
			</div>
		</div>
	</div>
</div>


<?php require_once('footer.php'); ?>