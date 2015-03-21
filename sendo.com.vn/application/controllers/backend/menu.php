<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends My_Controller {

    private $auth;

    public function __construct() {
        parent::__construct();
        $this->auth = $this->my_auth->check();
        if ($this->auth == NULL) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/menu/index');
        $this->my_auth->allow($this->auth, 'backend/menu');
    }
    
    /* Phương thức sử lý việc sắp xếp các list quảng cáo */
    public function index($page = 1) {
        $this->my_auth->allow($this->auth, 'backend/menu/index');
        if ($this->input->post('sort')) {
            $_order = $this->input->post('order');
            if (isset($_order) && count($_order)) {
                foreach ($_order as $keyOrder => $valOrder) {
                    $_data[] = array(
                        'id' => $keyOrder,
                        'orders' => (int) $valOrder,
                    );
                }
                $this->db->update_batch('menu', $_data, 'id');
                $this->my_string->js_redirect('Sắp xếp thành công!', CMS_BASE_URL . 'backend/menu/index');
            }
        }
        $data['seo']['title'] = 'menu';
        $_lang = $this->session->userdata('_lang');
        $keyword = $this->input->get('keyword');
        $sort = $this->my_common->sort_orderby($this->input->get('sort_field'), $this->input->get('sort_value'));
        $config = $this->my_common->backend_pagination(); //load method backend_pagination() sử lý việc phân trang phía backend
        $config['base_url'] = 'backend/menu/index/';
        if (!empty($keyword)) {
            $config['total_rows'] = $this->db->from('menu')->like('title', $keyword)->where(array('lang' => $_lang))->count_all_results();
        } else {
            $config['total_rows'] = $this->db->from('menu')->where(array('lang' => $_lang))->count_all_results();
        }
        if($config['total_rows'] > 0){
            $_totalpage = ceil($config['total_rows'] / $config['per_page']);
            $page = ($page > $_totalpage) ? $_totalpage : $page;
            $config['cur_page']  = $page;//Thay cho đoạn code $config['uri_segment'] = 4;
            $config['suffix'] = ((isset($sort) && count($sort)) ? '?sort_field=' . $sort['field'] . '&sort_value=' . $sort['value'] : '');
            $config['suffix'] = $config['suffix'] . (!empty($keyword) ? '&keyword=' . $keyword : '');
            $config['first_url'] = $config['base_url'] . $config['suffix'];
            $this->pagination->initialize($config);
            $data['data']['pagination'] = $this->pagination->create_links();
        }
        if (!empty($keyword)) {
            $data['data']['_list'] = $this->db->from('menu')->where(array('lang' => $_lang))->like('title', $keyword)->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
        } else {
            $data['data']['_list'] = $this->db->from('menu')->where(array('lang' => $_lang))->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
        }
        $data['data']['_page'] = $page;
        $data['data']['_config'] = $config;
        $data['data']['_sort'] = $sort;
        $data['data']['_keyword'] = $keyword;
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/menu/index';
        $this->load->view('backend/layout/home', isset($data) ? $data : NULL);
    }
    public function add(){
        $this->my_auth->allow($this->auth, 'backend/menu/add');
        if($this->input->post('add')){
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
               $_post = $this->my_string->allows_post($_post, array('title', 'url', 'module', 'module_id', 'publish'));
                $_post['created'] = gmdate('Y-m-d H:s:i', time() +  7*3600);
                $_post['userid_created'] = $this->auth['id'];
                $_post['lang'] = $this->session->userdata('_lang');
                $this->db->insert('menu', $_post);
                $this->my_string->js_redirect('Thêm menu thành công', CMS_BASE_URL . 'backend/menu/index');
                //﻿2014-11-18 09:11:55
            }
        }else{
            $_post['publish'] = 1;
            $data['data']['_post'] = $_post;
        }
        $data['seo']['title'] = 'Thêm menu';
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/menu/add';
        $this->load->view('backend/layout/home', isset($data) ? $data : NULL);
    }
	public function editmenu($id){
    	$this->my_auth->allow($this->auth, 'backend/menu/edit');
        $id = (int) $id;
        $continue = $this->input->get('continue');
        $menu = $this->db->where(array('id' => $id))->from('menu')->get()->row_array();
        if (!isset($menu) || count($menu) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/menu/index');
    	if($this->input->post('edit')){
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
            	$_post = $this->my_string->allows_post($_post, array('title', 'url', 'module','module_id', 'publish'));
                $_post['updated'] = gmdate('Y-m-d H:s:i', time() +  7*3600);
                $_post['userid_updated'] = $this->auth['id'];
                $this->db->where(array('id' => $id))->update('menu', $_post);
                $this->my_string->js_redirect('Thay đổi menu thành công !', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/adv/index');
			}
        }else{
            $_post['publish'] = 1;
            $data['data']['_post'] = $menu;
        }
        $data['seo']['title'] = 'Thay đổi menu';
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/menu/edit';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    public function delmenu($id){
    	$this->my_auth->allow($this->auth, 'backend/menu/delmenu');
    	$this->db->delete('menu', array('id' => $id));
    	$this->my_string->js_redirect('Bạn đã xóa menu thành công!', CMS_BASE_URL.'backend/menu/index');
    }
    public function set($field, $id) {
    	$this->my_auth->allow($this->auth, 'backend/menu/set');
    	$id = (int) $id;
    	$continue = $this->input->get('continue');
    	$menu = $this->db->where(array('id' => $id))->from('menu')->get()->row_array();
    	if(!isset($menu) && count($menu) == 0) $this->my_string->php_redirect(CMS_BASE_URL.'backend/menu/index');
    	if(!isset($menu[$field])) $this->my_string->php_redirect(CMS_BASE_URL.'backend/menu/index');
    	$this->db->where(array('id'=>$id))->update('menu', array($field => ($menu[$field] == 1) ? 0 : 1));
    	$this->my_string->js_redirect('Thay đổi trạng thái thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/menu/index');
    }
    public function setmenu($field, $id) {
    	$this->my_auth->allow($this->auth, 'backend/menu/setmenu');
    	$continue = $this->input->get('continue');
    	
    	$menu = $this->db->where(array('module'=>$field, 'module_id'=>$id))->from('menu')->get()->row_array();
    	if(!isset($menu['title']) || empty($menu['title'])){
    		$category = $this->db->where(array('id' => $id))->from($field)->get()->row_array();
        	if (!isset($category) || count($category) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/article/category');
        	if ($category['level'] == 0) $this->my_string->js_redirect('Bạn không được sửa Root', CMS_BASE_URL . 'backend/article/category');
        	if($category['lang'] != $this->session->userdata('_lang')) $this->my_string->js_redirect('Ngôn ngữ không phù hợp!', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL.'backend/article/category');
       		$_post['title'] = $category['title'];
    		$_post['url'] = '';
    		$_post['module'] = $field;
    		$_post['module_id'] = $id;
    		$_post['created'] = gmdate('Y-m-d: H:s:i', time() + 3600);
    		$_post['publish'] = 1;
    		$_post['lang'] = $this->session->userdata('_lang');
    		$this->db->insert('menu', $_post);
    	}else {
    		$_post['publish'] = ($menu['publish'] == 0) ? 1:0;
    		//echo $menu['publish'];die; 
    		$_post['updated'] = gmdate('Y-m-d H:s:i', time() +  7*3600);
    		$_post['userid_updated'] = $this->auth['id'];
    		$this->db->where(array('module' => $field, 'module_id' => $id))->update('menu', $_post);
    		
    	}
    	$this->my_string->js_redirect('Thay đổi trạng thái thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/menu/index');
    	
    }
}
