<?php

	$title = 'Danh mục sản phẩm';
	require_once("../inc/header.php");
?>
<div class="widget">
<?php
	if(isset($_GET['act'])) {
		switch($_GET['act']) {
			case'add':
				echo '<div class="widget-title"><i class="icon-sitemap"></i>&nbsp;Thêm mới danh mục sản phẩm <span style="float: right;"><a href="'.$set['home'].'/admin/categories.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>';
				echo '<div class="widget-body">';
				if(isset($_POST['submit'])) {
					$cat_name = $_POST['cat_name'];
					if(strlen($cat_name) < 4 OR strlen($cat_name) > 50)
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên danh mục quá ngắn hoặc quá dài (4 - 50 ký tự)</div>';
					elseif(empty($cat_name))
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bạn phải nhập thông tin tên danh mục</div>';
					else {
							$show = $_POST['show'];
							$sql = "INSERT `categories`(`cat_name`, `show`) VALUES('$cat_name', '$show')";
							$result = @mysql_query($sql);
							if(isset($result))
								echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Tạo danh mục mới thành công</div>';
					}
				}
?>
	<form action="" method="POST" name="form1">
	<table cellpadding="4" cellspacing="0">
		<tr>
			<td>Tên danh mục <span class="required">*</span></td>
			<td><input type="text" name="cat_name" required="required" style="width:400px;" /></td>
		</tr>
	<tr>
		<td>Hiển thị</td>
		<td>
			<select name="show" style="width:80px;">
				<option selected="selected" value="true">Có</option>
				<option value="false">Không</option>
			</select>
		</td>
	</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="Thêm mới" class="btn" /></td>
		</tr>	
	</table>
</form>
</div><!--end widget-body-->
<?php
			break;//end case add
			case'edit':
				echo '<div class="widget-title"><i class="icon-sitemap"></i>&nbsp;Sửa danh mục sản phẩm <span style="float: right;"><a href="'.$set['home'].'/admin/categories.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>';
				echo '<div class="widget-body">';
				if(isset($_GET['id'])) {
					$id = $_GET['id'];
					$sql = "SELECT * FROM `categories` WHERE `id` = '$id'";
					$result = @mysql_query($sql);
					if(@mysql_num_rows($result)==0) {
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Danh mục sản phẩm không tồn tại</div>';
					}else {
                        $row = @mysql_fetch_array($result);
						if(isset($_POST['submit'])) {
							$cat_name = $_POST['cat_name'];
							if(strlen($cat_name) < 4 OR strlen($cat_name) > 50)
								echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên danh mục quá ngắn hoặc quá dài (4 - 50 ký tự)</div>';
							elseif(empty($cat_name))
								echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bạn phải nhập thông tin tên danh mục</div>';
							else {
									$show = $_POST['show'];
									$sql = "UPDATE `categories` SET `cat_name` = '$cat_name', `show` = '$show' WHERE `id` = '$id'";
									$result = @mysql_query($sql);
									if(isset($result)) {
										echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Cập nhật thông tin thành công</div>';
                                        $sql = "SELECT * FROM `categories` WHERE `id` = '$id'";
                                        $result = @mysql_query($sql);
                                        $row = @mysql_fetch_array($result);
                                    }
							}
						}
?>
	<form action="" method="POST" name="form1">
	<table cellpadding="4" cellspacing="0">
		<tr>
			<td>Tên danh mục <span class="required">*</span></td>
			<td><input type="text" name="cat_name" required="required" value="<?php echo $row['cat_name']; ?>" style="width:400px;" /></td>
		</tr>
	<tr>
		<td>Hiển thị</td>
		<td>
			<select name="show" style="width:80px;">
				<?php
					if($row['show']=='true') {
						echo '<option selected="selected" value="true">Có</option>
						<option value="false">Không</option>';
					}
					else {
						echo '<option value="true">Có</option>
						<option selected="selected" value="false">Không</option>';
					}
				?>
			</select>
		</td>
	</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" name="submit" value="Cập nhật" class="btn" /></td>
		</tr>	
	</table>
</form>
<?php
					}
				}else {
					echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bạn chưa chọn danh mục sản phẩm</div>';
				}
				echo '</div><!--end widget-body-->';
			break;//end case edit
			
			case'delete':
				echo '<div class="widget-title"><i class="icon-sitemap"></i>&nbsp;Xóa danh mục sản phẩm <span style="float: right;"><a href="'.$set['home'].'/admin/categories.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>';
				echo '<div class="widget-body">';
				if(isset($_GET['id'])) {
					$id = $_GET['id'];
					$sql = "SELECT * FROM `categories` WHERE `id` = '$id'";
					$result = @mysql_query($sql);
					if(@mysql_num_rows($result)==0) {
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Danh mục sản phẩm không tồn tại</div>';
					}else {
						$row = @mysql_fetch_array($result);
						$cat_id = $row['id'];
						$query = "SELECT `cat_id` FROM `products` WHERE `cat_id` = '$cat_id'";
						$res = @mysql_query($query);
						if(@mysql_num_rows($res) == 0) {
							if(isset($_GET['confirm'])=='ok') {
    							@mysql_query("DELETE FROM `categories` WHERE `id` = '$id'") or die (@mysql_error());
								header('Location: categories.php');
                                exits();
							}else
								echo 'Bạn chắc chắn muốn xóa danh mục sản phẩm: '.$row['cat_name'].'<br /><br /><a href="'.$set['home'].'/admin/categories.php?act=delete&id='.$id.'&confirm=ok" class="btn">Tiếp tục</a>';
						}else {
						  echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Hiện danh mục này đang có các sản phẩm, bạn cần phải xóa sản phẩm trước</div>';
						}
					}
				}
				echo '</div><!--end widget-body-->';
			break;//end case delete
		}//end switch
	}else {//end if $_GET['act']
?>
		<div class="widget-title"><i class="icon-sitemap"></i>&nbsp;Danh mục sản phẩm <span style="float: right;"><a href="<?php echo ''.$set['home'].'/admin/categories.php?act=add'; ?>" class="btn"><i class="icon-plus"></i>&nbsp;Thêm mới</a>&nbsp;<a href="<?php echo ''.$set['home'].'/admin/'; ?>" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
		<div class="widget-body">
		<?php
			$sql = "SELECT * FROM `categories` ORDER BY `id` DESC";
			$result = @mysql_query($sql);
			if(@mysql_num_rows($result)==0) {
				echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có danh mục sản phẩm nào</div>';
			}else {
				echo '<table class="table table-striped table-bordered dataTable" cellspacing="0" style="width:100%;border-collapse:collapse;">
		<tbody>
		<tr>
			<th scope="col">#</th><th scope="col">Danh mục sản phẩm</th><th scope="col">Trạng thái</th><th scope="col" style="width:50px;">Sản phẩm</th><th scope="col">&nbsp;</th>
		</tr>';
				$i = 0;
				while($row = @mysql_fetch_array($result)) {
					$i++;
                    $cat_id = $row['id'];
		?>
					<tr class="row0">
						<td align="center" style="width:8px;">
							<?php echo $i; ?>
						</td><td>
							<span style="margin-left: 0px"></span>
							   <?php echo $row['cat_name']; ?>
						</td><td align="center" style="width:80px;">
							<?php
								if($row['show']=='true')
									echo 'Hiển thị';
								else
									echo 'Ẩn';
							?>
						</td>
                        <td>
                        <?php
                            $rows = @mysql_fetch_array(@mysql_query("SELECT COUNT(`id`) FROM `products` WHERE `cat_id` = '$cat_id'"));
                            $count = $rows[0];
                            echo $count;
                        ?>                        
                        </td>
						<td class="text-center" align="center" style="width:120px;">
							<a href="<?php echo ''.$set['home'].'/admin/products.php?act=add&cat_id='.$row['id'].''; ?>" title="Thêm sản phẩm vào danh mục này" class="link-btn">
								<i class="icon-plus"></i>
							</a>
							<a href="<?php echo ''.$set['home'].'/admin/categories.php?act=edit&id='.$row['id'].''; ?>" title="Sửa danh mục sản phẩm" class="link-btn">
								<i class="icon-edit"></i>
							</a>
							<a id="imb_del" class="imb_delete link-btn" title="Xóa danh mục sản phẩm" href="<?php echo ''.$set['home'].'/admin/categories.php?act=delete&id='.$row['id'].''; ?>">
								<i class="icon-trash"></i>
							</a>
						</td>
					</tr>
<?php
				}
			}
		echo '</tbody></table>
		</div><!--end widget-body-->';
	}
	echo '</div><!--end widget-->';
	require_once("../inc/footer.php");
?>