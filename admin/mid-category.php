<?php require_once('header.php'); ?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Danh mục phụ 1</h1>
	</div>
	<div class="content-header-right">
		<a href="mid-category-add.php" class="btn btn-primary btn-sm">Thêm</a>
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
			        <th>#</th>
			        <th>Tên danh mục phụ</th>
                    <th>Tên danh mục chính</th>
			        <th>Hành động</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * 
                                    FROM tbl_mid_category t1
                                    JOIN tbl_top_category t2
                                    ON t1.tcat_id = t2.tcat_id
                                    ORDER BY t1.mcat_id DESC");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
					<tr>
	                    <td><?php echo $i; ?></td>
	                    <td><?php echo $row['mcat_name']; ?></td>
                        <td><?php echo $row['tcat_name']; ?></td>
	                    <td>
	                        <a href="mid-category-edit.php?id=<?php echo $row['mcat_id']; ?>" class="btn btn-primary btn-xs">Sửa</a>
	                        <a href="#" class="btn btn-danger btn-xs" data-href="mid-category-delete.php?id=<?php echo $row['mcat_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Xoá</a>
	                    </td>
	                </tr>
            		<?php
            	}
            	?>
            </tbody>
          </table>
        </div>
      </div>
  

</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Xác nhận xoá</h4>
            </div>
            <div class="modal-body">
                <p>bạn có chắc chắn muốn xoá?</p>
                <p style="color:red;">Nếu xoá sẽ xoá toàn bộ danh mục phụ 2 của danh mục này!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Huỷ</button>
                <a class="btn btn-danger btn-ok">Xoá</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>