<?php

	$title = 'Đăng xuất';
	require_once("inc/header.php");
	unset($_SESSION['user']);
	setcookie('user', '', time() - 3600, "/");
    unset($_SESSION['cart']);
	header('Location: index.php');
	exit();
?>