<?php

    $title = 'Tìm kiếm';
    require_once("inc/header.php")
?>
<div class="widget">
<div class="widget-title"><i class="icon-search"></i>&nbsp;Tìm kiếm sản phẩm</div>
<div class="widget-body">
	<form action="search.php" name="form1" method="GET">
		<input type="text" name="key" placeholder="Tên sản phẩm" style="/* width: 57% */" />
		<input type="submit" class="btn" value="Tìm kiếm" />
	</form>
<?php
    if(isset($_GET['key'])) {
        $key = $_GET['key'];
        $title = 'Kết quả tìm kiếm cho từ: '.$key.'';
        if(empty($key))
            echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bạn chưa nhập từ khóa</div>';
        elseif(strlen($key) < 2 OR strlen($key) > 50)
            echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Từ khóa quá ngắn hoặc quá dài (2 - 50 ký tự)</div>';
        else {
            $display = 2;
            $query = "SELECT COUNT(`id`) FROM `products` WHERE `show` = 'true' AND `pro_name` LIKE '%$key%'";
            $res = @mysql_query($query);
            $rows = @mysql_fetch_array($res);
            $record = $rows[0];
            $count = ceil($record/$display);
            if(isset($_GET['page']))
                $page = $_GET['page'];
            if(empty($page) OR $page < 1 OR $page > $count)
                $page = 1;
            $start = ($page - 1)*$display;
            $sql = "SELECT * FROM `products` WHERE `show` = 'true' AND `pro_name` LIKE '%$key%' LIMIT $start,$display";
            $result = @mysql_query($sql);
            if(@mysql_num_rows($result) == 0)
                echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Không tìm thấy kết quả nào</div>';
            else {
                echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Kết quả tìm kiếm cho từ: '.$key.'</div>';
                echo '<div class="ProductList">
                <ul>';
                while($row = @mysql_fetch_array($result)) {
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
                echo '</ul></div>';
                if($count > 1) {
                    echo '<ul class="page">';
                    $pre = $page - 1;
                    $next = $page + 1;
                    if($page != 1)
                        echo '<li><a href="?key='.$key.'&page='.$pre.'"><<</a></li>';
                    for($i = 1; $i <= $count; $i++) {
                        if($page != $i)
                            echo '<li><a href="?key='.$key.'&page='.$i.'">'.$i.'</a></li>';
                        else
                            echo '<li class="current">'.$i.'</li>';
                    }
                    if($page != $count)
                        echo '<li><a href="?key='.$key.'&page='.$next.'">>></a></li>';
                    echo '</ul>';
                }
            }
        }
    }
?>
</div><!--end widget-body-->
</div><!--end widget-->
<?php
    require_once("inc/footer.php")
?>