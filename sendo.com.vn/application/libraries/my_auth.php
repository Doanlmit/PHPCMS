<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_auth
{
    private $CI;
    public function __construct() {
        $this->CI = & get_instance();
    }
    public function check() {
        if (isset($_COOKIE[CMS_PREFIX . '_user_logged']) && !empty($_COOKIE[CMS_PREFIX . '_user_logged'])) {
            $cookie = $_COOKIE[CMS_PREFIX . '_user_logged'];
            $_cookie = $cookie;
            $cookie = json_decode($this->CI->my_string->decode_cookie($cookie), TRUE);
            $user = $this->CI->db->select('id, username, password, salt, email, fullname, groupid')->where(array('username' => $cookie['username']))->from('user')->get()->row_array();
            //Sua o gan cuoi clip 14 $group = $this->CI->db->select('title, allow, groups')->where(array('id' => $user['groupid']))->from('user_group')->get()->row_array();
            //Kiểm tra xem username có tồn tại không
            //$group = $this->CI->my_string->trim_array(explode("\n", $group['groups']));
            //print_r($group);
            if (isset($user) && count($user)) {
                //Sau đó thì so cookie với dữ liệu trong database và tiến hành cập nhật lại cookie
                $group = $this->CI->db->select('title, allow, groups')->where(array('id' => $user['groupid']))->from('user_group')->get()->row_array();
		if ($cookie['username'] == $user['username'] && $cookie['password'] == $user['password'] && $cookie['salt'] == $user['salt']) {
                    /*
                    setcookie(CMS_PREFIX . '_user_logged', $this->CI->my_string->encode_cookie(json_encode(array(
                                                                                                                'username' => $user['username'], 
                                                                                                                'password' => $user['password'],
                                                                                                                'salt' => $user['salt']))), 
                                                                                                            time() + 7 * 24 * 3600, '/');
                    */
                    setcookie(CMS_PREFIX . '_user_logged', $_cookie, time() + 7 * 24 * 3600, '/');
                    //Ma hoa folder trong tinyMCY
                    setcookie(CMS_PREFIX . '_folder', $this->CI->my_string->encode_folder($user['username']), time() + 7 * 24 * 3600, '/');
                    //code cũ
                    /*
                    return array(
                                    'id' => $user['id'],
                                    'username' => $user['username'],
                                    'email' => $user['email'],
                                    'fullname' => $user['fullname'],
                                    'group_title' => $group['title'],
                                    'group_allow' => $group['allow'],
                                    'group_content' => $this->CI->my_string->trim_array(explode("\n", $group['groups']))
                                );
                     */                     
                    //code mới
                    return array(
                                    'id' => $user['id'],
                                    'username' => $user['username'],
                                    'email' => $user['email'],
                                    'fullname' => $user['fullname'],
                                    'group_title' => !empty($group['title']) ? $group['title'] : '',
                                    'group_allow' => !empty($group['allow']) ? $group['allow'] : '',
                                    'group_content' => $this->CI->my_string->trim_array(explode("\n", !empty($group['groups']) ? $group['groups']:''))
                                );
                }
            }
        }
        return NULL;
    }
    
    //Cuoi Clip 12 Phương thức phân quyền người dùng cho user phép qua
    public function allow($auth, $url) {
        
        //cho phép
        if ($auth['group_allow'] == 1) {
            if (!isset($auth['group_content']) && count($auth['group_content']) == 0) {
                $this->CI->my_string->js_redirect('Bạn không đủ quyền truy cập', CMS_BASE_URL . 'backend/home/index');
            }
            if (in_array($url, $auth['group_content']) == FALSE) {
                $this->CI->my_string->js_redirect('Bạn không đủ quyền truy cập', CMS_BASE_URL . 'backend/home/index');
            }
        }
        
        //Không cho phép
        else if ($auth['group_allow'] == 0) {
            if (isset($auth['group_content']) && count($auth['group_content']) && $auth['group_allow'] == 0) {
                if (in_array($url, $auth['group_content']) == TRUE) {
                    $this->CI->my_string->js_redirect('Bạn không đủ quyền truy cập', CMS_BASE_URL . 'backend/home/index');
                }
            }
        }
    }
    //Phương thức tạo nhật ký truy cập của website
    public function logs($param){
        if(isset($param) && count($param) >= 7){
            $this->CI->db->insert('logs',  $param);
        }
    }
}

