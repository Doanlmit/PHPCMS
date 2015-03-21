<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_frontend
{
    private $CI;
    public function __construct() {
        $this->CI = & get_instance();
    }
    public function lang_frontend($lang){
    	if(!empty($lang) && in_array($lang, array('jp', 'en', 'vi'))){
    		$this->CI->session->set_userdata('_lang', $lang);
    	}else{
    		$this->CI->my_string->php_redirect(CMS_BASE_URL);
    	}
    	$_lang = $this->CI->session->userdata('_lang');
    	$this->CI->lang->load('frontend', $_lang);
    }
    //Clip 25
    public function canonical($route, $alias, $id, $module, $suffig = TRUE) {
        if ($suffig == TRUE) {
            if (!empty($route))
                return CMS_BASE_URL . $route . CMS_URL_SUFFIX;
            else
                return CMS_BASE_URL . $alias . '-' . $module . $id . CMS_URL_SUFFIX;
        }
        else {
            if (!empty($route))
                return CMS_BASE_URL . $route;
            else
                return CMS_BASE_URL . $alias . '-' . $module . $id;
        }
    }

    //Phương thức sử lý việc phân trang ở frontend
    public function pagination() {
    	$param['base_url'] = ''; // The page we are linking to
    	$param['prefix'] = ''; // A custom prefix added to the path.
    	$param['suffix'] = CMS_URL_SUFFIX; // A custom suffix added to the path.
    	$param['total_rows'] = 0; // Total number of items (database results)
    	$param['per_page'] = 1; // Max number of items you want shown per page
    	$param['num_links'] = 3; // Number of "digit" links to show before/after the currently viewed page
    	$param['cur_page'] = 0; // The current page being viewed
    	$param['use_page_numbers'] = TRUE; // Use page number for segment instead of offset
    	$param['first_link'] = 'Trang đầu';
    	$param['next_link'] = 'Tiếp tục';
    	$param['prev_link'] = 'Lùi lại';
    	$param['last_link'] = 'Trang cuối';
    	$param['uri_segment'] = 1;
    	$param['full_tag_open'] = '<ul>';
    	$param['full_tag_close'] = '</ul>';
    	$param['first_tag_open'] = '<li>';
    	$param['first_tag_close'] = '</li>';
    	$param['last_tag_open'] = '<li>';
    	$param['last_tag_close'] = '</li>';
    	$param['first_url'] = ''; // Alternative URL for the First Page.
    	$param['cur_tag_open'] = '<li class="active">';
    	$param['cur_tag_close'] = '</li>';
    	$param['next_tag_open'] = '<li>';
    	$param['next_tag_close'] = '</li>';
    	$param['prev_tag_open'] = '<li>';
    	$param['prev_tag_close'] = '</li>';
    	$param['num_tag_open'] = '<li>';
    	$param['num_tag_close'] = '</li>';
        $param['current_page'] = FALSE;
        $param['bar'] = FALSE;
        return $param;
    }
    
}

