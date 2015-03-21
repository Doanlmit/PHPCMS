<?php 
    if (!function_exists('common_valuepost')) {

        function common_valuepost($value) {
            return !empty($value) ? htmlspecialchars($value) : '';
        }

    }
    //Cuoi clip 16
    if (!function_exists('common_fullurl')) {

        function common_fullurl() {
            return ('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']).((!empty($_SERVER['QUERY_STRING'])) ? ('?'.$_SERVER['QUERY_STRING']):'');
        }
    }

    if (!function_exists('common_showerror')) {

        function common_showerror($error) {
            return (isset($error) && !empty($error)) ? '<ul class="error">' . $error . '</ul>' : '';
        }

    }
    if (!function_exists('get_user')) {

        function get_user($id, $select) {
            $CI = & get_instance();
            $user = $CI->db->select($select)->where(array('id' => $id))->from('user')->get()->row_array();
            if (isset($user) && count($user)) {
                return $user;
            } else {
                return NULL;
            }
        }

    }
    //Clip 17
    //Lấy ra danh mục(category) hiển thị trong bài viết(item)
    if (!function_exists('get_category')) {

        function get_category($table, $select, $param) {
            $CI = & get_instance();
            $category = $CI->db->select($select)->where($param)->from($table)->get()->row_array();
            if (isset($category) && count($category)) {
                return $category;
            } else {
                return NULL;
            }
        }

    }
    //Clip 17 - Phương thức hiển thị số bài viết(item) trong danh mục(category)
    if (!function_exists('get_count_item')) {

        function get_count_item($table, $param) {
             $CI = & get_instance();
            $count = $CI->db->where($param)->from($table)->count_all_results();
            return $count;
        }

    }
    if (!function_exists('get_count_user_group')) {

        function get_count_user_group($param) {
            $CI = & get_instance();
            $count = $CI->db->where($param)->from('user')->count_all_results();
            if (isset($count) && count($count)) {
                return $count;
            } else {
                return NULL;
            }
        }

    }
    if (!function_exists('get_count_post')) {

            function get_count_post($table, $select, $param) {
                $CI = & get_instance();
                $count = $CI->db->select($select)->where($param)->from($table)->count_all_results();
                if (isset($count) && count($count)) {
                    return $count;
                } else {
                    return NULL;
                }
            }

        }
    if (!function_exists('get_link_sort')) {
        function get_link_sort($param) {
            $str = '';
            $status = 0;
            if (isset($param) && count($param)) {
                if($param['field'] == $param['sort_field']){
                   //$param['sort_value'] = ($param['sort_value'] == 'asc') ? 'desc':'asc'; 
                    $param['sort_value'] = ($param['sort_value'] == 'desc') ? 'asc':'desc'; 
                     $status = 1;
                }else{
                    $param['sort_field'] = $param['field'];
                    $param['sort_value'] = 'asc';
                }
                foreach ($param as $key => $val) {
                    if ($key == 'base_url') {
                        $str = $val;  
                    }else if($key == 'page'){
                        //$str =  $str.'/'.$val.'?';  
                        $str = $str.(($val > 1)?('/'.$val):'').'?';
                    }
                    else if(in_array($key, array('field','title'))){
                        continue;
                    } else{
                        $str = $str.$key.'='.$val.'&';
                    }
                }
            }
            return '<a class="a-color" href="'.substr($str, 0, -1).'">'.$param['title'].(($status==1)?'<img title="'.$param['field'].' '.$param['sort_value'].'" src="public/template/backend/images/'.$param['sort_value'].'.png"/>':'').'</a>';
         }
    }
    
    //Cuoi Clip 22
    if (!function_exists('get_allow')) {

        function get_allow($auth, $url) {
            $CI = & get_instance();
            //cho phép
            if ($auth['group_allow'] == 1) {
                if (!isset($auth['group_content']) && count($auth['group_content']) == 0) {
                    $this->CI->my_string->js_redirect('Không đủ quyền truy cập!', ITQ_BASE_URL . 'backend/home/index');
                }
                if (in_array($url, $auth['group_content']) == FALSE) {
                    $this->CI->my_string->js_redirect('Không đủ quyền truy cập!', ITQ_BASE_URL . 'backend/home/index');
                }
            }

            //Không cho phép
            else if ($auth['group_allow'] == 0) {
                if (isset($auth['group_content']) && count($auth['group_content']) && $auth['group_allow'] == 0) {
                    if (in_array($url, $auth['group_content']) == TRUE) {
                        $this->CI->my_string->js_redirect('Không đủ quyền truy cập!', ITQ_BASE_URL . 'backend/home/index');
                    }
                }
            }
        }
    }
    //Phương thức dùng để cắt các ký tự
    if (!function_exists('cutnchar')) {
    	function cutnchar($str = NULL, $n = 0) {
    		if(strlen($str) < $n) return $str;
    		$html = substr($str, 0, $n);
    		$html = substr($html,0,(strrpos($html, ' ')));
    		return $html.'...';
    	}
    }
    
    //Check menu trong module menu
    if(!function_exists('check_menu')){
    	function check_menu($module, $module_id) {
    		if(!empty($module) && $module_id > 0){
    			$CI = & get_instance();
    			$count = $CI->db->where(array('module' => $module, 'module_id' => $module_id, 'publish'=>1))->from('menu')->count_all_results();
    			return (($count > 0) ? 'check' : 'uncheck');
    		}
    		
    		return 'uncheck';
    	}
    }
?>