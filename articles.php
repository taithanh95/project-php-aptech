<?php

$connect = null;
$title = 'Tin tức';
require_once("inc/header.php");
?>
    <div class="widget">
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM `articles` WHERE `show` = 'true' AND `id` = '$id'";
            $result = $connect->query($sql);
            if ($result->fetch_array(MYSQLI_NUM) == 0) {
                $title = '404';
                echo '<div class="widget-title"><i class="icon-warning-sign"></i>&nbsp;404</div>
    <div class="widget-body"><p align="center">Oops, Trang này không tồn tại<br /><br /><a href="' . $set['home'] . '" class="btn">Trở lại</a></p></div>';
            } else {
                $row = $result ->fetch_array(MYSQLI_ASSOC);
                $cat_id = $row['cat_id'];
                $title = $row['articles_name'];
                $query = "SELECT * FROM `categorie_articles` WHERE `id` = '$cat_id'";
                $res = $connect->query($query);
                $rows = $res ->fetch_array(MYSQLI_ASSOC);
                echo '<div style="padding: 10px;"><a href="' . $set['home'] . '">Trang chủ</a> > <a href="' . $set['home'] . '/categorie_articles.php">Danh mục tin tức</a> > <a href="' . $set['home'] . '/categorie_articles.php?id=' . $rows['id'] . '">' . $rows['cat_name'] . '</a> > ' . $row['articles_name'] . '</div>';
                echo '<div class="widget-title"><i class="icon-list-alt"></i>&nbsp;' . $row['articles_name'] . '</div>
    <div class="widget-body">';
                $datetime = explode(" ", $row['created']);
                $time = $datetime[1];
                $date = $datetime[0];
                $date = explode("-", $date);
                $date = $date[2] . '/' . $date[1] . '/' . $date[0];
                echo $time . ' | ' . $date . '<br /><br />';
                echo $row['content'];
                //comment
                echo '<div class="newsDetail" id="comment">Bình luận';
                $rows_count = ($connect->query("SELECT COUNT(`id`) as total FROM `articles_comment` WHERE `art_id` = '$id'")) ->fetch_array(MYSQLI_ASSOC);
                $comment_count = $rows_count['total'];
                echo ' (' . $comment_count . ')';
                echo '</div>';
                if (empty($account))
                    echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Vui lòng <a href="' . $set['home'] . '/login.php" style="text-decoration: underline;">đăng nhập</a> để bình luận</div>';
                elseif ($row['comment'] != 'true')
                    echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chức năng bình luận đã tắt bởi người quản lí</div>';
                else {
                    if (isset($_GET['delcomment'])) {
                        $idcomment = $_GET['delcomment'];
                        $connect->query("DELETE FROM `articles_comment` WHERE `art_id` = '$id' AND `id` = '$idcomment'") or die(@mysql_error());
                        header('Location: articles.php?id=' . $id . '#comment');
                        exits();
                    }
                    ?>
                    <?php
                    if (isset($_POST['submit'])) {
                        if (empty($_POST['captcha']) or $_POST['captcha'] != $_SESSION['captcha'])
                            echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Mã xác nhận không đúng</div>';
                        else {
                            if (empty($_POST['comment']))
                                echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bạn chưa nhập bình luận</div>';
                            else {
                                $comment = $_POST['comment'];
                                if (strlen($comment) < 50 or strlen($comment) > 500)
                                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bình luận phải dài hơn 50 ký tự và nhỏ hơn 500 ký tự</div>';
                                else {
                                    $created = date("Y-m-d H:i:s");
                                    $connect->query("INSERT INTO `articles_comment` (`art_id`, `user_id`, `comment`, `created`) VALUE ('$id', '$users_id', '$comment', '$created')");
                                    header('Location: articles.php?id=' . $id . '#comment');
                                    exits();
                                }
                            }
                        }
                    }
                    if ($account != 'admin') {
                        ?>
                        <div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chỉ chấp nhận bình luận bằng
                            tiếng Việt có dấu, những bình luận sai qui định sẽ bị xóa.
                        </div>
                        <form action="" method="POST" name="form1">
                            <textarea name="comment"></textarea><br/><br/>
                            <?php
                            $a = rand(1, 10);
                            $b = rand(1, 10);
                            $_SESSION['captcha'] = $a + $b;
                            echo '<span style="background-color:#ddd;padding:6px;">' . $a . '+' . $b . '=</span>';
                            ?>
                            <input type="text" name="captcha" style="width: 30px;"/>
                            <input type="submit" name="submit" value="Bình luận" class="btn"/>
                        </form>
                        <?php
                    }
                    $comment_sql = "SELECT * FROM `articles_comment` WHERE `art_id` = '$id' ORDER BY `id` DESC";
                    $comment_result = $connect->query($comment_sql);
                    if ($comment_result ->fetch_array(MYSQLI_NUM) == 0)
                        echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có bình luận nào</div>';
                    else {
                        while ($row_comment = $comment_result ->fetch_array(MYSQLI_ASSOC)) {
                            $row_comment_id = $row_comment['user_id'];
                            $users_comment = ($connect->query("SELECT `user` FROM `users` WHERE `id` = '$row_comment_id'")) ->fetch_array(MYSQLI_ASSOC);
                            echo '<div class="cat_list"><strong>' . $users_comment['user'] . '</strong> ' . $row_comment['comment'] . ' (' . $row_comment['created'] . ')';
                            if ($users_id == $row_comment['user_id'])
                                echo '&nbsp;<a href="?id=' . $id . '&delcomment=' . $row_comment['id'] . '" title="Xóa bình luận"><i class="icon-trash"></i></a>';
                            echo '</div>';
                        }
                    }
                }
                //categories
                echo '<div class="newsDetail">Các tin khác</div>';
                $cat_id = $row['cat_id'];
                $query = "SELECT * FROM `articles` WHERE `show` = 'true' AND `cat_id` = '$cat_id' AND `id` != '$id' ORDER BY `id` DESC LIMIT 0,5";
                $res = $connect->query($query);
                if ($res ->fetch_array(MYSQLI_NUM) == 0)
                    echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có tin tức khác</div>';
                else {
                    while ($rows = $res ->fetch_array(MYSQLI_ASSOC)) {
                        if ($rows['id'] != $id) {
                            echo '<div class="cat_list"><a href="?id=' . $rows['id'] . '">' . $rows['articles_name'] . '</a></div>';
                        }
                    }
                }
                echo '</div><!--end widget-body-->';
            }
        } else {
            echo '<div class="widget-title"><i class="icon-file"></i>&nbsp;Tin tức</div>
        <div class="widget-body">';
            $display = $set['page'];
            $query = "SELECT COUNT(`id`) as total FROM `articles` WHERE `show` = 'true'";
            $res = $connect->query($query);
            $rows = $res ->fetch_array(MYSQLI_ASSOC);
            $record = $rows['total'];
            $count = ceil($record / $display);
            if (isset($_GET['page']))
                $page = $_GET['page'];
            if (empty($page) or $page < 1 or $page > $count)
                $page = 1;
            $start = ($page - 1) * $display;
            $sql = "SELECT * FROM `articles` WHERE `show` = 'true' LIMIT $start,$display";
            $result = $connect->query($sql);
            if ($result ->fetch_array(MYSQLI_NUM) == 0)
                echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có tin tức nào</div>';
            else {
                while ($row = $result ->fetch_array(MYSQLI_ASSOC)) {
                    echo '<div class="cat_list">';
                    echo '<a href="?id=' . $row['id'] . '">' . $row['articles_name'] . '</a><br />';
                    echo substr($row['content'], 0, 200) . '..<a href="?id=' . $row['id'] . '">>></a>';
                    echo '</div>';
                }

            }
            if ($count > 1) {
                $pre = $page - 1;
                $next = $page + 1;
                echo '<ul class="page">';
                if ($page != 1)
                    echo '<li><a href="?page=' . $pre . '"><<</a></li>';
                for ($i = 1; $i <= $count; $i++) {
                    if ($page != $i)
                        echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';
                    else
                        echo '<li class="current">' . $i . '</li>';
                }
                if ($page != $count)
                    echo '<li><a href="?page=' . $next . '">>></a></li>';
                echo '</ul>';
            }
            echo '</div><!--end widget-body-->';
        }
        ?>
    </div><!--end widget-->
<?php
require_once("inc/footer.php");
?>