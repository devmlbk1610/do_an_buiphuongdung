<?php require_once('header.php'); ?>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
foreach ($result as $row) {
    $banner_checkout = $row['banner_checkout'];
}
?>

<?php
if(!isset($_SESSION['cart_p_id'])) {
    header('location: cart.php');
    exit;
}
?>

<div class="page-banner" style="background-image: url(assets/uploads/<?php echo $banner_checkout; ?>)">
    <div class="overlay"></div>
    <div class="page-banner-inner">
        <h1>Thanh toán</h1>
    </div>
</div>

<div class="page">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <?php if(!isset($_SESSION['customer'])): ?>
                    <p>
                        <a href="login.php" class="btn btn-md btn-danger"><?php echo LANG_VALUE_160; ?></a>
                    </p>
                <?php else: ?>

                <h3 class="special">Chi tiết đơn hàng</h3>
                <div class="cart">
                    <table class="table table-responsive table-hover table-bordered">
                        <tr>
                            <th><?php echo '#' ?></th>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Loại</th>
                            <th>Màu</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th class="text-right">Tổng giá</th>
                        </tr>
                         <?php
                        $table_total_price = 0;

                        $i=0;
                        foreach($_SESSION['cart_p_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_size_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_size_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_id'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_id[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_color_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_color_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_qty'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_qty[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_current_price'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_current_price[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_name'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_name[$i] = $value;
                        }

                        $i=0;
                        foreach($_SESSION['cart_p_featured_photo'] as $key => $value) 
                        {
                            $i++;
                            $arr_cart_p_featured_photo[$i] = $value;
                        }
                        ?>
                        <?php for($i=1;$i<=count($arr_cart_p_id);$i++): ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td>
                                <img src="assets/uploads/<?php echo $arr_cart_p_featured_photo[$i]; ?>" alt="">
                            </td>
                            <td><?php echo $arr_cart_p_name[$i]; ?></td>
                            <td><?php echo $arr_cart_size_name[$i]; ?></td>
                            <td><?php echo $arr_cart_color_name[$i]; ?></td>
                            <td><?php echo $arr_cart_p_current_price[$i]; ?> đ</td>
                            <td><?php echo $arr_cart_p_qty[$i]; ?></td>
                            <td class="text-right">
                                <?php
                                $row_total_price = $arr_cart_p_current_price[$i]*$arr_cart_p_qty[$i];
                                $table_total_price = $table_total_price + $row_total_price;
                                ?>
                                <?php echo $row_total_price; ?> đ
                            </td>
                        </tr>
                        <?php endfor; ?>           
                        <tr>
                            <th colspan="7" class="total-text">Tổng giá tất cả các sản phẩm</th>
                            <th class="total-amount"><?php echo $table_total_price; ?> đ</th>
                        </tr>
                        <?php
                        $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost WHERE country_id=?");
                        $statement->execute(array($_SESSION['customer']['cust_country']));
                        $total = $statement->rowCount();
                        if($total) {
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $shipping_cost = $row['amount'];
                            }
                        } else {
                            $statement = $pdo->prepare("SELECT * FROM tbl_shipping_cost_all WHERE sca_id=1");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row) {
                                $shipping_cost = $row['amount'];
                            }
                        }                        
                        ?>
                        <tr>
                            <td colspan="7" class="total-text">Phí ship</td>
                            <td class="total-amount"><?php echo $shipping_cost; ?> đ</td>
                        </tr>
                        <tr>
                            <th colspan="7" class="total-text">Tổng chi phí</th>
                            <th class="total-amount">
                                <?php
                                $final_total = $table_total_price+$shipping_cost;
                                ?>
                                <?php echo $final_total; ?> đ
                            </th>
                        </tr>
                    </table> 
                </div>

                

                <div class="billing-address">
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="special">Địa chỉ thanh toán</h3>
                            <table class="table table-responsive table-bordered table-hover table-striped bill-address">
                                <tr>
                                    <td>Họ và tên</td>
                                    <td><?php echo $_SESSION['customer']['cust_b_name']; ?></p></td>
                                </tr>
                                <tr>
                                    <td>Tên công ty</td>
                                    <td><?php echo $_SESSION['customer']['cust_b_cname']; ?></td>
                                </tr>
                                <tr>
                                    <td>Số điện thoại</td>
                                    <td><?php echo $_SESSION['customer']['cust_b_phone']; ?></td>
                                </tr>
                                <tr>
                                    <td>Tỉnh</td>
                                    <td>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                        $statement->execute(array($_SESSION['customer']['cust_b_country']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            echo $row['country_name'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Địa chỉ</td>
                                    <td>
                                        <?php echo nl2br($_SESSION['customer']['cust_b_address']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Quận/Huyện/Thành phố</td>
                                    <td><?php echo $_SESSION['customer']['cust_b_city']; ?></td>
                                </tr>
                                <tr>
                                    <td>Đường</td>
                                    <td><?php echo $_SESSION['customer']['cust_b_state']; ?></td>
                                </tr>
                                <tr>
                                    <td>Mã ZIP</td>
                                    <td><?php echo $_SESSION['customer']['cust_b_zip']; ?></td>
                                </tr>                                
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h3 class="special">Địa chỉ giao hàng</h3>
                            <table class="table table-responsive table-bordered table-hover table-striped bill-address">
                                <tr>
                                    <td>Họ và tên</td>
                                    <td><?php echo $_SESSION['customer']['cust_s_name']; ?></p></td>
                                </tr>
                                <tr>
                                    <td>Tên công ty</td>
                                    <td><?php echo $_SESSION['customer']['cust_s_cname']; ?></td>
                                </tr>
                                <tr>
                                    <td>Số điện thoại</td>
                                    <td><?php echo $_SESSION['customer']['cust_s_phone']; ?></td>
                                </tr>
                                <tr>
                                    <td>Tỉnh</td>
                                    <td>
                                        <?php
                                        $statement = $pdo->prepare("SELECT * FROM tbl_country WHERE country_id=?");
                                        $statement->execute(array($_SESSION['customer']['cust_s_country']));
                                        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            echo $row['country_name'];
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Địa chỉ</td>
                                    <td>
                                        <?php echo nl2br($_SESSION['customer']['cust_s_address']); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Quận/Huyện/Thành phố</td>
                                    <td><?php echo $_SESSION['customer']['cust_s_city']; ?></td>
                                </tr>
                                <tr>
                                    <td>Đường</td>
                                    <td><?php echo $_SESSION['customer']['cust_s_state']; ?></td>
                                </tr>
                                <tr>
                                    <td>Mã ZIP</td>
                                    <td><?php echo $_SESSION['customer']['cust_s_zip']; ?></td>
                                </tr> 
                            </table>
                        </div>
                    </div>                    
                </div>

                

                <div class="cart-buttons">
                    <ul>
                        <li><a href="cart.php" class="btn btn-primary">Quay lại giỏ hàng</a></li>
                    </ul>
                </div>

				<div class="clear"></div>
                <h3 class="special">Phương thức thanh toán</h3>
                <div class="row">
                    
                    	<?php
		                $checkout_access = 1;
		                if(
		                    ($_SESSION['customer']['cust_b_name']=='') ||
		                    ($_SESSION['customer']['cust_b_cname']=='') ||
		                    ($_SESSION['customer']['cust_b_phone']=='') ||
		                    ($_SESSION['customer']['cust_b_country']=='') ||
		                    ($_SESSION['customer']['cust_b_address']=='') ||
		                    ($_SESSION['customer']['cust_b_city']=='') ||
		                    ($_SESSION['customer']['cust_b_state']=='') ||
		                    ($_SESSION['customer']['cust_b_zip']=='') ||
		                    ($_SESSION['customer']['cust_s_name']=='') ||
		                    ($_SESSION['customer']['cust_s_cname']=='') ||
		                    ($_SESSION['customer']['cust_s_phone']=='') ||
		                    ($_SESSION['customer']['cust_s_country']=='') ||
		                    ($_SESSION['customer']['cust_s_address']=='') ||
		                    ($_SESSION['customer']['cust_s_city']=='') ||
		                    ($_SESSION['customer']['cust_s_state']=='') ||
		                    ($_SESSION['customer']['cust_s_zip']=='')
		                ) {
		                    $checkout_access = 0;
		                }
		                ?>
		                <?php if($checkout_access == 0): ?>
		                	<div class="col-md-12">
				                <div style="color:red;font-size:22px;margin-bottom:50px;">
			                        You must have to fill up all the billing and shipping information from your dashboard panel in order to checkout the order. Please fill up the information going to <a href="customer-billing-shipping-update.php" style="color:red;text-decoration:underline;">this link</a>.
			                    </div>
	                    	</div>
	                	<?php else: ?>
		                	<div class="col-md-4">
		                		
	                            <div class="row">

	                                <div class="col-md-12 form-group">
	                                    <label for="">Chọn phương thức thanh toán *</label>
	                                    <select name="payment_method" class="form-control select2" id="advFieldsStatus">
	                                        <option value="">-- Chọn --</option>
	                                        <option value="PayPal"><?php echo LANG_VALUE_36; ?></option>
	                                        <option value="Bank Deposit">Chuyển khoản ngân hàng</option>
	                                        <option value="Bank Deposit">Thanh toán khi nhận hàng</option>
	                                    </select>
	                                </div>

                                    <form class="paypal" action="<?php echo BASE_URL; ?>payment/paypal/payment_process.php" method="post" id="paypal_form" target="_blank">
                                        <input type="hidden" name="cmd" value="_xclick" />
                                        <input type="hidden" name="no_note" value="1" />
                                        <input type="hidden" name="lc" value="UK" />
                                        <input type="hidden" name="currency_code" value="USD" />
                                        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />

                                        <input type="hidden" name="final_total" value="<?php echo $final_total; ?>">
                                        <div class="col-md-12 form-group">
                                            <input type="submit" class="btn btn-primary" value="<?php echo LANG_VALUE_46; ?>" name="form1">
                                        </div>
                                    </form>



                                    <form action="payment/bank/init.php" method="post" id="bank_form">
                                        <input type="hidden" name="amount" value="<?php echo $final_total; ?>">
                                        <div class="col-md-12 form-group">
                                            <label for=""><?php echo LANG_VALUE_43; ?></span></label><br>
                                            <?php
                                            $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
                                            $statement->execute();
                                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result as $row) {
                                                echo nl2br($row['bank_detail']);
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for=""><?php echo LANG_VALUE_44; ?> <br><span style="font-size:12px;font-weight:normal;">(<?php echo LANG_VALUE_45; ?>)</span></label>
                                            <textarea name="transaction_info" class="form-control" cols="30" rows="10"></textarea>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <input type="submit" class="btn btn-primary" value="<?php echo LANG_VALUE_46; ?>" name="form3">
                                        </div>
                                    </form>
                                    
                                    <!-- Thanh toán khi nhận hàng -->
                                    <form action="payment/bank/init.php" method="post" id="bank_form">
                                        <input type="hidden" name="amount" value="<?php echo $final_total; ?>">
                                        <div class="col-md-12 form-group">
                                            
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <!--<label for="">Xác nhận thanh toán COD: <br><span style="font-size:12px;font-weight:normal;">(Bạn phải gõ vào "Xác nhận" hoặc số điện thoại để xác nhận đặt đơn hàng này)</span></label>
                                            <textarea name="transaction_info" class="form-control" cols="30" rows="10"></textarea>-->
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <input name="transaction_info" type="hidden" value="Xác nhận">
                                            <input type="submit" class="btn btn-primary" value="Thanh toán khi nhận hàng" name="form3">
                                        </div>
                                    </form>
	                                
                                    <form class="" method="POST" enctype="application/x-www-form-urlencoded" action="./xulymomoqr.php">
                                        <input type="submit" value="Thanh toán QR Momo">
                                    </form>

	                            </div>
		                            
		                        
		                    </div>
		                <?php endif; ?>
                        
                </div>
                

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>