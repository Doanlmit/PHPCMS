<?php
	//breadcrumb hỗ trợ bot google đọc
	echo frontend_breadcrumb('article_category', array('level >=' => 1, 'lft <=' => $_category['lft'], 'rgt >=' => $_category['rgt']), 'item');
	if(isset($_children) && count($_children)){
		$str = '<ul>';
		foreach ($_children as $key => $val){
			$str = $str.'<li><h3><a href = "'.frontend_menu_link($val['route'], $val['alias'], $val['id'], 68).'" title="'.htmlspecialchars($val['title']).'">'.$val['title'].'</a></h3></li>';		
		}
		$str .= '</ul>';
		echo $str;
	}
	
	//Nội dung của bài viết
	echo (isset($_item['content']) &&  !empty($_item['content'])) ? $_item['content'] : '';
	
	//Comment
	
	
	if(isset($_comment) && count($_comment)){
		$comment = '<ul>';
		foreach ($_comment as $keyComment => $valComment){
			$comment .= '<li><a>'.$valComment['content'].'</a></li>';	
			$comment = $comment.'<li><strong><a href="#">'.$valComment['fullname'].'</a></strong></li>';	
		}
		$comment .= '</ul>';
		echo $comment;
	}
?>
<?php echo common_showerror(validation_errors()); ?>
<form method="post" action="">
	<label class="item">
		<p class="label">Họ và tên:</p><input type="text" name="data[fullname]" value="<?php echo common_valuepost(isset($_post['fullname']) ? $_post['fullname'] : ''); ?>" class="txtText" />
	</label> <label class="item">
		<p class="label">Email:</p><input type="text" name="data[email]" value="<?php echo common_valuepost(isset($_post['email']) ? $_post['email'] : ''); ?>" class="txtText" />
	</label> <label class="item">
		<p class="label">Nội dung phản hồi:</p><textarea type="text" name="data[content]" class="mceEditor"><?php echo common_valuepost(isset($_post['content']) ? $_post['content'] : '') ?></textarea>
	</label>
	<section class="action">
		<!--.action-->
		<p class="label">Thao tác:</p>
		<section class="group">
			<input type="submit" name="comment" value="Gủi bình luận"/> <input
				type="submit" name="reset" value="Làm lại"/>
		</section>
	</section>
</form>