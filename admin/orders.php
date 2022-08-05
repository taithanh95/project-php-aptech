<?php

/**
 * @author Nguyen Ba Tuan Anh -  t1304i Ha Noi Aptech
 * @copyright 2014
 */
    $title = 'Quản lý đơn hàng';
    require_once("../inc/header.php");
?>
<div class="widget">
<?php
    if(isset($_GET['act'])) {
        switch($_GET['act']) {
            case'read':
                $id = $_GET['id'];
                $sql = "SELECT * FROM `lesson_order` WHERE `id` = '$id'";
                $result = @mysql_query($sql);
                if(@mysql_num_rows($result) == 0) {
                    $title = '404';
                    echo '<div class="widget-title"><i class="icon-warning-sign"></i>&nbsp;404</div>
            <div class="widget-body"><p align="center">Oops, Trang này không tồn tại<br /><br /><a href="/" class="btn">Trở lại</a></p></div>';
                }else {
                    $row = @mysql_fetch_array($result);
                    $title = 'Chi tiết đơn hàng #'.$id.'';
                    echo '<div class="widget-title"><i class="icon-paste"></i>&nbsp;Chi tiết đơn hàng #'.$id.'<span style="float: right;"><a href="orders.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
            <div class="widget-body">';
					if(isset($_POST['submit'])) {
						$status = $_POST['status'];
						@mysql_query("UPDATE `lesson_order` SET `status` = '$status' WHERE `id` = '$id'");
						echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Cập nhật trạng thái thành công</div>';
						$sql = "SELECT * FROM `lesson_order` WHERE `id` = '$id'";
						$result = @mysql_query($sql);
						$row = @mysql_fetch_array($result);
					}
                    $datetime = explode(" ", $row['date']);
                    $time = $datetime[1];
                    $date = explode("-", $datetime[0]);
                    $date = $date[2].'/'.$date[1].'/'.$date[0];
                    echo 'Ngày tạo: '.$time.' | '.$date;
                    echo '<br />Trạng thái: ';
                    if($row['status'] != 3) {
?>
					<form action="" method="POST" name="from1">
					<select name="status" style="width: 130px;">';
                        <option value="1" <?php if($row['status'] == 1) echo 'selected="selected"'; ?>>Chưa xử lí</option>
                        <option value="2" <?php if($row['status'] == 2) echo 'selected="selected"'; ?>>Đang xử lí</option>
                        <option value="3">Đã xử lí</option>
					</select>
					<input type="submit" name="submit" value="Cập nhật" class="btn" />
					</form>
<?php
                    }else {
                        echo 'Đã xử lí<br />';
                    }
                    echo 'Trị giá đơn hàng: '.number_format($row['total'],0,",",".").' ₫';
                    echo '<br />Phương thức thanh toán: ';
                    if($row['choosepayment'] == 1)
                        echo 'Thanh toán trực tiếp<br />';
                    elseif($row['choosepayment'] == 2)
                        echo 'Thanh toán qua bưu điện<br />';
                    else
                        echo 'Chuyển khoản qua ngân hàng<br />Số tài khoản '.$row['number_account'].'<br />';
                    echo '<div class="newsDetail">Thông tin người thanh toán</div>
                    <strong>'.$row['fullname'].'</strong>
                    <br />Địa chỉ: '.$row['address'].'
                    <br />Điện thoại: '.$row['phone'].'
                    <br />Email: '.$row['email'].'';
                    echo '<div class="newsDetail">Thông tin người nhận</div>
                    <strong>Nguyễn Bá Tuấn Anh</strong>
                    <br />Địa chỉ: 19 Nguyễn Trãi - Thanh Xuân - Hà Nội
                    <br />Điện thoại: 01646868928';
                    echo '<div class="newsDetail">Đơn hàng bao gồm</div>';
                    $order_id = $row['id'];
                    $query = "SELECT * FROM `lesson_order_detail` WHERE `order_id` = '$order_id'";
                    $res = @mysql_query($query);
                    $i = 0;
    ?>
                    <table class="table table-striped table-bordered dataTable" style="width:100%;">
                    	<tbody>
                    	<tr>
                    		<th scope="col" style="width: 8px;">#</th><th scope="col">Sản phẩm</th><th scope="col" style="width: 65px;">Số lượng</th><th scope="col" style="width: 80px;">Giá</th><th scope="col" style="width: 90px;">Tổng</th>
                    	</tr>
    <?php
                    while($rows = @mysql_fetch_array($res)) {
                        $i++;
                        $product_id = $rows['product_id'];
                        $product_sql = "SELECT `pro_name` FROM `products` WHERE `id` = '$product_id'";
                        $product_result = @mysql_query($product_sql);
                        $product_row = @mysql_fetch_array($product_result);
    ?>
                        <tr class="row0">
                    		<td>
                    			<?php echo $i; ?>
                    		</td>
                            <td>
                    			<a href="products.php?id=<?php echo $product_id; ?>"><?php echo $product_row['pro_name']; ?></a>
                    		</td>
                            <td>
                                <input type="text" value="<?php echo $rows['qty']; ?>" style="width: 30px;" disabled="disabled" />
                    		</td>
                            <td>
                    			<?php echo number_format($rows['price'],0,",","."); ?> ₫
                    		</td>
                            <td>
                    			<?php echo number_format($rows['qty']*$rows['price'],0,",","."); ?> ₫
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
            break;
            case'delete':
                $id = $_GET['id'];
                $sql = "SELECT * FROM `lesson_order` WHERE `id` = '$id'";
                $result = @mysql_query($sql);
                if(@mysql_num_rows($result) == 0) {
                    $title = '404';
                    echo '<div class="widget-title"><i class="icon-warning-sign"></i>&nbsp;404</div>
            <div class="widget-body"><p align="center">Oops, Trang này không tồn tại<br /><br /><a href="/" class="btn">Trở lại</a></p></div>';
                }else {
                    echo '<div class="widget-title"><i class="icon-paste"></i>&nbsp;Xóa hóa đơn #'.$id.'<span style="float: right;"><a href="orders.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
            <div class="widget-body">';
                    $row = @mysql_fetch_array($result);
					if(isset($_GET['confirm'])=='ok') {
                        @mysql_query("DELETE FROM `lesson_order_detail` WHERE `order_id` = '$id'") or die(@mysql_error());
						@mysql_query("DELETE FROM `lesson_order` WHERE `id` = '$id'") or die(@mysql_error());
						header('Location: orders.php');
                        exits();
					}else {
					   $query = "SELECT `id` FROM `lesson_order` WHERE `id` = '$id' AND `status` = '1' OR `status` = '2'";
                       $res = @mysql_query($query) or die($query);
                       if(@mysql_num_rows($res) != 0) {
                            echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Bạn chỉ xóa được đơn hàng đang ở trạng thái đã xử lí</div>';
                       }else {
						    echo 'Bạn chắc chắn muốn xóa hóa đơn: #'.$id.'<br /><br /><a href="'.$set['home'].'/admin/orders.php?act=delete&id='.$id.'&confirm=ok" class="btn">Tiếp tục</a>';
                       }
                    }
                    echo '</div>';
                }
                
            break;
        }
    }else {

?>
<div class="widget-title"><i class="icon-shopping-cart"></i>&nbsp;Quản lí đơn hàng<span style="float: right;"><a href="<?php echo $set['home']; ?>/admin/" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
<div class="widget-body">

        <?php
            if(isset($_GET['status'])) {
                if($_GET['status'] == 2)
                    $status = 2;
                elseif($_GET['status'] == 3)
                    $status = 3;
                elseif($_GET['status'] == 1)
                    $status = 1;
                else
                    $status = 0;
            }else
                $status = 0;
        ?>
<select onchange="location='?status='+this.options[this.selectedIndex].value;" name="order">
    <option value="0"<?php if($status == 0) echo ' selected="selected"' ?>>Tất cả</option>
    <option value="1"<?php if($status == 1) echo ' selected="selected"' ?>>Chưa xử lí</option>
    <option value="2"<?php if($status == 2) echo ' selected="selected"' ?>>Đang xử lí</option>
    <option value="3"<?php if($status == 3) echo ' selected="selected"' ?>>Đã xử lí</option>
</select>
        <?php
            $display = 10;
            $query = "SELECT COUNT(`id`) FROM `products`";
            $res = @mysql_query($query);
            $rows = @mysql_fetch_array($res);
            $record = $rows[0];
            $count = ceil($record/$display);
            if(isset($_GET['page']))
                $page = $_GET['page'];
            if(empty($page) OR $page < 1 OR $page > $count)
                $page = 1;
            $start = ($page - 1)*$display;
            if($status == 0) {
                $sql = "SELECT * FROM `lesson_order` ORDER BY `id` DESC LIMIT $start,$display";   
            }else {
                $sql = "SELECT * FROM `lesson_order` WHERE `status` = '$status' ORDER BY `id` DESC LIMIT $start,$display";   
            }
            $result = @mysql_query($sql);
            if(@mysql_num_rows($result) == 0)
                echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có đơn hàng nào</div>';
            else {
        ?>
    <table class="table table-striped table-bordered dataTable" style="width:100%;border-collapse:collapse;">
		<tbody>
		<tr>
			<th scope="col">#</th><th scope="col">Khách hàng</th>
            <th scope="col">Thời gian</th>
            <th scope="col">Trạng thái</th>
            <th scope="col">Tổng</th>
            <th scope="col">&nbsp;</th>
		</tr>
        <?php
                $i = 0;
                while($row = @mysql_fetch_array($result)) {
                    $i++;
        ?>
                    <tr class="row0">
						<td style="width:8px;">
							<?php echo $i; ?>
						</td>
                        <td>
							   <?php echo $row['fullname']; ?>
						</td>
                        <td style="width: 140px;">
							<?php
                                $datetime = explode(" ", $row['date']);
                                $date = explode("-", $datetime[0]);
                                $date = $date[2].'/'.$date[1].'/'.$date[0];
                                $time = $datetime[1];
                                echo $time.', '.$date;
                            ?>
						</td>
                        <td>
                        <?php
							if($row['status'] == 1)
                                echo 'Chưa xử lí';
                            elseif($row['status'] == 2)
                                echo 'Đang xử lí';
                            else
                                echo 'Đã xử lí';
                        ?>
							</select>
						</td>
                        <td>
							<?php echo number_format($row['total'],0,",","."); ?> ₫
						</td>
						<td class="text-center" style="width:100px;">
                            <a id="imb_del" class="imb_delete link-btn" title="Chi tiết đơn hàng" href="<?php echo ''.$set['home'].'/admin/orders.php?act=read&id='.$row['id'].''; ?>">
								<i class="icon-eye-open"></i>
							</a>
                            <?php
                                if($row['status'] == 3) {
                            ?>
							<a id="imb_del" class="imb_delete link-btn" title="Xóa đơn hàng" href="<?php echo ''.$set['home'].'/admin/orders.php?act=delete&id='.$row['id'].''; ?>">
								<i class="icon-trash"></i>
							</a>
                            <?php } ?>
						</td>
					</tr>
        <?php
                }
     echo '</tbody>
    </table>';
            }
        ?>
</div><!--end widget-body-->
<?php
    }
?>
</div><!--end widget-->
<?php
    require_once("../inc/footer.php");
?>