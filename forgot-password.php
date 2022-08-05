<?php

    $title = 'Quên mật khẩu';
    require_once("inc/header.php");
?>
<div class="widget">
    <div class="widget-title"><i class="icon-user"></i>&nbsp;Quên mật khẩu</div>
    <div class="widget-body">
    <?php
        if(isset($_POST['submit'])) {
            $user = $_POST['user'];
            if(empty($user))
                echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bạn chưa nhập tên đăng nhập</div>';
            else {
                $sql = "SELECT * FROM `users` WHERE `user` = '$user'";
                $result = @mysql_query($sql);
                if(@mysql_num_rows($result) == 0)
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên đăng nhập không tồn tại</div>';
                else {
                    $row = @mysql_fetch_array($result);
                    $email = $row['email'];
        	        $password = rand(111111, 999999);
        	        $from = 'no-reply@localhost.com';
        	        $to = $email;
        	        $subject = 'Xác nhận thay đổi mật khẩu tài khoản '.$user.'';  
        	        $message = 'Xin chào '.$user.',\n\nMật khẩu mới cho tài khoản của bạn là: '.$password.'\n\nNếu bạn đã không thay đổi mật khẩu của mình, tài khoản của bạn có thể đã bị xâm nhập. Để quay trở lại tài khoản, bạn cần đặt lại mật khẩu của mình.\n\nMời bạn đăng nhập để thay đổi mật khẩu: '.$set['home'].'/login.php\n\nTrân trọng,';
        	        $header = "From: $from\r\nReply-to: $from";
        	        if (mail($to, $subject, $message, $header)) {
        	        	$password = md5($password);
        	        	$query = "UPDATE `users` SET `password` = '$password'";
        	        	$res = @mysql_query($query);
        	     		if(isset($res))
        				    echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Mật khẩu mới đã được gửi tới hòm thư <strong>'.$email.'</strong>, nếu không tìm thấy thư trong hòm thư hãy thử kiểm tra hòm thư SPAM nhé</div>';
       	            }else
          	        	echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Gửi mail không thành công</div>';
                }
            }
        }
    ?>
        <form action="" method="POST" name="forgot_password">
        	<table>
        		<tbody>
        			<tr>
        				<td>Tên đăng nhập :</td>
        				<td><input type="text" name="user" required="required" /></td>
        			</tr>
        			<tr>
        				<td>&nbsp;</td>
        				<td><input type="submit" name="submit" value="Tiếp tục" class="btn" /></td>
        			</tr>
        		</tbody>
        	</table>
        </form>
    </div><!--end widget-body-->
</div><!--end widget-->
<?php
    require_once("inc/footer.php");
?>