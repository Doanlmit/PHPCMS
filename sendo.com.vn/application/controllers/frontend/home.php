<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class Home extends My_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    //Code Root của bạn Hải
    public function index($lang = 'vi') {
        if($lang =='vi'){ $this->session->userdata('_lang', 'vi');}
        else if (!empty($lang) && in_array($lang, array('jp', 'en'))) {$this->session->set_userdata('_lang', $lang);
        }
        $_lang = $this->session->userdata('_lang');
        $this->lang->load('frontend', $_lang);
        $data['title'] = $this->db->select('id, title, highlight, orders')->from('article_item')->where(array('lang'=>$_lang, 'highlight'=>1, 'publish'=>1))->order_by('orders desc, id desc')->get()->result_array();
        $data['template'] = 'frontend/home/index';
        $this->load->view('frontend/layout/home', isset($data) ? $data : NULL);
    }
    //Code sau khi sửa của -----LMD------
    public function lang($lang) {
    	//Thay đổi ngôn ngữ được viết trong Lib
        $this->my_frontend->lang_frontend($lang);
        $data['template'] = 'frontend/home/index';
        $this->load->view('frontend/layout/home', isset($data) ? $data : NULL);
    }
}
