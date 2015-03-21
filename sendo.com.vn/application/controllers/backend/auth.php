<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends My_Controller {

    private $auth;

    public function __construct() {
        parent::__construct();
        $this->auth = $this->my_auth->check();
    }
	
    //Phương thức làm nhiệm vụ đăng xuất khỏi hệ thống
    public function logout() {
        if ($this->auth == NULL) $this->my_string->php_redirect(CMS_BASE_URL . 'backend');
        setcookie(CMS_PREFIX . '_user_logged', NULL, time() - 3600, '/');
        setcookie(CMS_PREFIX . '_folder', NULL, time() - 3600, '/');
        $this->my_string->js_redirect('Logout hệ thống thành công', CMS_BASE_URL . 'backend');
    }
    public function login() {
        if ($this->auth != NULL) $this->my_string->php_redirect(CMS_BASE_URL .'backend/home/index');
        $data['seo']['title'] = 'Đăng nhập hệ thống';
        $data['seo']['keywords'] = 'Thị nở, Vịt béo';
        $data['seo']['desciption'] = 'Gấu nhỏ yêu thương';
        if ($this->input->post('login')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[username]', 'Tên sử dụng', 'trim|required|min_length[3]|max_length[20]|regex_match[/^([a-z0-9])+$/i]|callback__username');
            $this->form_validation->set_rules('data[password]', 'Mật khẩu', 'trim|required|callback__password[' . $_post['username'] . ']');
            if ($this->form_validation->run() == TRUE) {
                $user = $this->db->select('username, password, salt')->where(array('username' => $_post['username']))->from('user')->get()->row_array();
                setcookie(CMS_PREFIX . '_user_logged', $this->my_string->encode_cookie(json_encode($user)), time() + 7 * 24 * 3600, '/');
                $this->db->where(array('username' => $_post['username']))->update('user', array('logined' => gmdate('Y-m-d H:i:s' + time() + 7 * 3600), 'ip_logging' => $_SERVER['SERVER_ADDR']));
                $this->my_string->js_redirect('Đăng nhập hệ thống thành công', CMS_BASE_URL . 'backend/auth/login');
            }
        }
        $data['template'] = 'backend/auth/login';
        $this->load->view('backend/layout/login', isset($data) ? $data : NULL);
    }

    //Phương thức kiểm tra username có hợp lệ không thông qua callback__username 
    public function _username($username) {
        $count = $this->db->where(array('username' => $username))->from('user')->count_all_results();
        if ($count == 0) {
            $this->form_validation->set_message('_username', '%s không tồn tại');
            return FALSE;
        }
        return TRUE;
    }

    //Phương thức kiểm tra password có hợp lệ không thông qua callback__password
    public function _password($password, $username) {
        if ($this->_username($username)) {
            $user = $this->db->select('username, password, salt, groupid')->where(array('username' => $username))->from('user')->get()->row_array();
            $password = $this->my_string->encode_password($user['username'], $password, $user['salt']);
            if ($password != $user['password']) {
                $this->form_validation->set_message('_password', '%s không hợp lệ');
                return FALSE;
            }
            $group = $this->db->select('title, allow, groups')->where(array('id' => $user['groupid']))->from('user_group')->get()->row_array();
            //echo ($group['groups']); 
            //code mới
            $_group = array(
                    'group_title' => !empty($group['title']) ? $group['title']:'',
                    'group_allow' => !empty($group['allow']) ? $group['allow']:'',
                    'group_content' => $this->my_string->trim_array(explode("\n", !empty($group['groups']) ? $group['groups'] : '')),
                );
//code cũ
//            $_group = array(
//                    'group_title' => $group['title'],
//                    'group_allow' => $group['allow'],
//                    'group_content' => $this->my_string->trim_array(explode("\n", $group['groups']))
//            );
            $this->my_auth->allow($_group, 'backend/auth/login');
            return TRUE;
        }
    }

    //Phương thức kiểm tra email có hợp lệ không
    public function _email($email) {
        $count = $this->db->where(array('email' => $email))->from('user')->count_all_results();
        if ($count == 0) {
            $this->form_validation->set_message('_email', '%s không tồn tại');
            return FALSE;
        }
        return TRUE;
    }

    //Phương thức để sử lý khi người dùng quên mật khẩu
    public function forgot() {
        $data['seo']['title'] = 'Quên thông tin tài khoản';
        if ($this->input->post('forgot')) {
            $_post = $this->input->post('data');
            $data['data']['$_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[email]', 'email', 'trim|required|valid_email|callback__email');
            if ($this->form_validation->run() == TRUE) {
                $_code = $this->my_string->ramdom(69, TRUE);
                $_post = $this->my_string->allows_post($_post, array('email'));
                $this->db->where(array('email' => $_post['email']))->
                update('user',
                                array(
                                    'forgot_time_expired' => time() + 3600, 
                                    'forgot_code' => $_code,
                                    )
                        );
                    require_once('Mail.php'); 
                    error_reporting(0);
                    $from = 'Doan <Doanlmit@gmail.com>';
                    $to = $_post['email'];
                    $subject = 'Admin Harvey Nash';
                    $body = 'Mã xác nhận quên thông tin tài khoản cho Email '.''.$_post['email'];
                    $body .= 'Click vào link bên dưới để nhận lại mật khẩu mới:'.CMS_BASE_URL.'backend/auth/reset?email='.urlencode($_post['email']).'&code='.urlencode($_code);
                    $host = 'smtp.gmail.com';
                    $username = 'doanlmit@gmail.com';
                    $password = 'luongmanhdoan1711';
                    $headers = array ('From' => $from, 'To' => $to, 'Subject' => $subject, 'message'=> $message);
                    $smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => true, 'username' => $username, 'password' => $password));
                    $mail = $smtp->send($to, $headers, $body);
                /*Cách 1 - dùng send maill of ci
                 $this->my_common->send_mail_stand(
                                            array(
                                                'name' => 'CMS CMS',
                                                'from' => 'Doanlmit@gmail.com',
                                                'password'=>'luongmanhdoan1711',
                                                'to' => $_post['email'],
                                                'subject' => 'Mã xác nhận quên thông tin tài khoản cho Email'.$_post['email'],
                                                'message' => 'Click vào link bên dưới để nhận lại mật khẩu mới:'.CMS_BASE_URL.'backend/auth/reset?email='.urlencode($_post['email']).'&code='.urlencode($_code)
                                                )
                                            );
                */                            
                $this->my_string->js_redirect("Gửi mã xác nhận vào Mail thành công", CMS_BASE_URL . 'backend');
            }
        }
        $data['template'] = 'backend/auth/forgot';
        $this->load->view('backend/layout/login', isset($data) ? $data : NULL);
    }
    public function reset() {
        if ($this->auth != NULL) $this->my_string->php_redirect(CMS_BASE_URL . 'backend');
        $email = $this->input->get('email');
        $code = $this->input->get('code');
        if(isset($email) && !empty($email) && isset($code) && !empty($code)){
            $_password = '';
            $user = $this->db->select('username, forgot_code, forgot_time_expired')->where(array('email' => $email,'forgot_code' => $code))->from('user')->get()->row_array();
                if(!isset($user) || count($user)==0) $this->my_string->js_redirect('Mã xác nhận hoặc email không hợp lệ', CMS_BASE_URL.'backend');
                if($user['forgot_time_expired'] <= time()) $this->my_string->js_redirect("Mã xác nhận đã hết hạn!", CMS_BASE_URL . 'backend');
                    $_post['password'] = $this->my_string->ramdom(5, TRUE);
                    $_password = $_post['password'];
                    $_post['salt'] = $this->my_string->ramdom(69, TRUE);
                    $_post['password'] = $this->my_string->encode_password($user['username'], $_post['password'], $_post['salt']);
                    $_post['forgot_code'] = '';
                    $_post['forgot_time_expired'] = '';
                    $this->db->where(array('username' => $user['username']))->update('user',$_post);
                    require_once('Mail.php'); 
                    error_reporting(0);
                    $from = 'Doan <Doanlmit@gmail.com>';
                    $to = $email;
                    $subject = 'Admin Harvey Nash';
                    $body = 'Tài khoản mới: '.$user['username'].''.'Mật khẩu mới: '.$_password.' Sau khi đăng nhập bạn nên đổi mật khẩu!';
                    $host = 'smtp.gmail.com';
                    $username = 'doanlmit@gmail.com';
                    $password = 'luongmanhdoan1711';
                    $headers = array ('From' => $from, 'To' => $to, 'Subject' => $subject, 'message'=> $message);
                    $smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => true, 'username' => $username, 'password' => $password));
                    $mail = $smtp->send($to, $headers, $body);
                    $this->my_string->js_redirect("Gửi tài khoản và mật khẩu vào Mail thành công!", CMS_BASE_URL . 'backend');
            }
            else{
                $this->my_string->js_redirect('Mã xác nhận hoặc email không hợp lệ', CMS_BASE_URL.'backend');

            }
        // $data['template'] = 'backend/auth/reset';
        // $this->load->view('backend/layout/login', isset($data) ? $data : NULL);
    }

    //Phương thức tạo tài khoản cho người quản trị hệ thống 
    public function create_manage() {
        //Code đếm số tài khoản trong bảng user nếu đã có rồi thì chuyển về login 
        $count = $this->db->from('user')->count_all_results();
        if ($count >= 1) {
            $this->my_string->php_redirect(CMS_BASE_URL . 'backend/auth/login');
        }
        $data['seo']['title'] = 'Tạo tài khoản quản trị';
        if ($this->input->post('create')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[username]', 'Tên sử dụng', 'trim|required|min_length[3]|max_length[20]|regex_match[/^([a-z0-9])+$/i]');
            $this->form_validation->set_rules('data[password]', 'Mật khẩu', 'trim|required');
            $this->form_validation->set_rules('data[email]', 'Email', 'trim|required|valid_email');
            if ($this->form_validation->run() == TRUE) {
                $_post = $this->my_string->allows_post($_post, array('username', 'password', 'email'));
                $_post['salt'] = $this->my_string->ramdom(69, TRUE);
                $_post['password'] = $this->my_string->encode_password($_post['username'], $_post['password'], $_post['salt']);
                $_post['created'] = time() + 7 * 3600;
                $this->db->insert('user', $_post);
                $this->my_string->js_redirect('Tạo tài khoản quản trị thành công!', CMS_BASE_URL . 'backend/auth/login');
            }
        }
        $data['template'] = 'backend/auth/create_manage';
        $this->load->view('backend/layout/login', isset($data) ? $data : NULL);
    }

}
