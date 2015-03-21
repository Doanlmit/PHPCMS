<?php
	echo frontend_breadcrumb('article_category', array('level >=' => 1, 'lft <=' => $_category['lft'], 'rgt >=' => $_category['rgt']), 'category');
	
	if(isset($_children) && count($_children)){
		$str = '<ul>';
		foreach ($_children as $key => $val){
			$str = $str.'<li><h3><a href = "'.frontend_menu_link($val['route'], $val['alias'], $val['id'], 68).'" title="'.htmlspecialchars($val['title']).'">'.$val['title'].'</a></h3>';		
		}
		$str .= '</ul>';
		echo $str;
	}
	if(isset($_list) && count($_list)){ 
		$str = '<ol>';
		foreach ($_list as $keyList => $valList){
			$str .= '<li><h2><a href="'.frontend_menu_link($valList['route'], $valList['alias'], $valList['id'], '88').'" title="'.$valList['title'].'">'.$valList['title'].'</a></h2></li>'; 
		}
		$str .= '</ol>';
		echo $str;
	}
	echo (isset($pagination) && !empty($pagination)) ? '<section class="pagination">'.$pagination.'</section>' : '';
?>