<?php

?>
<div id="footer"></div>
</div><!--end body-->
<div id="sidebar">
    <div class="widget">
        <div class="widget-title"><i class="icon-search"></i>&nbsp;Tìm kiếm sản phẩm</div>
        <div class="widget-body">
            <form action="<?php echo $set['home']; ?>/search.php" name="form1" method="GET">
                <input type="text" name="key" placeholder="Tên sản phẩm" style="width: 57%"/>
                <input type="submit" class="btn" value="Tìm kiếm"/>
            </form>
        </div>
        <div class="widget-title"><i class="icon-reorder"></i>&nbsp;Danh mục sản phẩm</div>
        <div class="widget-body">
            <?php
            $sql = "SELECT * FROM `categories` WHERE `show` = 'true' ORDER BY `id` DESC";
            $result = $connect->query($sql);
            if ($result->fetch_array(MYSQLI_NUM) == 0)
                echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có danh mục sản phẩm nào</div>';
            else {
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $cat_id = $row['id'];
                    $query = "SELECT COUNT(`id`) as total FROM `products` WHERE `show` = 'true' AND `cat_id` = '$cat_id'";
                    $res = $connect->query($query);
                    $rows = $res->fetch_array(MYSQLI_ASSOC);
                    $count = $rows['total'];
                    echo '<div class="cat_list"><a href="' . $set['home'] . '/categories.php?id=' . $row['id'] . '">' . $row['cat_name'] . '</a> (' . $count . ')</div>';
                }
            }
            ?>
        </div>
        <div class="widget-title"><i class="icon-reorder"></i>&nbsp;Tin mới</div>
        <div class="widget-body">
            <?php
            $sql = "SELECT * FROM `articles` WHERE `show` = 'true' ORDER BY `id` DESC LIMIT 0,5";
            $result = $connect->query($sql);
            if ($result->fetch_array(MYSQLI_NUM) == 0)
                echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có tin tức nào</div>';
            else {
                echo '<marquee  behavior="scroll" scrollamount="2" direction="up" onmouseover="this.stop()" onmouseout="this.start()">';
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    echo '<div class="cat_list"><a href="' . $set['home'] . '/articles.php?id=' . $row['id'] . '">' . $row['articles_name'] . '</a><div class="shortdesc">' . substr($row['content'], 0, 100) . '..</div><span style="float: right;"><a href="#">Xem tiếp >></a></span><br /></div>';
                }
                echo '</marquee>';
            }
            ?>
        </div>
        <div class="widget-title"><i class="icon-user"></i>&nbsp;Liên hệ</div>
        <div class="widget-body">
            <div class="cat_list"><?php echo $set['email']; ?></div>
        </div>
    </div><!--end sidebar-->
</div><!--end content-->
<div class="clearfix"></div>

</body>
</html>