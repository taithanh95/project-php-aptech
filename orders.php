<?php


$connect = null;
$title = 'Quản lí đơn hàng';
require_once("inc/header.php")
?>
    <div class="widget">
<?php
if (empty($account))
    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Trang này chỉ dành cho khách hàng đã đăng nhập</div>';
else {
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM `lesson_order` WHERE `user_id` = '$users_id' AND `id` = '$id'";
    $result = $connect->query($sql);
    if ($result -> fetch_array(MYSQLI_NUM) == 0) {
        $title = '404';
        echo '<div class="widget-title"><i class="icon-warning-sign"></i>&nbsp;404</div>
            <div class="widget-body"><p align="center">Oops, Trang này không tồn tại<br /><br /><a href="' . $set['home'] . '" class="btn">Trở lại</a></p></div>';
    } else {
        $row = $result -> fetch_array(MYSQLI_ASSOC);
        $title = 'Chi tiết đơn hàng #' . $id . '';
        echo '<div class="widget-title"><i class="icon-paste"></i>&nbsp;Chi tiết đơn hàng #' . $id . '<span style="float: right;"><a href="orders.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
            <div class="widget-body">';
        $datetime = explode(" ", $row['date']);
        $time = $datetime[1];
        $date = explode("-", $datetime[0]);
        $date = $date[2] . '/' . $date[1] . '/' . $date[0];
        echo 'Ngày tạo: ' . $time . ' | ' . $date;
        echo '<br />Trạng thái: ';
        if ($row['status'] == 1)
            echo '<strong>Chưa xử lí</strong>';
        elseif ($row['status'] == 2)
            echo '<strong>Đang xử lí</strong>';
        else
            echo '<strong>Đã xử lí</strong>';
        echo '<br />Trị giá đơn hàng: ' . number_format($row['total'], 0, ",", ".") . ' ₫';
        echo '<br />Phương thức thanh toán: ';
        if ($row['choosepayment'] == 1)
            echo 'Thanh toán trực tiếp<br />';
        elseif ($row['choosepayment'] == 2)
            echo 'Thanh toán qua bưu điện<br />';
        else
            echo 'Chuyển khoản qua ngân hàng<br />Số tài khoản của bạn là ' . $row['number_account'] . '<br />';
        echo '<div class="newsDetail">Thông tin người thanh toán</div>
                    <strong>' . $row['fullname'] . '</strong>
                    <br />Địa chỉ: ' . $row['address'] . '
                    <br />Điện thoại: ' . $row['phone'] . '
                    <br />Email: ' . $row['email'] . '';
        echo '<div class="newsDetail">Thông tin người nhận</div>
                    <strong>' . $ad_user['fullname'] . '</strong>
                    <br />Địa chỉ: ' . $ad_user['address'] . '
                    <br />Điện thoại: ' . $ad_user['phone'] . '
                    <br />Email: ' . $ad_user['email'] . '';
        echo '<div class="newsDetail">Đơn hàng bao gồm</div>';
        $order_id = $row['id'];
        $query = "SELECT * FROM `lesson_order_detail` WHERE `order_id` = '$order_id'";
        $res = $connect->query($query);
        $i = 0;
        ?>
        <table class="table table-striped table-bordered dataTable" style="width:100%;">
            <tbody>
            <tr>
                <th scope="col" style="width: 8px;">#</th>
                <th scope="col">Sản phẩm</th>
                <th scope="col" style="width: 65px;">Số lượng</th>
                <th scope="col" style="width: 80px;">Giá</th>
                <th scope="col" style="width: 90px;">Tổng</th>
            </tr>
            <?php
            while ($rows = $res -> fetch_array(MYSQLI_ASSOC)) {
                $i++;
                $product_id = $rows['product_id'];
                $product_sql = "SELECT `pro_name` FROM `products` WHERE `id` = '$product_id'";
                $product_result = $connect->query($product_sql);
                $product_row = $product_result -> fetch_array(MYSQLI_ASSOC);
                ?>
                <tr class="row0">
                    <td>
                        <?php echo $i; ?>
                    </td>
                    <td>
                        <a href="products.php?id=<?php echo $product_id; ?>"><?php echo $product_row['pro_name']; ?></a>
                    </td>
                    <td>
                        <input type="text" value="<?php echo $rows['qty']; ?>" style="width: 30px;"
                               disabled="disabled"/>
                    </td>
                    <td>
                        <?php echo number_format($rows['price'], 0, ",", "."); ?> ₫
                    </td>
                    <td>
                        <?php echo number_format($rows['qty'] * $rows['price'], 0, ",", "."); ?> ₫
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <?php
        echo '</div>';
    }
}else {
    ?>
    <div class="widget-title"><i class="icon-paste"></i>&nbsp;Quản lý đơn hàng</div>
    <div class="widget-body">
    <?php
    $sql = "SELECT * FROM `lesson_order` WHERE `user_id` = '$users_id'";
    $result = $connect->query($sql);
    if ($result -> fetch_array(MYSQLI_NUM) == 0)
        echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có đơn hàng nào</div>';
    else {
        while ($row = $result -> fetch_array(MYSQLI_ASSOC)) {
            echo '<div class="cat_list">';
            echo 'Đơn hàng <strong>#' . $row['id'] . '</strong>';
            echo '<br />Trạng thái: ';
            if ($row['status'] == 1)
                echo '<strong>Chưa xử lí</strong>';
            elseif ($row['status'] == 2)
                echo '<strong>Đang xử lí</strong>';
            else
                echo '<strong>Đã xử lí</strong>';
            echo '<br />Trị giá đơn hàng: ' . number_format($row['total'], 0, ",", ".") . ' ₫';
            echo '<br />Phương thức thanh toán: ';
            if ($row['choosepayment'] == 1)
                echo 'Thanh toán trực tiếp<br />';
            elseif ($row['choosepayment'] == 2)
                echo 'Thanh toán qua bưu điện<br />';
            else
                echo 'Chuyển khoản qua ngân hàng<br />Số tài khoản của bạn là ' . $row['number_account'] . '<br />';
            echo '<a href="?id=' . $row['id'] . '">Chi tiết đơn hàng</a>';
            echo '</div>';
        }
    }
    echo '</div><!--end widget-body-->';
}
}
?>
    </div><!--end widget-->
<?php
require_once("inc/footer.php");
?>