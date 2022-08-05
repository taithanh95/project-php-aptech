<?php

    $title = 'Bình luận';
    require_once("../inc/header.php");
?>
<div class="widget">
    <?php
        if(isset($_GET['act'])) {
            switch($_GET['act']) {
                case'del_pro':
                    $id = $_GET['id'];
                    $sql = "DELETE FROM `products_comment` WHERE `id` = '$id'";
                    $res = @mysql_query($sql);
                    if(isset($res)) {
                        header('Location: comments.php');
                        exits();
                    }
                break;
                case'del_art':
                    $id = $_GET['id'];
                    $sql = "DELETE FROM `articles_comment` WHERE `id` = '$id'";
                    $res = @mysql_query($sql);
                    if(isset($res)) {
                        header('Location: comments.php?articles');
                        exits();
                    }
                break;
            }
        }else {
    ?>
        <div class="widget-title"><i class="icon-comment"></i>&nbsp;Bình luận</div>
        <div class="widget-body">
                <?php
                    if(isset($_GET['articles'])) {
                        $count_products = @mysql_fetch_array(@mysql_query("SELECT COUNT(`id`) FROM `products_comment`"));
                        $count_articles = @mysql_fetch_array(@mysql_query("SELECT COUNT(`id`) FROM `articles_comment`"));
                        echo '<a href="comments.php">Bình luận sản phẩm ('.$count_products[0].')</a> · Bình luận tin tức ('.$count_articles[0].')';
                        $sql = "SELECT * FROM `articles_comment`";
                        $result = @mysql_query($sql);
                        if(@mysql_num_rows($result) == 0)
                            echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có bình luận nào</div>';
                        else {
                ?>
                            <table class="table table-striped table-bordered dataTable" style="width:100%;border-collapse:collapse;">
                    		<tbody>
                        		<tr>
                        			<th scope="col">#</th>
                                    <th scope="col">Người gửi</th>
                                    <th scope="col">Bình luận</th>
                                    <th scope="col">Đường dẫn</th>
                                    <th scope="col">Ngày gửi</th>
                                    <th scope="col">&nbsp;</th>
                        		</tr>
                <?php
                            $i = 0;
                            while($row = @mysql_fetch_array($result)) {
                                $i++;                            
                ?>
                                <tr class="row0">
                                    <td><?php echo $i; ?></td>
                                    <td>
                                    <?php
                                        $users_comment = @mysql_fetch_array(@mysql_query("SELECT `user` FROM `users` WHERE `id` = '".$row['user_id']."'"));
                                        echo $users_comment['user'];
                                    ?>
                                    </td>
                                    <td><?php echo $row['comment']; ?></td>
                                    <td>
                                    <?php
                                        $title_articles = @mysql_fetch_array(@mysql_query("SELECT `articles_name` FROM `articles` WHERE `id` = '".$row['art_id']."'"));
                                        echo '<a href="'.$set['home'].'/articles.php?id='.$row['art_id'].'#comment">'.$title_articles['articles_name'].'</a>';
                                    ?>
                                    </td>
                                    <td><?php echo $row['created']; ?></td>
                                    <td><a href="?act=del_art&id=<?php echo $row['id']; ?>"><i class="icon-trash"></i></a></td>
                                </tr>
                    <?php   }
                        echo '</tbody></table>';
                        }
                    }else {
                        $count_products = @mysql_fetch_array(@mysql_query("SELECT COUNT(`id`) FROM `products_comment`"));
                        $count_articles = @mysql_fetch_array(@mysql_query("SELECT COUNT(`id`) FROM `articles_comment`"));
                        echo 'Bình luận sản phẩm ('.$count_products[0].') · <a href="?articles">Bình luận tin tức</a> ('.$count_articles[0].')';
                        $sql = "SELECT * FROM `products_comment`";
                        $result = @mysql_query($sql);
                        if(@mysql_num_rows($result) == 0)
                            echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có bình luận nào</div>';
                        else {
                    ?>
                            <table class="table table-striped table-bordered dataTable" style="width:100%;border-collapse:collapse;">
                    		<tbody>
                        		<tr>
                        			<th scope="col">#</th>
                                    <th scope="col">Người gửi</th>
                                    <th scope="col">Bình luận</th>
                                    <th scope="col">Đường dẫn</th>
                                    <th scope="col">Ngày gửi</th>
                                    <th scope="col">&nbsp;</th>
                        		</tr>
                <?php
                            $i = 0;
                            while($row = @mysql_fetch_array($result)) {
                                $i++;                            
                ?>
                                <tr class="row0">
                                    <td><?php echo $i; ?></td>
                                    <td>
                                    <?php
                                        $users_comment = @mysql_fetch_array(@mysql_query("SELECT `user` FROM `users` WHERE `id` = '".$row['user_id']."'"));
                                        echo $users_comment['user'];
                                    ?>
                                    </td>
                                    <td><?php echo $row['comment']; ?></td>
                                    <td>
                                    <?php
                                        $title_products = @mysql_fetch_array(@mysql_query("SELECT `pro_name` FROM `products` WHERE `id` = '".$row['pro_id']."'"));
                                        echo '<a href="'.$set['home'].'/products.php?id='.$row['pro_id'].'#comment">'.$title_products['pro_name'].'</a>';
                                    ?>
                                    </td>
                                    <td><?php echo $row['created']; ?></td>
                                    <td><a href="?act=del_pro&id=<?php echo $row['id']; ?>"><i class="icon-trash"></i></a></td>
                                </tr>
                    <?php   }
                        echo '</tbody></table>';
                        }
                    }
        echo '</div>';
        }
    ?>
</div><!--end widget-->
<?php
    require_once("../inc/footer.php");
?>