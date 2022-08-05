<?php

    $connect = null;
    $title = 'Giỏ hàng';
    require_once("inc/header.php");
?>
<div class="widget">
<?php
    if(isset($_GET['act'])) {
        switch($_GET['act']) {
            case'delcart':
                $cart = $_SESSION['cart'];
                $id = $_GET['id'];
                if($id == 0) {
                    unset($_SESSION['cart']);
                    unset($_SESSION['total']);
                }else
                    unset($_SESSION['cart'][$id]);
                    header('Location: cart.php');
            break;
            case'addcart':
				if($account == 'admin') {
					header('Location: cart.php');
					exit();
				}else {					
					$id = $_GET['id'];
					if(isset($_SESSION['cart'][$id]))
						$cart = $_SESSION['cart'][$id] + 1;
					else
						$cart = 1;
					$_SESSION['cart'][$id] = $cart;
					header('Location: cart.php');
				}
            break;
            case'checkout':
            $title = 'Điền thông tin khách hàng';
?>
    <div class="widget-title"><i class="icon-edit"></i>&nbsp;Điền thông tin khách hàng</div>
    <div class="widget-body">
        <img src="themes/step2.png" width="100%" /><br /><br />
        <?php
            if(isset($_POST['submit'])) {
                if(empty($_POST['fullname']) OR strlen($_POST['fullname']) > 50)
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Vui lòng nhập đầy đủ Họ và tên và không vượt quá 50 ký tự</div>';
                elseif(empty($_POST['cmnd']))
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Số CMND không được để trống</div>';
                elseif(strlen($_POST['cmnd']) < 9 OR strlen($_POST['cmnd']) > 13 OR !is_numeric($_POST['cmnd']))
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Vui lòng nhập chính xác Số CMND</div>';
                elseif(empty($_POST['email']))
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Email không được để trống</div>';
                elseif(!preg_match("/^[a-zA-Z0-9_.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $_POST['email']))
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Vui lòng nhập chính xác Email</div>';
                elseif(empty($_POST['phone']))
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Số điện thoại không được để trống</div>';
                elseif(strlen($_POST['phone']) < 4 OR strlen($_POST['phone']) > 11)
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Vui lòng nhập chính xác Số điện thoại</div>';
                elseif(empty($_POST['address']))
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Địa chỉ không được để trống</div>';
                else {
                    $_SESSION['fullname'] = $_POST['fullname'];
                    $_SESSION['office'] = $_POST['office'];
                    $_SESSION['cmnd'] = $_POST['cmnd'];
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['sex'] = $_POST['sex'];
                    $_SESSION['phone'] = $_POST['phone'];
                    $_SESSION['address'] = $_POST['address'];
                    header('Location: cart.php?act=choosepayment');
                    exits();
                }
                
            }
            $sql = "SELECT * FROM `users` where `user` = '$account'";
        	$result = $connect -> query($sql);
        	$row = $result -> fetch_array(MYSQLI_ASSOC);
        ?>
        <form action="" method="POST" id="form1" name="form1">
    		<table>
    			<tr>
    				<td>Họ và tên <span class="required">*</span></td>
    				<td><input type="text" name="fullname" value="<?php if(empty($_SESSION['fullname'])) echo $row['fullname']; else echo $_SESSION['fullname']; ?>" required="required" /></td>
    			</tr>
                <tr>
    				<td>Tên/Địa chỉ cơ quan</td>
    				<td><input type="text" name="office" value="<?php if(isset($_SESSION['office'])) echo $_SESSION['office'] ?>" /></td>
    			</tr>
                <tr>
    				<td>Số CMND <span class="required">*</span></td>
    				<td><input type="number" name="cmnd" value="<?php if(!empty($_SESSION['cmnd'])) echo $_SESSION['cmnd']; ?>" required="required" /></td>
    			</tr>
    			<tr>
    				<td>Email <span class="required">*</span></td>
    				<td><input type="email" name="email" value="<?php if(empty($_SESSION['email'])) echo $row['email']; else echo $_SESSION['email']; ?>" required="required" /></td>
    			</tr>
    			<tr>
    				<td>Giới tính <span class="required">*</span></td>
    				<td>
                    <?php
                        if(empty($_SESSION['sex'])) {
                            if($row['sex'] == 'Nam')
                                echo '<input type="radio" name="sex" value="Nam" checked="checked" />&nbsp;Nam&nbsp;<input type="radio" name="sex" value="Nữ" />&nbsp;Nữ';
                            else
                                echo '<input type="radio" name="sex" value="Nam" />&nbsp;Nam&nbsp;<input type="radio" name="sex" value="Nữ" checked="checked" />&nbsp;Nữ';
                        }else {
                            if($_SESSION['sex'] == 'Nam')
                                echo '<input type="radio" name="sex" value="Nam" checked="checked" />&nbsp;Nam&nbsp;<input type="radio" name="sex" value="Nữ" />&nbsp;Nữ';
                            else
                                echo '<input type="radio" name="sex" value="Nam" />&nbsp;Nam&nbsp;<input type="radio" name="sex" value="Nữ" checked="checked" />&nbsp;Nữ';
                        }
                    ?>
                    </td>
    			</tr>
    			<tr>
    				<td>Số điện thoại <span class="required">*</span></td>
    				<td><input type="number" name="phone" value="<?php if(empty($_SESSION['phone'])) echo $row['phone']; else echo $_SESSION['phone']; ?>" required="required" /></td>
    			</tr>
    			<tr>
    				<td>Địa chỉ <span class="required">*</span></td>
    				<td><input type="text" name="address" value="<?php if(empty($_SESSION['address'])) echo $row['address']; else echo $_SESSION['address']; ?>" required="required" /></td>
    			</tr>
    		</table>
            <br /><br /><p style="text-align: center;"><a href="cart.php" class="btn" style="padding: 5px 12px; vertical-align: middle;">Quay lại</a>&nbsp;<input type="submit" name="submit" value="Tiếp tục" class="btn" /></p>
    	</form>
    </div><!--end widget-body-->
<?php
            break;
            case'choosepayment':
            $title = 'Chọn hình thức thanh toán';
?>
    <div class="widget-title"><i class="icon-list-alt"></i>&nbsp;Chọn hình thức thanh toán</div>
    <div class="widget-body">
        <img src="themes/step3.png" width="100%" /><br /><br />
        <?php
            $check = 0;
            $input = 0;
            if(isset($_POST['submit'])) {
                if(empty($_POST['choosepayment']))
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Quý khách chưa chọn hình thức thanh toán nào</div>';
                else {
                    $_SESSION['choosepayment'] = $_POST['choosepayment'];
                    if($_SESSION['choosepayment'] == '3') {
                        $check = 1;
                        if(empty($_POST['number_account'])) {
                                $input = 1;
                                echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Quý khách chưa nhập Số tài khoản</div>';
                        }else {
                            $number_account = intval($_POST['number_account']);
                            if(!is_int($number_account) OR strlen($number_account) < 10 OR strlen($number_account) > 20)
                                echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Vui lòng nhập chính xác số tài khoản ngân hàng</div>';
                            else {
                                $_SESSION['number_account'] = $_POST['number_account'];
                                header('Location: cart.php?act=confirm');
                                exits();
                            }
                        }
                    }else {
                        header('Location: cart.php?act=confirm');
                        exits();
                    }
                }
            }
        ?>
        Quý khách lựa chọn thanh toán theo 1 trong các hình thức sau đây:<br />
        <form action="" method="POST" name="form1">
            <input type="radio" name="choosepayment" value="1"<?php if(isset($_SESSION['choosepayment'])) {if($_SESSION['choosepayment'] == 1) echo ' checked="checked"';} ?> /> Thanh toán trực tiếp<br />
            Quý khách có thể thanh toán trực tiếp tại địa chỉ. <?php echo $ad_user['address'] ?><br />
            <input type="radio" name="choosepayment" value="2"<?php if(isset($_SESSION['choosepayment'])) {if($_SESSION['choosepayment'] == 2) echo ' checked="checked"';} ?> /> Thanh toán qua bưu điện<br />
            Người nhận: <?php echo $ad_user['fullname'] ?><br />
            Địa chỉ: <?php echo $ad_user['address'] ?><br />
            <input type="radio" name="choosepayment" value="3"<?php if(isset($_SESSION['choosepayment'])) {if($_SESSION['choosepayment'] == 3) echo ' checked="checked"';} ?><?php if($check != 0) echo ' checked="checked"' ?> /> Chuyển khoản qua ngân hàng<br />
            Số tài khoản của Quý khách<?php if($input != 0) echo ' <span class="required">*</span>' ?>: <input type="number" name="number_account" value="<?php if(isset($_SESSION['number_account']) AND $_SESSION['choosepayment'] == 3) echo $_SESSION['number_account']; ?>"<?php if($input != 0) echo ' required="required"' ?> /><br />
            <br /><br /><p style="text-align: center"><a href="?act=checkout" class="btn" style="padding: 5px 12px; vertical-align: middle;">Quay lại</a>&nbsp;<input type="submit" name="submit" value="Tiếp tục" class="btn" /></p>
        </form>
    </div>
<?php
            break;
            case'confirm':
            $title = 'Xác nhận';
?>
    <div class="widget-title"><i class="icon-tag"></i>&nbsp;Xác nhận</div>
    <div class="widget-body">
        <img src="themes/step4.png" width="100%" /><br /><br />
    		<table>
    			<tr>
    				<td>Họ và tên</td>
    				<td><input type="text" name="fullname" value="<?php echo $_SESSION['fullname']; ?>" disabled="disabled" style="width: 250px;" /></td>
    			</tr>
                <?php
                    if(!empty($_SESSION['office'])) {
                ?>
                <tr>
    				<td>Tên/Địa chỉ cơ quan</td>
    				<td><input type="text" name="office" value="<?php echo $_SESSION['office']; ?>" disabled="disabled" style="width: 250px;" /></td>
    			</tr>
                <?php } ?>
                <tr>
    				<td>Số CMND</td>
    				<td><input type="text" name="cmnd" value="<?php echo $_SESSION['cmnd']; ?>" disabled="disabled" style="width: 250px;" /></td>
    			</tr>
    			<tr>
    				<td>Email</td>
    				<td><input type="email" name="email" value="<?php echo $_SESSION['email']; ?>" disabled="disabled" style="width: 250px;" /></td>
    			</tr>
    			<tr>
    				<td>Giới tính</td>
    				<td>
                    <?php
                        if($_SESSION['sex'] == 'Nam')
                            echo '<input type="radio" name="sex" value="Nam" checked="checked" />&nbsp;Nam&nbsp;<input type="radio" name="sex" value="Nữ" disabled="disabled" />&nbsp;Nữ';
                        else
                            echo '<input type="radio" name="sex" value="Nam" disabled="disabled" />&nbsp;Nam&nbsp;<input type="radio" name="sex" value="Nữ" checked="checked" />&nbsp;Nữ';
                    ?>
                    </td>
    			</tr>
    			<tr>
    				<td>Số điện thoại</td>
    				<td><input type="number" name="phone" value="<?php echo $_SESSION['phone']; ?>" disabled="disabled" style="width: 250px;" /></td>
    			</tr>
    			<tr>
    				<td>Địa chỉ</td>
    				<td><input type="text" name="address" value="<?php echo $_SESSION['address']; ?>" disabled="disabled" style="width: 250px;" /></td>
    			</tr>
    			<tr>
    				<td>Hình thức thanh toán</td>
    				<td><textarea name="choosepayment" rows="3" disabled="disabled" style="width: 250px;"><?php
                    if($_SESSION['choosepayment'] == 1)
                        echo 'Thanh toán trực tiếp';
                    elseif($_SESSION['choosepayment'] == 2)
                        echo 'Thanh toán qua bưu điện';
                    else
                        echo 'Chuyển khoản qua ngân hàng
Số tài khoản của bạn là '.$_SESSION['number_account'].'';
                    ?></textarea></td>
    			</tr>
    		</table>
        <table class="table table-striped table-bordered dataTable" style="width:100%;">
        	<tbody>
        	<tr>
        		<th scope="col" style="width: 8px;">#</th><th scope="col">Sản phẩm</th><th scope="col" style="width: 65px;">Số lượng</th><th scope="col" style="width: 80px;">Giá</th><th scope="col" style="width: 90px;">Tổng</th>
        	</tr>
        <?php
            foreach($_SESSION['cart'] as $key => $value)
                $item[] = $key;
            $str = implode(",",$item);
            $sql = "SELECT * FROM `products` WHERE `show` = 'true' AND `id` IN ($str)";
            $result = $connect -> query($sql);
            $i = 0;
            $_SESSION['total'] = 0;
            while($row = $result -> fetch_array(MYSQLI_ASSOC)) {
                $i++;
        ?>
            <tr class="row0">
        		<td>
        			<?php echo $i; ?>
        		</td>
                <td>
        			<a href="products.php?id=<?php echo $row['id']; ?>"><?php echo $row['pro_name']; ?></a>
        		</td>
                <td>
                    <input type="text" name="sl[<?php echo $row['id']; ?>]" value="<?php echo $_SESSION['cart'][$row['id']]; ?>" style="width: 30px;" disabled="disabled" />
        		</td>
                <td>
        			<?php echo number_format($row['price'],0,",","."); ?> ₫
        		</td>
                <td>
        			<?php echo number_format($_SESSION['cart'][$row['id']]*$row['price'],0,",","."); ?> ₫
        		</td>
            </tr>
        <?php
            $_SESSION['total'] += $_SESSION['cart'][$row['id']]*$row['price'];
            }
        ?>
            </tbody>
        </table>
        <p style="float: right;">Tổng tiền thanh toán: <?php echo number_format($_SESSION['total'],0,",","."); ?>  ₫</p><br /><br />
        <br /><br /><p style="text-align: center"><a href="?act=choosepayment" class="btn" style="padding: 5px 12px; vertical-align: middle;">Quay lại</a>&nbsp;<a href="?act=success" class="btn" style="padding: 5px 12px; vertical-align: middle;">Tiếp tục</a></p>
    </div>
        <?php
            break;
            case'success':
                //lesson_order
                $fullname = $_SESSION['fullname'];
                $office = $_SESSION['office'];
                $cmnd = $_SESSION['cmnd'];
                $email = $_SESSION['email'];
                $sex = $_SESSION['sex'];
                $phone = $_SESSION['phone'];
                $address = $_SESSION['address'];
                $choosepayment = $_SESSION['choosepayment'];
                if($choosepayment == '3')
                    $number_account = $_SESSION['number_account'];
                else
                    $number_account = '';
                $total = $_SESSION['total'];
                $tg = date("Y-m-d H:i:s");
                $connect -> query("INSERT INTO `lesson_order` (`user_id`, `fullname`, `office`, `cmnd`, `email`, `sex`, `phone`, `address`, `choosepayment`, `number_account`, `total`, `date`, `status`) VALUES ('$users_id', '$fullname', '$office', '$cmnd', '$email', '$sex', '$phone', '$address', '$choosepayment', '$number_account', '$total', '$tg', '1')");
                //lesson_order_detail
                $order_id = mysqli_insert_id();
                foreach($_SESSION['cart'] as $key => $value)
                    $item[] = $key;
                $str = implode(",",$item);
                $product_sql = "SELECT * FROM `products` WHERE `show` = 'true' AND `id` IN ($str)";
                $product_result = $connect -> query($product_sql);
                while($row = $product_result -> fetch_array(MYSQLI_ASSOC)) {
                    $product_id = $row['id'];
                    $price = $row['price'];
                    $qty = $_SESSION['cart'][$row['id']];
                    $connect -> query("INSERT INTO `lesson_order_detail` (`order_id`, `product_id`, `price`, `qty`) VALUE ('$order_id', '$product_id', '$price', '$qty')");
                }
                unset($_SESSION['fullname']);
                unset($_SESSION['office']);
                unset($_SESSION['cmnd']);
                unset($_SESSION['email']);
                unset($_SESSION['sex']);
                unset($_SESSION['phone']);
                unset($_SESSION['address']);
                unset($_SESSION['choosepayment']);
                unset($_SESSION['number_account']);
                unset($_SESSION['total']);
                unset($_SESSION['cart']);
                header('Location: cart.php?act=ordercompleted');
                exits();
            break;
            case'ordercompleted':
            $title = 'Hoàn thành';
?>
    <div class="widget-title"><i class="icon-ok"></i>&nbsp;Hoàn thành</div>
    <div class="widget-body">
        <img src="themes/step5.png" width="100%" /><br /><br />
        Cảm ơn bạn đã đặt hàng tại website của chúng tôi!<br />
        Đơn hàng của bạn sẽ hoàn thành khi được thanh toán.
    </div>
<?php
            break;
        }
    }else {
?>
    <div class="widget-title"><i class="icon-shopping-cart"></i>&nbsp;Giỏ hàng</div>
    <div class="widget-body">
<?php
	if(empty($account)) {
		echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chỉ thành viên mới sử dụng được chức năng này</div>';
	}elseif($account == 'admin') {
	   echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;BQT không sử dụng được chức năng này</div>';
	}else {
    if(isset($_POST['submit'])) {
        foreach($_POST['sl'] as $key => $value) {
            $value = intval($value);
            $_SESSION['cart'][$key] = $value;
        }
        header("location: cart.php");
        exits();
    }
$ok = 1;
if(isset($_SESSION['cart'])) {
    foreach($_SESSION['cart'] as $k => $v) {
        if(isset($k))
            $ok = 2;
    }
}
if ($ok != 2)
    echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có sản phẩm nào trong giỏ hàng của bạn</div>';
else {
    $items = $_SESSION['cart'];
    foreach($_SESSION['cart'] as $key => $value)
        $item[] = $key;
    $str = implode(",",$item);
    $sql = "SELECT * FROM `products` WHERE `show` = 'true' AND `id` IN ($str)";
    $result = $connect -> query($sql);
?>
<img src="themes/step1.png" width="100%" /><br /><br />
<script>
function fcheckupdate(t)
{
	t.value=t.value.replace(/[^\d]/g,'');
	if(t.value=='' || t.value==0)
		t.value=1;
}
</script>
<form action="" method="POST" name="form1">
<table class="table table-striped table-bordered dataTable" style="width:100%;">
	<tbody>
	<tr>
		<th scope="col" style="width: 8px;">#</th><th scope="col">Sản phẩm</th><th scope="col" style="width: 65px;">Số lượng</th><th scope="col" style="width: 80px;">Giá</th><th scope="col" style="width: 90px;">Tổng</th><th scope="col" style="width: 10px;">&nbsp;</th>
	</tr>
<?php
    $i = 0;
    $_SESSION['total'] = 0;
    while($row = $result -> fetch_array(MYSQLI_ASSOC)) {
        $i++;
?>
    <tr class="row0">
		<td>
			<?php echo $i; ?>
		</td>
        <td>
			<a href="products.php?id=<?php echo $row['id']; ?>"><?php echo $row['pro_name']; ?></a>
		</td>
        <td>
            <input type="number" name="sl[<?php echo $row['id']; ?>]" value="<?php echo $_SESSION['cart'][$row['id']]; ?>" style="width: 35px;" onkeyup="fcheckupdate(this);" />
		</td>
        <td>
			<?php echo number_format($row['price'],0,",","."); ?>
		</td>
        <td>
			<?php echo number_format($_SESSION['cart'][$row['id']]*$row['price'],0,",",".").' ₫'; ?>
		</td>
        <td>
			<a href="?act=delcart&id=<?php echo $row['id']; ?>" title="Xóa sản phẩm này khỏi giỏ hàng"><i class="icon-trash "></i></a>
		</td>
    </tr>
<?php
    $_SESSION['total'] += $_SESSION['cart'][$row['id']]*$row['price'];
    }
?>
    </tbody>
</table>
<p style="float: right;">Tổng tiền thanh toán: <?php echo number_format($_SESSION['total'],0,",","."); ?>  ₫</p><br /><br />
<p style="float: right;"><input type="submit" name="submit" value="Cập nhật số lượng" class="btn" /></a>&nbsp;<a href="?act=delcart&id=0" class="btn" style="padding: 5px 12px; vertical-align: middle;">Xóa giỏ hàng</a>&nbsp;<a href="?act=checkout" class="btn" style="padding: 5px 12px; vertical-align: middle;">Thanh toán</a></p><br /><br />
</form>
<?php }
	}
    echo '</div><!--end widget-body-->';
} ?>
</div><!--end widget-->
<?php
    require_once("inc/footer.php");
?>