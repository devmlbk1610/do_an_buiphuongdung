<?php require_once('header.php'); ?>

<?php
$error_message = '';
if (isset($_POST['form1'])) {
    $valid = 1;
    if (empty($_POST['subject_text'])) {
        $valid = 0;
        $error_message .= 'Không được bỏ trống\n';
    }
    if (empty($_POST['message_text'])) {
        $valid = 0;
        $error_message .= 'Không được bỏ trống\n';
    }
    if ($valid == 1) {

        $subject_text = strip_tags($_POST['subject_text']);
        $message_text = strip_tags($_POST['message_text']);

        // Getting Customer Email Address
        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
        $statement->execute(array($_POST['cust_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $cust_email = $row['cust_email'];
        }

        // Getting Admin Email Address
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $admin_email = $row['contact_email'];
        }

        $order_detail = '';
        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {

            if ($row['payment_method'] == 'PayPal') :
                $payment_details = '
Transaction Id: ' . $row['txnid'] . '<br>
        		';
            elseif ($row['payment_method'] == 'Stripe') :
                $payment_details = '
Transaction Id: ' . $row['txnid'] . '<br>
Card number: ' . $row['card_number'] . '<br>
Card CVV: ' . $row['card_cvv'] . '<br>
Card Month: ' . $row['card_month'] . '<br>
Card Year: ' . $row['card_year'] . '<br>
        		';
            elseif ($row['payment_method'] == 'Bank Deposit') :
                $payment_details = '
            Transaction Details: <br>' . $row['bank_transaction_info'];

            elseif ($row['payment_method'] == 'ATM Momo') :
                $payment_details = '
            Transaction Details: <br>' . $row['bank_transaction_info'];
            endif;

            $order_detail .= '
Customer Name: ' . $row['customer_name'] . '<br>
Customer Email: ' . $row['customer_email'] . '<br>
Payment Method: ' . $row['payment_method'] . '<br>
Payment Date: ' . $row['payment_date'] . '<br>
Payment Details: <br>' . $payment_details . '<br>
Paid Amount: ' . $row['paid_amount'] . '<br>
Payment Status: ' . $row['payment_status'] . '<br>
Shipping Status: ' . $row['shipping_status'] . '<br>
Payment Id: ' . $row['payment_id'] . '<br>
            ';
        }

        $i = 0;
        $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $i++;
            $order_detail .= '
<br><b><u>Product Item ' . $i . '</u></b><br>
Product Name: ' . $row['product_name'] . '<br>
Size: ' . $row['size'] . '<br>
Color: ' . $row['color'] . '<br>
Quantity: ' . $row['quantity'] . '<br>
Unit Price: ' . $row['unit_price'] . '<br>
            ';
        }

        $statement = $pdo->prepare("INSERT INTO tbl_customer_message (subject,message,order_detail,cust_id) VALUES (?,?,?,?)");
        $statement->execute(array($subject_text, $message_text, $order_detail, $_POST['cust_id']));

        // sending email
        $to_customer = $cust_email;
        $message = '
<html><body>
<h3>Message: </h3>
' . $message_text . '
<h3>Order Details: </h3>
' . $order_detail . '
</body></html>
';
        $headers = 'From: ' . $admin_email . "\r\n" .
            'Reply-To: ' . $admin_email . "\r\n" .
            'X-Mailer: PHP/' . phpversion() . "\r\n" .
            "MIME-Version: 1.0\r\n" .
            "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Sending email to admin                  
        mail($to_customer, $subject_text, $message, $headers);

        $success_message = 'Email của bạn tới khách hàng đã được gửi thành công.';
    }
}
?>
<?php
if ($error_message != '') {
    echo "<script>alert('" . $error_message . "')</script>";
}
if ($success_message != '') {
    echo "<script>alert('" . $success_message . "')</script>";
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Báo cáo doanh thu</h1>

    </div>
    <div class="card-body">
        <form id="filter-form">
            <div class="row align-items-end">
                <div class="form-group col-md-3">
                    <label for="date_start">Ngày bắt đầu</label>
                    <input type="date" class="form-control form-control-sm" name="date_start" value="<?php echo date("Y-m-d", strtotime($date_start)) ?>">
                </div>
                <div class="form-group col-md-3">
                    <label for="date_start">Ngày kết thúc</label>
                    <input type="date" class="form-control form-control-sm" name="date_end" value="<?php echo date("Y-m-d", strtotime($date_end)) ?>">
                </div>
                <div class="form-group col-md-1">
                    <button class="btn btn-flat btn-block btn-primary btn-sm"><i class="fa fa-filter"></i> Lọc</button>
                </div>
                <div class="form-group col-md-1">
                    <button onclick="window.print()" class="btn btn-flat btn-block btn-success btn-sm" type="button" id="printBTN"><i class="fa fa-print"></i> In</button>
                </div>
            </div>
        </form>
    </div>

</section>


<section class="content">

    <div class="row">
        <div class="col-md-12">


            <div class="box box-info">

                <div class="box-body table-responsive">
                    <div class="printable">
                        <div class="row row-cols-2 justify-content-center align-items-center" id="print_header" style="display:none">
                            
                        </div>
                        <hr>
                        <table id="print_header" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Khách hàng</th>
                                    <th>Thông tin chi tiết</th>
                                    <th>Tổng số tiền thanh toán</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                $statement = $pdo->prepare("SELECT * FROM tbl_payment ORDER by id DESC");
                                $statement->execute();
                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row) {
                                    $i++;
                                ?>
                                    <tr class="<?php if ($row['payment_status'] == 'Pending') {
                                                    echo 'bg-r';
                                                } else {
                                                    echo 'bg-g';
                                                } ?>">
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            
                                            <b>Tên:</b><br> <?php echo $row['customer_name']; ?><br>
                                            <b>Email:</b><br> <?php echo $row['customer_email']; ?><br><br>
                                            
                                            <div id="model-<?php echo $i; ?>" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title" style="font-weight: bold;">Gửi tin nhắn</h4>
                                                        </div>
                                                        <div class="modal-body" style="font-size: 14px">
                                                            <form action="" method="post">
                                                                <input type="hidden" name="cust_id" value="<?php echo $row['customer_id']; ?>">
                                                                <input type="hidden" name="payment_id" value="<?php echo $row['payment_id']; ?>">
                                                                <table class="table table-bordered">
                                                                    <tr>
                                                                        <td>Tiêu đề</td>
                                                                        <td>
                                                                            <input type="text" name="subject_text" class="form-control" style="width: 100%;">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Nội dung tin nhắn</td>
                                                                        <td>
                                                                            <textarea name="message_text" class="form-control" cols="30" rows="10" style="width:100%;height: 200px;"></textarea>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><input type="submit" value="Gửi cho khách hàng" name="form1"></td>
                                                                    </tr>
                                                                </table>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Quay lại</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
                                            $statement1->execute(array($row['payment_id']));
                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result1 as $row1) {
                                                echo '<b>Sản phẩm:</b> ' . $row1['product_name'];
                                                echo '<br>(<b>Kích cỡ:</b> ' . $row1['size'];
                                                echo ', <b>Màu:</b> ' . $row1['color'] . ')';
                                                echo '<br>(<b>Số lượng:</b> ' . $row1['quantity'];
                                                echo ', <b>Đơn giá:</b> ' . $row1['unit_price'] . ' đ)';
                                                echo '<br><br>';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['paid_amount']; ?> đ</td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Xác nhận xóa</h4>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                <a class="btn btn-danger btn-ok">Xóa</a>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('table th, table td').addClass("px-1 py-2 align-middle")
        $('#filter-form').submit(function(e) {
            e.preventDefault()
            location.href = "./?&date_start=" + $('[name="date_start"]').val() + "&date_end=" + $('[name="date_end"]').val()
        })

        $('#printBTN').click(function() {
            var head = $('head').clone();
            var rep = $('#printable').clone();
            var ns = $('noscript').clone().html();
            start_loader()
            rep.prepend(ns)
            rep.prepend(head)
            rep.find('#print_header').show()
            var nw = window.document.open('', '_blank', 'width=900,height=600')
            nw.document.write(rep.html())
            nw.document.close()
            setTimeout(function() {
                nw.print()
                setTimeout(function() {
                    nw.close()
                    end_loader()
                }, 200)
            }, 300)
        })
    })
</script>


<?php require_once('footer.php'); ?>