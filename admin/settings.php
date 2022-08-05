<?php

    $title = 'Cấu hình website';
    require_once("../inc/header.php");
?>
<div class="widget">
    <div class="widget-title"><i class="icon-wrench"></i>&nbsp;Cấu hình website<span style="float: right;"><a href="<?php echo $set['home']; ?>/admin/" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></span></div>
    <div class="widget-body">
    <?php
        if(isset($_POST['submit'])) {
            $title = $_POST['title'];
            $home = $_POST['home'];
            $email = $_POST['email'];
            $page = $_POST['page'];
            if(empty($title) OR strlen($title) < 4 OR strlen($title) > 150)
                echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tiêu đề trang quá ngắn hoặc quá dài (4 - 150 ký tự)</div>';
            elseif(empty($home))
                echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Home URL không được để trống và phải nhập chính xác</div>';
            elseif(!preg_match("/^[a-zA-Z0-9_.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $email))
                echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Vui lòng nhập chính xác Email</div>';
            elseif(empty($page) OR $page < 0 OR $page > 30)
                echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Phân trang phải lớn hơn 0 và nhỏ hơn 30</div>';
            else {
                $sql = "UPDATE `settings` SET `title` = '$title', `home` = '$home', `email` = '$email', `page` = '$page'";
                $result = @mysql_query($sql);
                if(isset($result)) {
                    echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Cập nhật thành công</div>';
                    $set = @mysql_fetch_array(@mysql_query("SELECT * FROM `settings`"));
                }
            } 
        }
    ?>
    <form action="" method="POST" name="form1">
        <table>
            <tr>
                <td>Tiêu đề trang <span class="required">*</span></td>
                <td><input type="text" name="title" value="<?php echo $set['title']; ?>" required="required" /></td>
            </tr>
            <tr>
                <td>Home URL <span class="required">*</span></td>
                <td><input type="text" name="home" value="<?php echo $set['home']; ?>" required="required" /></td>
            </tr>
            <tr>
                <td>Email <span class="required">*</span></td>
                <td><input type="text" name="email" value="<?php echo $set['email']; ?>" required="required" /></td>
            </tr>
            <tr>
                <td>Phân trang <span class="required">*</span></td>
                <td><input type="text" name="page" value="<?php echo $set['page']; ?>" required="required" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="Cập nhật" class="btn" /></td>
            </tr>
        </table>
    </form>
    </div><!--end widget-body-->
</div><!--end widget-->
<?php
    require_once("../inc/footer.php");
?>