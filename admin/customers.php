<?php
    $connect = null;
    $title = 'Danh sách khách hàng';
    require_once("../inc/header.php");
?>
<div class="widget">
    <?php
        if(isset($_GET['act'])) {
            switch($_GET['act']) {
                case'delete':
                    echo '<div class="widget-title"><i class="icon-group"></i>&nbsp;Xóa khách hàng<span style="float: right;"><a href="'.$set['home'].'/admin/customers.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
    <div class="widget-body">';
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM `users` WHERE `id` = '$id'";
                    $result = $connect -> query($sql) or die(@mysql_error());
                    if($result -> fetch_array(MYSQLI_NUM) == 0)
                        	echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Khách hàng không tồn tại</div>';
                    else {
                        $row = $result -> fetch_array(MYSQLI_ASSOC);
                        if(isset($_GET['confirm']) == 'ok') {
                            $pro_comment_sql = $connect -> query("SELECT `user_id` FROM `products_comment` WHERE `user_id` = '$id'") or die(@mysql_error());
                            if($pro_comment_sql -> fetch_array(MYSQLI_NUM) != 0)
                                $connect -> query("DELETE FROM `products_comment` WHERE `user_id` = '$id'") or die(@mysql_error());
                            $art_comment_sql = $connect -> query("SELECT `user_id` FROM `articles_comment` WHERE `user_id` = '$id'") or die(@mysql_error());
                            if($art_comment_sql -> fetch_array(MYSQLI_NUM) != 0)
                                $connect -> query("DELETE FROM `articles_comment` WHERE `user_id` = '$id'") or die(@mysql_error());
                            $order_sql = $connect -> query("SELECT `id` FROM `lesson_order` WHERE `user_id` = '$id'") or die(@mysql_error());
                            if($order_sql -> fetch_array(MYSQLI_ASSOC) != 0) {
                                $row_order = $order_sql -> fetch_array(MYSQLI_NUM);
                                $connect -> query("DELETE FROM `lesson_order_detail` WHERE `order_id` = '".$row_order['id']."'") or die(@mysql_error());
                                $connect -> query("DELETE FROM `lesson_order` WHERE `id` = '".$row_order['id']."'") or die(@mysql_error());
                            }
                            $connect -> query("DELETE FROM `users` WHERE `id` = '$id'") or die(@mysql_error());
                            header('Location: customers.php');
                            exits();
                        }else {
                            $order_sql = $connect -> query("SELECT `id` FROM `lesson_order` WHERE `user_id` = '$id' AND `status` = '1' OR `status` = '2'") or die(@mysql_error());
                            if($order_sql -> fetch_array(MYSQLI_NUM) != 0) {
                                echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Đơn hàng của thành viên này đang trong trạng thái chưa xử lí hoặc đang xử lí, bạn không thể xóa</div>';
                            }else {
                                echo 'Bạn có thể xóa thành viên này: '.$row['user'].'<br />
                            Chú ý: Nếu tiếp tục, toàn bộ bình luận và đơn hàng đã xử lí của khách hàng này sẽ bị xóa<br /><br /><a href="'.$set['home'].'/admin/customers.php?act=delete&id='.$id.'&confirm=ok" class="btn">Tiếp tục</a>';
                            }
                        }
                    echo '</div><!--end widget-body--></div><!--end widget-->';
                    }
                break;
                case'edit':
                    echo '<div class="widget-title"><i class="icon-group"></i>&nbsp;Chỉnh sửa khách hàng<span style="float: right;"><a href="'.$set['home'].'/admin/customers.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
    <div class="widget-body">';
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM `users` where `id` = '$id'";
            		$result = $connect -> query($sql);
            		$row = $result -> fetch_array(MYSQLI_ASSOC);
            		if(isset($_POST['update'])) {
      		            $user = $_POST['user'];
                        $email = $_POST['email'];
                        if(strlen($user) < 4 OR strlen($user) > 20 )
                             echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên đăng nhập quá ngắn hoặc quá dài (4 - 20 ký tự)</div>';
                        else {
                			$fullname =  $_POST['fullname'];
                			$sex =  $_POST['sex'];
                			$phone = $_POST['phone'];
                			$address = $_POST['address'];
                			$update_query = "UPDATE `users` SET `user` = '$user', `email` = '$email', `fullname` = '$fullname', `sex` = '$sex', `phone` = '$phone', `address` = '$address' WHERE `id` = '$id';";
                			$update_result = $connect -> query($update_query);
                			if(isset($update_result))
                				echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Cập nhật thông tin thành công</div>';
   		                }
                    }
            		if(isset($_POST['submit'])) {
            			$newpassword = $_POST['newpassword'];
            			$renewpassword = $_POST['renewpassword'];
                        if(strlen($newpassword) < 6 OR strlen($newpassword) > 12)
                            echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Mật khẩu mới quá ngắn hoặc quá dài (6 - 12 ký tự)</div>';
            			elseif($renewpassword != $newpassword)
            				echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Nhập lại mật khẩu mới không đúng</div>';
            			else {
            				$pw = md5($_POST['newpassword']);
            				$submit_query = "UPDATE `users` SET `password` = '$pw' WHERE `id` = '$id';";
            				$submit_result = $connect -> query($submit_query);
            				if(isset($submit_result))
            					echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Thay đổi mật khẩu thành công</div>';
            			}
            		}
    ?>
        <form action="" method="POST" id="form1" name="form1">
			<table cellpadding="4" cellspacing="0">
				<tr>
					<td>Tên đăng nhập <span class="required">*</span></td>
					<td><input type="text" name="user" value="<?php echo $row['user']; ?>" /></td>
				</tr>
				<tr>
					<td>Email <span class="required">*</span></td>
					<td><input type="email" name="email" value="<?php echo $row['email']; ?>" /></td>
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
                    echo '</div><!--end widget-->';
                break;
            }
        }else {
    ?>
        <div class="widget-title"><i class="icon-group"></i>&nbsp;Danh sách khách hàng<span style="float: right;"><a href="<?php echo $set['home']; ?>/admin/" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
        <div class="widget-body">
                <?php
                    $display = 10;
                    $query = "SELECT COUNT(`id`) as total FROM `users`";
                    $res = $connect -> query($query);
                    $rows = $res -> fetch_array(MYSQLI_ASSOC);
                    $record = $rows['total'];
                    $count = ceil($record/$display);
                    if(isset($_GET['page']))
                        $page = $_GET['page'];
                    if(empty($page) OR $page < 1 OR $page > $count)
                        $page = 1;
                    $start = ($page - 1)*$display;
                    $sql = "SELECT * FROM `users` WHERE `user` != 'admin' ORDER BY `id` DESC LIMIT $start,$display";
                    $result = $connect -> query($sql);
                    if($result -> fetch_array(MYSQLI_NUM) == 0)
                        echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Chưa có khách hàng nào</div>';
                    else {
                ?>
        <table class="table table-striped table-bordered dataTable" cellspacing="0" style="width:100%;border-collapse:collapse;">
    		<tbody>
        		<tr>
        			<th scope="col">#</th>
                    <th scope="col">User</th>
                    <th scope="col">Họ tên</th>
                    <th scope="col">Giới tính</th>
                    <th scope="col">Email</th>
                    <th scope="col">Điện thoại</th>
                    <th scope="col">Thành phố</th>
                    <th scope="col">Tham gia</th>
                    <th scope="col">&nbsp;</th>
        		</tr>
                <?php
                        $i = 0;
                        while($row = $result -> fetch_array(MYSQLI_ASSOC)) {
                            $i++;
                            if($row['user'] != 'admin') {
                ?>
                <tr class="row0">
    				<td align="center">
    					<?php echo $i; ?>
    				</td>
                    <td>
       					<span style="margin-left: 0px"></span>
  					    <?php echo $row['user']; ?>
    				</td>
                    <td align="center">
    					<?php echo $row['fullname']; ?>
    				</td>
                    <td align="center">
    					<?php echo $row['sex']; ?>
    				</td>
                    <td align="center">
    					<?php echo $row['email']; ?>
    				</td>
                    <td align="center">
    					<?php echo $row['phone']; ?>
    				</td>
                    <td align="center">
    					<?php echo $row['address']; ?>
    				</td>
                    <td align="center">
    					<?php echo $row['registed']; ?>
    				</td>
    				<td class="text-center" align="center">
    					<a href="<?php echo ''.$set['home'].'/admin/customers.php?act=edit&id='.$row['id'].''; ?>" title="Chỉnh sửa khách hàng" class="link-btn">
    						<i class="icon-edit"></i>
    					</a>
    					<a id="imb_del" class="imb_delete link-btn" title="Xóa khách hàng" href="<?php echo ''.$set['home'].'/admin/customers.php?act=delete&id='.$row['id'].''; ?>">
    						<i class="icon-trash"></i>
    					</a>
    				</td>
    			</tr>
                <?php
                        }
                    }
       echo '</tbody></table>';
                }
                ?>
          <?php
          if($count > 1) {
            $pre = $page - 1;
            $next = $page + 1;
            echo '<ul class="page">';
            if($page != 1)
                echo '<li><a href="?page='.$pre.'"><<</a></li>';
            for($i = 1; $i <= $count; $i++) {
                if($page != $i)
                    echo '<li><a href="?page='.$i.'">'.$i.'</a></li>';
                else
                    echo '<li class="current">'.$i.'</li>';
            }
            if($page != $count)
                echo '<li><a href="?page='.$next.'">>></a></li>';
            echo '</ul>';
          }
          ?>
    </div><!--end widget-body-->
</div><!--end widget-->
<?php
        }
    require_once("../inc/footer.php")

?>