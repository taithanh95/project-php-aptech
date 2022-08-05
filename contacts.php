<?php

    $connect = null;
    $title = 'Liên hệ';
    require_once("inc/header.php");
?>
<div class="widget">
    <div class="widget-title"><i class="icon-comment"></i>&nbsp;Liên hệ</div>
    <div class="widget-body">
    <?php
		if($account == 'admin') {
			echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;BQT không sử dụng được chức năng này</div>';
		}else {
			if(isset($_POST['submit'])) {
				if($_POST['captcha'] != $_SESSION['captcha'])
					echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Mã xác nhận không chính xác</div>';
				else {
					$fullname = $_POST['fullname'];
					$email = $_POST['email'];
					$sex = $_POST['sex'];
					$phone = $_POST['phone'];
					$address = $_POST['address'];
					$title = $_POST['title'];
					$content = $_POST['content'];
					$created = date("Y-m-d H:i:s");
					if(empty($fullname))
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Họ và tên không được để trống</div>';
					elseif(strlen($fullname) < 4 OR strlen($fullname) > 150)
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Vui lòng nhập chính xác Họ và tên</div>';
					elseif(empty($email))
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Email không được để trống</div>';
					elseif(!preg_match("/^[a-zA-Z0-9_.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $email))
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Vui lòng nhập chính xác Email</div>';
					elseif(empty($phone))
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Số điện thoại không được để trống</div>';
					elseif(strlen($phone) < 10 OR strlen($phone) > 11)
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Vui lòng nhập chính xác Số điện thoại</div>';
					elseif(empty($address))
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Địa chỉ không được để trống</div>';
					elseif(strlen($address) < 4 OR strlen($address) > 200)
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Vui lòng nhập chính xác Địa chỉ</div>';
					elseif(empty($title))
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tiêu đề không được để trống</div>';
					elseif(strlen($title) < 4 OR strlen($title) > 150)
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tiêu đề quá ngắn hoặc quá dài (4 - 150 ký tự)</div>';
					elseif(empty($content))
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Nội dung không được để trống</div>';
					elseif(strlen($content) < 4 OR strlen($content) > 5000)
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Nội dung quá ngắn hoặc quá dài (4 - 50000 ký tự)</div>';
					else {
						$sql = "INSERT INTO `contacts` (`fullname`, `email`, `sex`, `phone`, `address`, `title`, `content`, `created`, `status`) VALUES ('$fullname', '$email', '$sex', '$phone', '$address', '$title', '$content', '$created', '0')";
						$result = $connect -> query($sql);
						if(isset($result))
							echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Cảm ơn quý khách hàng! Thông tin liên hệ của quý khách đã được gửi đi</div>';
					}
				}            
			}
			$query = "SELECT * FROM `users` WHERE `user` = '$account'";
			$res = $connect -> query($query);
			$row = $res -> fetch_array(MYSQLI_ASSOC);
    ?>
    Xin vui lòng điền các yêu cầu vào form dưới đây và gửi cho chúng tôi. Chúng tôi sẽ trả lời bạn ngay sau khi nhận được. Xin chân thành cảm ơn!<br />
    <form action="" method="POST" id="form1" name="form1">
	<table cellpadding="4" cellspacing="0">
		<tr>
			<td align="right">Họ và tên <span class="required">*</span></td>
			<td><input type="text" name="fullname" value="<?php echo $row['fullname']; ?>" required="required" /></td>
		</tr>
		<tr>
			<td align="right">Hòm thư <span class="required">*</span></td>
			<td><input type="email" name="email" value="<?php echo $row['email']; ?>" required="required" /></td>
		</tr>
		<tr>
			<td align="right">Giới tính <span class="required">*</span></td>
			<td>
            <?php
                if($row['sex'] == 'Nam')
                    echo '<input type="radio" name="sex" value="Nam" checked="checked" />&nbsp;Nam&nbsp;<input type="radio" name="sex" value="Nữ" />&nbsp;Nữ';
                else
                    echo '<input type="radio" name="sex" value="Nam" />&nbsp;Nam&nbsp;<input type="radio" name="sex" value="Nữ" checked="checked" />&nbsp;Nữ';
            ?>
           </td>
		</tr>
		<tr>
			<td align="right">Số điện thoại <span class="required">*</span></td>
			<td><input type="number" name="phone" value="<?php echo $row['phone']; ?>" required="required" /></td>
		</tr>
		<tr>
			<td align="right">Địa chỉ <span class="required">*</span></td>
			<td><input type="text" name="address" value="<?php echo $row['address']; ?>" required="required" /></td>
		</tr>
		<tr>
			<td align="right">Tiêu đề <span class="required">*</span></td>
			<td><input type="text" name="title" required="required" /></td>
		</tr>
		<tr>
			<td align="right">Nội dung <span class="required">*</span></td>
			<td><textarea name="content" required="required"></textarea></td>
		</tr>
		<tr>
			<td align="right">Mã xác nhận <span class="required">*</span></td>
			<td><input type="text" name="captcha" required="required" style="width:30px;" />
            <?php
                $a = rand(1,10);
                $b = rand(1,10);
                $_SESSION['captcha'] = $a+$b;
                echo '<span style="background-color:#ddd;padding:6px;">'.$a.'+'.$b.'=</span>';
            ?>
            </td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td><input type="submit" name="submit" value="Gửi" class="btn" /> <input type="reset" value="Nhập lại" class="btn" /></td>
		</tr>
	</table>
	</form>
	<?php } ?>
    </div>
</div>
<?php
	require_once("inc/footer.php");
?>