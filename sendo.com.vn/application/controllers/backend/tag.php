<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tag extends My_Controller {

    private $auth;

    public function __construct() {
        parent::__construct();
        $this->auth = $this->my_auth->check();
        if ($this->auth == NULL) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/home/index');
        //$this->my_auth->allow($this->auth, 'backend/tag');
    }

    /* Phương thức sử lý việc sắp xếp các list chủ đề */

    public function index($page = 1) {
        $this->my_auth->allow($this->auth, 'backend/tag/index');
        $data['seo']['title'] = 'Chủ đề';
        $keyword = $this->input->get('keyword');
        $sort = $this->my_common->sort_orderby($this->input->get('sort_field'), $this->input->get('sort_value'));
        $config = $this->my_common->backend_pagination(); //load method backend_pagination() sử lý việc phân trang phía backend
        $config['base_url'] = 'backend/tag/index/';
        if (!empty($keyword)) {
            $config['total_rows'] = $this->db->from('tag')->like('title', $keyword)->count_all_results();
        } else {
            $config['total_rows'] = $this->db->from('tag')->count_all_results();
            //$config['total_rows'] = $this->db->where(array('lang' => $_lang))->count_all_results('tag');
        }
        if($config['total_rows'] > 0){
            $_totalpage = ceil($config['total_rows'] / $config['per_page']);
            $page = ($page > $_totalpage) ? $_totalpage : $page;
            //echo $_totalpage."<br/>";
            //echo $page;
            //Clip 17
            //$config['total_rows'] tổng số dòng 
            //$config['per_page'] số lượng hiển thị
            $config['cur_page'] = $page; //Thay cho đoạn code $config['uri_segment'] = 4;
            $config['suffix'] = ((isset($sort) && count($sort)) ? '?sort_field=' . $sort['field'] . '&sort_value=' . $sort['value'] : '');
            $config['suffix'] = $config['suffix'] . (!empty($keyword) ? '&keyword=' . $keyword : '');
            $config['first_url'] = $config['base_url'] . $config['suffix'];
            $this->pagination->initialize($config);
            $data['data']['pagination'] = $this->pagination->create_links();
        }
        /* cách 2
          $_order_by = ((isset($sort) && count($sort)) ? ($sort['field']. ' ' . $sort['value']):'');
          if(!empty($_order_by) && ($sort['field'] != 'id')){ $_order_by = $_order_by.', id asc';}else{$_order_by = 'id asc';}
         */
        if (!empty($keyword)) {
            $data['data']['_list'] = $this->db->from('tag')->like('title', $keyword)->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
        } else {
            $data['data']['_list'] = $this->db->from('tag')->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
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
        $data['template'] = 'backend/tag/index';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }

    public function addtag() {
        $this->my_auth->allow($this->auth, 'backend/tag/add');
        if ($this->input->post('add')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required|callback__alias');
            if ($this->form_validation->run() == TRUE) {
                $_post = $this->my_string->allows_post($_post, array('title','description', 'publish', 'meta_title', 'meta_keywords', 'meta_descriptions'));
                $_post['created'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                $_post['userid_created'] = $this->auth['id'];
                $_post['alias'] = $this->my_string->alias_standard($_post['title']);
                $this->db->insert('tag', $_post);
                $this->my_string->js_redirect('Thêm chủ đề thành công', CMS_BASE_URL . 'backend/tag/index');
                //﻿2014-11-18 09:11:55
            }
        } else {
            $_post['publish'] = 1;
            $data['data']['_post'] = $_post;
        }
        $data['seo']['title'] = 'Thêm chủ đề';
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/tag/addtag';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    //Clip 18 Phương thức kiểm tra chủ đề đã tồn tại trong CSDL hay chưa?
    public function _alias($title, $old_title){
        //echo $old_title;
        if(empty($old_title)){
            $count = $this->db->from('tag')->where(array('alias' => $this->my_string->alias_standard($title)))->count_all_results();
        }else{
            $count = $this->db->from('tag')->where(array('alias' => $this->my_string->alias_standard($title), 
                                                         'alias !='=>$this->my_string->alias_standard($old_title)
                                                          ))->count_all_results();
	//$count = "SELECT COUNT(*) FROM (`CMS_tag`) WHERE `alias` =  $this->my_string->alias_standard($title) AND `alias` != $this->my_string->alias_standard($old_title)";
	}
        if($count > 0){
            $this->form_validation->set_message('_alias', 'Chủ đề đã tồn tại!');
            return FALSE;
        }
        return TRUE;
    }
   
    //Phương thức thực hiện khi user click vào thanh trạng thái nếu giá trị là 0 sẽ gán thành 1 và ngược lại
    public function set($field, $id) {
        $this->my_auth->allow($this->auth, 'backend/tag/set');
        $id = (int) $id;
        $continue = $this->input->get('continue');
        $tag = $this->db->where(array('id' => $id))->from('tag')->get()->row_array();
        if (!isset($tag) || count($tag) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/tag/index');
        if (!isset($tag[$field])) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/tag/index');
        $this->db->where(array('id' => $id))->update('tag', array($field => ($tag[$field] == 1) ? 0 : 1));
        //$field la publish - tham số truyền vào qua url trong <a href="backend/tag/set/publish/
        $this->my_string->js_redirect('Thay đổi trạng thái thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/tag/index');
    }

    public function edittag($id) {
        $this->my_auth->allow($this->auth, 'backend/tag/edittag');
        $id = (int) $id;
        $continue = $this->input->get('continue');
        $tag = $this->db->where(array('id' => $id))->from('tag')->get()->row_array();
        if (!isset($tag) || count($tag) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/tag/index');
        if ($this->input->post('edit')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required|callback__alias['.$tag['title'].']');
            if ($this->form_validation->run() == TRUE) {
                $_post = $this->my_string->allows_post($_post, array('title','description', 'publish', 'meta_title', 'meta_keywords', 'meta_descriptions'));
                $_post['updated'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                $_post['userid_updated'] = $this->auth['id'];
                $_post['alias'] = $this->my_string->alias_standard($_post['title']);
                $this->db->where(array('id' => $id))->update('tag', $_post);
                $this->my_string->js_redirect('Thay đổi chủ đề thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/tag/index');
				
                }
        } else {
           $data['data']['_post'] = $tag;
        }
        $data['seo']['title'] = 'Thay đổi chủ đề';
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/tag/edittag';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    public function deltag($id) {
        $this->my_auth->allow($this->auth, 'backend/tag/deltag');
        $id = (int) $id;
        $continue = $this->input->get('continue');
        $tag = $this->db->where(array('id' => $id))->from('tag')->get()->row_array();
        if (!isset($tag) || count($tag) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/tag/index');
        $this->db->delete('tag', array('id' => $id));
        $this->my_string->js_redirect('Xóa chủ đề thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/tag/index');
    }
    public function suggest($char = ''){
        $this->my_tags->suggest($char);
    }
    public function insert(){
        $item = $this->input->post('item');
        $list = $this->input->post('list');
        $this->my_tags->insert($item, $list);
    }
}
