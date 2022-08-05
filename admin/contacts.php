<?php

    $title = 'Liên hệ';
    require_once("../inc/header.php")
?>
<div class="widget">
<?php
    if(isset($_GET['act'])) {
        switch($_GET['act']) {
            case'read':
                $id = $_GET['id'];
                echo '<div class="widget-title"><i class="icon-comment"></i>&nbsp;Chi tiết liên hệ<span style="float: right;"><a href="'.$set['home'].'/admin/contacts.php?act=reply&id='.$id.'" class="btn"><i class="icon-envelope"></i>&nbsp;Trả lời</a>&nbsp;<a href="'.$set['home'].'/admin/contacts.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
        <div class="widget-body">';
                $sql = "SELECT * FROM `contacts` WHERE `id` = '$id'";
                $result = @mysql_query($sql);
                if(@mysql_num_rows($result) == 0)
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Liên hệ không tồn tại</div>';
                else {
                    $row = @mysql_fetch_array($result);
                    if($row['status'] == '0') {
                        $update_sql = "UPDATE `contacts` SET `status` = '1' WHERE `id` = '$id'";
                        $update_result = @mysql_query($update_sql);
                    }
?>
<table class="admintable" style="width: 100%;">
    <tbody><tr>
        <td class="key">
            Người gửi
        </td>
        <td>
            <?php echo $row['fullname']; ?>
        </td>
    </tr>
    <tr>
        <td class="key">
            Địa chỉ
        </td>
        <td>
            <?php echo $row['address']; ?>
        </td>
    </tr>
    <tr>
        <td class="key">
            Ngày gửi
        </td>
        <td>
            <?php echo $row['created']; ?>
        </td>
    </tr>
    <tr>
        <td class="key">
            Email
        </td>
        <td>
            <?php echo $row['email']; ?>
        </td>
    </tr>
    <tr>
        <td class="key">
            Điện thoại
        </td>
        <td>
            <?php echo $row['phone']; ?>
        </td>
    </tr>
    <tr>
        <td class="key">
            Tiêu đề
        </td>
        <td>
            <?php echo $row['title']; ?>
        </td>
    </tr>
    <tr>
        <td class="key">
            Nội dung
        </td>
        <td>
            <?php echo $row['content']; ?>
        </td>
    </tr>
</tbody></table>
<?php
                }
                echo '</div><!--end widget-body-->';
            break;//end case read
            case'reply':
                $id = $_GET['id'];
                echo '<div class="widget-title"><i class="icon-envelope"></i>&nbsp;Trả lời liên hệ<span style="float: right;"><a href="'.$set['home'].'/admin/contacts.php?act=read&id='.$id.'" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
        <div class="widget-body">';
                $sql = "SELECT * FROM `contacts` WHERE `id` = '$id'";
                $result = @mysql_query($sql);
                if(@mysql_num_rows($result) == 0)
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Liên hệ không tồn tại</div>';
                else {
                    $row = @mysql_fetch_array($result);
                    if(isset($_POST['submit'])) {
                        $email = $row['email'];
                        $subject = $_POST['subject'];
                        $message = $_POST['message'];
                        $from = $set['email'];
                        $header = "From: $from\r\nReply-to: $email"; 
                        if(empty($title))
                            echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tiêu đề không được để trống</div>';
                        elseif(strlen($title) < 4 OR strlen($title) > 150)
                            echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tiêu đề quá ngắn hoặc quá dài (4 - 150 ký tự)</div>';
                        elseif(empty($message))
                            echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Nội dung không được để trống</div>';
                        elseif(strlen($message) < 4 OR strlen($message) > 5000)
                            echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Nội dung quá ngắn hoặc quá dài (4 - 5000 ký tự)</div>';
                        else {
                            if(mail($email, $subject, $message, $header)) {
                				echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Trả lời tin nhắn thành công</div>';
                	        }else
                	        	echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Gửi mail không thành công</div>';
                        }
                    }
?>
<form action="" method="POST" name="form1">
<table class="admintable" style="width: 100%;">
    <tbody><tr>
        <td class="key">
            Gửi đến <span style="color: #F00;">*</span>
        </td>
        <td>
            <input name="email" type="text" value="<?php echo $row['email']; ?>" disabled="disabled" style="width:400px;" />
        </td>
    </tr>
    <tr>
        <td class="key">
            Tiêu đề <span style="color: #F00;">*</span>
        </td>
        <td>
            <input name="subject" type="text" value="Re: <?php echo $row['title']; ?>" style="width:400px;" required="required" />
        </td>
    </tr>
    <tr>
        <td class="key">
            Nội dung <span style="color: #F00;">*</span>
        </td>
        <td>
            <textarea name="message" rows="5" cols="20" style="width:400px;" required="required"></textarea>
        </td>
    </tr>
    <tr>
        <td class="key"></td>
        <td>
            <input type="submit" name="submit" value="Gửi" class="btn" />
        </td>
    </tr>
</tbody></table>
</form>
<?php
                }
                echo '</div><!--end widget-body-->';
            break;//end case reply
            case'delete':
                $id = $_GET['id'];
                echo '<div class="widget-title"><i class="icon-envelope"></i>&nbsp;Xóa liên hệ<span style="float: right;"><a href="'.$set['home'].'/admin/contacts.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
        <div class="widget-body">';
                $sql = "SELECT * FROM `contacts` WHERE `id` = '$id'";
                $result = @mysql_query($sql);
                if(@mysql_num_rows($result) == 0)
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Liên hệ không tồn tại</div>';
                else {
                    $row = @mysql_fetch_array($result);
                    if(isset($_GET['confirm']) == 'ok') {
						$query = "DELETE FROM `contacts` WHERE `id` = '$id'";
						$res = @mysql_query($query);
						if(isset($res))
							echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Xóa liên hệ thành công</div>';
					}else
						echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Bạn chắc chắn muốn xóa liên hệ từ: '.$row['fullname'].'<br /><br /><a href="'.$set['home'].'/admin/contacts.php?act=delete&id='.$id.'&confirm=ok" class="btn"><i class="icon-ok-sign"></i>&nbsp;Tiếp tục</a></div>';
                }
                echo '</div><!--end widget-body-->';
            break;//end case delete
        }
    }else {
        echo '<div class="widget-title"><i class="icon-comment"></i>&nbsp;Liên hệ<span style="float: right;"><a href="'.$set['home'].'/admin/" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
        <div class="widget-body">';
        $display = 10;
        $query = "SELECT COUNT(`id`) FROM `contacts`";
        $res = @mysql_query($query);
        $rows = @mysql_fetch_array($res);
        $record = $rows[0];
        $count = ceil($record/$display);
        if(isset($_GET['page']))
            $page = $_GET['page'];
        if(empty($page) OR $page < 1 OR $page > $count)
            $page = 1;
        $start = ($page - 1)*$display;
        $sql = "SELECT * FROM `contacts` ORDER BY `id` DESC LIMIT $start,$display";
        $result = @mysql_query($sql);
        if(@mysql_num_rows($result) == 0)
            echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có liên hệ nào</div>';
        else {
            echo '<table class="table table-striped table-bordered dataTable" cellspacing="0" style="width:100%;border-collapse:collapse;">
		<tbody>
		<tr>
			<th scope="col">#</th><th scope="col">Người gửi</th><th scope="col">Tiêu đề</th><th scope="col">Nội dung</th><th scope="col">Ngày gửi</th><th scope="col">Trạng thái</th><th scope="col">&nbsp;</th>
		</tr>';
            $i = 0;
            while($row = @mysql_fetch_array($result)) {
                $i++;
?>
          <tr class="row0">
				<td align="center" style="width:8px;">
					<?php echo $i; ?>
				</td><td>
					   <?php echo $row['fullname']; ?>
				</td>
                <td>
					 <?php echo $row['title']; ?>
				</td>
                <td>
					 <?php echo $row['content']; ?>
				</td>
                <td>
					 <?php echo $row['created']; ?>
				</td>
                <td>
                    <?php
						if($row['status']=='1')
							echo 'Đã đọc';
						else
							echo '<span style="color: green;">Chưa đọc</span>';
					?>
				</td>
				<td class="text-center" align="center">
					<a href="<?php echo ''.$set['home'].'/admin/contacts.php?act=read&id='.$row['id'].''; ?>" title="Đọc liên hệ" class="link-btn">
						<i class="icon-eye-open"></i>
					</a>
					<a href="<?php echo ''.$set['home'].'/admin/contacts.php?act=delete&id='.$row['id'].''; ?>" title="Xóa liên hệ" class="link-btn">
						<i class="icon-trash"></i>
					</a>
				</td>
			</tr>
<?php
            }
            echo '</tbody></table>';
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
        }
        echo '</div><!--end widget-body-->';
    }
?>
</div><!--end widget-->
<?php
    require_once("../inc/footer.php")
?>