<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Config extends My_Controller {

    private $auth;

    public function __construct() {
        parent::__construct();
        $this->auth = $this->my_auth->check();
        if ($this->auth == NULL) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/home/index');
        $this->my_auth->allow($this->auth, 'backend/config');
        $_lang = $this->session->userdata('_lang');
    }
    //Phương thức sử lý việc cấu hình hệ thống:
    public function index($group = 'frontend') {
        $this->my_auth->allow($this->auth, 'backend/config/index');
        $_lang = $this->session->userdata('_lang');
        $config = $this->db->select('label, keyword, value_'.$_lang.', type')->where(array('groups' => $group, 'publish' => 1))->from('config')->get()->result_array();
        if (!isset($config) || count($config) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/home/index');
        $data['seo']['title'] = 'Thay đổi cấu hình';
        $_allow_post = NULL;
        foreach ($config as $keyConfig => $valConfig) {
            $_allow_post[] = $valConfig['keyword'];
        }
        if ($this->input->post('change')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $_post = $this->my_string->allows_post($_post, $_allow_post); //cho phép keyword qua
            foreach ($_post as $keyPost => $valPost) {
                $_data[] = array(
                    'keyword' => $keyPost,
                    'value_'.$_lang => $valPost,
                    'updated' => gmdate('Y-m-d H:i:s' + time() + 7 * 3600)
                );
            }
            $this->db->update_batch('config', $_data, 'keyword');
            $this->my_string->js_redirect('Cấu hình hệ thống thành công', CMS_BASE_URL . 'backend/config/index');
        }
        $data['data']['auth'] = $this->auth;
        $data['data']['_config'] = $config;
        $data['data']['_group'] = $group;
        $data['template'] = 'backend/config/index';
        $this->load->view('backend/layout/home', isset($data) ? $data : NULL);
    }

    //dongvudaoly
}
