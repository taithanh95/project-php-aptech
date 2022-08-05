<?php

    $title = 'Danh mục tin tức';
    require_once("inc/header.php");
?>
<div class="widget">
    <?php
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $cat_sql = "SELECT * FROM `categorie_articles` WHERE `id` = '$id'";
            $cat_res = @mysql_query($cat_sql);
            if(@mysql_num_rows($cat_res) == 0 ) {
                $title = '404';
                echo '<div class="widget-title"><i class="icon-warning-sign"></i>&nbsp;404</div>
    <div class="widget-body"><p align="center">Oops, Trang này không tồn tại<br /><br /><a href="'.$set['home'].'" class="btn">Trở lại</a></p></div>';
            }else {
                $row_cat = @mysql_fetch_array($cat_res);
				echo '<div style="padding: 10px;"><a href="'.$set['home'].'">Trang chủ</a> > <a href="'.$set['home'].'/categorie_articles.php">Danh mục tin tức</a> > '.$row_cat['cat_name'].'</div>';
                $title = $row_cat['cat_name'];
                echo '<div class="widget-title"><i class="icon-sitemap"></i>&nbsp;'.$row_cat['cat_name'].'</div>
        <div class="widget-body">';
                $display = 5;
                $sql = "SELECT COUNT(`id`) FROM `articles` WHERE `show` = 'true' AND `cat_id` = '$id'";
                $result = @mysql_query($sql);
                $row = @mysql_fetch_array($result);
                $record = $row[0];
                $count = ceil($record/$display);
                if(isset($_GET['page']))
                    $page = $_GET['page'];
                if(empty($page) OR $page < 1 OR $page > $count)
                    $page = 1;
                $start = ($page - 1)*$display;
                $query = "SELECT * FROM `articles` WHERE `show` = 'true' AND `cat_id` = '$id' LIMIT $start,$display";
                $res = @mysql_query($query);
                if(@mysql_num_rows($res) == 0)
                    echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có tin tức nào</div>';
                else {
                    while($rows = @mysql_fetch_array($res)) {
                        echo '<div class="cat_list">';
						echo '<a href="articles.php?id='.$rows['id'].'">'.$rows['articles_name'].'</a>';
						echo '</div>';
                    }
                }
                echo '</div>';
            }
        }else {
    ?>
	<div style="padding: 10px;"><a href="<?php echo $set['home']; ?>">Trang chủ</a> > Danh mục tin tức</div>
    <div class="widget-title"><i class="icon-sitemap"></i>&nbsp;Danh mục tin tức</div>
    <div class="widget-body">
    <?php
            $sql = "SELECT * FROM `categorie_articles` WHERE `show` = 'true' ORDER BY `id` DESC";
			$result = @mysql_query($sql);
			if(@mysql_num_rows($result) == 0) {
				echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có danh mục tin tức nào</div>';
			}else {
		      while($row = @mysql_fetch_array($result)) {
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