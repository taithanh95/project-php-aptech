<?php
$title = 'Tin tức';
require_once("../inc/header.php");
echo '<div class="widget">';
if (isset($_GET['act'])) {
    switch ($_GET['act']) {
        case'add':
            echo '<div class="widget-title"><i class="icon-list-alt"></i>&nbsp;Thêm tin tức mới <span style="float: right;"><a href="' . $set['home'] . '/admin/articles.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>';
            echo '<div class="widget-body">';
            if (isset($_POST['submit'])) {
                $articles_name = $_POST['articles_name'];
                if (strlen($articles_name) < 4 or strlen($articles_name) > 150)
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên tin tức quá ngắn hoặc quá dài (4 - 150 ký tự)</div>';
                elseif (empty($articles_name))
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bạn phải nhập thông tin tên tin tức</div>';
                else {
                    $cat_id = $_POST['cat_id'];
                    $show = $_POST['show'];
                    $content = $_POST['content'];
                    if (!empty($content)) {
                        $content = str_replace("


", "<br /><br /><br />", $content);
                        $content = str_replace("

", "<br /><br />", $content);
                        $content = str_replace("
", "<br />", $content);
                    }
                    $comment = $_POST['comment'];
                    $created = date("Y-m-d H:i:s");
                    $sql = "INSERT INTO `articles` (`articles_name`, `cat_id`, `show`, `content`, `created`, `comment`) VALUES ('$articles_name', '$cat_id', '$show', '$content', '$created', '$comment')";
                    $result = @mysql_query($sql);
                    if (isset($result))
                        echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Đăng tin tức mới thành công</div>';
                }
            }
            ?>
            <form action="" method="POST" name="form1">
                <table cellpadding="4" cellspacing="0">
                    <tr>
                        <td>Tên tin tức <span class="required">*</span></td>
                        <td><input type="text" name="articles_name" required="required" style="width:400px;"/></td>
                    </tr>
                    <tr>
                        <td>Danh mục</td>
                        <td>
                            <select name="cat_id">
                                <?php
                                $query = "SELECT * FROM `categorie_articles` WHERE `show` = 'true'";
                                $res = @mysql_query($query);
                                if (@mysql_num_rows($res) == 0)
                                    echo '<option value="0">Chưa có danh mục nào</option>';
                                else {
                                    while ($rows = @mysql_fetch_array($res)) {
                                        if (isset($_GET['cat_id'])) {
                                            $id = $_GET['cat_id'];
                                            if ($rows['id'] == $id)
                                                echo '<option selected="selected" value="' . $rows['id'] . '">' . $rows['cat_name'] . '</option>';
                                            else
                                                echo '<option value="' . $rows['id'] . '">' . $rows['cat_name'] . '</option>';
                                        } else
                                            echo '<option value="' . $rows['id'] . '">' . $rows['cat_name'] . '</option>';
                                    }
                                }
                                ?>
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
                        <td><input type="submit" name="submit" value="Thêm mới" class="btn"/></td>
                    </tr>
                </table>
            </form>
            </div><!--end widget-body-->
            <?php
            break;//end case add
        case'edit':
            echo '<div class="widget-title"><i class="icon-list-alt"></i>&nbsp;Sửa tin tức <span style="float: right;"><a href="' . $set['home'] . '/admin/articles.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>';
            echo '<div class="widget-body">';
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM `articles` WHERE `id` = '$id'";
                $result = @mysql_query($sql);
                if (@mysql_num_rows($result) == 0) {
                    echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Tin tức không tồn tại</div>';
                } else {
                    $row = @mysql_fetch_array($result);
                    if (isset($_POST['submit'])) {
                        $articles_name = $_POST['articles_name'];
                        if (strlen($articles_name) < 4 or strlen($articles_name) > 150)
                            echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tên tin tức quá ngắn hoặc quá dài (4 - 150 ký tự)</div>';
                        elseif (empty($articles_name))
                            echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bạn phải nhập thông tin tên tin tức</div>';
                        else {
                            $cat_id = $_POST['cat_id'];
                            $show = $_POST['show'];
                            $content = $_POST['content'];
                            if (!empty($content)) {
                                $content = str_replace("


", "<br /><br /><br />", $content);
                                $content = str_replace("

", "<br /><br />", $content);
                                $content = str_replace("
", "<br />", $content);
                            }
                            $comment = $_POST['comment'];
                            $created = date("Y-m-d H:i:s");
                            $sql = "UPDATE `articles` SET `articles_name` = '$articles_name', `cat_id` = '$cat_id', `show` = '$show', `content` = '$content', `created` = '$created', `comment` = '$comment' WHERE `id` = '$id'";
                            $result = mysql_query($sql);
                            if (isset($result)) {
                                echo '<div class="alert alert-success"><i class="icon-ok"></i>&nbsp;Cập nhật thông tin thành công</div>';
                                $sql = "SELECT * FROM `articles` WHERE `id` = '$id'";
                                $result = @mysql_query($sql);
                                $row = @mysql_fetch_array($result);
                            }
                        }
                    }
                    ?>
                    <form action="" method="POST" name="form1">
                        <table cellpadding="4" cellspacing="0">
                            <tr>
                                <td>Tên tin tức <span class="required">*</span></td>
                                <td><input type="text" name="articles_name" value="<?php echo $row['articles_name']; ?>"
                                           required="required" style="width:400px;"/></td>
                            </tr>
                            <tr>
                                <td>Danh mục</td>
                                <td>
                                    <select name="cat_id">
                                        <?php
                                        $query = "SELECT * FROM `categorie_articles` WHERE `show` = 'true' ORDER BY `id` DESC";
                                        $res = @mysql_query($query);
                                        if (@mysql_num_rows($res) == 0)
                                            echo '<option value="0">Chưa có danh mục nào</option>';
                                        else {
                                            while ($rows = @mysql_fetch_array($res)) {
                                                if ($rows['id'] == $row['cat_id'])
                                                    echo '<option selected="selected" value="' . $rows['id'] . '">' . $rows['cat_name'] . '</option>';
                                                else
                                                    echo '<option value="' . $rows['id'] . '">' . $rows['cat_name'] . '</option>';
                                            }
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
                                        if ($row['show'] == 'true') {
                                            echo '<option selected="selected" value="true">Có</option>';
                                            echo '<option value="false">Không</option>';
                                        } else {
                                            echo '<option value="true">Có</option>';
                                            echo '<option selected="selected" value="false">Không</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Mô tả</td>
                                <td><textarea name="content" rows="4" cols="20"
                                              style="width:400px;"><?php echo $row['content']; ?></textarea></td>
                            </tr>
                            <tr>
                                <td>Cho phép bình luận</td>
                                <td>
                                    <select name="comment" style="width:80px;">
                                        <?php
                                        echo '<option ';
                                        if ($row['comment'] == 'true') {
                                            echo '<option selected="selected" value="true">Có</option>';
                                            echo '<option value="false">Không</option>';
                                        } else {
                                            echo '<option value="true">Có</option>';
                                            echo '<option selected="selected" value="false">Không</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td><input type="submit" name="submit" value="Cập nhật" class="btn"/></td>
                            </tr>
                        </table>
                    </form>
                    <?php
                }
            } else {
                echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Bạn chưa chọn tin tức</div>';
            }
            echo '</div><!--end widget-body-->';
            break;//end case edit

        case'delete':
            echo '<div class="widget-title"><i class="icon-list-alt"></i>&nbsp;Xóa tin tức <span style="float: right;"><a href="' . $set['home'] . '/admin/articles.php" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>';
            echo '<div class="widget-body">';
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $sql = "SELECT * FROM `articles` WHERE `id` = '$id'";
                $result = @mysql_query($sql);
                if (@mysql_num_rows($result) == 0) {
                    echo '<div class="alert alert-error"><i class="icon-warning-sign"></i>&nbsp;Tin tức không tồn tại</div>';
                } else {
                    $row = @mysql_fetch_array($result);
                    if (isset($_GET['confirm']) == 'ok') {
                        @mysql_query("DELETE FROM `articles_comment` WHERE `art_id` = '$id'") or die(@mysql_error());
                        @mysql_query("DELETE FROM `articles` WHERE `id` = '$id'") or die(@mysql_error());
                        header('Location: articles.php');
                        exits();
                    } else
                        echo 'Bạn chắc chắn muốn xóa tin tức: ' . $row['articles_name'] . '<br />Chú ý: Tiếp tục đồng nghĩa với việc bạn sẽ xóa toàn bộ bình luận trong tin tức này<br /><br /><a href="' . $set['home'] . '/admin/articles.php?act=delete&id=' . $id . '&confirm=ok" class="btn">Tiếp tục</a>';
                }
            }
            echo '</div><!--end widget-body-->';
            break;//end case delete
    }//end switch
} else {//end if $_GET['act']
?>
		<div class="widget-title"><i class="icon-list-alt"></i>&nbsp;Danh sách tin tức <span style="float: right;"><a href="<?php echo ''.$set['home'].'/admin/articles.php?act=add'; ?>" class="btn"><i class="icon-plus"></i>&nbsp;Thêm mới</a>&nbsp;<a href="<?php echo ''.$set['home'].'/admin/'; ?>" class="btn"><i class="icon-chevron-left"></i>&nbsp;Quay lại</a></span></div>
		<div class="widget-body">
		<?php
            $display = 10;
            $query = "SELECT COUNT(`id`) FROM `articles`";
            $res = @mysql_query($query);
            $rows = @mysql_fetch_array($res);
            $record = $rows[0];
            $count = ceil($record/$display);
            if(isset($_GET['page']))
                $page = $_GET['page'];
            if(empty($page) or $page < 1 or $page > $count)
                $page = 1;
            $start = ($page - 1)*$display;
			$sql = "SELECT * FROM `articles` ORDER BY `id` DESC LIMIT $start,$display";
			$result = @mysql_query($sql);
			if(@mysql_num_rows($result)==0) {
				echo '<div class="alert alert-info"><i class="icon-info-sign"></i>&nbsp;Chưa có tin tức nào</div>';
			}else {
				echo '<table class="table table-striped table-bordered dataTable" cellspacing="0" style="width:100%;border-collapse:collapse;">
		<tbody>
		<tr>
			<th scope="col">#</th><th scope="col">Tin tức</th><th scope="col">Danh mục</th><th scope="col">Trạng thái</th><th scope="col">Bình luận</th><th scope="col">&nbsp;</th>
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
							   <?php echo $row['articles_name']; ?>
						</td><td>
							<span style="margin-left: 0px"></span>
							<?php
								$id = $row['cat_id'];
								$query = "SELECT * FROM `categorie_articles` WHERE `show` = 'true' AND `id` = '$id'";
								$res = @mysql_query($query);
								if(@mysql_num_rows($res)==0)
									echo 'Chưa có danh mục nào';
								else {
									$rows = @mysql_fetch_array($res);
									echo $rows['cat_name'];
								}
							?>
						</td><td align="center" style="width:80px;">
							<?php
								if($row['show']=='true')
									echo 'Hiển thị';
								else
									echo 'Ẩn';
							?>
						</td><td align="center" style="width:80px;">
							<?php
								if($row['comment']=='true')
									echo 'Hiển thị';
								else
									echo 'Ẩn';
							?>
						</td>
						<td class="text-center" align="center" style="width:120px;">
							<a href="<?php echo ''.$set['home'].'/admin/articles.php?act=edit&id='.$row['id'].''; ?>" title="Sửa tin tức" class="link-btn">
								<i class="icon-edit"></i>
							</a>
							<a id="imb_del" class="imb_delete link-btn" title="Xóa tin tức" href="<?php echo ''.$set['home'].'/admin/articles.php?act=delete&id='.$row['id'].''; ?>">
								<i class="icon-trash"></i>
							</a>
							<a id="imb_del" class="imb_delete link-btn" title="Xem tin tức" href="<?php echo ''.$set['home'].'/articles.php?id='.$row['id'].''; ?>">
								<i class="icon-eye-open"></i>
							</a>
						</td>
					</tr>
<?php
				}
			}
		echo '</tbody></table>';
        if($count > 1) {
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
            echo '</ul>';
        }
		echo '</div><!--end widget-body-->';
	}
echo '</div><!--end widget-->';
require_once("../inc/footer.php");
?>