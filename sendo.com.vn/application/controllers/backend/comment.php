<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Comment extends My_Controller {

    private $auth;

    public function __construct() {
        parent::__construct();
        $this->auth = $this->my_auth->check();
        if ($this->auth == NULL) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/comment/index');
        $this->my_auth->allow($this->auth, 'backend/comment');
    }
    
    /* Phương thức sử lý việc sắp xếp các list comment */
    public function index($page = 1) {
        $this->my_auth->allow($this->auth, 'backend/comment/index');
        $data['seo']['title'] = 'comment';
        $keyword = $this->input->get('keyword');
        $sort = $this->my_common->sort_orderby($this->input->get('sort_field'), $this->input->get('sort_value'));
        $config = $this->my_common->backend_pagination(); //load method backend_pagination() sử lý việc phân trang phía backend
        $config['base_url'] = 'backend/comment/index/';
        if (!empty($keyword)) {
            $config['total_rows'] = $this->db->from('comment')->like('title', $keyword)->count_all_results();
        } else {
            $config['total_rows'] = $this->db->from('comment')->count_all_results();
        }
        if($config['total_rows'] > 0){
            $_totalpage = ceil($config['total_rows'] / $config['per_page']);
            $page = ($page > $_totalpage) ? $_totalpage : $page;
            $config['cur_page'] = $page;//Thay cho đoạn code $config['uri_segment'] = 4;
            $config['suffix'] = ((isset($sort) && count($sort)) ? '?sort_field=' . $sort['field'] . '&sort_value=' . $sort['value'] : '');
            $config['suffix'] = $config['suffix'] . (!empty($keyword) ? '&keyword=' . $keyword : '');
            $config['first_url'] = $config['base_url'] . $config['suffix'];
            $this->pagination->initialize($config);
            $data['data']['pagination'] = $this->pagination->create_links();
        }
        if (!empty($keyword)) {
            $data['data']['_list'] = $this->db->from('comment')->like('title', $keyword)->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
        } else {
            $data['data']['_list'] = $this->db->from('comment')->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
        }
        $data['data']['_page'] = $page;
        $data['data']['_config'] = $config;
        $data['data']['_sort'] = $sort;
        $data['data']['_keyword'] = $keyword;
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/comment/index';
        $this->load->view('backend/layout/home', isset($data) ? $data : NULL);
    }
    public function editcomment($id){
    	$this->my_auth->allow($this->auth, 'backend/comment/edit');
        $id = (int) $id;
        $continue = $this->input->get('continue');
        $comment = $this->db->where(array('id' => $id))->from('comment')->get()->row_array();
        if (!isset($comment) || count($comment) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/comment/index');
    	if($this->input->post('edit')){
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[fullname]', 'Họ và tên: ', 'trim|required');
			$this->form_validation->set_rules('data[email]', 'Email: ', 'trim|required|valid_email');
			$this->form_validation->set_rules('data[content]', 'Nội dung: ', 'trim|required');
				
            if ($this->form_validation->run() == TRUE) {
               $_post = $this->my_string->allows_post($_post, array('fullname', 'email','content', 'publish'));
                $_post['created'] = gmdate('Y-m-d H:s:i', time() +  7*3600);
                $_post['userid_updated'] = $this->auth['id'];
                $this->db->where(array('id' => $id))->update('comment', $_post);
                $this->my_string->js_redirect('Thay đổi comment thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/adv/index');
			}
        }else{
            $_post['publish'] = 1;
            $data['data']['_post'] = $comment;
        }
        $data['seo']['title'] = 'Thay đổi comment';
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/comment/edit';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    public function delcomment($id){
    	$this->my_auth->allow($this->auth, 'backend/comment/edit');
    	$this->db->delete('comment', array('id' => $id));
        $this->my_string->js_redirect('Bạn đã xóa comment thành công', CMS_BASE_URL.'backend/comment/index');
    }
    public function setcomment($var_set, $id) {
    	$this->my_auth->allow($this->auth, 'backend/comment/setcomment');
    	$id = (int) $id;
    	$continue = $this->input->get('continue');
    	$comment = $this->db->where(array('id' => $id))->from('comment')->get()->row_array();
    	if(!isset($comment) && count($comment) == 0) $this->my_string->php_redirect(CMS_BASE_URL.'backend/comment/index');
    	if(!isset($comment[$var_set])) $this->my_string->php_redirect(CMS_BASE_URL.'backend/comment/index');
    	$this->db->where(array('id'=>$id))->update('comment', array($var_set => ($comment[$var_set] ==1) ? 0 : 1));
    	$this->my_string->js_redirect('Thay đổi trạng thái thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/article/item');
    	
    }
    
}
