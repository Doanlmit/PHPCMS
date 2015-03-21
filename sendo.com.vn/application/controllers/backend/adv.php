<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adv extends My_Controller {

    private $auth;

    public function __construct() {
        parent::__construct();
        $this->auth = $this->my_auth->check();
        if ($this->auth == NULL) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/home/index');
        $this->my_auth->allow($this->auth, 'backend/adv');
    }
    
    /* Phương thức sử lý việc sắp xếp các list quảng cáo */
    public function index($page = 1) {
        $this->my_auth->allow($this->auth, 'backend/adv/index');
        if ($this->input->post('sort')) {
            $_order = $this->input->post('order');
            //print_r($_order);
            if (isset($_order) && count($_order)) {
                foreach ($_order as $keyOrder => $valOrder) {
                    $_data[] = array(
                        'id' => $keyOrder,
                        'orders' => (int) $valOrder,
                        //'updated' => gmdate('Y-m-d H:i:s' + time() + 7 * 3600) - khong can nua vi ta su dung update 
                    );
                }
                $this->db->update_batch('adv', $_data, 'id');
                $this->my_string->js_redirect('Sắp xếp thành công!', CMS_BASE_URL . 'backend/adv/index');
                
            }
        }
        $data['seo']['title'] = 'Quảng cáo';
        $_lang = $this->session->userdata('_lang');
        //echo $_lang;
        $keyword = $this->input->get('keyword');
        $sort = $this->my_common->sort_orderby($this->input->get('sort_field'), $this->input->get('sort_value'));
        $config = $this->my_common->backend_pagination(); //load method backend_pagination() sử lý việc phân trang phía backend
        $config['base_url'] = 'backend/adv/index/';
        if (!empty($keyword)) {
            $config['total_rows'] = $this->db->from('adv')->like('title', $keyword)->where(array('lang' => $_lang))->count_all_results();
        } else {
            $config['total_rows'] = $this->db->from('adv')->where(array('lang' => $_lang))->count_all_results();
            //$config['total_rows'] = $this->db->where(array('lang' => $_lang))->count_all_results('adv');
        }
        if($config['total_rows'] > 0){
            $_totalpage = ceil($config['total_rows'] / $config['per_page']);
            $page = ($page > $_totalpage) ? $_totalpage : $page;
            //echo $_totalpage."<br/>";
            //echo $page;
            //Clip 17
            //$config['total_rows'] tổng số dòng 
            //$config['per_page'] số lượng hiển thị
            $config['cur_page'] = $page;//Thay cho đoạn code $config['uri_segment'] = 4; 
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
            $data['data']['_list'] = $this->db->from('adv')->where(array('lang' => $_lang))->like('title', $keyword)->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
        } else {
            $data['data']['_list'] = $this->db->from('adv')->where(array('lang' => $_lang))->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
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
        $data['template'] = 'backend/adv/index';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    //Phương thức thêm thông tin quảng cáo
    public function add() {
        $this->my_auth->allow($this->auth, 'backend/adv/add');
        $data['seo']['title'] = 'Thêm quảng cáo';
        $data['data']['auth'] = $this->auth;
        if ($this->input->post('add')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[time_start]', 'Thời gian bắt đầu', 'trim|required|callback__date['.  json_encode(array('time_start' => $_post['time_start'], 'time_end' => $_post['time_end'])).'])');
            $this->form_validation->set_rules('data[time_end]', 'Thời gian kết thúc', 'trim|required');
            $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required');
            $this->form_validation->set_rules('data[content]', 'Nội dung', 'trim|required');
            $this->form_validation->set_rules('data[position]', 'Vị trí', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $_post = $this->my_string->allows_post($_post, array('title', 'content', 'position', 'time_start', 'time_end', 'publish'));
                $_post['time_start'] = !empty($_post['time_start']) ? gmdate('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_post['time_start'])) + 7 * 3600) : '';
                $_post['time_end'] = !empty($_post['time_end']) ? gmdate('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_post['time_end'])) + 7 * 3600) : '';
                $_post['created'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                $_post['userid_created'] = $this->auth['id'];
                $_post['lang'] = $this->session->userdata('_lang');
                $this->db->insert('adv', $_post);
                $this->my_string->js_redirect('Thêm quảng cáo thành công', CMS_BASE_URL . 'backend/adv/index');
                //﻿2014-11-18 09:11:55
            }
        } else {
            $_post['publish'] = 1;
            $data['data']['_post'] = $_post;
        }
        $data['template'] = 'backend/adv/add';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }

    //Phương thức thực hiện khi user click vào thanh trạng thái nếu giá trị là 0 sẽ gán thành 1 và ngược lại
    public function set($field, $id) {
        $this->my_auth->allow($this->auth, 'backend/adv/set');
        $id = (int) $id;
        $continue = $this->input->get('continue');
        //print_r($continue);
        $adv = $this->db->where(array('id' => $id))->from('adv')->get()->row_array();
        if (!isset($adv) || count($adv) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/adv/index');
        if (!isset($adv[$field])) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/adv/index');
        $this->db->where(array('id' => $id))->update('adv', array($field => ($adv[$field] == 1) ? 0 : 1));
        //$field la publish - tham số truyền vào qua url trong <a href="backend/adv/set/publish/
        $this->my_string->js_redirect('Thay đổi trạng thái thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/adv/index');
    }

    public function edit($id) {
        $this->my_auth->allow($this->auth, 'backend/adv/edit');
        $id = (int) $id;
        $continue = $this->input->get('continue');
        $adv = $this->db->where(array('id' => $id))->from('adv')->get()->row_array();
        if (!isset($adv) || count($adv) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/adv/index');
        if($adv['lang'] != $this->session->userdata('_lang')) $this->my_string->js_redirect('Ngôn ngữ không phù hợp!', !empty($continue) ? base64_decode ($continue) : CMS_BASE_URL.'backend/adv/index');
        $data['seo']['title'] = 'Thay đổi quảng cáo';
        $data['data']['auth'] = $this->auth;
        if ($this->input->post('edit')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[time_end]', 'Ngày kết thúc', 'trim|required|callback__date[' . json_encode(array('time_start' => $_post['time_start'], 'time_end' => $_post['time_end'])).']');
            $this->form_validation->set_rules('data[time_start]', 'Ngày bắt đầu', 'trim|required');
            $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required');
            $this->form_validation->set_rules('data[content]', 'Nội dung', 'trim|required');
            $this->form_validation->set_rules('data[position]', 'Vị trí', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $_post = $this->my_string->allows_post($_post, array('title', 'content', 'position', 'time_start', 'time_end', 'publish'));
                $_post['time_start'] = !empty($_post['time_start']) ? gmdate('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_post['time_start'])) + 7 * 3600) : '';
                $_post['time_end'] = !empty($_post['time_end']) ? gmdate('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_post['time_end'])) + 7 * 3600) : '';
                $_post['updated'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                $_post['userid_updated'] = $this->auth['id'];
                $this->db->where(array('id' => $id))->update('adv', $_post);
                $this->my_string->js_redirect('Thay đổi quảng cáo thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/adv/index');
				
			}
        } else {
            //Cũ sửa ở Clip 22  $adv['time_start'] = ($adv['time_start'] != '0000-00-00 00:00:00') ? gmdate('H:m:s d/m/Y', strtotime($adv['time_start']) + 7 * 3600) : '';
            $adv['time_start'] = ($adv['time_start'] != '0000-00-00 00:00:00') ? gmdate('H:i:s d/m/Y', strtotime(str_replace('-', '/', $adv['time_start'])) + 7 * 3600):'';
            $adv['time_end'] = ($adv['time_end'] != '0000-00-00 00:00:00') ? gmdate('H:i:s d/m/Y', strtotime(str_replace('-', '/', $adv['time_end'])) + 7 * 3600):'';
            $data['data']['_post'] = $adv;
        }
        $data['template'] = 'backend/adv/edit';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }

    //Phương thức kiểm tra ngày bắt đầu và ngày kết thúc  có hợp lệ không
    public function _date($title, $date) {
        $date = json_decode($date, TRUE);
        if (isset($date['time_start']) && !empty($date['time_start']) && isset($date['time_end']) && !empty($date['time_end']) && (strtotime(str_replace('/', '-', $date['time_start'])) + 7 * 3600 >= strtotime(str_replace('/', '-', $date['time_end'])) + 7 * 3600)) {
            $this->form_validation->set_message('_date', 'Thời gian kết thúc phải lớn hơn thời gian hiện tại');
            return FALSE;
        }
    }

    public function del($id) {
        $this->my_auth->allow($this->auth, 'backend/adv/del');
        $id = (int) $id;
        $continue = $this->input->get('continue');
        $adv = $this->db->where(array('id' => $id))->from('adv')->get()->row_array();
        if (!isset($adv) || count($adv) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/adv/index');
        if($adv['lang'] != $this->session->userdata('_lang')) $this->my_string->js_redirect('Ngôn ngữ không phù hợp!', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL.'backend/adv/index');
        $data['seo']['title'] = 'Xóa nhóm thành viên';
        $this->db->delete('adv', array('id' => $id));
        $this->my_string->js_redirect('Xóa quảng cáo thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/adv/index');
    }

}
