<?php

    $connect = null;
	$title = 'Đăng nhập';
	require_once("inc/header.php");
?>
<div class="widget">
	<div class="widget-title"><i class="icon-user"></i>&nbsp;Đăng nhập</div>
	<div class="widget-body">
<?php
	if(isset($_POST['submit'])) {
		$user = $_POST['user'];
		$password = md5($_POST['password']);
		$sql = "SELECT * FROM `users` where `user` = '$user' and `password` = '$password'";
		$result = $connect -> query($sql);
		if($result -> fetch_array(MYSQLI_NUM) == 0)
			echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên đăng nhập hoặc mật khẩu không đúng</div>';
		else {
			if(isset($_POST['remember']))
				setcookie('user', $user, time() + 3600 * 24 * 365, "/");
			$_SESSION['user'] = $user;
			header('Location: index.php');
		}
	}
?>
<form action="" method="POST" id="form1" name="form1">
    <table>
		<tbody>
            <tr>
                <td>Tên đăng nhập </td>
                <td><input name="user" type="text" maxlength="50" placeholder="Tên đăng nhập" required="required" /></td>
            </tr>
            <tr>
                <td>Mật khẩu </td>
                <td><input name="password" type="password" placeholder="Mật khẩu" required="required" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="checkbox" name="remember" /> Ghi nhớ&nbsp;<input type="submit" name="submit" value="Đăng nhập" class="btn" /></td>
            </tr>
        </tbody>
    </table>
</form>
<a href="forgot-password.php">Quên mật khẩu?</a>
	</div><!--end widget-body-->
</div><!--end widget-->
<?php
	require_once("inc/footer.php");
?>