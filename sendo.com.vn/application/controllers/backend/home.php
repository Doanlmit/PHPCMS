<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends My_Controller {
    private $auth;
    public function __construct() {
        parent::__construct();
        $this->auth = $this->my_auth->check();
    }
    //Kiểm tra username và password để đăng nhập vào hệ thống
    public function index() {
        if ($this->auth == NULL) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/auth/login');
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/home/index';
        $this->load->view('backend/layout/home', isset($data) ? $data : NULL);
        //echo 'Hellow World! <a href="'.CMS_BASE_URL.'backend/auth/logout">Đăng xuất</a>';
    }
    public function lang($lang) {
        $continue = $this->input->get('continue');
        if(!empty($lang) && in_array($lang, array('jp', 'en', 'vi'))){
            $this->session->set_userdata('_lang', $lang);
            $this->my_string->js_redirect('Chuyển đổi ngôn ngữ thành công!', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL.'backend/home/index');
        }
        else {
            $this->my_string->js_redirect('Không tồn tại ngôn ngữ!', CMS_BASE_URL . 'backend/home/index');
        
        }
    }
   
}
