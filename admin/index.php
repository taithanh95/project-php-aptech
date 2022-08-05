<?php

$connect = null;
$title = 'Quản trị website';
require_once("../inc/header.php");
?>
    <div class="widget">
    <div class="widget-title"><i class="icon-cog"></i>&nbsp;Quản trị website</div>
    <div class="widget-body">
<?php
if ($account != 'admin') {
    header('Location: adlogin.php');
} else {
    ?>
    <div class="tabs tabbable tabbable-custom">
        <div class="statistic row-fluid circle-state-overview">
            <!-- Khách hàng -->
            <div class="span2 responsive">
                <div class="circle-wrap">
                    <a href="customers.php">
                        <div class="stats-circle turquoise-color">
                            <i class="icon-user"></i>
                        </div>
                        <p>
                            <?php
                            $user_sql = "SELECT COUNT(`id`) as `count` FROM `users` WHERE `user` != 'admin'";
                            $user_result = $connect->query($user_sql);
                            $user_row = $user_result -> fetch_array(MYSQLI_ASSOC);
                            echo '<strong>' . $user_row['count'] . '</strong> Khách hàng';
                            ?>
                        </p>
                    </a>
                </div>
            </div>
            <!-- Đơn hàng -->
            <div class="span2 responsive">
                <div class="circle-wrap">
                    <a href="orders.php">
                        <div class="stats-circle blue-color">
                            <i class="icon-shopping-cart"></i>
                        </div>
                        <p>
                            <?php
                            $order_sql = "SELECT COUNT(`id`) as `order_count` FROM `lesson_order`";
                            $order_result = $connect->query($order_sql);
                            $order_row = $order_result -> fetch_array(MYSQLI_ASSOC);
                            $order_notifition_sql = "SELECT COUNT(`id`) as 'order_count_notifition' FROM `lesson_order` WHERE `status` = '1'";
                            $order_notifition_result = $connect->query($order_notifition_sql);
                            $order_notifition_row = $order_notifition_result -> fetch_array(MYSQLI_ASSOC);
                            echo '<strong>' . $order_row['order_count'] . '</strong> Đơn hàng';
                            if ($order_notifition_row['order_count_notifition'] != 0)
                                echo '&nbsp;<span style="color: #FF0000; font-weight: bold;">(' . $order_notifition_row['order_count_notifition'] . ')</span>';
                            ?>
                        </p>
                    </a>
                </div>
            </div>
            <!-- Sản phẩm -->
            <div class="span2 responsive">
                <div class="circle-wrap">
                    <a href="products.php">
                        <div class="stats-circle red-color">
                            <i class="icon-tags"></i>
                        </div>
                        <p>
                            <?php
                            $product_sql = "SELECT COUNT(`id`) as `count` FROM `products`";
                            $product_result = $connect->query($product_sql);
                            $product_row = $product_result -> fetch_array(MYSQLI_ASSOC);
                            echo '<strong>' . $product_row['count'] . '</strong> Sản phẩm';
                            ?>
                        </p>
                    </a>
                </div>

            </div>
            <!-- Liên hệ -->
            <div class="span2 responsive">
                <div class="circle-wrap">
                    <a href="contacts.php">
                        <div class="stats-circle  gray-color">
                            <i class="icon-envelope"></i>
                        </div>
                        <p>
                            <?php
                            $user_sql = "SELECT COUNT(`id`) as `count` FROM `contacts`";
                            $user_result = $connect->query($user_sql);
                            $user_row = $user_result -> fetch_array(MYSQLI_ASSOC);
                            $user_notifition_sql = "SELECT COUNT(`id`) as 'user_count_notifition' FROM `contacts` WHERE `status` = '0'";
                            $user_notifition_result = $connect->query($user_notifition_sql);
                            $user_notifition_row = $user_notifition_result -> fetch_array(MYSQLI_ASSOC);
                            echo '<strong>' . $user_row['count'] . '</strong> Liên hệ';
                            if ($user_notifition_row['user_count_notifition'] != 0)
                                echo '&nbsp;<span style="color: #FF0000; font-weight: bold;">(' . $user_notifition_row['user_count_notifition'] . ')</span>';
                            ?>
                        </p>
                    </a>
                </div>
            </div>
            <!-- Bình luận -->
            <div class="span2 responsive">
                <div class="circle-wrap">
                    <a href="comments.php">
                        <div class="stats-circle green-color">
                            <i class="icon-comment"></i>
                        </div>
                        <p>
                            <?php
                            $procomment_sql = "SELECT COUNT(`id`) as `count` FROM `products_comment`";
                            $procomment_result = $connect->query($procomment_sql);
                            $procomment_row = $procomment_result -> fetch_array(MYSQLI_ASSOC);
                            $artcomment_sql = "SELECT COUNT(`id`) as `count` FROM `articles_comment`";
                            $artcomment_result = $connect->query($artcomment_sql);
                            $artcomment_row = $artcomment_result -> fetch_array(MYSQLI_ASSOC);
                            echo '<strong>' . ($procomment_row['count'] + $artcomment_row['count']) . '</strong> Bình luận';
                            ?>
                        </p>
                    </a>
                </div>
            </div>
            <!-- Tin tức -->
            <div class="span2 responsive">
                <div class="circle-wrap">
                    <a href="articles.php">
                        <div class="stats-circle purple-color">
                            <i class="icon-file"></i>
                        </div>
                        <p>
                            <?php
                            $user_sql = "SELECT COUNT(`id`) as `count` FROM `articles`";
                            $user_result = $connect->query($user_sql);
                            $user_row = $user_result -> fetch_array(MYSQLI_ASSOC);
                            echo '<strong>' . $user_row['count'] . '</strong> Tin tức';
                            ?>
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div><!--end widget-body-->
    </div><!--end widget-->


    <div class="widget">
        <div class="widget-title"><i class="icon-bolt"></i>&nbsp;Truy cập nhanh</div>
        <div class="widget-body maxheight">
            <div class="square-state">
                <div class="row-fluid">
                    <a href="products.php?act=add" class="icon-btn span3"><i class="icon-plus-sign"></i>
                        <div>Thêm sản phẩm mới</div>
                    </a>
                    <a href="categories.php" class="icon-btn span3"><i class="icon-sitemap"></i>
                        <div>Danh mục sản pẩm</div>
                    </a>
                    <a href="categorie_articles.php" class="icon-btn span3"><i class="icon-sitemap"></i>
                        <div>Danh mục tin tức</div>
                    </a>
                    <a href="articles.php?act=add" class="icon-btn span3"><i class="icon-plus"></i>
                        <div>Thêm tin mới</div>
                    </a>
                </div>
                <div class="row-fluid">
                    <a href="settings.php" class="icon-btn span3"><i class="icon-wrench"></i>
                        <div>Cấu hình website</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php }
require_once("../inc/footer.php");
?>