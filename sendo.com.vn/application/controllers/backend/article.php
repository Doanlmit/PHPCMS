<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Article extends My_Controller {
    public $auth;
    public function __construct() {
        parent::__construct();
        $this->auth = $this->my_auth->check();
        if ($this->auth == NULL) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/home/index');
        $this->my_auth->allow($this->auth, 'backend/article');
        //$this->my_route->create();
        //$this->output->cache(5);
        $this->db->cache_delete_all();
    }

    //phương thức hiển thị danh mục bài viết
    public function category() {
        $this->my_auth->allow($this->auth, 'backend/article/category');
        if ($this->input->post('sort')) {
            $this->my_auth->allow($this->auth, 'backend/article/category/sort');
            $_order = $this->input->post('order');
            if (isset($_order) && count($_order) >= 2) {
                foreach ($_order as $keyOrder => $valOrder) {
                    $_data[] = array(
                        'id' => $keyOrder,
                        'orders' => (int) $valOrder,
                        'updated' => gmdate('Y-m-d H:i:s', time() + 7 * 3600),
                    );
                }
                $this->db->update_batch('article_category', $_data, 'id');
                $this->my_string->js_redirect('Sắp xếp thành công!', CMS_BASE_URL . 'backend/article/category');
            }else {
                // 
                $this->my_string->js_redirect('Chọn nhiều hơn 2 đối tượng để xắp xếp!', CMS_BASE_URL . 'backend/article/category');
            }
        }
        $data['seo']['title'] = 'Danh mục bài viết';
        $this->my_nested->set('article_category');
        $data['data']['_list'] = $this->my_nested->data('article_category');
        $data['data']['auth'] = $this->auth;
        $data['template'] = 'backend/article/category';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }

    //phương thức thêm danh mục bài viết 
    public function addcategory() {
        $this->my_auth->allow($this->auth, 'backend/article/addcategory');
        $this->my_nested->check_empty('article_category'); //Tao Root
        $data['seo']['title'] = 'Thêm danh mục bài viết';
        $data['data']['action'] = 
        $data['data']['auth'] = $this->auth;
        if ($this->input->post('add')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required|callback_title');
            $this->form_validation->set_rules('data[parentid]', 'Node cha', 'trim|required|is_natural_no_zero');
            if(isset($_post['route']) && !empty($_post['route'])){
                $this->form_validation->set_rules('data[route]', 'Url', 'trim|required|callback__route');
                $_post['route'] = $this->my_string->alias_standard($_post['route']);
            }
            if ($this->form_validation->run() == TRUE) {
                $_post = $this->my_string->allows_post($_post, array('title','route' , 'parentid', 'description', 'publish', 'meta_title', 'meta_keywords', 'meta_descriptions'));
                $_post['created'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                $_post['userid_created'] = $this->auth['id'];
                $_post['lang'] = $this->session->userdata('_lang');
                $_post['alias'] = $this->my_string->alias_standard($_post['title']);
                $this->db->insert('article_category', $_post);
                if(isset($_post['route']) && count($_post['route'])){
                    $this->my_route->insert(array(
                                                    'url' => $_post['route'],
                                                    'param' => 'article/category/'.$this->db->insert_id(),//insert cai id trong table item
                                                    'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
                    ));
                }
                /**** Tạo nhật ký cho hệ thống website ****/
                $this->my_auth->logs(
                        array(
                                'lang' => $this->session->userdata('_lang'),
                                'module_name' => 'category',
                                'name_key'    => $data['seo']['title'],
                                'note_action' => $_post['title'],
                                'link_acess'  => $_post['title'],
                                'userid'      => $this->auth['id'],
                                'log_time' => gmdate('Y-m-d:H:i:s', time()  + 3600),
                            )
                    );
                $this->my_string->js_redirect('Thêm danh mục thành công', CMS_BASE_URL . 'backend/article/category');
            }
        } else {
            $_post['publish'] = 1;
            $data['data']['_post'] = $_post;
        }
        $data['data']['_show']['parentid'] = $this->my_nested->dropdown('article_category', NULL, 'category');
        $data['template'] = 'backend/article/addcategory';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    
    //phương thức sửa danh mục bài viết
    public function editcategory($id) {
        $this->my_auth->allow($this->auth, 'backend/article/editcategory');
        $id = (int) $id;
        $continue = $this->input->get('continue');
        $category = $this->db->where(array('id' => $id))->from('article_category')->get()->row_array();
        if (!isset($category) || count($category) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/article/category');
        if ($category['level'] == 0) $this->my_string->js_redirect('Bạn không được sửa Root', CMS_BASE_URL . 'backend/article/category');
        if($category['lang'] != $this->session->userdata('_lang')) $this->my_string->js_redirect('Ngôn ngữ không phù hợp!', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL.'backend/article/category');
        $data['seo']['title'] = 'Thay đổi danh mục bài viết';
        $data['data']['auth'] = $this->auth;
        if ($this->input->post('edit')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required');
            $this->form_validation->set_rules('data[parentid]', 'Nội dung', 'trim|required|is_natural_no_zero|callback__parentid['.$id.']');
            if(isset($_post['route']) && !empty($_post['route'])){
                $this->form_validation->set_rules('data[route]', 'Url', 'trim|required|callback___route['.$category['route'].']');
                $_post['route'] = $this->my_string->alias_standard($_post['route']);
            }
            if ($this->form_validation->run() == TRUE) {
                $_post = $this->my_string->allows_post($_post, array('title', 'route','parentid', 'description', 'publish', 'meta_title', 'meta_keywords', 'meta_descriptions'));
                $_post['updated'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600); //cập nhật thời gian sửa
                $_post['userid_updated'] = $this->auth['id']; //lay ra ma nguoi sua //--12
                $_post['alias'] = $this->my_string->alias_standard($_post['title']);
                $this->db->where(array('id' => $id))->update('article_category', $_post);
                $this->my_route->update_route('article/category/'.$id.'', $_post['route']);
                
                /**** Tạo nhật ký cho hệ thống website ****/
                $this->my_auth->logs(
                        array(
                                'lang'           => $this->session->userdata('_lang'),
                                'module_name'    => 'category',
                                'name_key'       => $data['seo']['title'],
                                'note_action'    => $_post['title'],
                                'link_acess'     => $_post['title'],
                                'userid_created' => $this->auth['id'],
                                'log_time' => gmdate('Y-m-d:H:i:s', time()  + 3600),
                            )
                    );
                $this->my_string->js_redirect('Thay đổi danh mục thành công', CMS_BASE_URL . 'backend/article/category');
            }
        } else {
            $data['data']['_post'] = $category;
        }
        $data['data']['_show']['parentid'] = $this->my_nested->dropdown('article_category', NUll, 'category');
        $data['template'] = 'backend/article/editcategory';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    //-- 14 - kiểm tra không được cho danh mục cha là con của chính nó hoặc danh mục cha là con của danh mục con
    //Ví dụ không thể cho danh mục bóng đá là con của danh mục bóng đá hoặc là con của danh mục bóng đá Anh
    public function _parentid($parentid, $catid){
        $parentid = (int) $parentid;
        $catid = (int) $catid;
        return $this->my_nested->check_parentid('article_category', $parentid, $catid);
    }
    //Phương thức xóa danh mục bài viết đầu -- 16
    public function delcategory($id) {
        $this->my_auth->allow($this->auth, 'backend/article/delcategory');
        $id = (int) $id; //id truyền vào phải là số 
        //Kiem tra table article_category con du lieu khong
        $continue = $this->input->get('continue');
        $category = $this->db->where(array('id' => $id))->from('article_category')->get()->row_array();
        if (!isset($category) || count($category) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/article/category');
        if($category['level'] == 0) $this->my_string->js_redirect('Bạn không được xóa Root!', CMS_BASE_URL.'backend/article/category');
        if($category['lang'] != $this->session->userdata('_lang')) $this->my_string->js_redirect('Ngôn ngữ không phù hợp!', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL.'backend/article/category');
        $data['seo']['title'] = 'Xóa danh mục bài viết';
        $count = count($this->my_nested->children('article_category', array('lft > ' => $category['lft'],'rgt < ' => $category['rgt'],)));
        if($count > 0) $this->my_string->js_redirect('Vẫn còn chuyên mục con!', CMS_BASE_URL.'backend/article/category');
        //Cuối  : đếm tổng số bài viết
        $count = $this->db->from('article_item')->where(array('parentid' => $id))->count_all_results();
        if($count > 0) $this->my_string->js_redirect('Vẫn còn bài viết!', CMS_BASE_URL.'backend/article/category');
        $this->db->delete('article_category', array('id' => $id));
        
        
        /**** Tạo nhật ký cho hệ thống website ****/
                $this->my_auth->logs(
                        array(
                                'lang'           => $this->session->userdata('_lang'),
                                'module_name'    => 'category',
                                'name_key'       => $data['seo']['title'],
                                'note_action'    => 1,
                                'link_acess'     => 1,
                                'userid_created' => $this->auth['id'],
                                'log_time' => gmdate('Y-m-d:H:i:s', time() + 3600),
                            )
                    );
        
        $this->my_string->js_redirect('Bạn đã xóa bài viết thành công', CMS_BASE_URL . 'backend/article/category');
    }
  
    //-- 16 Phương thức sử lý trạng thái của danh mục bài viết
    public function setcategory($field, $id) {
        $this->my_auth->allow($this->auth, 'backend/article/setcategory');
        $id = (int) $id;
        $continue = $this->input->get('continue'); 
        $category = $this->db->where(array('id' => $id))->from('article_category')->get()->row_array();
        if(!isset($category) || count($category)==0) $this->my_string->js_redirect(CMS_BASE_URL . 'backend/article/category');
        if(!isset($category[$field])) $this->my_string->php_redirect(CMS_BASE_URL.'backend/article/category');
        $this->db->where(array('id' => $id))->update('article_category', array($field => ($category[$field]==1) ? 0 : 1));
        //$field la publish - tham số truyền vào qua url trong <a href="backend/adv/set/publish/
        $this->my_string->js_redirect('Thay đổi trạng thái thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/article/category');
    }
        //-- 16 Phương thức sử lý trạng thái của danh mục bài viết
    public function setitem($field, $id) {
        $this->my_auth->allow($this->auth, 'backend/article/setitem');
        $id = (int) $id;
        $continue = $this->input->get('continue'); 
        //echo $continue;
        $item = $this->db->where(array('id' => $id))->from('article_item')->get()->row_array();
        //print_r($item[$field]);//thuc chat la mình print_r($item['publish'])
        if(!isset($item) || count($item)==0) $this->my_string->js_redirect(CMS_BASE_URL . 'backend/article/item');
        if(!isset($item[$field])) $this->my_string->php_redirect(CMS_BASE_URL.'backend/article/item');
        $this->db->where(array('id' => $id))->update('article_item', array($field => ($item[$field] == 1) ? 0 : 1));
        //$field la publish - tham số truyền vào qua url trong <a href="backend/adv/set/publish/
        $this->my_string->js_redirect('Thay đổi trạng thái thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/article/item');
    }
    
    /* Phương thức sử lý việc hiển thị list bài viết */

    public function item($page = 1) {
        $this->my_auth->allow($this->auth, 'backend/article/item');
        if ($this->input->post('sort')) {
            $_order = $this->input->post('order');
            //print_r($_order);
            if (isset($_order) && count($_order) >= 2) {
                foreach ($_order as $keyOrder => $valOrder) {
                    $_data[] = array(
                        'id' => $keyOrder,
                        'orders' => (int) $valOrder,
                            //'updated' => gmdate('Y-m-d H:i:s' + time() + 7 * 3600) - khong can nua vi ta su dung update 
                    );
                }
                $this->db->update_batch('article_item', $_data, 'id');
                //$this->my_string->js_redirect('Sắp xếp thành công!', CMS_BASE_URL . 'backend/article/item');
            }else{
                // 
                $this->my_string->js_redirect('Chọn nhiều hơn 2 đối tượng để sắp xếp!', CMS_BASE_URL . 'backend/article/item');
            
            }
        }
        //Cuối   
        if($this->input->post('del')){
            $_checkbox = $this->input->post('checkbox');
            //echo isset($_checkbox[]) ? 'ma':'n';die();
            //Chọn lớn hơn 2 để vòng foreach ko báo rỗng
            if(isset($_checkbox) && count($_checkbox) >= 2){
                $_temp = NULL;
                foreach($_checkbox as $_keyCheckbox => $_valueCheckbox) {
                    $_temp[] = $_keyCheckbox; 
                }
                if(count($_temp)) {
                    $this->db->where_in('id', $_temp);
                    $this->db->delete('article_item');
                    $this->my_string->js_redirect('Xóa lựa chọn thành công!', CMS_BASE_URL . 'backend/article/item');
                } 
            }
             else {
                    $this->my_string->js_redirect('Chọn nhiều hơn 2 chọn đối tượng để xóa!', CMS_BASE_URL . 'backend/article/item');
                }
        }
        $_lang = $this->session->userdata('_lang');
        $data['seo']['title'] = 'Bài viết';
        $keyword = $this->input->get('keyword');
        $parentid = (int)$this->input->get('parentid');
        $sort = $this->my_common->sort_orderby($this->input->get('sort_field'), $this->input->get('sort_value'));
        $config = $this->my_common->backend_pagination(); //load method backend_pagination() sử lý việc phân trang phía backend
        $config['base_url'] = 'backend/article/item/';
        if (!empty($keyword) && $parentid == 0){
            //Viết lại -- 18
            $_sql = 'SELECT * FROM '.CMS_DB_PREFIX.'article_item WHERE `lang` = ? AND (`title` LIKE ? OR `description` LIKE ? OR `content` LIKE ?)';
            $_param = array($_lang, '%'.$keyword.'%', '%'.$keyword.'%', '%'.$keyword.'%');
            $config['total_rows'] = $this->db->query($_sql, $_param)->num_rows();
             //$config['total_rows'] = $this->db->from('article_item')->like('title', $keyword)->or_like('description',$keyword)->or_like('content', $keyword)->count_all_results();
        }    
        else if (empty($keyword) && $parentid > 0) $config['total_rows'] = $this->db->from('article_item')->where(array('lang'=>$_lang))->where(array('parentid' => $parentid))->count_all_results();
        else if(!empty ($keyword) && $parentid > 0){
            //khong co cach ghep like, or_like với where trong CI
            $_sql = 'SELECT * FROM '.CMS_DB_PREFIX.'article_item WHERE `lang` = ? AND `parentid` = ? AND (`title` LIKE ? OR `description` LIKE ? OR `content` LIKE ?)';
            $_param = array($_lang, $parentid, '%'.$keyword.'%', '%'.$keyword.'%', '%'.$keyword.'%');
            $config['total_rows'] = $this->db->query($_sql, $_param)->num_rows();
        } 
        else $config['total_rows'] = $this->db->from('article_item')->where(array('lang'=>$_lang))->count_all_results();
        //echo $config['total_rows']; die();
        $_totalpage = ceil($config['total_rows'] / $config['per_page']);
        $page = ($page > $_totalpage) ? $_totalpage : $page;
        //echo $_totalpage."<br/>";
        //echo $page;
        // 
        //$config['total_rows'] tổng số dòng - bản ghi
        //$config['per_page'] số lượng hiển thị
       $config['cur_page'] = $page;;//code phân trang kiểu cũ chưa sủa $config['uri_segment'] = 4;
        $config['suffix'] = ((isset($sort) && count($sort)) ? '?sort_field=' . $sort['field'] . '&sort_value=' . $sort['value'] : '');
        $config['first_url'] = $config['base_url'] . $config['suffix'];
        $config['suffix'] = $config['suffix'] . (($parentid > 0) ? '&parentid='.$parentid : '');
        $config['suffix'] = $config['suffix'] . (!empty($keyword) ? '&keyword=' . $keyword : '');
        
        //Xem lai phút 30  
        if($config['total_rows'] > 0){
            $this->pagination->initialize($config);
            $data['data']['pagination'] = $this->pagination->create_links();
            /* cách 2
              $_order_by = ((isset($sort) && count($sort)) ? ($sort['field']. ' ' . $sort['value']):'');
              if(!empty($_order_by) && ($sort['field'] != 'id')){ $_order_by = $_order_by.', id asc';}else{$_order_by = 'id asc';}
             */
            // 
            if (!empty($keyword) && $parentid == 0) {
                //-- 18
                $_sql = 'SELECT * FROM ' . CMS_DB_PREFIX . 'article_item WHERE `lang` = ? AND (`title` LIKE ? OR `description` LIKE ? OR `content` LIKE ?) ORDER BY ' . ($sort['field'] . ' ' . $sort['value']) . ' LIMIT ' . (($page - 1) * $config['per_page']) . ', ' . $config['per_page'];
                $_param = array($_lang, '%' . $keyword . '%', '%' . $keyword . '%', '%' . $keyword . '%');
                $data['data']['_list'] = $this->db->query($_sql, $_param)->result_array();
                /*Code cũ*/
                //$data['data']['_list'] = $this->db->from('article_item')->like('title', $keyword)->or_like('description', $keyword)->or_like('content', $keyword)->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
            } else if (empty($keyword) && $parentid > 0) $data['data']['_list'] = $this->db->from('article_item')->where(array('lang' => $_lang))->where(array('parentid' => $parentid))->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
            else if(!empty ($keyword) && $parentid > 0){
                //khong co cach ghep like, or_like với where trong CI
                $_sql = 'SELECT * FROM '.CMS_DB_PREFIX.'article_item WHERE `lang` = ? AND `parentid` = ? AND (`title` LIKE ? OR `description` LIKE ? OR `content` LIKE ?) ORDER BY '.($sort['field'].' '.$sort['value']) . ' LIMIT '.(($page-1)*$config['per_page']).', '.$config['per_page'];
                $_param = array($_lang, $parentid, '%'.$keyword.'%', '%'.$keyword.'%', '%'.$keyword.'%');
                $data['data']['_list']  = $this->db->query($_sql, $_param)->result_array();
            } 
            else {
                $data['data']['_list'] = $this->db->from('article_item')->where(array('lang' => $_lang))->limit($config['per_page'], ($page - 1) * $config['per_page'])->order_by($sort['field'] . ' ' . $sort['value'])->get()->result_array();
            }
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
        $data['data']['_parentid'] = $parentid;
        $data['data']['auth'] = $this->auth;
        $data['data']['_show']['parentid'] = $this->my_nested->dropdown('article_category',NULL,'item');
        $data['template'] = 'backend/article/item';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }

    //-- 14-phương thức thêm danh mục bài viết 
    public function additem() {
        $this->my_auth->allow($this->auth, 'backend/article/additem');
        $data['seo']['title'] = 'Thêm bài viết';
        $data['data']['auth'] = $this->auth;
        if ($this->input->post('add')) {
            $_post = $this->input->post('data');
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required');
            $this->form_validation->set_rules('data[parentid]', 'Node cha', 'trim|required|is_natural_no_zero');
            //Khi route khác trống thì nó mới chạy
            if(isset($_post['route']) && !empty($_post['route'])){
                $this->form_validation->set_rules('data[route]', 'Url', 'trim|required|callback__route');
                //Chuyển Du lịch thành Du-lich thông qua gọi method alias_standard trong lib
                $_post['route'] = $this->my_string->alias_standard($_post['route']);
            }
            $data['data']['_post'] = $_post;
            if ($this->form_validation->run() == TRUE) {
                $_post = $this->my_string->allows_post($_post, array('title', 'parentid', 'tags', 'image', 'description', 'content', 'source', 'publish', 'highlight','timer', 'meta_title', 'meta_keywords', 'meta_descriptions', 'route'));
                $_post['created'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                $_post['timer'] = !empty($_post['timer']) ? gmdate('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_post['timer'])) + 7 * 3600):'';
                $_post['userid_created'] = $this->auth['id'];
                //$_post['tags'] -- giua 20 dùng để insert dữ liệu có thêm đấu, ở 2 đầu đoạn văn 
                $_post['tags'] = !empty($_post['tags']) ? ','.str_replace(', ', ',', $_post['tags']).',':''; 
				$_post['alias'] = $this->my_string->alias_standard($_post['title']);
                $_post['lang'] = $this->session->userdata('_lang');
                $this->db->insert('article_item', $_post);
                $this->my_tags->insert_list($_post['tags']);
                //$id = $this->db->insert_id();
                if(isset($_post['route']) && !empty($_post['route'])){
                $this->my_route->insert(array(
                                                'url' => $_post['route'],
                                                'param' => 'article/item/'.$this->db->insert_id(),//insert cai id trong table item
                                                'created' => gmdate('Y-m-d H:i:s', time() + 7*3600),
                                            ));
                }
                $this->my_string->js_redirect('Thêm bài viết thành công', CMS_BASE_URL . 'backend/article/item');
            }
        } else {
            $_post['publish'] = 1;
            $data['data']['_post'] = $_post;
        }
        $data['data']['_show']['parentid'] = $this->my_nested->dropdown('article_category', NULL, 'item');
        $data['template'] = 'backend/article/additem';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    
    // -phương thức sửa bài viết 
    public function edititem($id) {
        $this->my_auth->allow($this->auth, 'backend/article/edititem');
        $id = (int) $id;
        $continue = $this->input->get('continue');
        $item = $this->db->where(array('id' => $id))->from('article_item')->get()->row_array();
        if (!isset($item) || count($item) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/article/item');
        if($item['lang'] != $this->session->userdata('_lang')) $this->my_string->js_redirect('Ngôn ngữ không phù hợp!', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL.'backend/article/item');
        //Đoạn mã kiểm tra bạn không được sửa bài của người khác viết
        if($this->auth['group_allow'] == 1 && count($this->auth['group_content']) && in_array('backend/article/edititem/self', $this->auth['group_content']) && $this->auth['id'] != $item['userid_created']) $this->my_string->js_redirect('Bạn không đủ quyền sửa bài viết của người khác!', CMS_BASE_URL.'backend/home/index');
        if ($this->input->post('edit')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[title]', 'Tiêu đề', 'trim|required');
            $this->form_validation->set_rules('data[parentid]', 'Node cha', 'trim|required|is_natural_no_zero');
            if(isset($_post['route']) && !empty($_post['route'])){
                $this->form_validation->set_rules('data[route]', 'Url', 'trim|required|callback__route['.$item['route'].']');
                //Chuyển Du lịch thành Du-lich thông qua gọi method alias_standard trong lib
                $_post['route'] = $this->my_string->alias_standard($_post['route']);
            }
            if ($this->form_validation->run() == TRUE) {
                $_post = $this->my_string->allows_post($_post, array('title','parentid', 'tags', 'image', 'description', 'content', 'publish', 'highlight', 'timer', 'meta_title', 'meta_descriptions', 'source', 'route'));
                $_post['updated'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
                $_post['userid_updated'] = $this->auth['id'];
                $_post['timer'] = !empty($_post['timer']) ? gmdate('Y-m-d H:i:s', strtotime(str_replace('/', '-', $_post['timer'])) + 7 * 3600):'';
                //$_post['tags'] -- giua 20 dùng để insert dữ liệu có thêm đấu, ở 2 đầu đoạn văn 
                $_post['tags'] = !empty($_post['tags']) ? ','.str_replace(', ', ',', $_post['tags']).',':''; 
                $_post['alias'] = $this->my_string->alias_standard($_post['title']);
                $this->db->where(array('id' => $id))->update('article_item', $_post);
                $this->my_route->update_route('article/item/'.$id.'', $_post['route']);
                
                /*Code cũ: 
                if(isset($_post['route']) && !empty($_post['route'])){
                    $this->my_route->update_route('article/item/'.$id.'', $_post['route']);
                }
                */
                /*Cách 2 để update cái route trong bảng route 
                $this->my_route->update('article/item/'.$id, array('url'=>$_post['route'], 'updated'=> gmdate('Y-m-d H:i:s')));
                */
                $this->my_tags->insert_list($_post['tags']);
                $this->my_string->js_redirect('Thay đổi bài viết thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/article/item');
            }
        }else{
            $item['timer'] = ($item['timer'] != '0000-00-00 00:00:00') ? gmdate('H:i:s d/m/Y', strtotime(str_replace('-', '/', $item['timer'])) + 7 * 3600):'';
            $item['tags'] = !empty($item['tags']) ? str_replace(',', ', ', substr(substr($item['tags'], 1), 0, -1)):'';
            $data['data']['_post'] = $item;
        }
        $data['seo']['title'] = 'Thay đổi bài viết';
        $data['data']['auth'] = $this->auth;
        $data['data']['_show']['parentid'] = $this->my_nested->dropdown('article_category', NULL, 'item');
        $data['template'] = 'backend/article/edititem';
        $this->load->view('backend/layout/home', isset($data) ? $data : '');
    }
    //-- 21 kiểm tra route đã tồn tại trong bảng route hay chưa và battj ra thông báo
    public function _route($route, $old_route){
        return $this->my_route->check_route($route, isset($old_route) ? $old_route:'');
		
    }
    /*public function _routedemo($route, $old_route){
       $route = $this->my_string->alias_standard($route);
       if(empty($old_route)){
           $count = $this->db->from('route')->where(array('url' => $route))->count_all_results();
       }
       else{
            $count = $this->db->from('route')->where(array('url' => $route, 'url !=' => $old_route))->count_all_results();
       }
        if ($count > 0) {
            $this->form_validation->set_message('_route', 'Url: ' . $route . ' đã tồn tại!');
            return FALSE;
        }
        return TRUE;
    }
    */
    // -phương thức xóa bài viết trong list bài viết
    public function delitem($id) {
        $this->my_auth->allow($this->auth, 'backend/article/delitem');
        $id = (int) $id;
        $continue = $this->input->get('continue');
        $item = $this->db->where(array('id' => $id))->from('article_item')->get()->row_array();
        if (!isset($item) || count($item) == 0) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/article/item');
        if($item['lang'] != $this->session->userdata('_lang')) $this->my_string->js_redirect('Ngôn ngữ không phù hợp!', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL.'backend/article/item');
        $this->db->delete('article_item', array('id' => $id));
        $this->my_string->js_redirect('Xóa bài viết thành công', !empty($continue) ? base64_decode($continue) : CMS_BASE_URL . 'backend/article/item');
    }
}
