<?php

    $connect = null;
	$title = 'Đăng ký';
	require_once("inc/header.php");
?>
<div class="widget">
	<div class="widget-title"><i class="icon-user"></i>&nbsp;Đăng ký</div>
	<div class="widget-body">
<?php
	if(isset($_POST['submit'])) {
		if($_POST['captcha'] != $_SESSION['kq'])
			echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Mã xác nhận không đúng</div>';
		else {
			$user = $_POST['user'];
			$email = $_POST['email'];
			$user_sql = "SELECT `user` FROM `users` WHERE `user`='$user'";
			$user_result = $connect -> query($user_sql);
			$email_sql = "SELECT `email` FROM `users` WHERE `email` = '$email'";
			$email_result = $connect -> query($email_sql);
			if($user_result -> fetch_array(MYSQLI_NUM) != 0)
				echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên đăng nhập đã tồn tại</div>';
			elseif(strlen($user) < 4 OR strlen($user) > 20)
				echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên đăng nhập quá ngắn hoặc quá dài (4 - 20 ký tự)</div>';
			elseif($email_result -> fetch_array(MYSQLI_NUM) != 0)
				echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Email đã tồn tại</div>';
			else {
				$pw = $_POST['password'];
				$repw = $_POST['repassword'];
				if($repw != $pw)
					echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Nhập lại mật khẩu không đúng</div>';
				else {
					$password = md5($_POST['password']);
					$fullname = $_POST['fullname'];
					$sex = $_POST['sex'];
					$phone = $_POST['phone'];
					$address = $_POST['address'];
					$registed = date("Y-m-d H:i:s");
					$sql = "INSERT INTO `users` (`user`, `password`, `email`, `fullname`, `sex`, `phone`, `address`, `registed`) VALUES ('$user', '$password', '$email', '$fullname', '$sex', '$phone', '$address', '$registed');";
					$result = $connect -> query($sql);
					if(isset($result))
						echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Đăng ký tài khoản thành công bạn có thể <a href="login.php">đăng nhập</a> ngay bây giờ</div>';
				}
			}
		}
	}
?>
</script>
	<form action="" method="POST" id="form1" name="form1">
	<table cellpadding="4" cellspacing="0">
		<tr>
			<td align="right">Tên đăng nhập <span class="required">*</span></td>
			<td><input type="text" name="user" required="required" /></td>
		</tr>
		<tr>
			<td align="right">Email <span class="required">*</span></td>
			<td><input type="email" name="email" required="required" /></td>
		</tr>
		<tr>
			<td align="right">Mật khẩu <span class="required">*</span></td>
			<td><input type="password" name="password" required="required" /></td>
		</tr>
		<tr>
			<td align="right">Nhập lại mật khẩu <span class="required">*</span></td>
			<td><input type="password" name="repassword" required="required" /></td>
		</tr>
		<tr>
			<td align="right">Họ và tên <span class="required">*</span></td>
			<td><input type="text" name="fullname" required="required" /></td>
		</tr>
		<tr>
			<td align="right">Giới tính <span class="required">*</span></td>
			<td><input type="radio" name="sex" value="Nam" checked="checked" />&nbsp;Nam&nbsp;<input type="radio" name="sex" value="Nữ" />&nbsp;Nữ</td>
		</tr>
		<tr>
			<td align="right">Số điện thoại <span class="required">*</span></td>
			<td><input type="number" name="phone" required="required" /></td>
		</tr>
		<tr>
			<td align="right">Địa chỉ <span class="required">*</span></td>
			<td><input type="text" name="address" required="required" /></td>
		</tr>
		<tr>
			<td align="right">Mã xác nhận <span class="required">*</span></td>
			<td><input type="text" name="captcha" required="required" style="width:30px;" />
			<?php
				$a = rand(1,10);
				$b = rand(1,10);
				$_SESSION['kq'] = $a + $b;
				echo '<span style="background-color:#ddd;padding:6px;">'.$a.'+'.$b.'=</span>';
			?>
			</td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
			<td><input type="submit" name="submit" value="Tạo tài khoản" class="btn" /> <input type="reset" value="Nhập lại" class="btn" /></td>
		</tr>
	</table>
	</form>
	</div>
</div>
<?php
	require_once("inc/footer.php");
?>