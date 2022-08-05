<?php

    $connect = null;
    $title = 'Sản phẩm';
    require_once("inc/header.php");
 ?>
<div class="widget">
<?php
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM `products` WHERE `show` = 'true' AND `id` = '$id'";
        $result = $connect -> query($sql);
        if($result -> fetch_array(MYSQLI_NUM) == 0) {
            $title = '404';
            echo '<div class="widget-title"><i class="icon-warning-sign"></i>&nbsp;404</div>
    <div class="widget-body"><p align="center">Oops, Trang này không tồn tại<br /><br /><a href="'.$set['home'].'" class="btn">Trở lại</a></p></div>';
        }else {
            $row = $result -> fetch_array(MYSQLI_ASSOC);
            $cat_id = $row['cat_id'];
            $title = $row['pro_name'];
            $query = "SELECT * FROM `categories` WHERE `id` = '$cat_id'";
            $res = $connect -> query($query);
            $rows = $res -> fetch_array(MYSQLI_ASSOC);
            echo '<div style="padding: 10px;"><a href="'.$set['home'].'">Trang chủ</a> > <a href="'.$set['home'].'/categories.php">Danh mục sản phẩm</a> > <a href="'.$set['home'].'/categories.php?id='.$rows['id'].'">'.$rows['cat_name'].'</a> > '.$row['pro_name'].'</div>';
            echo '<div class="widget-title"><i class="icon-list-alt"></i>&nbsp;'.$row['pro_name'].'</div>
    <div class="widget-body">
    <div class="BlockContent">';
            echo '<div style="float: left; margin-right: 20px;">';
            if(empty($row['img']))
                echo '<img src="'.$set['home'].'/admin/files/no-avatar.jpg" alt="*" width="200px" height="150px" />';
            else
                echo '<img src="'.$set['home'].'/admin/files/'.$row['img'].'" alt="*" width="200px" height="150px" />';
            echo '</div><div>';
            echo 'Giá bán: '.number_format($row['price'],0,",",".").'  ₫<br />';
            if($row['vat'] == 1)
                echo 'Đã bao gồm VAT<br />';
            echo 'Bảo hành: '.$row['baohanh'].' năm<br />';
            echo '<a href="cart.php?act=addcart&id='.$row['id'].'">Thêm vào giỏ hàng</a>';
            echo '</div><div style="clear: both"></div></div><!--end BlockContent-->';
            echo '<div class="ProductTabs">
            <ul class="TabNav">
            <li class="Active"><strong>Thông tin</strong></li></div>
            <div class="Description">';
            if(empty($row['content']))
                echo 'Không có thông tin cho sản phẩm này';
            else
                echo $row['content'];
                echo '</div></ul>';
            //comment
            echo '<div class="newsDetail" id="comment">Bình luận';
            $rows_count = ($connect -> query("SELECT COUNT(`id`) as total FROM `products_comment` WHERE `pro_id` = '$id'")) -> fetch_array(MYSQLI_ASSOC);
            $comment_count = $rows_count['total'];
            echo ' ('.$comment_count.')';
            echo '</div>';
            if(empty($account))
                echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Vui lòng <a href="login.php" style="text-decoration: underline;">đăng nhập</a> để bình luận</div>';
            elseif($row['comment'] != 'true')
                echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chức năng bình luận đã tắt bởi người quản lí</div>';
            else {
                if(isset($_GET['delcomment'])) {
                    $idcomment = $_GET['delcomment'];
                    $connect -> query("DELETE FROM `products_comment` WHERE `pro_id` = '$id' AND `id` = '$idcomment'");
                    header('Location: products.php?id='.$id.'#comment');
                    exits();
                }
                if(isset($_POST['submit'])) {
                    if(empty($_POST['captcha']) OR $_POST['captcha'] != $_SESSION['captcha'])
                        echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Mã xác nhận không đúng</div>';
                    else {
                        if(empty($_POST['comment']))
                            echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bạn chưa nhập bình luận</div>';
                        else {
                            $comment = $_POST['comment'];
                            if(strlen($comment) < 50 OR strlen($comment) > 500)
                                echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bình luận phải dài hơn 50 ký tự và nhỏ hơn 500 ký tự</div>';
                            else {
                                $created = date("Y-m-d H:i:s");
                                    $connect -> query("INSERT INTO `products_comment` (`pro_id`, `user_id`, `comment`, `created`) VALUE ('$id', '$users_id', '$comment', '$created')") or die(@mysql_error());
                                header('Location: products.php?id='.$id.'#comment');
                                exits();
                            }
                        }
                    }
                }
                if($account != 'admin') {
            ?>
                    <div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chỉ chấp nhận bình luận bằng tiếng Việt có dấu, những bình luận sai qui định sẽ bị xóa.</div>
                    <form action="" method="POST" name="form1">
                        <textarea name="comment"></textarea><br /><br />
                        <?php
                            $a = rand(1,10);
                            $b = rand(1,10);
                            $_SESSION['captcha'] = $a + $b;
                            echo '<span style="background-color:#ddd;padding:6px;">'.$a.'+'.$b.'=</span>';
                        ?>
                        <input type="text" name="captcha" style="width: 30px;" />
                        <input type="submit" name="submit" value="Bình luận" class="btn" />
                    </form>
            <?php
                }
                $comment_sql = "SELECT * FROM `products_comment` WHERE `pro_id` = '$id' ORDER BY `id` DESC";
                $comment_result = $connect -> query($comment_sql);
                if($comment_result -> fetch_array(MYSQLI_NUM) == 0)
                    echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có bình luận nào</div>';
                else {
                    while($row_comment = $comment_result -> fetch_array(MYSQLI_ASSOC)) {
                        $row_comment_id = $row_comment['user_id'];
                        $users_comment = ($connect -> query("SELECT `user` FROM `users` WHERE `id` = '$row_comment_id'")) -> fetch_array(MYSQLI_ASSOC);
                        echo '<div class="cat_list"><strong>'.$users_comment['user'].'</strong> '.$row_comment['comment'].' ('.$row_comment['created'].')';
                        if($users_id == $row_comment['user_id'])
                            echo '&nbsp;<a href="?id='.$id.'&delcomment='.$row_comment['id'].'" title="Xóa bình luận"><i class="icon-trash"></i></a>';
                        echo '</div>';
                    }
                }
            }
            //categories
            echo '<div class="newsDetail">Sản phẩm cùng loại</div>';
            echo '<div class="ProductList">';
            $cat_id = $row['cat_id'];
            $sql = "SELECT * FROM `products` WHERE `show` = 'true' AND `cat_id` = '$cat_id' AND `id` != '$id'";
            $result = $connect -> query($sql);
            if($result -> fetch_array(MYSQLI_NUM) == 0)
                echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Không có sản phẩm cùng loại</div>';
            else {
                echo '<ul>';
                while($row = ($result -> fetch_array(MYSQLI_ASSOC))) {
                    if($row['id'] != $id) {
                        echo '<li class="p">
                        <div class="ProductImage">
                        <a href="?id='.$row['id'].'">';
                        if(empty($row['img']))
                            echo '<img src="'.$set['home'].'/admin/files/no-avatar.jpg" alt="*" width="200px" height="150px" />';
                        else
                            echo '<img src="'.$set['home'].'/admin/files/'.$row['img'].'" alt="*" width="200px" height="150px" />';
                        echo '</a>
                        </div>
                        <div class="ProductDetails"><a href="?id='.$row['id'].'"><strong>'.$row['pro_name'].'</strong></a></div>
                        <div class="ProductPrice">'.number_format($row['price'],0,",",".").'  ₫</div>
                        <div class="ProductActionAdd"><a href="cart.php?act=addcart&id='.$row['id'].'">Thêm vào giỏ hàng</a></div>
                        </li>';
                    }
                }
                echo '</ul>';
            }
            echo '</div>';
            echo '</div><!--end widget-body-->';
        }
    }else {
?> 
<div class="widget-title"><i class="icon-list-alt"></i>&nbsp;Sản phẩm</div>
    <div class="widget-body">
	<div class="ProductList">
    <?php
        $display = $set['page'];
        $query = "SELECT COUNT(`id`) as total FROM `products` WHERE `show` = 'true'";
        $res = $connect -> query($query);
        $rows = $res -> fetch_array(MYSQLI_NUM);
        $record = $rows['total'];
        $count = ceil($record/$display);
        if(isset($_GET['page']))
            $page = $_GET['page'];
        if(empty($page) OR $page < 1 OR $page > $count)
            $page = 1;
        $start = ($page-1)*$display;
        $sql = "SELECT * FROM `products` WHERE `show` = 'true' ORDER BY `id` DESC LIMIT $start, $display";
        $result = $connect -> query($sql);
        if($result -> fetch_array(MYSQLI_NUM) == 0)
            echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có sản phẩm nào</div>';
        else {
            echo '<ul>';
            while($row = $result -> fetch_array(MYSQLI_ASSOC)) {
                echo '<li>
                <div class="ProductImage">
                <a href="?id='.$row['id'].'">';
                if(empty($row['img']))
                    echo '<img src="'.$set['home'].'/admin/files/no-avatar.jpg" alt="*" width="200px" height="150px" />';
                else
                    echo '<img src="'.$set['home'].'/admin/files/'.$row['img'].'" alt="*" width="200px" height="150px" />';
                echo '</a>
                </div>
                <div class="ProductDetails"><a href="?id='.$row['id'].'"><strong>'.$row['pro_name'].'</strong></a></div>
                <div class="ProductPrice">'.number_format($row['price'],0,",",".").'  ₫</div>
                <div class="ProductActionAdd"><a href="cart.php?act=addcart&id='.$row['id'].'">Thêm vào giỏ hàng</a></div>
                </li>';
            }
            echo '</ul>';
        }
    ?>
    </div><!--end ProductList-->
    <?php
        if($count > 1) {
            echo '<ul class="page">';
            $pre = $page - 1;
            $next = $page + 1;
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
    echo '</div><!--end widget-body-->';
    }
 echo '</div><!--end widget-->';
    require_once("inc/footer.php");
?>