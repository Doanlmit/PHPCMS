<?php
    header('Content-Type: text/html; charset=utf-8');
    define('CMS_BASE_URL', 'http://localhost:81/project/sendo.com.vn/');
    define('CMS_PREFIX', md5(CMS_BASE_URL));
    define('CMS_LANGUAGE', 'vi');
    define('CMS_DB_HOST', 'localhost');
    define('CMS_DB_USER', 'root');
    define('CMS_DB_PASS', '');
    define('CMS_DB_DATABASE', 'google_cms');
    define('CMS_DB_PREFIX', 'cms_');
    define('CMS_URL_SUFFIX', '.html');
?>
