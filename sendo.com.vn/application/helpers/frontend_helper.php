<?php
    //Phương thức tạo menu bên ngoài trang chủ CLIP 24
    if (!function_exists('frontend_menu')) {
        function frontend_menu ($param) {
            $CI = & get_instance();
            $_lang = $CI->session->userdata('_lang');
            $menu = $CI->db->where(array('publish' => 1, 'lang'=> $_lang))->from('menu')->order_by('orders asc, id asc')->get()->result_array();
            $str = '';
            if (isset($menu) && count($menu)) {
                $str = '<ul class="main">';
                foreach ($menu as $keyMain => $valMain) {
                    if(!empty($valMain['url'])){
                        $str = $str.'<li class = "main"><a href = "'.$valMain['url'].'" title="'.htmlspecialchars($valMain['title']).'">'.$valMain['title'].'</a></li>';
                    }
                    else if(!empty($valMain['module']) && $valMain['module_id'] > 0){
                        if($valMain['module'] == 'article_category'){
                            $str = $str.frontend_menu_article_category($param['article_category'], $valMain['module_id']);
                        }
                    }
                }
                $str = $str.'</ul>';
            } 
            return $str;
        }
    }
    //Phương thức tạo menu được gọi bên trong frontend_menu tạo các menu cấp 2-CLIP 24
    if (!function_exists('frontend_menu_article_category')){
        function frontend_menu_article_category($data, $module_id = 0) {
        if (isset($data) && count($data)) {
            //Main
            $_itemMain = '';
            foreach ($data as $keyMain => $valMain) {
                if ($valMain['id'] == $module_id) {
                    $_itemMain = $_itemMain.'<li class="main"><a href="'.frontend_menu_link($valMain['route'], $valMain['alias'], $valMain['id'], '68').'" class="main">' . $valMain['title'] . '</a>';
                    //Item
                    $_tempItem = '';
                    foreach ($data as $keyItem => $valItem) {
                        if ($valMain['id'] == $valItem['parentid']) {
                            $_tempItem = $_tempItem.'<li class="item"><a href = "'.frontend_menu_link($valItem['route'], $valItem['alias'], $valItem['id'], '68') . '" class="item">'.$valItem['title'].'</a></li>';
                            //Sub
                            $_temSub = '';
                            foreach($data as $keySub => $valSub){
                                if($valItem['id'] == $valSub['parentid']){
                                   $_temSub = $_temSub.'<li class="sub"><a href="'.frontend_menu_link($valSub['route'], $valSub['alias'], $valSub['id'], '68').'">'.$valSub['title'].'</a></li>';
                                   //Child
                                   $_temChildren = '';
                                   foreach ($data as $keyChildren => $valChidren) {
                                       if($valSub['id'] == $valChidren['parentid']){
                                            $_temChildren .= '<li class="children"><a href="'.frontend_menu_link($valChidren['route'], $valChidren['alias'], $valChidren['id'], '68').'">'.$valChidren['title'].'</a></li>';
                                        }
                                        continue;
                                   }
                                   $_temChildren = (!empty($_temChildren)) ? '<ul class="children">'.$_temChildren.'</ul>':'';
                                   $_temSub = $_temSub.$_temChildren;
                                }
                                continue;
                            }
                            $_temSub = (!empty($_temSub)) ? '<ul class="sub">'.$_temSub.'</ul>':'';
                            $_tempItem = $_tempItem.$_temSub;
                        }
                        continue;
                    }
                    $_tempItem = (!empty($_tempItem)) ? '<ul class="item">'.$_tempItem.'</ul>':'';
                    $_itemMain = $_itemMain .$_tempItem.'</li>';
                }
                continue;
            }
            return $_itemMain;
        }
    }

}

    if (!function_exists('frontend_menu_getdata')) {

        function frontend_menu_getdata($table = 'article_category') {
            $CI = & get_instance();
            $_lang = $CI->session->userdata('_lang');
            $menu = $CI->db->select('id, title, alias, route, parentid')->where(array('publish' => 1, 'lang' => $_lang))->from($table)->order_by('orders asc, id asc')->get()->result_array();
            return $menu;
        }

    }
    //Phương thức tạo link bên ngoài frontend-CLIP 24
    if (!function_exists('frontend_menu_link')){
        function frontend_menu_link($route, $alias, $id, $module){
            if(!empty($route)) return $route.CMS_URL_SUFFIX;
            else return $alias.'-'.$module.$id.CMS_URL_SUFFIX;
        }
    }

    //Phương thức tạo breadcrumb hỗ trợ seo CLIP 24
    if (!function_exists('frontend_breadcrumb')){
    	function frontend_breadcrumb($table = '', $param = NULL, $type = 'category'){
    		$CI = & get_instance();
    		$breadcrumb = '';
    		
    		$category = $CI->db->select('id, title, route, alias')->where($param)->from($table)->order_by("lft", "asc")->get()->result_array();
    		$breadcrumb = '<ul class = "breadcrum">';
    		$breadcrumb = $breadcrumb.'<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="." rel="nofolow" title="Trang chủ" itemprop="url"><span itemprop = "title">Trang chủ</span></a></li>';
    		if(isset($category) && count($category)){
    			$total = count($category);
    			foreach ($category as $key => $val){
    				$breadcrumb = $breadcrumb.'<li class="spacebar">&raquo</li>';
    				if($type = 'category') $h = $total - $key;
    				else if($type = 'item') $h = ($total - $key + 1);
    				$h = ($h > 6) ? '6' : $h;
    				$breadcrumb = $breadcrumb.
    				'<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><h'.$h.'><a href="'.frontend_menu_link($val['route'], $val['alias'], $val['id'], '68').'" rel="nofolow" title="'.htmlspecialchars($val['title']).'" itemprop="url"><span itemprop = "title">'.$val['title'].'</span></a></h'.$h.'></li>';
    				
    			}
    		}
    		$breadcrumb = $breadcrumb.'</ul>';
    		return $breadcrumb;
    	}
    }
    
?>