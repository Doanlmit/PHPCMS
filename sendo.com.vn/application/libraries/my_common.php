<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_common {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }
    //Phương thức này dùng cũng đươc mà ở đây dung trực tiếp dùng trực tiếp
    public function send_mail_chuan(){
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
                    if (PEAR::isError($mail)){
                      echo("<p>" . $mail->getMessage() . "</p>");
                     }else{
                        echo("<p>Message successfully sent!</p>");
                     }
    }
    //Phương thức sử lý việc gửi mail reset tài khoản
    public function send_mail($param = array()) {
        //send mail
        $config = Array(
        // 'protocol' => 'smtp',
        // 'smtp_host' => 'ssl://smtp.googlemail.com',
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => $param['from'], 
        'smtp_pass' => $param['to'], 
        'charset' => 'utf-8',
        'newline' => "\r\n",
        'mailtype' => 'html'
        );
        $this->CI->load->library('email', $config);
        $this->CI->email->from($param['from'], $param['name']);
        $this->CI->email->set_newline("\r\n");
        $this->CI->email->to($param['to']);
        $this->CI->email->subject($param['subject']);
        $this->CI->email->message($param['message']);
        $email = $this->CI->email->send();
        if (isset($email)){
       
    } else {
        echo 'email khong gui duoc';
    }
 }

    //Phương thức sử lý việc phân trang ở backend
    public function backend_pagination() {
        $param['base_url'] = ''; // The page we are linking to
    	$param['prefix'] = ''; // A custom prefix added to the path.
    	$param['suffix'] = ''; // A custom suffix added to the path.
    	$param['total_rows'] = 0; // Total number of items (database results)
    	$param['per_page'] = 4; // Max number of items you want shown per page
    	$param['num_links'] = 3; // Number of "digit" links to show before/after the currently viewed page
    	$param['cur_page'] = 0; // The current page being viewed
    	$param['use_page_numbers'] = TRUE; // Use page number for segment instead of offset
    	$param['first_link'] = 'Trang đầu';
    	$param['next_link'] = 'Tiếp tục';
    	$param['prev_link'] = 'Lùi lại';
    	$param['last_link'] = 'Trang cuối';
    	$param['uri_segment'] = 0;
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
        return $param;
    }
    
    public function sort_orderby($field, $value) {
        return (isset($field) && !empty($field) && isset($value) && !empty($value)) ? array(
            'field' => $field,
            'value' => $value
        ):array('field' => 'id',
                'value' => 'desc'
                );
    }

}
