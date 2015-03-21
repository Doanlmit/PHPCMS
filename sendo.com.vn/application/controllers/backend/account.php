<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Account extends My_Controller {
    private $auth;
    public function __construct() {
        parent::__construct();
        $this->auth = $this->my_auth->check();
        if ($this->auth == NULL) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/home/index');
        $this->my_auth->allow($this->auth, 'backend/account');
    }
    //phương thức sử lý thông tin các user trong hệ thống
    public function info() {
        $this->my_auth->allow($this->auth, 'backend/account/info');
        $user = $this->db->where(array('username' => $this->auth['username']))->from('user')->get()->row_array();
        if (!isset($user) || count($user) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/home/index');
        $data['seo']['title'] = 'Thay đổi thông tin tài khoản';
        $_post = $user;
        if ($this->input->post('change')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[email]', 'email', 'trim|required|valid_email|callback__email');
            if ($this->form_validation->run() == TRUE) {
                $_post = $this->my_string->allows_post($_post, array('email', 'fullname', 'google_author'));
                $_post['updated'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                $this->db->where(array('username' => $user['username']))->update('user', $_post);
                $this->my_string->js_redirect('Thay đổi thông tin tài khoản thành công', CMS_BASE_URL . 'backend/auth/login');
            }
        }
        $data['data']['_post'] = $_post;
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/account/info';
        $this->load->view('backend/layout/home', isset($data) ? $data : NULL);
    }
	//Callback kiêm tra email đã tồn tại trong csdl hay chứa 
    public function _email($email) {
        $count = $this->db->where(array('email' => $email, 'email !=' => $this->auth['email']))->from('user')->count_all_results();
        if ($count > 0) {
            $this->form_validation->set_message('_email', 'Email ' . $email . ' đã tồn tại');
            return FALSE;
        }
        return TRUE;
    }

    public function password() {
        $this->my_auth->allow($this->auth, 'backend/account/password');
        $user = $this->db->where(array('username' => $this->auth['username']))->from('user')->get()->row_array();
        if (!isset($user) || count($user) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/home/index');
        $data['seo']['title'] = 'Thay đổi mật khẩu';
        if ($this->input->post('change')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[oldpassword]', 'Mật khẩu cũ ', 'trim|required|callback__oldpassword');
            $this->form_validation->set_rules('data[newpassword]', 'Mật khẩu mới', 'trim|required');
            $this->form_validation->set_rules('data[repassword]', 'Xác nhận mật khẩu mới', 'trim|required|matches[data[newpassword]]');
            if ($this->form_validation->run() == TRUE) {
                $_temp = $_post;unset($_post);//hàm này sẽ remove các old, new mà biến $_post mang theo;
                $_post['password'] = $_temp['newpassword'];
                $_post['salt'] = $this->my_string->ramdom(69, TRUE);
                $_post['password'] = $this->my_string->encode_password($user['username'], $_post['password'], $_post['salt']);
                $_post['updated'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                $this->db->where(array('username' => $user['username']))->update('user', $_post);
				 $this->my_string->js_redirect('Thay đổi mật khẩu hệ thống thành công', CMS_BASE_URL . 'backend/auth/login');
            
			}
        }
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/account/password';
        $this->load->view('backend/layout/home', isset($data) ? $data : NULL);
    }

    public function _oldpassword($oldpassword) {
        $user = $this->db->from('user')->where(array('id' => $this->auth['id']))->get()->row_array();
        $password = $this->my_string->encode_password($user['username'], $oldpassword, $user['salt']);
        if ($password != $user['password']) {
            $this->form_validation->set_message('_oldpassword', '%s không hợp lệ');
            return FALSE;
        }
        return TRUE;
    }
        //phương thức sử lý thông tin các user trong hệ thống
    public function current() {
        $this->my_auth->allow($this->auth, 'backend/account/current');
        echo$this->auth['username'];
    }
	//dongvudaoly
}






