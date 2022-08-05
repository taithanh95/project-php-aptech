<?php

    $connect = null;
    $title = 'Danh mục sản phẩm';
    require_once("inc/header.php");
?>
<div class="widget">
    <?php
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $cat_sql = "SELECT * FROM `categories` WHERE `id` = '$id'";
            $cat_res = $connect -> query($cat_sql);
            if($cat_res -> fetch_array(MYSQLI_NUM) == 0 ) {
                $title = '404';
                echo '<div class="widget-title"><i class="icon-warning-sign"></i>&nbsp;404</div>
    <div class="widget-body"><p align="center">Oops, Trang này không tồn tại<br /><br /><a href="'.$set['home'].'" class="btn">Trở lại</a></p></div>';
            }else {
                $row_cat = $cat_res -> fetch_array(MYSQLI_ASSOC);
                $title = $row_cat['cat_name'];
				echo '<div style="padding: 10px;"><a href="'.$set['home'].'">Trang chủ</a> > <a href="'.$set['home'].'/categories.php">Danh mục sản phẩm</a> > '.$row_cat['cat_name'].'</div>';
                echo '<div class="widget-title"><i class="icon-sitemap"></i>&nbsp;'.$row_cat['cat_name'].'</div>
        <div class="widget-body">';
                $display = 5;
                $sql = "SELECT COUNT(`id`) as total FROM `products` WHERE `show` = 'true' AND `cat_id` = '$id'";
                $result = $connect -> query($sql);
                $row = $result -> fetch_array(MYSQLI_ASSOC);
                $record = $row['total'];
                $count = ceil($record/$display);
                if(isset($_GET['page']))
                    $page = $_GET['page'];
                if(empty($page) OR $page < 1 OR $page > $count)
                    $page = 1;
                $start = ($page - 1)*$display;
                $query = "SELECT * FROM `products` WHERE `show` = 'true' AND `cat_id` = '$id' LIMIT $start,$display";
                $res = $connect -> query($query);
                if($res -> fetch_array(MYSQLI_NUM) == 0)
                    echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có sản phẩm nào</div>';
                else {
                    echo '<div class="ProductList">
                    <ul>';
                    while($rows = $res -> fetch_array(MYSQLI_ASSOC)) {
                        echo '<li class="p">
                            <div class="ProductImage">
                            <a href="products.php?id='.$rows['id'].'">';
                            if(empty($rows['img']))
                                echo '<img src="'.$set['home'].'/admin/files/no-avatar.jpg" alt="*" width="200px" height="150px" />';
                            else
                                echo '<img src="'.$set['home'].'/admin/files/'.$rows['img'].'" alt="*" width="200px" height="150px" />';
                            echo '</a>
                            </div>
                            <div class="ProductDetails"><a href="products.php?id='.$rows['id'].'"><strong>'.$rows['pro_name'].'</strong></a></div>
                            <div class="ProductPrice">'.number_format($rows['price'],0,",",".").'  ₫</div>
                            <div class="ProductActionAdd"><a href="cart.php?act=addcart&id='.$rows['id'].'">Thêm vào giỏ hàng</a></div>
                            </li>';
                    }
                    echo '</ul>
                    </div>';
                }
                echo '</div>';
            }
        }else {
    ?>
	<div style="padding: 10px;"><a href="<?php echo $set['home']; ?>">Trang chủ</a> > Danh mục sản phẩm</div>
    <div class="widget-title"><i class="icon-sitemap"></i>&nbsp;Danh mục sản phẩm</div>
    <div class="widget-body">
    <?php
            $sql = "SELECT * FROM `categories` ORDER BY `id` DESC";
			$result = $connect -> query($sql);
			if($result -> fetch_array(MYSQLI_NUM) == 0) {
				echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có danh mục sản phẩm nào</div>';
			}else {
		      while($row = $result -> fetch_array(MYSQLI_ASSOC)) {
		          echo '<div class="cat_list"><a href="?id='.$row['id'].'">'.$row['cat_name'].'</a></div>';
		      }
            }
   echo '</div>';
        }
    ?>
</div><!--end widget-->
<?php
    require_once("inc/footer.php");
?>