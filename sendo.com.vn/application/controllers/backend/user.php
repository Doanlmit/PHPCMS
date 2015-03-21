<?php if (!defined('BASEPATH'))exit('No direct script access allowed');
class User extends My_Controller {

    private $auth;
    public function __construct() {
        parent::__construct();
        $this->auth = $this->my_auth->check();
        if ($this->auth == NULL) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/home/index');
        $this->my_auth->allow($this->auth, 'backend/user');
        //print_r($this->auth['email']);
    }
    /*Phương thức sử lý việc sắp xếp các tài khoản mà người dùng thêm vào hệ thống*/
    public function group($page = 1) {
        $this->my_auth->allow($this->auth, 'backend/user/group');
        if($this->input->post('sort')){
           $_order = $this->input->post('order');
           if (isset($_order) && count($_order)){
            foreach ($_order as $keyOrder => $valOrder) {
                $_data[] = array(
                    'id' => $keyOrder,
                    'orders'=>(int)$valOrder,
                    'updated' => gmdate('Y-m-d H:i:s' + time() + 7 * 3600)
                );
            }
            $this->db->update_batch('user_group', $_data, 'id');
            $this->my_string->js_redirect('Sắp xếp thành công!',  CMS_BASE_URL.'backend/user/group/?sort_field=id&sort_value=desc');
            
        }    
      }
        $data['seo']['title'] = 'Nhóm thành viên';
        $keyword = $this->input->get('keyword');
        $sort = $this->my_common->sort_orderby($this->input->get('sort_field'), $this->input->get('sort_value'));
        $config = $this->my_common->backend_pagination(); //load method backend_pagination() sử lý việc phân trang phía backend
        $config['base_url'] = 'backend/user/group';
        //Clip 12
        if (!empty($keyword)) {
            $config['total_rows'] = $this->db->like('title', $keyword)->count_all('user_group');
        } else {
            $config['total_rows'] = $this->db->count_all('user_group');
        }
        $config['uri_segment'] = 4;
        $config['suffix'] = ((isset($sort) && count($sort)) ? '?sort_field=' . $sort['field'] . '&sort_value=' . $sort['value'] : '');
        $config['suffix'] = $config['suffix'] . (!empty($keyword) ? '&keyword=' . $keyword : '');
        $config['first_url'] = $config['base_url'] . $config['suffix'];
        $this->pagination->initialize($config);
        $data['data']['pagination'] = $this->pagination->create_links();
        /* cách 2
          $_order_by = ((isset($sort) && count($sort)) ? ($sort['field']. ' ' . $sort['value']):'');
          if(!empty($_order_by) && ($sort['field'] != 'id')){ $_order_by = $_order_by.', id asc';}else{$_order_by = 'id asc';}
         */
        if (!empty($keyword)) {
            $data['data']['_list'] = $this->db->from('user_group')->like('title', $keyword)->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
        }else {
            $data['data']['_list'] = $this->db->from('user_group')->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
            //print_r($data['data']['_list']);
        }
        //Cách 1: order_by(((isset($sort) && count($sort)) ? ($sort['field']. ' ' . $sort['value']):'').(($sort['field'] != 'id') ? ', id asc':''))->
        //echo ($sort['field']. '  ' . $sort['value']);
        //$this->db->order_by("title", "desc");
        //$config['per_page']: đây là số lượng cần lấy để hiển thị ra
        //($page -1)* $config['per_page'] day la diem bat dau																						
        $data['data']['_page'] = $page;
        $data['data']['_config'] = $config;
        $data['data']['_sort'] = $sort;
        $data['data']['_keyword'] = $keyword;
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/user/group';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    //Phương thức dùng để thêm thành viên 
    public function addgroup(){
        $this->my_auth->allow($this->auth, 'backend/user/addgroup');
        $data['seo']['title'] = 'Thêm nhóm thành viên';
        $data['data']['auth'] = $this->auth;
        if ($this->input->post('add')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $_post = $this->my_string->allows_post($_post, array('title', 'allow', 'groups'));
                $_post['created'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                $_post['userid_created'] = $this->auth['id'];
                $this->db->insert('user_group', $_post);
                $this->my_string->js_redirect('Thêm thành viên thành công', CMS_BASE_URL . 'backend/user/group');
            }
        } else {
            $_post['allow'] = 0;
            $data['data']['_post'] = $_post;
        }
        $data['template'] = 'backend/user/addgroup';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    public function editgroup($id){
            $this->my_auth->allow($this->auth, 'backend/user/editgroup');
            $id = (int) $id;
            $group = $this->db->where(array('id' => $id))->from('user_group')->get()->row_array();
            if(!isset($group) || count($group) == 0) $this->my_string->php_redirect(CMS_BASE_URL.'backend/user/group');
            $data['seo']['title'] = 'Thay đổi nhóm thành viên';
            $data['data']['auth'] = $this->auth;
            if ($this->input->post('edit')) {
                $_post = $this->input->post('data');
                $data['data']['_post'] = $_post;
                $this->form_validation->set_error_delimiters('<li>', '</li>');
                $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required');
                if ($this->form_validation->run() == TRUE) {
                    $_post = $this->my_string->allows_post($_post, array('title', 'allow', 'groups'));
                    $_post['updated'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                    $_post['userid_updated'] = $this->auth['id'];
                    $this->db->where(array('id'=>$id))->update('user_group', $_post);
                    $this->my_string->js_redirect('Thay đổi nhóm thành viên thành công', CMS_BASE_URL . 'backend/user/group');
                }
            } else {
                $data['data']['_post'] = $group;
            }
            $data['template'] = 'backend/user/editgroup';
            $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    public function delgroup($id){
        $this->my_auth->allow($this->auth, 'backend/user/delgroup');
        $id = (int) $id;
        $group = $this->db->where(array('id' => $id))->from('user_group')->get()->row_array();
        if(!isset($group) || count($group) == 0) $this->my_string->php_redirect(CMS_BASE_URL.'backend/user/group');
        $data['seo']['title'] = 'Xóa nhóm thành viên';
        $data['data']['auth'] = $this->auth;
        $count = $this->db->where(array('groupid'=>$group['id']))->from('user')->count_all_results();
        if($count > 0) $this->my_string->js_redirect('Nhóm'.$group['title'].'vẫn còn thành viên',CMS_BASE_URL.'backend/user/group');
        $this->db->delete('user_group', array('id' => $id)); 
        $this->my_string->js_redirect('Xóa nhóm thành viên thành công', CMS_BASE_URL . 'backend/user/group');
        $data['template'] = 'backend/user/delgroup';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    
    /* Phương thức sử lý việc hiển thị list user Clip 22 */
    public function index($page = 1) {
        $this->my_auth->allow($this->auth, 'backend/user/index');
        $data['seo']['title'] = 'Danh sách thành viên';
        $keyword = $this->input->get('keyword');
        $groupid = (int)$this->input->get('groupid');
        $sort = $this->my_common->sort_orderby($this->input->get('sort_field'), $this->input->get('sort_value'));
        $config = $this->my_common->backend_pagination(); //load method backend_pagination() sử lý việc phân trang phía backend
        $config['base_url'] = 'backend/user/index/';
        if (!empty($keyword) && $groupid == 0){
            $_sql = 'SELECT * FROM '.CMS_DB_PREFIX.'user WHERE(`username` LIKE ? OR `email` LIKE ? OR `fullname` LIKE ?)';
            $_param = array('%'.$keyword.'%', '%'.$keyword.'%', '%'.$keyword.'%');
            $config['total_rows'] = $this->db->query($_sql, $_param)->num_rows();
        }
        else if (empty($keyword) && $groupid > 0) $config['total_rows'] = $this->db->from('user')->where(array('groupid' => $groupid))->count_all_results();
        else if(!empty ($keyword) && $groupid > 0){
            //khong co cach ghep like, or_like với where trong CI
            $_sql = 'SELECT * FROM '.CMS_DB_PREFIX.'user WHERE `groupid` = ? AND (`username` LIKE ? OR `email` LIKE ? OR `fullname` LIKE ?)';
            $_param = array($groupid, '%'.$keyword.'%', '%'.$keyword.'%', '%'.$keyword.'%');
            $config['total_rows'] = $this->db->query($_sql, $_param)->num_rows();
        } 
        else $config['total_rows'] = $this->db->from('user')->count_all_results();
        $_totalpage = ceil($config['total_rows'] / $config['per_page']);
        $page = ($page > $_totalpage) ? $_totalpage : $page;
        $config['cur_page'] = $page;//$config['uri_segment'] = 4;
        $config['suffix'] = ((isset($sort) && count($sort)) ? '?sort_field=' . $sort['field'] . '&sort_value=' . $sort['value'] : '');
        $config['first_url'] = $config['base_url'] . $config['suffix'];
        $config['suffix'] = $config['suffix'] . (($groupid > 0) ? '&groupid='.$groupid : '');
        $config['suffix'] = $config['suffix'] . (!empty($keyword) ? '&keyword=' . $keyword : '');
        if($config['total_rows'] > 0){
            $this->pagination->initialize($config);
            $data['data']['pagination'] = $this->pagination->create_links();
            if (!empty($keyword) && $groupid == 0){
                $_sql = 'SELECT * FROM '.CMS_DB_PREFIX.'user WHERE (`username` LIKE ? OR `email` LIKE ? OR `fullname` LIKE ?)';
                $_param = array('%'.$keyword.'%', '%'.$keyword.'%', '%'.$keyword.'%');
                $data['data']['_list']  = $this->db->query($_sql, $_param)->result_array();
            } 
            else if (empty($keyword) && $groupid > 0) $data['data']['_list'] = $this->db->from('user')->where(array('groupid' => $groupid))->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
            else if(!empty ($keyword) && $groupid > 0){
                //khong co cach ghep like, or_like với where trong CI
                $_sql = 'SELECT * FROM '.CMS_DB_PREFIX.'user WHERE `groupid` = ? AND (`username` LIKE ? OR `email` LIKE ? OR `fullname` LIKE ?) ORDER BY '.($sort['field'].' '.$sort['value']) . ' LIMIT '.(($page-1)*$config['per_page']).', '.$config['per_page'];
                $_param = array($groupid, '%'.$keyword.'%', '%'.$keyword.'%', '%'.$keyword.'%');
                $data['data']['_list']  = $this->db->query($_sql, $_param)->result_array();
            } 
            else {
                $data['data']['_list'] = $this->db->from('user')->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
            }
        }
        //print_r( $data['data']['_list']);
        $data['data']['_page'] = $page;
        $data['data']['_config'] = $config;
        $data['data']['_sort'] = $sort;
        $data['data']['_keyword'] = $keyword;
        $data['data']['_groupid'] = $groupid;
        $data['data']['auth'] = $this->auth;
        $_group = $this->db->select('id, title')->from('user_group')->get()->result_array();
        if(isset($_group) && count($_group)){
            $data['data']['_show']['groupid'][0] = '---';
            foreach ($_group as $key => $val){
               $data['data']['_show']['groupid'][$val['id']] = $val['title'];
            }
        }
        $data['template'] = 'backend/user/index';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    //Phương thức thêm thành viên Clip 22
    public function adduser(){
        $this->my_auth->allow($this->auth, 'backend/user/adduser');
        if ($this->input->post('add')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[username]', 'Tên sử dụng', 'trim|required|min_length[3]|max_length[20]|regex_match[/^([a-z0-9])+$/i]');
            $this->form_validation->set_rules('data[password]', 'Mật khẩu', 'trim|required');
            $this->form_validation->set_rules('data[repassword]', 'Xác nhận mật khẩu', 'trim|required|matches[data[password]]');
            $this->form_validation->set_rules('data[email]', 'Email', 'trim|required|valid_email|callback__email');
            $this->form_validation->set_rules('data[groupid]', 'Nhóm thành viên', 'trim|required|is_natural_no_zero');
            if ($this->form_validation->run() == TRUE) {
                $_post = $this->my_string->allows_post($_post, array('username', 'password', 'email', 'groupid'));
                $_post['salt'] = $this->my_string->ramdom(69, TRUE);
                $_post['password'] = $this->my_string->encode_password($_post['username'], $_post['password'], $_post['salt']);
                $_post['created'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                $this->db->insert('user', $_post);
                $this->my_string->js_redirect('Tạo tài khoản quản trị thành công!', CMS_BASE_URL . 'backend/auth/login');
            }
            
        }
        $data['seo']['title'] = 'Thêm thành viên';
        $data['data']['auth'] = $this->auth;
        $_group = $this->db->select('id, title')->from('user_group')->get()->result_array();
        if(isset($_group) && count($_group)){
            $data['data']['_show']['groupid'][0] = '---';
            foreach ($_group as $key => $val){
               $data['data']['_show']['groupid'][$val['id']] = $val['title'];
            }
        }
        $data['template'] = 'backend/user/adduser';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    public function edituser($id){
        $this->my_auth->allow($this->auth, 'backend/user/edituser');
        $id = (int) $id; 
        $continue = $this->input->get('continue');
        $user = $this->db->where(array('id' => $id))->from('user')->get()->row_array();
        if(!isset($user) || count($user)==0) $this->my_string->php_rederect(CMS_BASE_URL.'backend/user/index');
        if($this->input->post('edit')){
            $_post = $this->input->post('data');
            $data['data']['post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[email]', 'Email', 'trim|required|valid_email|callback__email['.$user['email'].']');
            $this->form_validation->set_rules('data[groupid]', 'Nhóm thành viên', 'trim|required|is_natural_no_zero');
            if ($this->form_validation->run() == TRUE) {
                $_post = $this->my_string->allows_post($_post, array('email', 'groupid', 'google_author'));
                $_post['salt'] = $this->my_string->ramdom(69, TRUE);
                $_post['updated'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                $this->db->where('id', $id)->update('user', $_post);
                $this->my_string->js_redirect('Thay đổi thông tin thành viên thành công!', CMS_BASE_URL . 'backend/user/index');
            }
        }else{
            $data['data']['_post'] = $user;
        }
        $_group = $this->db->select('id, title')->from('user_group')->get()->result_array();
        if(isset($_group) && count($_group)){
            $data['data']['_show']['groupid'][0] = '---';
            foreach ($_group as $key => $val) {
                $data['data']['_show']['groupid'][$val['id']] = $val['title'];
            }
        }
        $data['data']['seo'] = 'Thay đổi thành viên';
        $data['data']['user'] = $user['username'];
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/user/edituser';
        $this->load->view('backend/layout/home', isset($data)? $data : '');
    }
    //Callback kiêm tra email của user có tồn trong bảng user hay chưa 
    public function _email($email, $old_email) {
        if(isset($old_email) && !empty($old_email)){
            $count = $this->db->where(array('email' => $email, 'email !=' => $old_email))->from('user')->count_all_results();
        }else{
            $count = $this->db->where(array('email' => $email))->from('user')->count_all_results();
        }
        if ($count > 0) {
            $this->form_validation->set_message('_email', 'Email ' . $email . ' đã tồn tại');
            return FALSE;
        }
        return TRUE;
    }
    //phương thức xóa thành viên trong hệ quản trị nội dung
    public function deluser($id){
        $this->my_auth->allow($this->auth, 'backend/deleteuser');
        $continue = $this->input->get('continue'); 
        $id = (int) $id; //Ép kiểu $id truyền vào phải là số
        //Kiểm tra trong table có còn user để xóa hay không
        $user = $this->db->where(arraY('id' => $id))->from('user')->get()->row_array();
        if(!isset($user) && count($user) == 0) $this->my_string->php_rederect(CMS_BASE_URL.'backend/user/index');
        if($id == $this->auth['id']) $this->my_string->js_redirect('Không thể tự xóa chính mình',CMS_BASE_URL.'backend/user/index');
        //Kiểm tra trong bảng có còn bài viết nào hay không trước khi xóa
        $count = $this->db->where(array('userid_created'=>$id))->from('article_item')->count_all_results();
        if($count > 0) $this->my_string->js_redirect('Bài viết vẫn còn', CMS_BASE_URL.'backend/user/index');
        $this->db->delete('user', array('id'=>$id));
        $this->my_string->js_redirect('Xóa thành viên thành công!', CMS_BASE_URL.'backend/user/index');
    }
}
