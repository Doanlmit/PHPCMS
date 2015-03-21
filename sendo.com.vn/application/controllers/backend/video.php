<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Video extends My_Controller {

    private $auth;

    public function __construct() {
        parent::__construct();
        $this->auth = $this->my_auth->check();
        if ($this->auth == NULL) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/home/index');
        $this->my_auth->allow($this->auth, 'backend/video');
    }
    
    /* Phương thức sử lý việc sắp xếp các list video */
    public function index($page = 1) {
        $this->my_auth->allow($this->auth, 'backend/video/index');
        if ($this->input->post('sort')) {
            $_order = $this->input->post('order');
            if (isset($_order) && count($_order)) {
                foreach ($_order as $keyOrder => $valOrder) {
                    $_data[] = array(
                        'id' => $keyOrder,
                        'orders' => (int) $valOrder,
                    );
                }
                $this->db->update_batch('video', $_data, 'id');
                $this->my_string->js_redirect('Sắp xếp thành công!', CMS_BASE_URL . 'backend/video/index');
            }
        }
        $data['seo']['title'] = 'video';
        $keyword = $this->input->get('keyword');
        $sort = $this->my_common->sort_orderby($this->input->get('sort_field'), $this->input->get('sort_value'));
        $config = $this->my_common->backend_pagination(); //load method backend_pagination() sử lý việc phân trang phía backend
        $config['base_url'] = 'backend/video/index/';
        if (!empty($keyword)) {
            $config['total_rows'] = $this->db->from('video')->like('title', $keyword)->count_all_results();
        } else {
            $config['total_rows'] = $this->db->from('video')->count_all_results();
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
            $data['data']['_list'] = $this->db->from('video')->like('title', $keyword)->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
        } else {
            $data['data']['_list'] = $this->db->from('video')->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
        }
        $data['data']['_page'] = $page;
        $data['data']['_config'] = $config;
        $data['data']['_sort'] = $sort;
        $data['data']['_keyword'] = $keyword;
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/video/index';
        $this->load->view('backend/layout/home', isset($data) ? $data : NULL);
    }
    public function add(){
        $this->my_auth->allow($this->auth, 'backend/video/add');
        if($this->input->post('add')){
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required');
            $this->form_validation->set_rules('data[code]', 'Mã video', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
               $_post = $this->my_string->allows_post($_post, array('title', 'code', 'publish'));
                $_post['created'] = gmdate('Y-m-d H:s:i', time() +  7*3600);
                $_post['userid_created'] = $this->auth['id'];
                $this->db->insert('video', $_post);
                $this->my_string->js_redirect('Thêm video thành công', CMS_BASE_URL . 'backend/video/index');
                //﻿2014-11-18 09:11:55
            }
        }else{
            $_post['publish'] = 1;
            $data['data']['_post'] = $_post;
        }
        $data['seo']['title'] = 'Thêm video';
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/video/add';
        $this->load->view('backend/layout/home', isset($data) ? $data : NULL);
    }
    public function editvideo($id){
    	$this->my_auth->allow($this->auth, 'backend/video/edit');
        $id = (int) $id;
        $continue = $this->input->get('continue');
        $video = $this->db->where(array('id' => $id))->from('video')->get()->row_array();
        if (!isset($video) || count($video) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/video/index');
    	if($this->input->post('edit')){
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required');
			$this->form_validation->set_rules('data[title]', 'Mã video', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
               $_post = $this->my_string->allows_post($_post, array('title', 'code', 'publish'));
                $_post['created'] = gmdate('Y-m-d H:s:i', time() +  7*3600);
                $_post['userid_updated'] = $this->auth['id'];
                $this->db->where(array('id' => $id))->update('video', $_post);
                $this->my_string->js_redirect('Thay đổi video thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/adv/index');
			}
        }else{
            $_post['publish'] = 1;
            $data['data']['_post'] = $video;
        }
        $data['seo']['title'] = 'Thay đổi video';
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/video/edit';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    public function delvideo($id){
    	$this->my_auth->allow($this->auth, 'backend/video/edit');
    	$this->db->delete('video', array('id' => $id));
        $this->my_string->js_redirect('Bạn đã xóa video thành công', CMS_BASE_URL.'backend/video/index');
    }
    public function setvideo($var_set, $id) {
    	$this->my_auth->allow($this->auth, 'backend/video/setvideo');
    	$id = (int) $id;
    	$continue = $this->input->get('continue');
    	$video = $this->db->where(array('id' => $id))->from('video')->get()->row_array();
    	if(!isset($video) && count($video) == 0) $this->my_string->php_redirect(CMS_BASE_URL.'backend/video/index');
    	if(!isset($video[$var_set])) $this->my_string->php_redirect(CMS_BASE_URL.'backend/video/index');
    	$this->db->where(array('id'=>$id))->update('video', array($var_set => ($video[$var_set] ==1) ? 0 : 1));
    	$this->my_string->js_redirect('Thay đổi trạng thái thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/article/item');
    	
    }
    
}
