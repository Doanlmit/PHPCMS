<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends My_Controller {
    
    public $auth;
    public function __construct() {
        parent::__construct();
        $this->auth = $this->my_auth->check();
        if ($this->auth == NULL) $this->my_string->php_redirect(CMS_BASE_URL . 'backend/home/index');
        $this->my_auth->allow($this->auth, 'backend/article');
    }
    public function category(){
    	
    }
}
