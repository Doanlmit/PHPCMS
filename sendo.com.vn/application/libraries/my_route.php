<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class My_route {
    //Clip 21 
    private $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }
    /*Cập nhật trường route trong bảng route
    public function update($param, $list){
        $this->CI->db->where('param', $param)->update('route', $list);
    }
    */
    //Clip 21 update lại cái route theo bài viết khi bài viết được sửa
    public function update_route($param, $url) {
        if(isset($url) && !empty($url)){
            $count = $this->CI->db->from('route')->where(array('param' => $param))->count_all_results();
            if($count >=1){
            $this->CI->db->where('param', $param)->update('route', array(
                                                                        'url' => $url,
                                                                        'updated' => gmdate('Y-m-d H:i:s', time() + 3600)));
            }else{
                $this->insert(array('url' => $url, 'param' => $param, 'created' => gmdate('Y-m-d H:i:s')));
            }
        }else{
             $this->CI->db->delete('route', array('param' => $param));
        }
        $this->create();//goi method create cua route de ghi cai vua sua xong vao file
    }
    //Clip 21 Thêm route của bảng article_item vào url của bảng route
    public function insert($param){
        if(isset($param) && count($param) >= 2){
            $this->CI->db->insert('route',  $param);
        }
        $this->create();//goi method create cua route de ghi cai vua sua xong vao file
    }
    //Clip 21 Cập nhật url của bảng route với ky tu được lấy trong CSDL neu giong nhau thi bao da ton tai 
    public function check_route($route, $old_route){
       $route = $this->CI->my_string->alias_standard($route);
       if(empty($old_route)){
           $count = $this->CI->db->from('route')->where(array('url' => $route))->count_all_results();
       }
       else{
            $count = $this->CI->db->from('route')->where(array('url' => $route, 'url !=' => $old_route))->count_all_results();
       }
        if ($count > 0) {
            $this->CI->form_validation->set_message('_route', 'Url: ' . $route . ' đã tồn tại!');
            return FALSE;
        }
        return TRUE;
    }
    //Clip 23
    public function create() {
        $_data = $this->CI->db->select('url, param')->from('route')->get()->result_array();
        if (isset($_data) && count($_data)) {
            $str = '<?php' . "\n";
            foreach ($_data as $key => $val) {
            	$_temp = explode('/', $val['param']);
            	if(in_array('category', $_temp) == TRUE) $str = $str . '$route[\''.$val['url'].'/trang-(\d+)\'] = \'frontend/'.$val['param'].'/$1\';'."\n";
            	$str = $str . '$route[\'' . $val['url'] . '\'] = \'frontend/' . $val['param']  .'\';' . "\n";
                //print_r($val);
                //$route['am-thuc'] = 'article/category/17';
            }
            $str = $str . '?>' . "\n";
            $file = 'route.php'; //ten file can ghi xuong
            //debug lai sau
//            $this->CI->load->library('ftp');
//            $config['hostname'] = $this->CI->_config['ftp_hostname'];
//            $config['username'] = $this->CI->_config['ftp_username'];
//            $config['password'] = $this->CI->_config['ftp_password'];
//            $config['port'] = 21;
//            $config['passive'] = FALSE;
//            $config['debug'] = TRUE;
//            $this->CI->ftp->connect($config);
//            $this->CI->ftp->chmod($file, 0777); 
            $fm = fopen($file, 'w'); //Doc dile can ghi va chi thuc hien thao tac ghi
            if( fwrite($fm, $str)){
                //$this->CI->ftp->chmod($file, 0755); 
                //$this->CI->ftp->close();
            }
        }
    }

}
