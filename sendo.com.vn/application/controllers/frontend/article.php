<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class Article extends My_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    //Code sau khi sửa của -----LMD------
    public function category($catid = 0, $page = 1) {
    	$catid = (int) $catid;
        $category = $this->db->where(array('id'=>$catid, 'publish' => 1))->from('article_category')->get()->row_array();
       	if(!isset($category) || count($category) == 0) $this->my_string->php_redirect(ITQ_BASE_URL);
       	$author = $this->db->select('id, username, fullname, google_author')->from('user')->where(array('id'=>$category['userid_created']))->get()->row_array();
       	if(!isset($author) && count($author) == 0) $this->my_string->php_redirect(ITQ_BASE_URL);
       	//Gọi phương thức sử lý ngôn ngữ khi vào trang danh mục con của menu ví dụ vào sự kiện bình luận sẽ ra trang khác
        $this->my_frontend->lang_frontend($category['lang']);
       	$_lang = $this->session->userdata('_lang');
       	
       	/**** BEGIN PAGGING ***/
        $config = $this->my_frontend->pagination();
        $config['first_url'] = $this->my_frontend->canonical($category['route'], $category['alias'], $category['id'], '68', FALSE).CMS_URL_SUFFIX;
        $config['base_url'] = $this->my_frontend->canonical($category['route'], $category['alias'], $category['id'], '68', FALSE).'/trang-';
        if($category['rgt'] - $category['lft'] == 1){
        	//Kiểm tra nếu $category['rgt'] - $category['lft'] == 1 thì có node lá
        	$config['total_rows'] = $this->db->from('article_item')->where(array('lang' => $_lang, 'publish' => 1, 'parentid' => $catid))->count_all_results(); 
        }else{
        	//Dem so node con
        	$_children = $this->my_nested->children('article_category', array('lft >= ' => $category['lft'],'rgt <= ' => $category['rgt'],));
        	$config['total_rows'] = $this->db->from('article_item')->where(array('lang' => $_lang, 'publish' => 1))->where_in('parentid', $_children)->count_all_results(); 
        }
        $total_page = ceil($config['total_rows']/$config['per_page']);
        $page = ($page <= 0) ? '1' : $page;//Chuyển nó về trang 1 nếu user có gõ url trang-0.html
        $page = ($page > $total_page) ? $total_page:$page;
        $config['cur_page'] = $page;
        if ($config['total_rows'] > 0) {
        	$this->pagination->initialize($config);
        	$data['data']['pagination'] = $this->pagination->create_links();
        	$_children = $this->my_nested->children('article_category', array('lft >= ' => $category['lft'],'rgt <= ' => $category['rgt'],));
        	if($category['rgt'] - $category['lft'] == 1){
        		$data['data']['_list'] = $this->db->select('id, title, alias, route, parentid, image, description ,created')->from('article_item')->where(array('lang'=>$_lang, 'publish'=>1))->where_in('parentid', $_children)->order_by('orders desc, id desc')->limit($config['per_page'], ($page - 1) * $config['per_page'])->get()->result_array();
        		
        	}else{
        		$data['data']['_list'] = $this->db->select('id, title, alias, route, parentid, image, description ,created')->from('article_item')->where(array('lang'=>$_lang, 'publish' => 1))->where_in('parentid', $_children)->order_by('orders desc, id desc')->limit($config['per_page'], ($page - 1) * $config['per_page'])->get()->result_array();
        	}
        }
        $data['title'] = $this->db->select('id, title, alias, route, parentid, image, description ,created')->from('article_item')->where(array('lang'=>$_lang, 'publish'=>1))->order_by('orders desc, id desc')->get()->result_array();
            
       	//print_r($data['title']);
       	echo 'a';
        $_seopage = ($page > 1) ? '| Trang '.$page:'';
        $data['data']['_page'] = $page;
        $data['data']['_config'] = $config;
        
        /*** END PAGGING ***/
        $data['seo']['title'] = (!empty($category['meta_title']) ? $category['meta_title'] : $category['title']).$_seopage;
       	$data['seo']['keywords'] =  !empty($category['meta_keywords']) ? $category['meta_keywords'] : '';
       	$data['seo']['descriptions'] = (!empty($category['meta_descriptions']) ? $category['meta_descriptions'] : strip_tags($category['description'])).$_seopage;
        if($page > 1){
            $data['seo']['canonical'] = $this->my_frontend->canonical($category['route'], $category['alias'], $category['id'], '68', FALSE).'/'.'trang-'.$page.CMS_URL_SUFFIX;
        }else{
            $data['seo']['canonical'] = $this->my_frontend->canonical($category['route'], $category['alias'], $category['id'], '68');
        }
        $full_url = current(explode('?', $this->my_string->full_url()));
        if($full_url != $data['seo']['canonical']) $this->my_string->php_redirect($data['seo']['canonical']);
        $data['seo']['_author'] = $author;
        //$data['data']['_breadcrumb'] = $config;
        $data['data']['_category'] = $category;
        $data['data']['_children'] = ($category['rgt'] - $category['lft'] > 1) ? $this->db->select('id, title, route, alias')->from('article_category')->where(array('parentid'=>$catid, 'publish' => 1))->get()->result_array() : NULL;
        //Prev link
        $data['seo']['re_prev'] = ($page > 1) ? $config['base_url'].($page - 1) : '';   
        //Next link
        $data['seo']['re_next'] = ($page < $total_page) ? $config['base_url'].($page + 1).CMS_URL_SUFFIX : '';
        $data['template'] = 'frontend/article/category';
        $this->load->view('frontend/layout/home', isset($data) ? $data : NULL);
    }
	public function item($itemid = 0){
    	$itemid = (int) $itemid;
    	$item = $this->db->where(array('id'=>$itemid, 'publish' => 1))->from('article_item')->get()->row_array();
    	if(!isset($item) && count($item) == 0) $this->my_string->php_redirect(ITQ_BASE_URL);
    	$author = $this->db->select('id, username, fullname, google_author')->where(array('id'=>$item['userid_created']))->from('user')->get()->row_array();
    	if(!isset($author) && count($author) == 0) $this->my_string->php_redirect(ITQ_BASE_URL);
    	$category = $this->db->where(array('id'=>$item['parentid'], 'publish' => 1))->from('article_category')->get()->row_array();
    	if(!isset($category) || count($category) == 0) $this->my_string->php_redirect(ITQ_BASE_URL);
    	//Gọi phương thức sử lý ngôn ngữ khi vào trang danh mục con của menu ví dụ vào sự kiện bình luận sẽ ra trang khác
    	$this->my_frontend->lang_frontend($item['lang']);
    	$_lang = $this->session->userdata('_lang');
	 	if ($this->input->post('comment')) {
            $_post = $this->input->post('data');
            $data['data']['_post'] = $_post;
            $this->form_validation->set_error_delimiters('<li>', '</li>');
            $this->form_validation->set_rules('data[fullname]', 'Họ và tên', 'trim|required');
    		$this->form_validation->set_rules('data[email]', 'Email', 'trim|required|valid_email');
    		$this->form_validation->set_rules('data[content]', 'Nội dung', 'trim|required');
    		if ($this->form_validation->run() == TRUE) {
    			$_post = $this->my_string->allows_post($_post, array('fullname', 'email', 'content', 'publish'));
    			$_post['created'] = gmdate('Y-m-d H:i:s', time() + 7 * 3600);
    			$_post['param'] =  'article/item'.$itemid;
    			$_post['publish'] = 1;
    			$this->db->insert('comment', $_post);
    			$this->my_string->js_redirect('Gửi phản hồi thành công!', ITQ_BASE_URL);
    		}
    	}
    	$data['seo']['title'] = (!empty($item['meta_title']) ? $item['meta_title'] : $item['title']);
    	$data['seo']['keywords'] =  !empty($item['meta_keywords']) ? $item['meta_keywords'] : '';
    	$data['seo']['descriptions'] = (!empty($item['meta_descriptions']) ? $item['meta_descriptions'] : strip_tags($item['description']));
    	$data['seo']['canonical'] = $this->my_frontend->canonical($item['route'], $item['alias'], $item['id'], '88', FALSE).CMS_URL_SUFFIX;
    	$data['seo']['_author'] = $author;
    	$full_url = current(explode('?', $this->my_string->full_url()));
    	if($full_url != $data['seo']['canonical']) $this->my_string->php_redirect($data['seo']['canonical']);
    	$data['data']['_category'] = $category;
    	$data['data']['_item'] = $item;
    	$data['data']['_children'] = ($category['rgt'] - $category['lft'] > 1) ? $this->db->select('id, title, route, alias')->from('article_category')->where(array('parentid'=>$item['parentid'], 'publish' => 1))->get()->result_array() : NULL;
    	$data['data']['_comment'] = $this->db->from('comment')->where(array('param'=>'article/item'.$itemid, 'publish' => 1))->order_by('id asc')->get()->result_array();
        $data['template'] ='frontend/article/item';
    	$this->load->view('frontend/layout/home', isset($data) ? $data : NULL);
    }
}
