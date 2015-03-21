<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class My_Controller extends CI_Controller {
    
    public $_config;
    public function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Saigon');
        //Language
        $_lang = $this->session->userdata('_lang');
        if(!isset($_lang) || empty($_lang)) {$this->session->set_userdata('_lang', 'vi');}
        


        //Config
        $_data = $this->db->select('keyword, value_vi')->where(array('publish' => 1))->from('config')->get()->result_array();
        foreach ($_data as $key => $val) {
            $this->_config[$val['keyword']] = $val['value_vi'];
        }
        
    }
}
?>