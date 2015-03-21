<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_string {

    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    //Phương thức lấy ngẫu nhiên các ký tự
    public function ramdom($leng = 10, $char = FALSE) {
        if ($char == FALSE)
            $s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()';
        else
            $s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        mt_srand((double) microtime() * 1000000);
        $salt = '';
        for ($i = 0; $i < $leng; $i++) {
            $salt = $salt . substr($s, (mt_rand() % (strlen($s))), 1);
        }
        return $salt;
    }

    //Phương thức mã hóa md5
    public function encode_password($username, $password = '', $salt = '') {
        return md5($salt . $username . md5($username . $salt . md5($password) . $username . $salt) . $salt);
    }

    //Phương thức mã hóa cookie for username
    public function encode_cookie($cookie) {
        return $this->ramdom(10) . base64_encode($cookie);
    }
    //Phương thức mã hóa cookie for foldername
    public function encode_folder($cookie){
        return $this->ramdom(10) . base64_encode($cookie);
    }
    //Phương thức giải mã cookie for foldername - clip 13 
    public function decode_folder($cookie){
        return base64_decode(substr($cookie, 10));
    }
    //Phương thức giải mã cookie for username
    public function decode_cookie($cookie) {
        return base64_decode(substr($cookie, 10));
    }

    //Phương thức cho phép dữ liệu đi qua 
    public function allows_post($param, $allow) {
        $_temp = null;
        if (isset($param) && count($param) && isset($allow) && count($allow)) {
            foreach ($param as $key => $val) {
                if (in_array($key, $allow) == TRUE) {
                    $_temp[$key] = trim($val);
                }
            }
            return $_temp;
        }
        return $param;
    }
    //Phương tự thức chuyển trang bằng cách truyền vào URL 
    public function php_redirect($url) {
        header('Location: ' . $url);
        die();
    }
    //Phương thức hỏi bạn có muốn chuyển trang không sử dụng javascipt 
    public function js_redirect($alert, $url) {
        die('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script type="text/javascript">alert(\'' . $alert . '\');location.href = \'' . $url . '\';</script>');
    }
    //Phương thức load trang hiện tại sử dụng localtion.load()-clip 12
    public function js_reload($alert) {
            die('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><script type="text/javascript">alert(\'' . $alert . '\');location.reload();</script>');
    }
    public function trim_array($arr){
        $_arr=null;
        if(isset($arr) && count($arr)){
            foreach ($arr as $key => $val) {
                $val = trim($val);
                if(empty($val)) continue;
                $_arr[] = $val;
            }
        }
        return $_arr;
    }
    public function utf8convert($str = NULL){
        $chars = array(
            'a' => array('á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ'),
            'd' => array('đ|Đ'),
            'e' => array('é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ'),
            'i' => array('í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị'),
            'o' => array('ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ'),
            'u' => array('ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự'),
            'y' => array('ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ'),
        );
        foreach ($chars as $key => $arr){
            foreach ($arr as $val){
                $str = str_replace($val, $key, $arr);
            }
        }
        return $str;
    }
    public function alias($str = NULL) {
        $str = $this->utf8convert($str);
        $str = preg_replace('/[^a-zA-Z0-9-]/i', '', $str);
        $str = str_replace(array(
            '--------------------',
            '-------------------',
            '------------------',
            '-----------------',
            '----------------',
            '---------------',
            '--------------',
            '-------------',
            '------------',
            '-----------',
            '----------',
            '---------',
            '--------',
            '-------',
            '------',
            '-----',
            '----',
            '---',
            '--',
                ), 
            '-', 
            $str
        );
        $str = str_replace(array(
            '--------------------',
            '-------------------',
            '------------------',
            '-----------------',
            '----------------',
            '---------------',
            '--------------',
            '-------------',
            '------------',
            '-----------',
            '----------',
            '---------',
            '--------',
            '-------',
            '------',
            '-----',
            '----',
            '---',
            '--',
            ),
            '-', 
            $str
        );
       
        if (!empty($str)) {
            if ($str[count($str) - 1] == '-') {
                $str = substr($str, 0, -1);
            }
            if ($str[0] == '-') {
                $str = substr($str, 1);
            }
        }
        //= strtolower($str);
        return strtolower($str);
    }
    function utf8_convert($str) {
        if (!$str)
            return false;
        $utf8 = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ|Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );
        foreach ($utf8 as $ascii => $uni)
            $str = preg_replace("/($uni)/i", $ascii, $str);
        return $str;
    }
    //Clip 20 phương thức chuyển tiếng việt thành dạng vd the-young-Viet-Nam-likes-going-to-discover-touris
    public function alias_standard($st){
        $st = str_replace(' ', '-', strtolower($this->utf8_convert($st)));
        $_temp = NULL;
        for ($i = 10; $i >= 1; $i--) $_temp[] = str_repeat('-', $i);
        $st = str_replace($_temp, '-', $st);
        $st = preg_replace('/[^a-zA-Z0-9-]/i', '', $st);
        if (substr($st, -1) == '-') $st = substr($st, 0, -1);
        return $st;
    }
    public function full_url(){
        return ('http://'.$_SERVER['HTTP_HOST'].str_replace('/index.php/', '/', $_SERVER['PHP_SELF'])).((!empty($_SERVER['QUERY_STRING'])) ? ('?'.$_SERVER['QUERY_STRING']):'');
    }
}
