<?php

$connect =null;
	require_once("inc/header.php");
    $title = $set['title'];
?>
<div class="widget">
	<div class="widget-title"><i class="icon-list-alt"></i>&nbsp;Sản phẩm mới nhất</div>
	<div class="widget-body">
    <div class="ProductList">
    <?php
        $display = $set['page'];
        $query = "SELECT COUNT(`id`) as total FROM `products` WHERE `show` = 'true'";
        $res = $connect -> query($query);
        $rows = $res -> fetch_array(MYSQLI_ASSOC);
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
                <a href="products.php?id='.$row['id'].'">';
                if(empty($row['img']))
                    echo '<img src="'.$set['home'].'/admin/files/no-avatar.jpg" alt="*" width="200px" height="150px" />';
                else
                    echo '<img src="'.$set['home'].'/admin/files/'.$row['img'].'" alt="*" width="200px" height="150px" />';
                echo '</a>
                </div>
                <div class="ProductDetails"><a href="products.php?id='.$row['id'].'"><strong>'.$row['pro_name'].'</strong></a></div>
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
    ?>
	</div><!--end widget-body-->
</div><!--end widget-->
<?php
	require_once("inc/footer.php");
?>