<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Log extends My_Controller {

    private $auth;

    public function __construct() {
        parent::__construct();
        $this->auth = $this->my_auth->check();
        if ($this->auth == NULL)
            $this->my_string->php_redirect(CMS_BASE_URL . 'backend/logs/index');
        $this->my_auth->allow($this->auth, 'backend/logs');
    }

    /* Phương thức sử lý việc sắp xếp các list log */

    public function index($page = 1) {
        $this->my_auth->allow($this->auth, 'backend/log/index');
        $data['seo']['title'] = 'log';
        $keyword = $this->input->get('keyword');
        $_lang = $this->session->userdata('_lang');
        $sort = $this->my_common->sort_orderby($this->input->get('sort_field'), $this->input->get('sort_value'));
        $config = $this->my_common->backend_pagination(); //load method backend_pagination() sử lý việc phân trang phía backend
        $config['base_url'] = 'backend/log/index/';
        if (!empty($keyword)) {
            $this->db->cache_on();
            $_sql = 'SELECT * FROM '.CMS_DB_PREFIX.'logs WHERE `lang` = ? AND (`module_name` LIKE ? OR `name_key` LIKE ? OR `note_action` LIKE ?)';
            $_param = array($_lang, '%'.$keyword.'%', '%'.$keyword.'%', '%'.$keyword.'%');
            $config['total_rows'] = $this->db->query($_sql, $_param)->num_rows();
           } else {
            $config['total_rows'] = $this->db->from('logs')->count_all_results();
        }
        if ($config['total_rows'] > 0) {
            $_totalpage = ceil($config['total_rows'] / $config['per_page']);
            $page = ($page > $_totalpage) ? $_totalpage : $page;
            $config['cur_page'] = $page; //Thay cho đoạn code $config['uri_segment'] = 4;
            $config['suffix'] = ((isset($sort) && count($sort)) ? '?sort_field=' . $sort['field'] . '&sort_value=' . $sort['value'] : '');
            $config['suffix'] = $config['suffix'] . (!empty($keyword) ? '&keyword=' . $keyword : '');
            $config['first_url'] = $config['base_url'] . $config['suffix'];
            $this->pagination->initialize($config);
            $data['data']['pagination'] = $this->pagination->create_links();
        }
        if (!empty($keyword)) {
            $_sql = 'SELECT * FROM '.CMS_DB_PREFIX.'logs WHERE `lang` = ? AND (`module_name` LIKE ? OR `name_key` LIKE ? OR `note_action` LIKE ?)';
            $_param = array($_lang, '%'.$keyword.'%', '%'.$keyword.'%', '%'.$keyword.'%');
            $config['total_rows'] = $this->db->query($_sql, $_param)->num_rows();
           } else {
            $data['data']['_list'] = $this->db->from('logs')->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
        }
        $data['data']['_page'] = $page;
        $data['data']['_config'] = $config;
        $data['data']['_sort'] = $sort;
        $data['data']['_keyword'] = $keyword;
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/log/index';
        $this->load->view('backend/layout/home', isset($data) ? $data : NULL);
    }

    public function dellog($id) {
        $this->my_auth->allow($this->auth, 'backend/log/dellog');
        $this->db->delete('logs', array('id' => $id));
        $this->my_string->js_redirect('Bạn đã xóa log thành công', CMS_BASE_URL . 'backend/log/index');
    }

}
