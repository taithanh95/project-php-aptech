<?php

require_once("../inc/connect.php");
session_start();
if (isset($_COOKIE['user']))
    $account = $_COOKIE['user'];
elseif (isset($_SESSION['user']))
    $account = $_SESSION['user'];
else
    $account = '';
$ad_user = @mysql_fetch_array(@mysql_query("SELECT * FROM `admin` WHERE `user` = 'admin'"));
$set = @mysql_fetch_array(@mysql_query("SELECT * FROM `settings`"));
$users = @mysql_fetch_array(@mysql_query("SELECT * FROM `users` WHERE `user` = '$account'"));
$users_id = $users['id'];
date_default_timezone_set("Asia/Ho_Chi_Minh");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name="viewport"/>
    <title>Quản trị website</title>
    <link rel="stylesheet" href="<?php echo $set['home']; ?>/themes/style.css"/>
    <link rel="stylesheet" href="<?php echo $set['home']; ?>/themes/bootstrap.css"/>
    <link rel="stylesheet" href="<?php echo $set['home']; ?>/themes/font-awesome.css"/>
</head>
<body>
<div style="text-align: center;"><h1><img src="<?php echo $set['home']; ?>/themes/logo.png" alt="logo"/></h1></div>
<div style="margin: auto; padding: 40px; background: #fff; text-align: center; max-width: 300px;">
    <?php
    if (isset($_POST['submit'])) {
        $user = $_POST['user'];
        $password = md5($_POST['password']);
        $sql = "SELECT * FROM `admin` where `user` = '$user' and `password` = '$password'";
        $result = @mysql_query($sql);
        if (@mysql_num_rows($result) == 0)
            echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên đăng nhập hoặc mật khẩu không đúng</div>';
        else {
            if (isset($_POST['remember']))
                setcookie('user', $user, time() + 3600 * 24 * 365, "/");
            $_SESSION['user'] = $user;
            header('Location: ../admin/');
            exits();
        }
    }
    ?>
    <form action="" method="POST" id="form1" name="form1">
        <div class="input-prepend">
            <span class="add-on" style="padding: 10px; color: #828283;"><i class="icon-user"></i></span>
            <input name="user" type="text" maxlength="50" placeholder="Tên đăng nhập" style="padding: 11px;"/>
        </div>
        <br/>
        <div class="input-prepend" style="margin-bottom: 6px;">
            <span class="add-on" style="padding: 10px; color: #828283;"><i class="icon-key"></i></span>
            <input name="password" type="password" placeholder="Mật khẩu" style="padding: 11px;"/>
        </div>
        <br/>
        <input type="checkbox" name="remember"/> Ghi nhớ&nbsp;<a href="<?php echo 'forgot-password.php'; ?>">Quên mật
            khẩu?</a><br/>
        <input type="submit" name="submit" value="Đăng nhập" class="btn" style="width: 267px; padding: 11px;"/>
    </form>
    <br/><a href="<?php echo $set['home']; ?>">← Quay lại trang chủ</a>
</div>
<div id="footer"></div>
</body>
</html>