<?php

    $title = 'Upload';
    require_once("../inc/header.php");
?>
<div class="widget">
<?php
if(isset($_GET['upload'])) {
	echo '<div class="widget-title"><i class="icon-picture"></i>&nbsp;Thư viện <span style="float: right;"><a href="../admin/libraries.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
	<div class="widget-body">';
	if(isset($_POST['submit'])) {
		if($_FILES['file']['name'] != NULL) {
			$_FILES['file']['name'] = str_replace(' ','-', $_FILES['file']['name']);
			$_FILES['file']['name'] = str_replace('_','-', $_FILES['file']['name']);
			$img = $_FILES['file']['name'];
			$sizeimg = $_FILES['file']['size'];
			$typeimg = $_FILES["file"]["type"];
			$dl = 400*1000;
			$allowedExts = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["file"]["name"]);
			$extension = end($temp);
			$tg = date("Y-m-d H:i:s");
			if((($typeimg == "image/gif") || ($typeimg == "image/jpeg") || ($typeimg == "image/jpg") || ($typeimg == "image/pjpeg") || ($typeimg == "image/x-png") || ($typeimg == "image/png")) && in_array($extension, $allowedExts)) {
				if((int)$sizeimg > $dl) {
					echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Dung lượng ảnh tối đa 400kb</div>';
				}elseif(file_exists("libraries/".$_FILES["file"]["name"])) {
					echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên file đã tồn tại, vui lòng đổi tên rồi upload lại</div>';
				}else {
					if(!is_dir("libraries"))
						mkdir("libraries");
					move_uploaded_file($_FILES["file"]["tmp_name"],"libraries/".$_FILES["file"]["name"]);
					$query = "INSERT INTO `libraries` (`name`, `uploaded_by`, `uploaded`) VALUE ('$img', '$account', '$tg')";
					$result = @mysql_query($query);
					if(isset($result))
						echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Tải lên thành công</div>';
				}
			}else
				echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Định dạng tập tin không hợp lệ</div>';
		}else
			echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bạn chưa chọn tập tin</div>';
	}
		echo '- Định dạng hỗ trợ jpg, png, gif, jpeg.<br />- Dung lượng tối đa là 400kb.<br />- Tên tập tin gồm tiếng việt không dấu (a-Z, 0-9, _, -)<br />
		<form action="" method="POST" enctype="multipart/form-data">
			Chọn tập Tin:<br />
			<input type="file" name="file" size="15" /><br />
			<input type="submit" name="submit" class="btn" value="Upload" />
		</form></div>';
}else {
	echo '<div class="widget-title"><i class="icon-picture"></i>&nbsp;Thư viện <span style="float: right;"><a href="../admin/libraries.php?upload" class="btn"><i class="icon-plus-sign"></i>&nbsp;Thêm mới</a>&nbsp;<a href="../admin/" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
	<div class="widget-body">';
	$sql = "SELECT * FROM `libraries`";
	$result = @mysql_query($sql);
	if(@mysql_num_rows($result) == 0)
		echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Thư viện trống</div>';
	else {
		echo '<table class="table table-striped table-bordered dataTable" cellspacing="0" style="width:100%;border-collapse:collapse;">
		<tbody>
		<tr>
			<th scope="col">#</th><th scope="col">Tập tin</th><th scope="col">File url</th><th scope="col">Tác giả</th><th scope="col">Ngày</th><th scope="col">&nbsp;</th>
		</tr>';
		$i = 0;
		while($row = @mysql_fetch_array($result)) {
			$i++;
?>
			<tr class="row0">
				<td align="center" style="width:8px;">
					<?php echo $i; ?>
				</td><td>
					<span style="margin-left: 0px"></span>
					   <img src="libraries/<?php echo $row['name']; ?>" alt="*" class="icon" />
				</td><td align="center" style="width:80px;">
					<input type="text" style="border-color: #ddd; box-shadow: inset 0 1px 2px rgba(0,0,0,.07);" readonly="readonly" value="<?php echo '../admin/libraries/'.$row['name']; ?>" />
				</td><td align="center" style="width:80px;">
					<?php echo $row['uploaded_by']; ?>
				</td><td align="center" style="width:80px;">
					<?php echo $row['uploaded']; ?>
				</td>
				<td class="text-center" align="center" style="width:120px;">
					<a href="<?php echo '../admin/product.php?act=add&categories='.$row['id'].''; ?>" title="Thêm sản phẩm vào danh mục này" class="link-btn">
						<i class="icon-plus"></i>
					</a>
					<a href="<?php echo '../admin/categories.php?act=edit&id='.$row['id'].''; ?>" title="Sửa danh mục sản phẩm" class="link-btn">
						<i class="icon-edit"></i>
					</a>
					<a id="imb_del" class="imb_delete link-btn" title="Xóa danh mục sản phẩm" href="<?php echo '../admin/categories.php?act=delete&id='.$row['id'].''; ?>">
						<i class="icon-trash"></i>
					</a>
				</td>
			</tr>
<?php
		}
		echo '</tbody>
		</table>';
	}
	echo '</div><!--end widget-body-->';
}
	echo '</div><!--end widget-->';
	require_once("../inc/footer.php");
?>