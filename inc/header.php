<?php

    $connect = null;
    require_once("connect.php");
	session_start();
	if(isset($_COOKIE['user']))
		$account = $_COOKIE['user'];
	elseif(isset($_SESSION['user']))
		$account = $_SESSION['user'];
	else	
		$account = '';
    $ad_user = $connect -> query("SELECT * FROM `admin` WHERE `user` = 'admin'") -> fetch_array(MYSQLI_ASSOC);
    $set = $connect -> query("SELECT * FROM `settings`") -> fetch_array(MYSQLI_ASSOC);
    $users = $connect -> query("SELECT * FROM `users` WHERE `user` = '$account'") -> fetch_array(MYSQLI_ASSOC);
    $users_id = $users['id'];
	date_default_timezone_set ("Asia/Ho_Chi_Minh");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="<?php echo $set['home']; ?>/themes/style.css" />
	<link rel="stylesheet" href="<?php echo $set['home']; ?>/themes/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo $set['home']; ?>/themes/font-awesome.css" />
	<meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name="viewport"/>
    <title><?php echo $title; ?></title>
</head>
<body>
<div id="header">
	<img src="<?php echo $set['home']; ?>/themes/logo.png" alt="logo" />
	<div id="top_menu">
		<ul>
            <?php
            if($account && $account != 'admin') {
                echo '<li class="b_right"><a href="'.$set['home'].'/orders.php">Quản lí đơn hàng</a></li>';
            ?>
			<li class="b_right">
				<a href="<?php echo $set['home']; ?>/cart.php">Giỏ hàng
            <?php
					$ok = 1;
					if(isset($_SESSION['cart'])) {
						foreach($_SESSION['cart'] as $k => $v) {
							if(isset($k))
								$ok = 2;
						}
					}
					if ($ok == 2) {
						$items = $_SESSION['cart'];
						echo ' ('.count($items).')';
					}
				}
				echo '</a></li>';
            ?>
			<?php
				if(empty($account)) {
					echo '<li class="b_right"><a href="'.$set['home'].'/register.php">Đăng ký</a></li>
			<li><a href="'.$set['home'].'/login.php">Đăng nhập</a></li>';
				}else {
					if($account == 'admin') {
						echo '<li class="b_right"><a href="'.$set['home'].'/admin/">Quản trị website</a></li>';
						echo '<li class="b_right"><a href="'.$set['home'].'/admin/account.php">'.$account.'</a></li>';
					}else {
						echo '<li class="b_right"><a href="'.$set['home'].'/account.php">'.$account.'</a></li>';
					}
					echo '<li><a href="'.$set['home'].'/logout.php">Thoát</a></li>';
				}
			?>
		</ul>
	</div>
</div>
<div id="menu_container">
	<ul>
		<li class="b_right"><a href="<?php echo $set['home']; ?>/index.php">Trang chủ</a></li>
		<li class="b_right"><a href="<?php echo $set['home']; ?>/articles.php">Tin tức</a></li>
		<li class="b_right"><a href="<?php echo $set['home']; ?>/products.php">Sản phẩm</a></li>
		<li><a href="<?php echo $set['home']; ?>/contacts.php">Liên hệ</a></li>
	</ul>
</div>
<div id="content">
	<div id="body">