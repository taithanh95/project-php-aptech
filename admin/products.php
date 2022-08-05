<?php

	$title = 'Danh sách sản phẩm';
	require_once("../inc/header.php");
?>
<div class="widget">
<?php
	if(isset($_GET['act'])) {
		switch($_GET['act']) {
			case'add':
                $title = 'Thêm sản phẩm mới';
				echo '<div class="widget-title"><i class="icon-list-alt"></i>&nbsp;Thêm sản phẩm mới <span style="float: right;"><a href="'.$set['home'].'/admin/products.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>';
				echo '<div class="widget-body">';
				if(isset($_POST['submit'])) {
		$pro_name = $_POST['pro_name'];
		$price = intval($_POST['price']);
		if(strlen($pro_name) < 4 OR strlen($pro_name) > 150)
			echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên sản phẩm quá ngắn hoặc quá dài (4 - 150 ký tự)</div>';
        elseif(!is_int($price) OR $price <= 0)
            echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Giá sản phẩm phải là một số nguyên dương</div>';
		else {
			if(isset($_POST['vat']))
				$vat = $_POST['vat'];
			else
				$vat = 0;
			$cat_id = $_POST['cat_id'];
			$baohanh = $_POST['baohanh'];
			$show = $_POST['show'];
			$content = $_POST['content'];
            if(!empty($content)) {
                $content = str_replace("


", "<br /><br /><br />", $content);
                $content = str_replace("

", "<br /><br />", $content);
                $content = str_replace("
", "<br />", $content);
            }
			$comment = $_POST['comment'];
			$created = date("Y-m-d H:i:s");
			if($_FILES['file']['name'] != NULL) {
				$_FILES['file']['name'] = str_replace(' ','-', $_FILES['file']['name']);
				$_FILES['file']['name'] = str_replace('_','-', $_FILES['file']['name']);
				$sizeimg = $_FILES['file']['size'];
				$typeimg = $_FILES["file"]["type"];
				$dl = 4000*1000;
				$allowedExts = array("gif", "jpeg", "jpg", "png");
				$temp = explode(".", $_FILES["file"]["name"]);
				$extension = end($temp);
				if((($typeimg == "image/gif") || ($typeimg == "image/jpeg") || ($typeimg == "image/jpg") || ($typeimg == "image/pjpeg") || ($typeimg == "image/x-png") || ($typeimg == "image/png")) && in_array($extension, $allowedExts)) {
					if((int)$sizeimg > $dl) {
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Dung lượng ảnh tối đa 4Mb</div>';
					}elseif(file_exists("files/".$_FILES["file"]["name"])) {
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên file đã tồn tại, vui lòng đổi tên rồi upload lại</div>';
					}else {
						if(!is_dir("files"))
							mkdir("files");
						move_uploaded_file($_FILES["file"]["tmp_name"],"files/".$_FILES["file"]["name"]);
						$img = $_FILES['file']['name'];
						$sql = "INSERT `products`(`pro_name`, `cat_id`, `price`, `vat`, `baohanh`, `show`, `img`, `content`, `comment`, `created`) VALUES('$pro_name', '$cat_id', '$price', '$vat', '$baohanh', '$show', '$img', '$content', '$comment', '$created')";
						$result = mysql_query($sql);
						if(isset($result))
							echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Đăng sản phẩm mới thành công</div>';
					}
				}else
					echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Định dạng tập tin không hợp lệ</div>';
			}else {
				$sql = "INSERT `products`(`pro_name`, `cat_id`, `price`, `vat`, `baohanh`, `show`, `img`, `content`, `comment`, `created`) VALUES('$pro_name', '$cat_id', '$price', '$vat', '$baohanh', '$show', '', '$content', '$comment', '$created')";
				$result = mysql_query($sql);
				if(isset($result))
					echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Đăng sản phẩm mới thành công</div>';
			}
		}
	}
?>
	<form action="" method="POST" enctype="multipart/form-data" name="form1">
		<table cellpadding="4" cellspacing="0">
			<tr>
				<td>Tên sản phẩm <span class="required">*</span></td>
				<td><input type="text" name="pro_name" required="required" style="width:400px;" value="<?php if(isset($pro_name)) echo $pro_name; ?>" /></td>
			</tr>
			<tr>
				<td>Giá sản phẩm <span class="required">*</span></td>
				<td><input type="number" name="price" required="required" style="width:80px;" /></td>
			</tr>
			<tr>
				<td>Giá đã bao gồm VAT</td>
				<td><input type="checkbox" name="vat" value="1" /></td>
			</tr>
			<tr>
				<td>Danh mục</td>
				<td>
					<select name="cat_id">
					<?php
						$query = "SELECT * FROM `categories` WHERE `show` = 'true' ORDER BY `id` DESC";
						$res = @mysql_query($query);
						if(@mysql_num_rows($res)==0)
							echo '<option value="0">Chưa có danh mục nào</option>';
						else {
							while($rows = @mysql_fetch_array($res)) {
								if(isset($_GET['cat_id'])) {
									$id = $_GET['cat_id'];
									if($rows['id'] == $id)
										echo '<option selected="selected" value="'.$rows['id'].'">'.$rows['cat_name'].'</option>';
									else
										echo '<option value="'.$rows['id'].'">'.$rows['cat_name'].'</option>';
								}else
									echo '<option value="'.$rows['id'].'">'.$rows['cat_name'].'</option>';
							}
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Bảo hành</td>
				<td>
					<select name="baohanh" style="width:80px;">
						<option selected="selected" value="1">1 năm</option>
						<option value="2">2 năm</option>
						<option value="3">3 năm</option>
						<option value="4">4 năm</option>
						<option value="5">5 năm</option>
					</select>
				</td>
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
				<td>Ảnh hiển thị</td>
				<td><input type="file" name="file" style="width:400px;" /></td>
			</tr>
			<tr>
				<td>Mô tả</td>
				<td><textarea name="content" rows="4" cols="20" style="width:400px;"></textarea></td>
			</tr>
			<tr>
				<td>Cho phép bình luận</td>
				<td>
					<select name="comment" style="width:80px;">
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
				echo '<div class="widget-title"><i class="icon-list-alt"></i>&nbsp;Sửa sản phẩm <span style="float: right;"><a href="'.$set['home'].'/admin/products.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>';
				echo '<div class="widget-body">';
				if(isset($_GET['id'])) {
					$id = $_GET['id'];
					$sql = "SELECT * FROM `products` WHERE `id` = '$id'";
					$result = @mysql_query($sql);
					if(@mysql_num_rows($result)==0) {
						echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Sản phẩm không tồn tại</div>';
					}else {
						$row = @mysql_fetch_array($result);
						if(isset($_POST['submit'])) {
							$pro_name = $_POST['pro_name'];
							$price = intval($_POST['price']);
							if(strlen($pro_name) < 4 OR strlen($pro_name) > 150)
								echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên sản phẩm quá ngắn hoặc quá dài (4 - 150 ký tự)</div>';
							elseif(!is_int($price) OR $price <= 0)
                                echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Giá sản phẩm phải là một số nguyên dương</div>';
							else {
								if(isset($_POST['vat']))
									$vat = $_POST['vat'];
								else
									$vat = 0;
								$cat_id = $_POST['cat_id'];
								$baohanh = $_POST['baohanh'];
								$show = $_POST['show'];
								$content = $_POST['content'];
                                if(!empty($content)) {
                                    $content = str_replace("


", "<br /><br /><br />", $content);
                                    $content = str_replace("

", "<br /><br />", $content);
                                    $content = str_replace("
", "<br />", $content);
                                }
								$comment = $_POST['comment'];
								$created = date("Y-m-d H:i:s");
								if(empty($row['img'])) {
									if($_FILES['file']['name'] != NULL) {
										$_FILES['file']['name'] = str_replace(' ','-', $_FILES['file']['name']);
										$_FILES['file']['name'] = str_replace('_','-', $_FILES['file']['name']);
										$sizeimg = $_FILES['file']['size'];
										$typeimg = $_FILES["file"]["type"];
										$dl = 4000*1000;
										$allowedExts = array("gif", "jpeg", "jpg", "png");
										$temp = explode(".", $_FILES["file"]["name"]);
										$extension = end($temp);
										if((($typeimg == "image/gif") || ($typeimg == "image/jpeg") || ($typeimg == "image/jpg") || ($typeimg == "image/pjpeg") || ($typeimg == "image/x-png") || ($typeimg == "image/png")) && in_array($extension, $allowedExts)) {
											if((int)$sizeimg > $dl) {
												echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Dung lượng ảnh tối đa 4Mb</div>';
											}elseif(file_exists("files/".$_FILES["file"]["name"])) {
												echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên file đã tồn tại, vui lòng đổi tên rồi upload lại</div>';
											}else {
												if(!is_dir("files"))
													mkdir("files");
												move_uploaded_file($_FILES["file"]["tmp_name"],"files/".$_FILES["file"]["name"]);
												$img = $_FILES['file']['name'];
												$sql = "UPDATE `products` SET `pro_name` = '$pro_name', `cat_id` = '$cat_id', `price` = '$price', `vat` = '$vat', `baohanh` = '$baohanh', `show` = '$show', `img` = '$img', `content` = '$content', `comment` = '$comment', `created` = '$created' WHERE `id` = '$id'";
												$result = mysql_query($sql);
												if(isset($result)) {
													echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Cập nhật thông tin thành công</div>';
                                                    $sql = "SELECT * FROM `products` WHERE `id` = '$id'";
                                                    $result = @mysql_query($sql);
                                                    $row = @mysql_fetch_array($result);
                                                }
											}
										}else
											echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Định dạng tập tin không hợp lệ</div>';
									}else {
										$sql = "UPDATE `products` SET `pro_name` = '$pro_name', `cat_id` = '$cat_id', `price` = '$price', `vat` = '$vat', `baohanh` = '$baohanh', `show` = '$show', `content` = '$content', `comment` = '$comment', `created` = '$created' WHERE `id` = '$id'";
										$result = mysql_query($sql);
										if(isset($result)) {
											echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Cập nhật thông tin thành công</div>';
                                            $sql = "SELECT * FROM `products` WHERE `id` = '$id'";
                                            $result = @mysql_query($sql);
                                            $row = @mysql_fetch_array($result);
                                        }
									}
								}else {
									$sql = "UPDATE `products` SET `pro_name` = '$pro_name', `cat_id` = '$cat_id', `price` = '$price', `vat` = '$vat', `baohanh` = '$baohanh', `show` = '$show', `content` = '$content', `comment` = '$comment', `created` = '$created' WHERE `id` = '$id'";
									$result = mysql_query($sql);
									if(isset($result)) {
										echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Cập nhật thông tin thành công</div>';
                                        $sql = "SELECT * FROM `products` WHERE `id` = '$id'";
                                        $result = @mysql_query($sql);
                                        $row = @mysql_fetch_array($result);
									}
								}
							}
						}
?>
	<form action="" method="POST" enctype="multipart/form-data" name="form1">
		<table>
			<tr>
				<td>Tên sản phẩm <span class="required">*</span></td>
				<td><input type="text" name="pro_name" value="<?php echo $row['pro_name']; ?>" required="required" style="width:400px;" /></td>
			</tr>
			<tr>
				<td>Giá sản phẩm <span class="required">*</span></td>
				<td><input type="number" name="price" value="<?php echo $row['price']; ?>" required="required" style="width:80px;" /></td>
			</tr>
			<tr>
				<td>Giá đã bao gồm VAT</td>
				<td>
					<?php
						if($row['vat']==1)
							echo '<input type="checkbox" name="vat" value="1" checked="checked" />';
						else
							echo '<input type="checkbox" name="vat" value="1" />';
					?>
				</td>
			</tr>
			<tr>
				<td>Danh mục</td>
				<td>
					<select name="cat_id">
					<?php
						$query = "SELECT * FROM `categories` WHERE `show` = 'true' ORDER BY `id` DESC";
						$res = @mysql_query($query);
						if(@mysql_num_rows($res) == 0)
							echo '<option value="0">Chưa có danh mục nào</option>';
						else {
							while($rows = @mysql_fetch_array($res)) {
								if($rows['id'] == $row['cat_id'])
									echo '<option selected="selected" value="'.$rows['id'].'">'.$rows['cat_name'].'</option>';
								else
									echo '<option value="'.$rows['id'].'">'.$rows['cat_name'].'</option>';
							}
						}
					?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Bảo hành</td>
				<td>
					<select name="baohanh" style="width:80px;">
						<?php
							for($i = 1; $i <= 5; $i++) {
								echo '<option ';
								if($row['baohanh']==$i)
									echo 'selected="selected" value="'.$i.'">'.$i.' năm';
								else
									echo ' value="'.$i.'">'.$i.' năm';
								echo '</option>';
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Hiển thị</td>
				<td>
					<select name="show" style="width:80px;">
						<?php
							echo '<option ';
							if($row['show']=='true') {
								echo '<option selected="selected" value="true">Có</option>';
								echo '<option value="false">Không</option>';
							}else {
								echo '<option value="true">Có</option>';
								echo '<option selected="selected" value="false">Không</option>';
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Ảnh hiển thị</td>
				<td>
				<?php
					if(empty($row['img']))
						echo '<input type="file" name="file" style="width:400px;" />';
					else {
						echo '<div class="imgdel"><img src="files/'.$row['img'].'" alt="*" width="200px" /><a href="'.$set['home'].'/admin/products.php?act=delimg&id='.$row['id'].'" title="Xóa ảnh hiển thị" class="remove"><i class="icon-remove"></i></a></div>';
					}
				?>
				</td>
			</tr>
			<tr>
				<td>Mô tả</td>
				<td><textarea name="content" rows="4" cols="20" style="width:400px;"><?php echo $row['content']; ?></textarea></td>
			</tr>
			<tr>
				<td>Cho phép bình luận</td>
				<td>
					<select name="comment" style="width:80px;">
						<?php
							echo '<option ';
							if($row['comment']=='true') {
								echo '<option selected="selected" value="true">Có</option>';
								echo '<option value="false">Không</option>';
							}else {
								echo '<option value="true">Có</option>';
								echo '<option selected="selected" value="false">Không</option>';
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
					echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bạn chưa chọn sản phẩm</div>';
				}
				echo '</div><!--end widget-body-->';
			break;//end case edit
			
			case'delete':
				echo '<div class="widget-title"><i class="icon-list-alt"></i>&nbsp;Xóa sản phẩm <span style="float: right;"><a href="'.$set['home'].'/admin/products.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>';
				echo '<div class="widget-body">';
				if(isset($_GET['id'])) {
					$id = $_GET['id'];
					$sql = "SELECT * FROM `products` WHERE `id` = '$id'";
					$result = @mysql_query($sql);
					if(@mysql_num_rows($result)==0) {
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Sản phẩm không tồn tại</div>';
					}else {
						$row = @mysql_fetch_array($result);
						if(isset($_GET['confirm']) == 'ok') {
                            $cm_query = "SELECT `pro_id` FROM `products_comment` WHERE `pro_id` = '$id'";
                            $cm_res = @mysql_query($cm_query);
                            if(@mysql_num_rows($cm_res) != 0)
                                @mysql_query("DELETE FROM `products_comment` WHERE `pro_id` = '$id'") or die(@mysql_error());
                            @mysql_query("DELETE FROM `products` WHERE `id` = '$id'") or die(@mysql_error());
							header('Location: products.php');
                            exits();
                        }else {
                            $query = "SELECT `product_id`, `order_id` FROM `lesson_order_detail` WHERE `product_id` = '$id'";
                            $res = @mysql_query($query);
                            if(@mysql_num_rows($res) != 0) {
                                echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Sản phẩm này đã được khách hàng đặt hàng trước đó, bạn không thể xóa</div>';
                            }else {
                                echo 'Bạn chắc chắn muốn xóa sản phẩm: '.$row['pro_name'].'<br />
                                Chú ý: Nếu tiếp tục, tất cả bình luận có trong sản phẩm này sẽ bị xóa<br /><br />
                                <a href="'.$set['home'].'/admin/products.php?act=delete&id='.$id.'&confirm=ok" class="btn">Tiếp tục</a>';
                            }
                        }
					}
				}
				echo '</div><!--end widget-body-->';
			break;//end case delete
			case'delimg':
				if(isset($_GET['id'])) {
					$id = $_GET['id'];
					$sql = "SELECT `img` FROM `products` WHERE `id` = '$id'";
					$result = @mysql_query($sql);
					if(@mysql_num_rows($result)==0) {
						echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Ảnh sản phẩm không tồn tại</div>';
					}else {
						$row = @mysql_fetch_array($result);
						unlink("files/".$row['img']);
						$query = "UPDATE `products` SET `img` = '' WHERE `id` = '$id'";
						$res = @mysql_query($query);
						if(isset($res))
							header('Location: products.php?act=edit&id='.$id.'');
					}
				}
			break;//end case delimg
		}//end switch
	}else {//end if $_GET['act']
?>
		<div class="widget-title"><i class="icon-list-alt"></i>&nbsp;Danh sách sản phẩm <span style="float: right;"><a href="<?php echo ''.$set['home'].'/admin/products.php?act=add'; ?>" class="btn"><i class="icon-plus"></i>&nbsp;Thêm mới</a>&nbsp;<a href="<?php echo ''.$set['home'].'/admin/'; ?>" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
		<div class="widget-body">
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
			$sql = "SELECT * FROM `products` ORDER BY `id` DESC LIMIT $start,$display";
			$result = @mysql_query($sql);
			if(@mysql_num_rows($result)==0) {
				echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có sản phẩm nào</div>';
			}else {
				echo '<table class="table table-striped table-bordered dataTable" cellspacing="0" style="width:100%;border-collapse:collapse;">
		<tbody>
		<tr>
			<th scope="col">#</th><th scope="col">Sản phẩm</th><th scope="col">Danh mục</th><th scope="col">Trạng thái</th><th scope="col">Bình luận</th><th scope="col">&nbsp;</th>
		</tr>';
				$i = 0;
				while($row = @mysql_fetch_array($result)) {
					$i++;
		?>
					<tr class="row0">
						<td style="width:8px;">
							<?php echo $i; ?>
						</td><td>
							<span style="margin-left: 0px"></span>
							   <?php echo $row['pro_name']; ?>
						</td><td>
							<span style="margin-left: 0px"></span>
							<?php
								$id = $row['cat_id'];
								$query = "SELECT * FROM `categories` WHERE `show` = 'true' AND `id` = '$id' ORDER BY `id` DESC";
								$res = @mysql_query($query);
								if(@mysql_num_rows($res)==0)
									echo 'Chưa có danh mục nào';
								else {
									$rows = @mysql_fetch_array($res);
									echo $rows['cat_name'];
								}
							?>
						</td><td style="width:80px;">
							<?php
								if($row['show']=='true')
									echo 'Hiển thị';
								else
									echo 'Ẩn';
							?>
						</td><td style="width:80px;">
							<?php
								if($row['comment']=='true')
									echo 'Hiển thị';
								else
									echo 'Ẩn';
							?>
						</td>
						<td class="text-center" style="width:120px;">
							<a href="<?php echo ''.$set['home'].'/admin/products.php?act=edit&id='.$row['id'].''; ?>" title="Sửa sản phẩm" class="link-btn">
								<i class="icon-edit"></i>
							</a>
							<a id="imb_del" class="imb_delete link-btn" title="Xóa sản phẩm" href="<?php echo ''.$set['home'].'/admin/products.php?act=delete&id='.$row['id'].''; ?>">
								<i class="icon-trash"></i>
							</a>
                            <a id="imb_del" class="imb_delete link-btn" title="Xem sản phẩm" href="<?php echo ''.$set['home'].'/products.php?id='.$row['id'].''; ?>">
								<i class="icon-eye-open"></i>
							</a>
						</td>
					</tr>
<?php
				}
			}
		echo '</tbody></table>';
		/*if($count > 1) {
		  $pre = $page - 1;
          $next = $page + 1;
          echo '<ul class="page">';
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
          echo '<ul>';
		}
        */
        if($count > 1) {
            $out = array();
            if($count > 5) {
                if($page > 1) $out[] = '<li><a href="?page='.($page - 1).'"><<</a></li>';
                if($page > 3) $out[] = '<li><a href="?page=1">1</a></li>';
                if($page > 4) $out[] = '<li class="current">...</li>';
            }
            for ($i = 1; $i <= $count; $i++) {
                if (!($i >= ($page + 3) || $i <= ($page - 3)) || $count <= 5) {
                    if ($i == $page) {
                        $out[] = '<li class="current">' . $i . '</li>';
                    } else {
                        $out[] = '<li><a href="?page='.$i.'">'.$i.'</a></li>';
                    }
                }
            }
            if ($count > 5) {
                if ($count > ($page + 3)) $out[] = '<li class="current">...</li>';
                if ($count > ($page + 2)) $out[] = '<li><a href="?page='.$count.'">'.$count.'</a></li>';
                if ($count > $page) $out[] = '<li><a href="?page='.($page + 1).'">>></a></li>';
            }
            echo '<ul class="page">' . implode(' ', $out) . '</ul>';
        }
        echo '</div><!--end widget-body-->';
	}
	echo '</div><!--end widget-->';
	require_once("../inc/footer.php");
?>