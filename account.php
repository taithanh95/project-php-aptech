<?php

	$title = 'Tài khoản';
	require_once("inc/header.php");
?>
<div class="widget">
<?php
	if(empty($account)) {
        echo '<div class="widget-title"><i class="icon-user"></i>&nbsp;Tài khoản</div>
	<div class="widget-body">';
		echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bạn không có quyền truy cập vào đây</div></div>';
	}else {
        echo '<div class="widget-title"><i class="icon-user"></i>&nbsp;Tài khoản</div>
	<div class="widget-body">';
		$sql = "SELECT * FROM `users` where `user` = '$account'";
		$result = $connect -> query($sql);
		$row = $result ->fetch_array(MYSQLI_ASSOC);
		if(isset($_POST['update'])) {
			$fullname =  $_POST['fullname'];
			$sex =  $_POST['sex'];
			$phone = $_POST['phone'];
			$address = $_POST['address'];
			$sql = "UPDATE `users` SET `fullname` = '$fullname', `sex` = '$sex', `phone` = '$phone', `address` = '$address' WHERE `user` = '$account';";
			$result = $connect -> query($sql);
			if(isset($result)) {
				echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Cập nhật thông tin thành công</div>';
                $sql = "SELECT * FROM `users` where `user` = '$account'";
        		$result = $connect -> query($sql);
        		$row = $result ->fetch_array(MYSQLI_ASSOC);
            }
		}
		if(isset($_POST['submit'])) {
			$password = md5($_POST['password']);
			$newpassword = $_POST['newpassword'];
			$renewpassword = $_POST['renewpassword'];
            if($password != $row['password'])
				echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Mật khẩu cũ không đúng</div>';
			elseif(strlen($newpassword) < 6 OR strlen($newpassword) > 12)
                echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Mật khẩu mới quá ngắn hoặc quá dài (6 - 12 ký tự)</div>';
			elseif($renewpassword != $newpassword)
				echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Nhập lại mật khẩu mới không đúng</div>';
			else {
				$pw = md5($_POST['newpassword']);
				$sql = "UPDATE `users` SET `password` = '$pw' WHERE `user` = '$account';";
				$result = $connect -> query($sql);
				if(isset($result))
					echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Thay đổi mật khẩu thành công</div>';
			}
		}
?>
		<form action="" method="POST" id="form1" name="form1">
			<table cellpadding="4" cellspacing="0">
				<tr>
					<td>Tên đăng nhập <span class="required">*</span></td>
					<td><input type="text" name="user" disabled="disabled" value="<?php echo $row['user']; ?>" /></td>
				</tr>
				<tr>
					<td>Email <span class="required">*</span></td>
					<td><input type="email" name="email" disabled="disabled" value="<?php echo $row['email']; ?>" /></td>
				</tr>
				<tr>
					<td>Họ và tên <span class="required">*</span></td>
					<td><input type="text" name="fullname" value="<?php echo $row['fullname']; ?>" required="required" /></td>
				</tr>
				<tr>
					<td>Giới tính <span class="required">*</span></td>
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
					<td>Số điện thoại <span class="required">*</span></td>
					<td><input type="number" name="phone" value="<?php echo $row['phone']; ?>" required="required" /></td>
				</tr>
				<tr>
					<td>Địa chỉ <span class="required">*</span></td>
					<td><input type="text" name="address" value="<?php echo $row['address']; ?>" required="required" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" name="update" value="Cập nhật" class="btn" /></td>
				</tr>
			</table>
		</form>
	</div><!--end widget-body-->
	<div class="widget-title"><i class="icon-edit"></i>&nbsp;Thay đổi mật khẩu</div>
	<div class="widget-body">
		<form action="" method="POST" id="form2" name="form2">
			<table cellpadding="4" cellspacing="0">
				<tr>
					<td>Mật khẩu cũ <span class="required">*</span></td>
					<td><input type="password" name="password" required="required" /></td>
				</tr>
				<tr>
					<td>Mật khẩu mới <span class="required">*</span></td>
					<td><input type="password" name="newpassword" required="required" /></td>
				</tr>
				<tr>
					<td>Nhập lại mật khẩu mới <span class="required">*</span></td>
					<td><input type="password" name="renewpassword" required="required" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" name="submit" value="Đổi mật khẩu" class="btn" /></td>
				</tr>
			</table>
		</form>
	</div><!--end widget-body-->
<?php
    }
echo '</div><!--end widget-->';
	require_once("inc/footer.php");
?>